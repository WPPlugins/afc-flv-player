<?PHP
	$quicktag_page_uri = get_bloginfo('url').'/wp-content/plugins/afc-flv-player/menu_pages/quicktag_generator.php';
	$quicktag_title = $o['comp_tag'] ? strtoupper($o['comp_tag']) : 'FLV';
?>
<div id="<?php echo $quicktag_title?>_link" style="margin-bottom:10px; display:none;">
	<a href="#" onclick="return edInsertFLV()">AFC Flash Player</a>
</div>
<script type='text/javascript' src='<?php echo get_bloginfo('url')?>/wp-content/plugins/afc-plug-system/menu_pages/quicktag.js'></script>
<script type="text/javascript">
	<!--
		var qtToolbar = document.getElementById("ed_toolbar");
		if(qtToolbar){
			var flvNr = edButtons.length;
			edButtons[edButtons.length] = new edButton('ed_flv','','','','');
			var compBut = qtToolbar.lastChild;
			while (compBut.nodeType != 1){
				compBut = compBut.previousSibling;
			}
			compBut = compBut.cloneNode(true);
			qtToolbar.appendChild(compBut);
			compBut.value = '<?php echo $quicktag_title?>';
			compBut.onclick = edInsertFLV;
			compBut.title = "Insert a Flash Video";
			compBut.id = "ed_flv";
		} else {
			var <?php echo $quicktag_title?>Link = document.getElementById("<?php echo $quicktag_title?>_link");
			var pingBack = document.getElementById("pingback");
			
			if (pingBack == null){
				var pingBack = document.getElementById("post_pingback");
			}
			if (pingBack == null) {
				var pingBack = document.getElementById("savepage");
				pingBack = pingBack.parentNode;
			}
			
			pingBack.parentNode.insertBefore(<?php echo $quicktag_title?>Link, pingBack);
			<?php echo $quicktag_title?>Link.style.display = 'block';			
		}

		function edInsertFLV() {
			new_window = window.open ('<?php echo $quicktag_page_uri?>?sel_text=' + afc_tools_get_selection(), 'newwindow', config='height=600, width=650, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
			new_window.focus();
		}

	//-->
</script>