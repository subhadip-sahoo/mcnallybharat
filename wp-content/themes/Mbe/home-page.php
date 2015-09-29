<?php
/* Template Name: Home */
get_header();
?>
<div class="main_contaner homepage">
    <?php
        $args_news = query_posts(array(
            'post_type' => 'manufacture',
            'order' => 'ASC',
            'posts_per_page' => 4
        ));
        if(have_posts()):
            while(have_posts()):
                the_post();
                $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
    ?>
    <div class="colx">
        <div class="set_img"> 
            <?php
                if(!empty($image[0])){
            ?>
            <img src="<?php echo $image[0];?>" title="" alt="" /> 
            <?php } ?>
        </div>
        <div class="col_text">
            <h1><?php the_title();?> Factory</h1>
            <p style="text-align: justify;"><?php echo mb_strimwidth(trim(get_the_excerpt(get_the_ID())), 0, 80, "...");?></p>
        </div>
        <a href="<?php the_permalink();?>" class="read_more">more</a> 
    </div>
    <?php
            endwhile;
            wp_reset_query();
        endif;
    ?>
  <!--colx_End--> 
  
</div>
<?php get_footer();?>

