$(document).ready(function() {
    var ww = document.body.clientWidth;
    var adjustMenu = function() {
        if (ww < 1000) {
            $(".toggleMenu").css("display", "inline-block");
            if (!$(".toggleMenu").hasClass("active")) {
                $(".nav").hide();
            } else {
                $(".nav").show();
            }
            $(".nav li").unbind('mouseenter mouseleave');
            $(".nav li a.parent").unbind('click').bind('click', function(e) {
                // must be attached to anchor element to prevent bubbling
                e.preventDefault();
                $(this).parent("li").toggleClass("hover");
            });
        } 
        else if (ww >= 800) {
            $(".toggleMenu").css("display", "none");
            $(".nav").show();
            $(".nav li").removeClass("hover");
            $('.nav li a.parent').each(function(){
                if($(this).attr('href') == '#'){
                    $(this).attr('href','javascript:void(0)');
                }
            });
//            $('#menu-item-385 a').text('General Duty Impactor (EK Series)');
//            $('#menu-item-819 a').text('EOT Crane');
//            $('#menu-item-1576 a').text('ELL Crane');
//            $('#menu-item-1577 a').text('LLTT Crane');
//            $('#menu-item-860 a').text('Life At MSEL');
//            $(".nav li ul li").not('.nav > li#menu-item-594 ul li').unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {		 	
//                $(this).toggleClass('hover');
//            });
            $(document).delegate(".nav li",'click', function() {		 	
                $(this).siblings().removeClass("hover");
                $(this).addClass('hover');
            });
            $(window).on('click', function(event){
                var target_el = event.target;
                if($(target_el).attr('class') != 'parent'){
                    if($('.nav li').hasClass('hover')){
                        $('.nav li').removeClass('hover');
                    }
                }
            });
        }
    }
    $(".nav li a").each(function() {
        if ($(this).next().length > 0) {
            $(this).addClass("parent");
        };
    })

    $(".toggleMenu").click(function(e) {
        e.preventDefault();
        $(this).toggleClass("active");
        $(".nav").toggle();
    });
    adjustMenu();
    
    $(window).bind('resize orientationchange', function() {
        ww = document.body.clientWidth;
        adjustMenu();
    });
});

