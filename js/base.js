// NC STATE UNIVERSITY GLOBAL JAVASCRIPT (CORE)

/*
 * Core Javascript for NCState-NineSixty-Theme
 * Do not edit this file
 * Override any theme style defaults using the custom/js/custom.js file
 * Remember to backup the custom/custom.js file, and use restore it when upgrading the theme so you keep all your custom javascript intact
*/

// Quicklinks Dropdown
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_jumpMenuGo(selName,targ,restore){ //v3.0
  var selObj = MM_findObj(selName); if (selObj) MM_jumpMenu(targ,selObj,restore);
}
jQuery(document).ready(function() {
	
	if (jQuery('#edit-search-block-form--2')) {
		var search = jQuery('#edit-search-block-form--2');
	
		search.focus(function(){
	        if (search.val() == 'Search this site') {
	            search.val("");
	        }
	    }).blur(function(){
	        if (jQuery.trim(search.val()) == "") {
	            search.val('Search this site');
	        }
	    });
		
		search.val('Search this site');
		
		var $searchButton = jQuery('.form-submit', jQuery('#region-header-container'));
		
		// replace the search submit button with image
		
		var $input = jQuery('<input type="image" />')
					.addClass('ncstate-search-button')
					.attr('name', 'search')
					.attr('alt', 'search button')
					.attr('title', 'search this site')
					.attr('src', base_path + theme_path + '/images/base/head_btn_search.gif');
		$input.insertBefore($searchButton);
		
		$searchButton.remove();
		
	}
	
	
	
	
});
