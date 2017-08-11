<script type="text/javascript">
	// <![CDATA[		
	var so_{ITEM_ID} = new SWFObject("{COMPONENT_URI}", "{ITEM_ID}", "{WIDTH}", "{HEIGHT}", "7", "#FFFFFF");
	so_{ITEM_ID}.addParam("wmode", "transparent");
	so_{ITEM_ID}.addParam("FlashVars", "autoPlay={AUTOSTART}&autoBuffer=false&flvPath={PATH}&flvImage={SPLASH_PATH}&flvTitle={TITLE}&startFrame=1&bgColor={BGCOLOR}");

	//dynamically create div
	var sod_{ITEM_ID} = document.createElement('div');
	sod_{ITEM_ID}.setAttribute('id', '{ITEM_ID}-html');		
	sod_{ITEM_ID}.style.width = '{WIDTH}px';
 
	sod_{ITEM_ID}.innerHTML = '<div id="cont_a_{ITEM_ID}" class="highslide-move" style="height: 20px;"><a href="javascript://" onclick="return hs.closeId(\'{ITEM_ID}-anc\')" class="control" style="color:#666">Close (ESC)</a></div><div id="cont_b_{ITEM_ID}" class="highslide-body"></div>';

	//document.body.appendChild(sod_{ITEM_ID});
	// ]]>
</script>
<a href="{COMPONENT_URI}" id="{ITEM_ID}-anc" onclick="document.body.appendChild(sod_{ITEM_ID}); hs.htmlExpand(this, { swfObject: so_{ITEM_ID}, contentId: '{ITEM_ID}-html' } ); return false;" class="highslide">{TITLE}</a>