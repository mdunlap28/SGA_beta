// this jQuery is used in the Notify Bar plugin to make the farbtastic color picker work


jQuery(document).ready(function() {
	jQuery('#ilctabscolorpicker-background').hide();
	jQuery('#ilctabscolorpicker-background').farbtastic('#background_color');
	jQuery("#background_color").click(function(){jQuery('#ilctabscolorpicker-background').slideToggle()});
});


jQuery(document).ready(function() {
	jQuery('#ilctabscolorpicker-headline').hide();
	jQuery('#ilctabscolorpicker-headline').farbtastic('#headline_color');
	jQuery("#headline_color").click(function(){jQuery('#ilctabscolorpicker-headline').slideToggle()});
});


jQuery(document).ready(function() {
	jQuery('#ilctabscolorpicker-message').hide();
	jQuery('#ilctabscolorpicker-message').farbtastic('#message_color');
	jQuery("#message_color").click(function(){jQuery('#ilctabscolorpicker-message').slideToggle()});
});


jQuery(document).ready(function() {
	jQuery('#ilctabscolorpicker-link').hide();
	jQuery('#ilctabscolorpicker-link').farbtastic('#link_color');
	jQuery("#link_color").click(function(){jQuery('#ilctabscolorpicker-link').slideToggle()});
});

