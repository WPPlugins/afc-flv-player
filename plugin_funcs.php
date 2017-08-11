<?PHP

// returns list of required plugins
// thanks to Jonathan Leighton for an idea! see http://jonathanleighton.com/blog/wordpress-plugin-dependencies/
function afc_flv_player_reqs() {
	$required_plugins = array();
	$required_plugins[] = array(
		'name'=>'AFC Plug System ver 2.2.0 +', 'uri'=>'http://www.afcomponents.com/ext/wp/afc-plug-system/', 'func'=>'afc_plug_system', 'ver'=>'2.2.0'
	);

	
	$missing_plugins = array();
	foreach ($required_plugins as $plugin){
		if (!function_exists($plugin['func']) && !class_exists($plugin['func'])){
			$missing_plugins[] = $plugin;
		}elseif( $plugin['func']() < $plugin['ver'] ) { // check version
			$missing_plugins[] = $plugin; // plugin exists but version is missing
		}
		
	}
	
	return $missing_plugins;	
}

function afc_flv_player_reqs_failed() {
	$missing_plugins = afc_flv_player_reqs();
	if(!empty($missing_plugins) && count($missing_plugins)) {
		$this_plug_dir = '/afc-flv-player/';
		add_menu_page('AFC FLV-Player', 'AFC FLV-Player', 9, $this_plug_dir.'menu_pages/requirements.php');		
	}
}


/*
* Returns stored data associated with afc flv-player plugin
*/
function afc_flvp_get_options( $reset = 0) {
	//values used by default
	$def_opts = array(
		'component_uri'			=> get_bloginfo('url').'/wp-content/plugins/afc-flv-player/component.swf',
		'base_uri'				=> get_bloginfo('url').'/wp-content/uploads/',
		'comp_tag'			  => 'flv',
		'width'						=> 360,
		'height'					=> 270,
		'quicktag'				=> 1,
		'autostart'				=> 0,
		'show_as_link'		=> 0,
		'allow_full_screen' => 1,
		'bgcolor'				=> '0xFFFFFF',
		'alt_movie_title' => 'Advanced Flash Components (www.afcomponents.com)',
		'quicktag_pars' => array('href','splash_path','path', 'width', 'height', 'autostart', 'title', 'bgcolor', 'show_as_link'),
	);
	

	$options = $reset ? 0 : get_option('afc_flvp_options');

	if (!is_array($options)){
		$options = $def_opts;
		update_option('afc_flvp_options', $options);
	}else {
		// make sure that if option is not present it's filled with default value
		foreach($def_opts as $key=>$val) {
			if(!isset($options[$key])) {
				$options[$key] = $val;
			}
		}

		//manually update quicktag
		$options['quicktag_pars'] = $def_opts['quicktag_pars'];
	}
	
	return $options;
}

/*
* Transform <flv> meta-tag into actual HTML tags
*/
function afc_flvp_the_content($content) {
	$o = afc_flvp_get_options();
	
	$req_opts = array('height','width','autostart','title','allow_full_screen');

	//open template
	$flv_code_normal = file_get_contents(dirname(__FILE__).'/menu_pages/player_normal_html.tpl');
	$flv_code_linked = file_get_contents(dirname(__FILE__).'/menu_pages/player_linked_html.tpl');
	
	$flv_code_normal = str_replace('{COMPONENT_URI}',$o['component_uri'],$flv_code_normal);
	$flv_code_linked = str_replace('{COMPONENT_URI}',$o['component_uri'],$flv_code_linked);
	
	$quicktag_tag = isset($o['comp_tag']) ? strtolower($o['comp_tag']) : 'flv';
	preg_match_all ('!<'.$quicktag_tag.'([^>]*)[ ]*>([^/<>]*)</'.$quicktag_tag.'>!i', $content, $_matches); //locate <flv> tag

	if(isset($_matches[1])) {

		foreach($_matches[1] as $k1=>$flv_tag) {
			preg_match_all('!('.implode('|',$o['quicktag_pars']).')="([^"]*)"!i',$flv_tag,$attribs);	
			
			// decide which template to use
			$flv_code_cur = $flv_code_normal;
			if(isset($attribs[1]) && ( ($ind = array_search('show_as_link', $attribs[1])) !== false) && isset($attribs[2])) {
				if(isset($attribs[2][$ind]) && $attribs[2][$ind] == 'true') {
					$flv_code_cur = $flv_code_linked;
				}
			}

			// this ID could be used in js (for id) to locate current element
			$item_id = md5 (uniqid (rand()));
			$flv_code_cur = str_replace('{ITEM_ID}', $item_id, $flv_code_cur);
			
			//now create an array containing all transmitted via tag vars
			$flv_vars = array();
			foreach($attribs[1] as $k2=>$att_name) {
				$flv_vars[$att_name] = $attribs[2][$k2];
			}

			//now make sure that parameters not present are obtained from defaults
			foreach($req_opts as $opt_name) {
				if(!isset($flv_vars[$opt_name])) {
					$flv_vars[$opt_name] = ($o[$opt_name]=='y'||$o[$opt_name])?'true':$o[$opt_name];
					$flv_vars[$opt_name] = ($flv_vars[$opt_name]=='n' || (!$flv_vars[$opt_name]) ) ?'false':$flv_vars[$opt_name];
				}
			}
			
			//do replace
			foreach($flv_vars as $att_name=>$att_value) {
				$flv_code_cur = str_replace('{'.strtoupper($att_name).'}', $att_value.'', $flv_code_cur);
			}
			$content = str_replace($_matches[0][$k1],$flv_code_cur,$content);
		}
	}
	return $content;
}

// adds up quicktag button functionality
function afc_flvp_quicktag_button($content) {
	$o = afc_flvp_get_options();
	if($o['quicktag']) {
		require_once(dirname(__FILE__).'/menu_pages/quicktag_button.php');
	}
	return $content;
}

// adds to the list of TinyMCE's valid tags our quicktag
function afc_flv_player_mce_valid_elements($valid_elements) {
	$o = afc_flvp_get_options();
	$quicktag_tag = isset($o['comp_tag']) ? strtolower($o['comp_tag']) : 'flv';
	$valid_elements .= ',+'.$quicktag_tag.'['.implode('|',$o['quicktag_pars']).']';
  return $valid_elements;	
}


?>