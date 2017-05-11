/*
Bones Scripts File
Author: Eddie Machado

This file should contain any js scripts you want to add to the site.
Instead of calling it in the header or throwing it inside wp_head()
this file will be called automatically in the footer so as not to
slow the page load.

*/

// IE8 ployfill for GetComputed Style (for Responsive Script below)
if (!window.getComputedStyle) {
    window.getComputedStyle = function(el, pseudo) {
        this.el = el;
        this.getPropertyValue = function(prop) {
            var re = /(\-([a-z]){1})/g;
            if (prop == 'float') prop = 'styleFloat';
            if (re.test(prop)) {
                prop = prop.replace(re, function () {
                    return arguments[2].toUpperCase();
                });
            }
            return el.currentStyle[prop] ? el.currentStyle[prop] : null;
        }
        return this;
    }
}



// as the page loads, call these scripts
jQuery(document).ready(function($) {

    function getExpiration() {
        var date = new Date();
        var minutes = 30;
        date.setTime(date.getTime() + (minutes * 60 * 1000));
        return date;
    }

    var isLeftFadeIn = true;
    function closeFloatBottomLeft(el) {
        var date = getExpiration();
        if (isLeftFadeIn) {
            $("#floatbottomadleft").fadeOut("slow", function () {
                if (el) {
                    $(el).html("+Open");
                }
                isLeftFadeIn = false;

                $.cookie("closeFloattingBottomLeft", "true", { expires: date });
            });
        } else {
            $("#floatbottomadleft").fadeIn("slow", function () {
                if (el) {
                    $(el).html("-Close");
                }
                isLeftFadeIn = true;
                $.cookie("closeFloattingBottomLeft", "false", { expires: date });
            });
        }
    }
    var isRightFadeIn = true;
    function closeFloatBottomRight(el) {
        var date = getExpiration();
        if (isRightFadeIn) {
            $("#floatbottomadright").fadeOut("slow", function () {
                $(el).html("+Open");
                isRightFadeIn = false;
                $.cookie("closeFloattingBottomRight", "true", { expires: date });
            });
        } else {
            $("#floatbottomadright").fadeIn("slow", function () {
                $(el).html("-Close");
                isRightFadeIn = true;
                $.cookie("closeFloattingBottomRight", "false", { expires: date });
            });
        }
    }

    $("#hpCloseRight").click(function(event) {
        closeFloatBottomRight(this);
    });    

    $("#hpCloseLeft").click(function(event) {
        closeFloatBottomLeft(this);
    });

    function closeFloatingBottomAd() {
        var date = getExpiration();
        $(".floatbottomad").fadeOut("slow", function () {
            $("a.close-but").html("+Open");
            $.cookie("closeFloattingBottomLeft", "true", { expires: date });
            $.cookie("closeFloattingBottomRight", "true", { expires: date });
        });

    }

    function closeFloatingLeftAd() {
        $(".floating-left").fadeOut("slow", function () {

        });
    }

    var closeFloatingLeft = $.cookie("closeFloatingLeft");
    var closeFloattingBottomLeft = $.cookie("closeFloattingBottomLeft");
    var closeFloattingBottomRight = $.cookie("closeFloattingBottomRight");

    if (closeFloattingBottomLeft == "true") {

        $("#floatbottomadleft").fadeOut("slow", function () {
            $("#hpCloseLeft").html("+Open");
            isLeftFadeIn = false;
        });
    }

    if (closeFloattingBottomRight == "true") {
        //console.log("Right");
        $("#floatbottomadright").fadeOut("slow", function () {
            $("hpCloseRight").html("+Open");
            isRightFadeIn = false;
        });
    }

    // ul last li
    jQuery('ul').each(function(){ jQuery(this).find('li:last').addClass('last'); });
    // ul first li
    jQuery('ul').each(function(){ jQuery(this).find('li:first').addClass('first'); });
    /*Slider*/
    var owl_slider;
    owl_slider = jQuery("#owl-slider");
    owl_slider.owlCarousel({
        autoplay : true,
        loop: true,
        items: 1,
        nav:true,
        dots: false,
        navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
        //lazyLoad: true,
        autoplayHoverPause: true
    });
    var owl_popular;
    owl_popular = jQuery("#owl-popular");
    owl_popular.owlCarousel({
        autoplay : true,
        loop: true,
        margin: 15,
        nav: true,
        dots: false,
        navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
        lazyLoad: false,
        responsiveClass: false,
        responsive:{
            0:{
                items:1,
            },
            480:{
                items:2,
            },
            600:{
                items:3,
            },
            1000:{
                items:5,
            }
        }
    });
    /*Scroll to Top*/
    jQuery('.scrollTo').on('click', scrollToTop);
    function scrollToTop() {
        verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
        element = jQuery('body');
        offset = element.offset();
        offsetTop = offset.top;
        jQuery('html, body').animate({scrollTop: offsetTop}, 500, 'linear');
    }
    /*Menu mobile*/
    jQuery(".navbar-toggle").click(function(){
        jQuery('body').addClass('mnopen');
    })
    jQuery(".close-menu").click(function(){
        jQuery('body').removeClass('mnopen');
    })
    // Button share
    //var post_img = jQuery('meta[property="og:image"]').attr('content');
    var post_title = jQuery('meta[property="og:title"]').attr('content').replace(" | Kênh thông tin tuyển sinh", "");
    var post_url = jQuery('meta[property="og:url"]').attr('content').replace("", "");
    //facebook
    jQuery('a.btn_facebook').click(function(e) {
        var url = 'https://www.facebook.com/sharer/sharer.php?u=' + urlEncode(post_url) + '&t=' + post_title;
        var newwindow = window.open(url, '_blank', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=450,width=710');
        if (window.focus) {
            newwindow.focus();
        }
        e.preventDefault();
    });
    //google+
    jQuery('a.btn_google').click(function(e) {
        var url = 'https://plus.google.com/share?url=' + urlEncode(post_url);
        var newwindow = window.open(url, '_blank', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=450,width=520');
        if (window.focus) {
            newwindow.focus();
        }
        e.preventDefault();
    });
    //twitter
    jQuery('a.btn_twitter').click(function(e) {
        var url = 'https://twitter.com/intent/tweet?source=webclient&text=' + post_title + '+' + urlEncode(post_url);
        var newwindow = window.open(url, '_blank', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=450,width=710');
        if (window.focus) {
            newwindow.focus();
        }
        e.preventDefault();
    });
    
    /* getting viewport width */
    var responsive_viewport = $(window).width();
    
    /* if is below 481px */
    if (responsive_viewport < 481) {
    
    } /* end smallest screen */
    
    /* if is larger than 481px */
    if (responsive_viewport > 481) {
        
    } /* end larger than 481px */
    
    /* if is above or equal to 768px */
    if (responsive_viewport >= 768) {
    
        /* load gravatars */
        $('.comment img[data-gravatar]').each(function(){
            $(this).attr('src',$(this).attr('data-gravatar'));
        });
        
    }
    
    /* off the bat large screen actions */
    if (responsive_viewport > 1030) {
        
    }
    
	
	// add all your scripts here
	
 
}); /* end of as page load scripts */

function urlEncode(str){
    str = (str + '').toString();
    return encodeURIComponent(str).replace(/#!/g, '%23').replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+');
}
//For box scroll comment single
var isFullBox=false;
function showFullBoxComment(){
    if(!jQuery('.box_comment_fixed').hasClass('hide_box_comment'))
        isFullBox =! isFullBox;
    jQuery('.box_comment_fixed').removeClass('hide_box_comment');
    if(isFullBox){
        jQuery('.box_comment_fixed').addClass('full_box_comment');
    }
    else{
        jQuery('.box_comment_fixed').removeClass('full_box_comment');
    }
}

function closeBoxComment(){
    jQuery('.box_comment_fixed').addClass('hide_box_comment');
}


/*! A fix for the iOS orientationchange zoom bug.
 Script by @scottjehl, rebound by @wilto.
 MIT License.
*/
(function(w){
	// This fix addresses an iOS bug, so return early if the UA claims it's something else.
	if( !( /iPhone|iPad|iPod/.test( navigator.platform ) && navigator.userAgent.indexOf( "AppleWebKit" ) > -1 ) ){ return; }
    var doc = w.document;
    if( !doc.querySelector ){ return; }
    var meta = doc.querySelector( "meta[name=viewport]" ),
        initialContent = meta && meta.getAttribute( "content" ),
        disabledZoom = initialContent + ",maximum-scale=1",
        enabledZoom = initialContent + ",maximum-scale=10",
        enabled = true,
		x, y, z, aig;
    if( !meta ){ return; }
    function restoreZoom(){
        meta.setAttribute( "content", enabledZoom );
        enabled = true; }
    function disableZoom(){
        meta.setAttribute( "content", disabledZoom );
        enabled = false; }
    function checkTilt( e ){
		aig = e.accelerationIncludingGravity;
		x = Math.abs( aig.x );
		y = Math.abs( aig.y );
		z = Math.abs( aig.z );
		// If portrait orientation and in one of the danger zones
        if( !w.orientation && ( x > 7 || ( ( z > 6 && y < 8 || z < 8 && y > 6 ) && x > 5 ) ) ){
			if( enabled ){ disableZoom(); } }
		else if( !enabled ){ restoreZoom(); } }
	w.addEventListener( "orientationchange", restoreZoom, false );
	w.addEventListener( "devicemotion", checkTilt, false );
})( this );

jQuery(document).ready(function($) {
    jQuery("#serverLink a").click(function(event) {
        var id = jQuery(this).data('id');
        var sttvideo = jQuery(this).data('sttvideo');
        var type = jQuery(this).data('type');
        jQuery('#serverLink li').removeClass('active');
        jQuery(this).parents('li').addClass('active');
        jQuery.ajax({
            url : ajax_url,
            type : 'post',
            data : {
                post_id : id,
                type : type,
                sttvideo : sttvideo,
                action : 'ajax_livestream',
            },
            // dataType: 'JSON',
            success : function( response ) {
                $("#player_container").html(response);
            }
        });
        return false;
        // jQuery('#serverLink li').removeClass('active');
        // $(this).parents('li').addClass('active');
        // var id = $(this).data('id');
        // var sttvideo = $(this).data('sttvideo');
        // var type = $(this).data('type');
        // $("#player_container").slideDown(200);
        // str = '<iframe  src="/liveplayer?id=' + id + '&type=' + type + '&mid=' + sttvideo + '" scrolling="no" height="100%" width="100%" frameborder="0"></iframe>';
        // $("#player_container").html(str);
        // if (id) $("html,body").animate({
        //     scrollTop: $("#versus").offset().top
        // }, "slow")
    });
    jQuery('#fillter-giaidau.league-nav li a').click(function(e) {  
        var data_show = $(this).attr('data-query');
        if(data_show == 'all'){
            $(".matches, .matches > .internalSoccer").show();  
        }else{
            $(".matches, .matches > .internalSoccer").hide();        
            $(".matches > .internalSoccer[data="+data_show+"]").show();        
            $(".matches > .internalSoccer[data="+data_show+"]").parent().show();              
        }
              
        return false;
    });

    jQuery('#fillter-time.league-nav li a').click(function(e) { 
        var data_show = $(this).attr('data-time');
        
        if(data_show == 'all'){
            $(".matches, .matches > .internalSoccer").show();  
        }else{
            $(".matches, .matches > .internalSoccer").hide();        
            $(".matches > .internalSoccer[time~="+data_show+"]").show();        
            $(".matches > .internalSoccer[time~="+data_show+"]").parent().show();              
        }        
        return false;
    });
});