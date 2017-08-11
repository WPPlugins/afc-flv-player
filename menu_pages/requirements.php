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

if($error) {
	echo '<div class="wrap" style="margin:7px;"><h2>Requirements</h2>'.$error.'</div>';	
}
?>