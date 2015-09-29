<?php 
    get_header();
?>
<div class="main_contaner">
    <?php
        if(have_posts()):
            while(have_posts()):
                the_post();
    ?>
    <h2><?php the_title();?></h2>
    <?php
        the_content();
        $get_all_images = $wpdb->get_results("SELECT `meta_value` FROM {$wpdb->prefix}postmeta WHERE meta_key = '_easy_image_gallery' AND post_id = ".get_the_ID(), ARRAY_A);
        if(!empty($get_all_images)){
            foreach ($get_all_images as $image_ids) {
                $ids = explode(',', $image_ids['meta_value']);
                foreach ($ids as $id) {
                    $get_img_src = $wpdb->get_results("SELECT guid FROM {$wpdb->prefix}posts WHERE ID = {$id}", ARRAY_A);
                    if(!empty($get_img_src)){
                        foreach ($get_img_src as $img_src) {
                            $img = vt_resize('', $img_src['guid'], 175, 129, TRUE);
    ?>
                        <a class="fancybox" href="<?php echo $img_src['guid'];?>" data-fancybox-group="gallery"><img src="<?php echo $img['url'];?>" alt="" /></a>
    <?php
                        }
                    }   
                }
            }
        }
            endwhile;
        endif;
    ?>
    <div class="clr"></div>
</div>
<?php get_footer();?>