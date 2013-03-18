// this jQuery is used to hide the Notify Bar when the end user clicks the Hide This link

jQuery(document).ready(function() {
 
// the #mbj-notify-bar-wrapper id is hidden initially via the notify-bar.css file
     
  	 // show the Notify Bar only if the cookie is null (that is, the site has not been visited previously)
  	 if (jQuery.cookie('the_cookie') == null) { 
         jQuery('#mbj-notify-bar-wrapper').show();
     }
 	
	 // hide the Notify Bar as soon the hide link is clicked
     jQuery('#mbj-notify-bar-wrapper p#hide a').click(function() {
	 jQuery.cookie("the_cookie", "previously_visited", { path: '/' });
     jQuery('#mbj-notify-bar-wrapper').slideUp('medium');
     return false;
  
  });
});