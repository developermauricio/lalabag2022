=== Video Player Gallery with Responsive===
Contributors: pareshpachani007
Tags: Slider, video slider, video player, video gallery with popup, wordpress slider, slider plugin, responsive slider, easy slider, post slider, youtube slider, video gallery slider, HTML5 video, youtube video gallery, vimeo video gallery, youtube, Youtube video, video playlist, video playlist with lightbox, video lightbox, youtube gallery, youtube player, magnific Popup, HTML5 video player, HTML5 video gallery. wordpress HTML5 video, wordpress HTML5 video player, wordpress HTML5 video gallery, responsive, wordpress responsive video gallery  
Requires at least: 4.0
Tested up to: 5.3
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple and create Video Player and Gallery and display your video on your WordPress website using YouTube, Vimeo, HTML5 video, with shortcode and display gallery with Responsive Popup to your WordPress website. 

== Description ==
This plugin Use for responsive Video Player And Video Gallery with using HTML5, YouTube, Vimeo. vedio gallery with click to Popup on your website. 
and show your video with Video Rotetor Slider, Grid, Playlist with shortcode. if you need multiple Video Slider, Grid, and Playlist you can create Category.

**[Free Live Demo](http://demo.wponlinehelp.com/video-player-gallery/)**
**[How to Installation](http://docs.wponlinehelp.com/docs-project/video-player-gallery/)**


= Plugin Features =
* No need of coding skills. 
* Responsive Design and Layout.
* Within 2 min you can set you Video slider, grid, Playlist using shorcode generater. 
* Plugin is very light weight.
* 5+ Design template available for each shortcode. 
* Work with all WordPress theme and WordPress website.
* No need of any settings.
* User & Developer friendly & easy to customize.
* Easy to generate shortcode in this plugin.
* Its easy to use interface allows you to manage, edit, create, and delete video with slider, Grid and Portfolio.
* Responsive & columns structures.
* Order options.
* show/hide title and description.
* show/hide Navigation Arrows & Dots. 
* All options works with True/False. 
* Custom link for Video URL.
* No Extra code.
* Fully SEO Friendly.

= Video slider, Grid, and Video Playlist works with 5+ Design template =

= This video player gallery contains three shorcode =
* <code>[vpg_grid]</code> : Displays Video in Grid view.
* <code>[vpg_slider]</code> : Displays Video in Slider view.
* <code>[vpg_playlist]</code> : Displays Video in Playlist view.

	Following  all parameter work with shortcode for Grid, slider, playlist to display video and make video gallery.

= For Video Grid(Columns) With Fully Responsive =
<code>[vpg_grid]</code>
= For Video Slider with fully responsive =
<code>[vpg_slider]</code>
= For video Playlist With Fully Responsive =
<code>[vpg_playlist]</code>
= Common shortcode paramaters for Grid, Slider, and Playlist video gallery view =

* **template:**
template="template-2"(ie. there are 5+ Design template for each shorcode.)

* **video_limit:**
video_limit="3" (ie. how many video you want to show like: 1,2,3 etc. if all video use limit="-1".)

* **video_cat:**
video_cat="13" (ie. get video according to category and 13 is category id. find ID under **Video Player -> Video Category**).

* **video_cell:**
video_cell="4" (ie. Set Video in cell(columns) per Row. and 4 is a number of columns, option: 1,2,3,4,6).
* **post:**
post="156, 158" (ie. if show fix video enter video id. and 156,158 is a Post ID. find ID under **Video Player -> All Video** ).
* **exclude_post:**
exclude_post="152, 159" (ie. if not show fix video enter video id. and 156,158 is a Post ID. find ID under **Video Player -> All Video** ).
* **query_offset:**
query_offset="4" (ie. if not show latest number of video. it's means 4 latest video is not show).
* **show_title**
show_title ="false" (ie. for show video title.  value are true or false).
* **show_content**
show_content ="true" (ie. for show video content. value are true or false).
* **order**
order"ASC" (ie. Set Video Ascending and Descending order. option: 'ASC' , 'DESC').
* **orderby**
orderby="ID" ( ie. set Video with orderby Attribute. option: ‘none’,ID’,’author’,’title’,’name’,rand’,date’).
* **popup_fix**
popup_fix="true" ( ie. on Popup you want to scroll popup or not).
* **extra_class**
extra_class="outer-wrap" ( ie. create CSS class for small customize).
= only Video Grid shortcode parameter =
* **popup_gallery**
popup_gallery="true" ( ie. Show in Gallery view on popup).
= Only common Video Slider, playlist shortcode parameter =
* **autoplay**
autoplay="false" ( ie. set Video slider slide move automatically. option: true/false).
* **autoplay_interval**
autoplay_interval="3000" ( ie. use for transition effects speed between two slide. value in Milliseconds).
* **speed**
speed="1000" ( ie. use for slider slide moving speed. value in Milliseconds).
* **arrows**
arrows="false" ( ie. use for Show Prev/Next Arrows.  option: true/false).
* **pagination_dots**
pagination_dots="false" ( ie. use for slider dots pagination. option: true/false).
* **loop**
loop="true" ( ie. use for move slide infinite automatically. option: true/false).
* **center_mode**
center_mode="true" ( ie. use for slider slide center automatically. but slider must be set with video cell with 3,5,7,9. option: true/false).
* **auto_height**
auto_height="true" ( ie. use for slider slide auto height Adaptive. option: true/false).
= Only Video slider shortcode parameter =
* **popup_gallery**
popup_gallery="true" ( ie. Show in Gallery view on popup).
* **slides_scroll**
slides_scroll="2" ( ie. Move (Scroll) video for each slide Default value is "1" . option: true/false).
= Only Video playlist shortcode parameter =
* **playlist_row** 
playlist_row="4" ( ie. set number of video in playlist. option: any number. if use center mode must be set: 3,5,7,9).
* **playlist_arrow**
playlist_arrow="false" ( ie. use for Show UP/Down arrow.  option: true/false).
= How to install & Setup Plugin : =
[youtube https://www.youtube.com/watch?v=4Yu2WU79R_0]	

== How to Install in directory ==
1. Upload the 'video-player-gallery' folder to the '/wp-content/plugins/' directory.
2. Activate the "video player gallery" list plugin through the 'Plugins' menu in WordPress.
3. Add and create new page for make video player and use this short code like: 
 <code>[vpg_grid]</code>
 <code>[vpg_slider]</code>
 <code>[vpg_playlist]</code>
4.If you use in PHP Template Code:
<code><?php echo do_shortcode('[vpg_grid]'); ?></code>
<code><?php echo do_shortcode('[vpg_slider]'); ?></code>
<code><?php echo do_shortcode('[vpg_playlist]'); ?></code>

== Screenshots ==
1. How to Add Video. 
2. All Video List.
3. Use multiple video using category.
4. How to generate shortcode.

== Frequently Asked Questions ==

= What is a template ? =

you can change your design layout with using template. and template is a video design.

= Do I need to upload my videos featured image? =

yes, this image will be front image of the video. so take screenshort and upload with featured image.


== Changelog ==
= 1.2 =
* set slider & playlist height css.

= 1.1 =
* remove extra css.
= 1.0 =
* Initial release.
== Upgrade Notice ==

= 1.2 =
* set slider & playlist height css.

= 1.1 =
* remove extra css.

= 1.0 =
* Initial release.