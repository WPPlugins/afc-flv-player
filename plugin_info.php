<?PHP
/*
Plugin Name: AFC FLV-Player
Plugin URI: http://www.afcomponents.com/ext/wp/afc-flv-player/
Description: The easiest way to play FLV video content within your blog posts. Based on extraordinary useful <a href="http://www.afcomponents.com/components/flv_player/">FLV Player</a> from <a href="http://www.afcomponents.com">Advanced Flash Components</a>.
Version: 2.5.7
Author: Vic Farazdagi
Author URI: http://www.afcomponents.com/team/torio/
*/

/*
AFC FLV-Player for Wordpress
(c) 2007 Advanced Flash Components / CrabDish LLC (email : support@afcomponents.com)

This plugin uses free embeddable version of	Advanced Flash Component's FLV Player.
For more details on component itself see	http://www.afcomponents.com/components/flv_player/
	
This Wordpress plugin is released "as is". Without any warranty. The author cannot
be held responsible for any damage that this script might cause.
*/

require_once(dirname(__FILE__).'/plugin_funcs.php');

      
function afc_flv_player() {return '2.5.7';}	// dummy function to let the others know that plugin has been loaded

add_filter('the_content', 'afc_flvp_the_content', '10');	// <flv> tag -> HTML tags
add_filter('admin_footer','afc_flvp_quicktag_button',1);
add_action('admin_menu', 'afc_flv_player_reqs_failed'); // on failed reqs, user would see requirements.php in menu
add_filter('mce_valid_elements', 'afc_flv_player_mce_valid_elements', 0); // just to make sure that TinyMCE leaves our quicktag alone

?>