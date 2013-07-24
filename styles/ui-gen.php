<?php 
	ob_start("ob_gzhandler");
    Header ("Content-type: text/css");
    $theme ='themes/';
    if(isset($_GET["theme"])){
		$theme .= $_GET["theme"];
    } else {
		$theme .= "default";
    }
	
	if(!isset($_GET['part'])){
		require_once($theme."/notification.css");
		require_once($theme."/ui-general.css");
		require_once($theme."/jquery-ui.css");
	}
	
    if(isset($_GET['accordion']))require_once($theme."/jquery.ui.accordion.css");
	if(isset($_GET['ac']))require_once($theme."/jquery.autocomplete.css");
	if(isset($_GET['jqdash']))require_once($theme."/jdashboard.css");
    if(isset($_GET['form']))require_once($theme."/form.css");
    if(isset($_GET['subform']))require_once($theme."/subform.css");
    if(isset($_GET['slider']))require_once($theme."/slider.css");
	if(isset($_GET['sliderjquery']))require_once($theme."/slider.css");
    if(isset($_GET['password']))require_once($theme."/password.css");
    if(isset($_GET['chat']))require_once($theme."/chatbox.css");
    if(isset($_GET['dp']))require_once($theme."/datepicker.css");
    if(isset($_GET['oc']))require_once($theme."/orgchart.css");
    if(isset($_GET['flex']))require_once($theme."/flexigrid.css");
    if(isset($_GET['tb']))require_once($theme."/toolbar.css");
    if(isset($_GET['chosen']))require_once($theme."/chosen.css");
    if(isset($_GET['cssdock']))require_once($theme."/dock.css");
    if(isset($_GET['dialogform']))require_once($theme."/dialogform.css");
    if(isset($_GET['clock']))require_once($theme."/analog.css");
    if(isset($_GET['cbox']))require_once($theme."/checkbox.css");
    if(isset($_GET['vc']))require_once($theme."/vacsched.css");
    if(isset($_GET['ls']))require_once($theme."/listselection.css");
    if(isset($_GET['main']))require_once($theme."/main.css");
	if(isset($_GET['slick']))require_once($theme."/slick-default-theme.css");
	if(isset($_GET['scroll']))require_once($theme."/jquery.mCustomScrollbar.css");
	if(isset($_GET['slick']))require_once($theme."/slick.css");
	if(isset($_GET['fc'])){
		require_once($theme."/fullcalendar.css");
		require_once($theme."/fullcalendar.print.css");
	}
	if(isset($_GET['slick-grid']))require_once($theme."/slick.grid.css");
 	if(isset($_GET['slick-pager']))require_once($theme."/slick.pager.css");
  	if(isset($_GET['slick-column']))require_once($theme."/slick.columnpicker.css");
	if(isset($_GET['jqplot']))require_once($theme."/jquery.jqplot.min.css");
	if(isset($_GET['jqgrid']))require_once($theme."/jquery.gridster.min.css");
	if(isset($_GET['feed'])) {
			require_once($theme."/feed.css");
	}
	if(isset($_GET['uidp']))require_once($theme."/jquery.ui.datepicker.css");
	if(isset($_GET['messi']))require_once($theme."/messi.min.css");
	if(isset($_GET['mobi'])){
			require_once($theme."/mobiscroll.core.css");
			require_once($theme."/mobiscroll.animation.css");
			if(isset($_GET['ios']))require_once($theme."/mobiscroll.ios.css");
			if(isset($_GET['jqm']))require_once($theme."/mobiscroll.ios.css");
			if(isset($_GET['android']))require_once($theme."/mobiscroll.android.css");
	}
?>

  