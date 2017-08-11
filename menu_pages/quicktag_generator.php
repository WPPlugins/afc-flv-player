<?PHP
error_reporting(E_ERROR);
define('ABSPATH', realpath(dirname(__FILE__).'/../../../../').'/' );
require_once( dirname(__FILE__).'/../../../../wp-admin/admin.php'); 

require_once( dirname(__FILE__) . '/../../../../wp-config.php');
require_once( dirname(__FILE__) . '/../../../../wp-settings.php');

// require plugin functions
require_once(dirname(__FILE__).'/../plugin_info.php');

$error = '';
$missing_plugins = afc_flv_player_reqs();
if(!empty($missing_plugins) && count($missing_plugins)) {
	$error .= 'Required plugins are missing:<br><ul>
	';
	foreach($missing_plugins as $plugin) {
		$error .= '<li><a href="'.$plugin['uri'].'" target="_blank">'.$plugin['name'].'</a><br>';
	}
	$error .= '</ul>Please make sure that you have all required plugins (of a given version or above).';
}

$o = afc_flvp_get_options();
if(!$o['quicktag']) {
	die('Quicktab disabled..');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>AFC FLV-Player &rsaquo; Quicktag</title>
<link rel="stylesheet" href="<?php echo get_bloginfo('url')?>/wp-admin/wp-admin.css?version=2.1.3" type="text/css" />
<style type="text/css">* html { overflow-x: hidden; }</style>

<script type='text/javascript' src='<?php echo get_bloginfo('url')?>/wp-includes/js/quicktags.js?ver=3517'></script>
<script type='text/javascript' src='<?php echo get_bloginfo('url')?>/wp-content/plugins/afc-plug-system/menu_pages/quicktag.js'></script>
<script language="JavaScript">
	function doInsert(){
		var parentCanvas = window.opener.document.getElementById('content');
		var myField = window.opener.document.getElementById('content');

		var f_height = document.getElementById('f_height');
		var f_width = document.getElementById('f_width');
		var f_movie_title = document.getElementById('f_movie_title');
		var f_movie_uri = document.getElementById('f_movie_uri');
		var f_splash_uri = document.getElementById('f_splash_uri');
		var f_bgcolor = document.getElementById('f_bgcolor');
		var f_autostart = document.getElementById('f_autostart');
		var f_show_as_link = document.getElementById('f_show_as_link');
		
		var myValue = '<<?php echo $o['comp_tag'] ? strtolower($o['comp_tag']) : 'FLV'?> path="' + f_movie_uri.value  
								+ '" splash_path="' + f_splash_uri.value 
								+ '" title="' + f_movie_title.value 
								+ '" width="' + f_width.value 
								+ '" height="' + f_height.value 
								+ '" bgcolor="' + f_bgcolor.value 
								+ '" autostart="';
		myValue += (f_autostart.checked) ? 'true"' : 'false"';
		myValue += ' show_as_link="' + ( (f_show_as_link.checked) ? 'true"' : 'false"' );
		myValue += '>{' + f_movie_title.value +'}';
		myValue += '</<?php echo $o['comp_tag'] ? strtolower($o['comp_tag']) : 'FLV'?>>';
		
		afc_tools_insert_html(myValue);
	}
	


	var quick_tag_screens = ['div_files', 'div_options'];
	var blog_uri = '<?php echo get_bloginfo('url')?>';

</script>

</head>
<body>
<?php
if($error) {
	?>
	<div class="wrap" style="margin:7px;">
	<h2>Error</h2>
	<?php echo $error;?>
	</div>
	</body>
	</html>
	<?
	exit;
}
?>
	<div class="wrap" style="margin:7px;">
		<h2>AFC FLV-Player Options</h2>
		<form name="plugin_html_form" method="post">
		<input type="hidden" name="afc_file_pick_frame" id="afc_file_pick_frame">
		<input type="hidden" name="afc_file_pick_el" id="afc_file_pick_el">

		<div id="div_files" style="display:none;height:100%;">
			<iframe id="frmFiles" width="100%" height="450" scrolling="auto" src="<?php echo get_bloginfo('url')?>/wp-content/plugins/afc-plug-system/menu_pages/file_manager.php?sa=1&sp=<?php echo $o['base_uri']?>" frameborder="0" style="border:1px solid silver;"></iframe>
			<p class="submit">
				<input type="button" onClick="afc_tools_on_file_selected('div_options')" name="Select" value="Select &raquo;" />
				<input type="button" onClick="afc_tools_on_file_not_selected()" name="Cancel" value="Cancel &raquo;" />
			</p>
		
		</div>

		<div id="div_options" style="height:500px;">
		<fieldset class="options">
			<legend>Required settings</legend>
			<table class="optiontable" border=0> 
				<tbody>
				<tr valign="top"> 
					<th scope="row">Movie Title:</th> 
					<td colspan=2>
						<input name="alt_movie_title" id="f_movie_title" value="<?php echo ((isset($_GET['sel_text'])&&$_GET['sel_text'])?$_GET['sel_text']:$o['alt_movie_title'])?>" size="40" class="code" type="text">
					</td>
				</tr> 
				<tr valign="top"> 
					<th scope="row">Movie Splash Screen:</th> 
					<td colspan=2>
						<div>
						<input type="text" id="f_splash_uri" name="f_movie_uri"  size="40" class="code" type="text" readonly>
						<a href="javascript://" onClick="afc_tools_select_file('div_options', 'div_files','f_splash_uri')">Choose File</a></div>
					</td>
				</tr> 
				<tr valign="top"> 
					<th scope="row">Movie URI:</th> 
					<td colspan=2>
						<div>
						<input type="text" id="f_movie_uri" name="f_movie_uri"  size="40" class="code" type="text" readonly>
						<a href="javascript://" onClick="afc_tools_select_file('div_options', 'div_files','f_movie_uri')">Choose File</a></div>
					</td>
				</tr> 
				<tr valign="top"> 
					<th scope="row">Show as link:</th> 
					<td width="60px">
						<input type="radio" value="1" id="f_show_as_link" name="show_as_link" <?php echo ($o['show_as_link'] ? 'checked="checked"' : '') ?> /> yes<br />
						<input type="radio" value="0" name="show_as_link" <?php echo (!$o['show_as_link'] ? 'checked="checked"' : '') ?> /> no
					</td>
					<td>
					 This option allows you to have simple links which popup into movie using Highslide JS.
					</td>
				</tr> 
				<tbody>
			</table>
		</fieldset>

		<fieldset class="options">
			<legend>Additional Settings</legend>
			<table class="optiontable"> 
				<tbody>
				<tr valign="top"> 
					<th scope="row">Dimensions:</th> 
					<td>
						<input type="text" value="<?php echo $o['width']?>" name="width" id="f_width" size="3" maxlength="4" /> x
						<input type="text" value="<?php echo $o['height']?>" name="height" id="f_height" size="3" maxlength="4" />
					</td>
				</tr> 
				<tr valign="top"> 
					<th scope="row">Background Color:</th> 
					<td>
						<input type="text" value="<?php echo $o['bgcolor']?>" name="bgcolor" id="f_bgcolor" size="8" maxlength="8" /><br>
					</td>
				</tr> 
				<tr valign="top"> 
					<th scope="row">Auto-Start:</th> 
					<td>
						<input type="radio" value="1" id="f_autostart" name="autostart" <?php echo ($o['autostart'] ? 'checked="checked"' : '') ?> /> yes<br />
						<input type="radio" value="0" name="autostart" <?php echo (!$o['autostart'] ? 'checked="checked"' : '') ?> /> no
					</td>
				</tr> 
				<tbody>
			</table>
		</fieldset>

		<p class="submit" style="margin-top:0px;">
			<input type="button" onClick="doInsert()" name="Submit" value="Insert Tag &raquo;" />
		</p>
		</div>
		</form>
	</div>

</body>
</html>
