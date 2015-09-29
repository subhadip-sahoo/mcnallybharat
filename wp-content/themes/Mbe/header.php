<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php wp_title('|', TRUE, 'right');?></title>
<meta name="viewport" content="width=device-width">
<link href="<?php echo get_template_directory_uri();?>/css/style.css" type="text/css" rel="stylesheet" media="all" />
<link rel="shortcut icon" href="<?php echo get_template_directory_uri();?>/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo get_template_directory_uri();?>/images/favicon.ico" type="image/x-icon">
<?php wp_head();?>
<link href="<?php echo get_template_directory_uri();?>/css/iphone.css" type="text/css" rel="stylesheet" media="all" />
<link href="<?php echo get_template_directory_uri();?>/css/responsive.css" type="text/css" rel="stylesheet" media="all" />
<link href="<?php echo get_template_directory_uri();?>/css/tablet.css" type="text/css" rel="stylesheet" media="all" />
<link href="<?php echo get_template_directory_uri();?>/css/jquery.bxslider.css" type="text/css" rel="stylesheet" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/css/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js"></script>

<script type="text/javascript">
	var message="Function Disabled!"; 
	function clickIE4(){ 
		 if (event.button==2){ 
			alert(message); 
			return false; 
		} 
	} 
	function clickNS4(e){
		if (document.layers||document.getElementById&&!document.all){ 
			if (e.which==2||e.which==3){
				alert(message); return false; 
			} 
		} 
	} 
	if (document.layers){ 
		document.captureEvents(Event.MOUSEDOWN); 
		document.onmousedown=clickNS4; 
	} else if (document.all&&!document.getElementById){ 
		document.onmousedown=clickIE4; 
	} 
	document.oncontextmenu = new Function("return false"); 
</script>
<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/jquery-1.7.2.min.js"></script> 
<script src="<?php echo get_template_directory_uri();?>/js/jquery.bxslider.min.js"></script>
<script type="text/javascript">
$.fn.mbe_ucwords = function() {
  return this.each(function(){
    var val = $(this).text();
    var newVal = '';
    val = val.split(' ');

    for(var c=0; c < val.length; c++) {
      newVal += val[c].substring(0,1).toUpperCase() + val[c].substring(1,val[c].length).toLowerCase() + (c+1==val.length ? '' : ' ');
    }
    $(this).text(newVal);
  });
}

$.fn.mbe_thumb_caption = function() {
  return this.each(function(){
    var val = $(this).text();
    var newVal = '';
    val = val.split(' ');

    for(var c=0; c < val.length; c++) {
      newVal += val[c].substring(0,1).toUpperCase() + val[c].substring(1,val[c].length).toUpperCase() + (c+1==val.length ? '' : ' ');
    }
    $(this).text(newVal);
  });
}

$(document).ready(function(){
	
    $('.bxslider').bxSlider({
        slideWidth: 1000,
        minSlides: 1,
        maxSlides: 1,
        slideMargin: 0,
        controls:false,
        pager:false,
        auto:true,
        autoHover: true
    });
    $('#cat_banner_images').bxSlider({
        controls:false,
        pager:true,
        infiniteLoop: true,
        hideControlOnEnd: true,
        autoControls: false,
        autoControls: true,
        auto:true
    });
	$('.menu_con ul.nav li:last').children('a').css('border','none');
    
//	$('.nav a').mbe_ucwords();
	$('.ngg-gallery-thumbnail span').mbe_thumb_caption();
        var offset = 220;
        var duration = 500;
        $(window).scroll(function() {
            if ($(this).scrollTop() > offset) {
                $('.crunchify-top').fadeIn(duration);
            } else {
                $('.crunchify-top').fadeOut(duration);
            }
        });

        $('.crunchify-top').click(function(event) {
            event.preventDefault();
            $('html, body').animate({scrollTop: 0}, duration);
            return false;
        })
});
</script>
<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.fancybox').fancybox();
    });
</script>
 <script type="text/JavaScript"> 
	<!--
	function MM_openBrWindow(theURL,winName,features) { //v2.0
	  window.open(theURL,winName,features);
	}
	//MM_reloadPage(true);
	 
	function MM_openBrWindow1(theURL,winName,features) { //v2.0
	  window.open(theURL,winName,features);
	}
	//-->
