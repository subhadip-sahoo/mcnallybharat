<div class="clr"></div>
<div class="main_rep">
  <div class="repar_area">
    <?php
        if(is_active_sidebar('sidebar-3')){
            dynamic_sidebar('sidebar-3');
        }
    ?>
  </div>
</div>
<!--main_rep_End-->
<div class="clr"></div>
<!--Footer Start-->
<div id="footer_contaner">
  <div class="fot_menu_bx">
    <h2>Download</h2>
    <?php
        $args_footer_product_menu1 = array(
                'theme_location'  => 'download',
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
                'items_wrap'      => '<ul class="fot_menu_box">%3$s</ul>',
                'depth'           => 0,
                'walker'          => ''
        );
        wp_nav_menu( $args_footer_product_menu1 );
    ?>
  </div>
  <div class="fot_menu_bx_facty">
    <h2>Manufacturing Facility</h2>
    <?php
        $args_footer2 = array(
                'theme_location'  => 'footer-menu2',
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
                'items_wrap'      => '<ul class="fot_menu_box">%3$s</ul>',
                'depth'           => 0,
                'walker'          => ''
        );
        wp_nav_menu( $args_footer2 );
    ?>
  </div>
  <div class="fot_menu_bx_associates">
    <h2>News</h2>
    <?php
        $args_footer3 = array(
                'theme_location'  => 'footer-menu3',
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
                'items_wrap'      => '<ul class="fot_menu_box">%3$s</ul>',
                'depth'           => 0,
                'walker'          => ''
        );
        wp_nav_menu( $args_footer3 );
    ?>
  </div>
  <div class="careers">
    <h2>Careers</h2>
    <?php
        $args_footer4 = array(
                'theme_location'  => 'footer-menu4',
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
                'items_wrap'      => '<ul class="fot_menu_box">%3$s</ul>',
                'depth'           => 0,
                'walker'          => ''
        );
        wp_nav_menu( $args_footer4 );
    ?>
  </div>
</div>
<!--footer_contaner_End-->
<div class="clr"></div>
<div id="footer-btm">
  <div class="container_fot">
       <?php
            if(is_active_sidebar('sidebar-4')){
                dynamic_sidebar('sidebar-4');
            }
        ?>
  </div>
</div>
<?php if(is_page(152)) : ?>
<a href="javascript:void(0);" class="crunchify-top">↑</a>
<?php endif; ?>
<?php wp_footer();?>
</body>
</html>