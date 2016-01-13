jQuery(document).ready(function($){

	window.FDRhotspots = 0;
	var FDRhotspot = '<div class="fdr-hotspot" style="top:0%;left:0%">0</div>';

	$('.layout[data-layout="hotspot_section"] tr[data-field_name="hotspots"]').find('.add-row-end').click(function(){
		var hotspotParent = $(this).parents('.layout[data-layout="hotspot_section"]');
		var hotspotImg = 'http://dev.web3box.com/fender_raducu/wp-content/uploads/2016/01/hotspot2.png';
	});

});