</script>
<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/script.js"></script>
<?php 
	if(is_page('Submit CV Online')){
?>
<script type="text/javascript">
    $(function(){				
        //alert($('input[type=radio][name=advertise]').val());
        $('input[type=radio][name=advertise]').change(function(){				
            if($(this).val() == 'Yes'){					
                    $('#ad_options').show();
            }else if($(this).val() == 'No'){
                    $('#ad_options').hide();
            }
        });	

        $('input[type=radio][name=prev-empolyee]').change(function(){				
            if($(this).val() == 'Yes'){					
                    $('#prev_employess').show();
            }else if($(this).val() == 'No'){
                    $('#prev_employess').hide();
            }
        });

        $('input[type=radio][name=interview]').change(function(){				
            if($(this).val() == 'Yes'){					
                    $('#prev_interview').show();
            }else if($(this).val() == 'No'){
                    $('#prev_interview').hide();
            }
        });

        $('input[type=radio][name=relative-employee]').change(function(){				
            if($(this).val() == 'Yes'){					
                    $('#relative_empolyee').show();
            }else if($(this).val() == 'No'){
                    $('#relative_empolyee').hide();
            }
        });
    });
</script>
<?php		
	} 
?>

</head>
<body <?php body_class();?>>
<header class="wrap_area">
    <div class="logo_area"> <a href="<?php echo home_url();?>"><img src="<?php header_image();?>" title="MBE" alt="Logo" /></a> </div>
  <div class="search_area">
    <h2><?php echo get_option('blogdescription');?></h2>
    <form method="get" action="<?php echo home_url('/');?>" id="search">
      <input name="s" type="text" size="40" placeholder="Search..." />
    </form>
  </div>
  <div class="clr"></div>
  <!--Menu-->
  <div class="menu_con"> <a class="toggleMenu" href="#">Menu</a>
      <?php
        $args = array(
                'theme_location'  => 'primary',
                'menu'            => '',
                'container'       => '',
                'container_class' => '',
                'container_id'    => '',
                'menu_class'      => 'menu',
                'menu_id'         => '',
                'echo'            => true,
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '<ul class="nav" id="header_main_menu">%3$s</ul>',
                'depth'           => 0,
                'walker'          => ''
        );
        wp_nav_menu( $args );
    ?>
  </div>
  <?php if(is_front_page()){?>
  <div class="banner_aside">
  
		
    <div id="bennar"> 
		<ul id="cat_banner_images">
		<?php
			$product_categories = get_categories(array('taxonomy' => 'product-categories', 'hide_empty' => 0, 'orderby' => 'id', 'order' => 'ASC'));
			/*echo '<pre>';
			print_r($product_categories);*/
			foreach($product_categories as $product_category){					
				$url = str_replace('product-categories/', '', get_term_link( $product_category->name,'product-categories' ));
				$cat_slider_image_id = $product_category->taxonomy."_".$product_category->term_id; 				
				$cat_slider_image = get_field('taxonomy_slider_image', $cat_slider_image_id);				
				if(empty($cat_slider_image)){
                                    continue;
				}
				$image = vt_resize('', $cat_slider_image, 845, 395, true);
		?>
			<li><a href="<?php echo 'javascript:void(0);'; //$url;?>"><img src="<?php echo $image['url'];?>" title="" alt="" width="<?php echo $image['width'];?>" height="<?php echo $image['height'];?>"/></a><span class="slider-text"><?php echo $product_category->name;?></span></li>			
		<?php					
			}
			wp_reset_query();
		?>
		</ul>
      <div class="tag_box">
        <ul class="bxslider">
            <?php
                query_posts(array(
                    'post_type' => 'news',
                    'order' => 'DESC'
                ));
                if(have_posts()):
                    while(have_posts()):
                        the_post();
            ?>
            <li><a href="<?php echo the_permalink();?>"><?php the_title();?></a></li>
            <?php
                    endwhile;
                    wp_reset_query();
                endif;
            ?>
        </ul>
      </div>
      <!--tag_box_End--> 
    </div>
    <!--bennar_End-->
    
    <div class="category_list">
      <div class="hd_title">
        <h1>Industries</h1>
      </div>
    <?php
        $args_industries = array(
                'theme_location'  => 'industries',
                'menu'            => '',
                'container'       => '',
                'container_class' => '',
                'container_id'    => '',
                'menu_class'      => 'menu',
                'menu_id'         => '',
                'echo'            => true,
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '<ul class="catg_list">%3$s</ul>',
                'depth'           => 0,
                'walker'          => ''
        );
        wp_nav_menu( $args_industries );
    ?>
    </div>
    <!--category_list_End--> 
    
  </div>
  <!--banner_aside_end--> 
  <?php } ?>
  
<?php if(!is_front_page()){ ?>
  <div class="clr"></div>
  <div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
    <?php if(function_exists('bcn_display')){
        bcn_display();		
    }?>
</div>
<?php } ?>
</header>
<div class="clr"></div>