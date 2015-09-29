<?php get_header();?>
<div class="main_contaner news-page-list">
<header class="page-header">
    <h2 class="page-title page-title"><?php printf( __( '<i>Search Results for</i>: %s', 'shape' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
</header><!-- .page-header -->
 <ul class="news-list">
    <?php
        if(have_posts()):
            while(have_posts()):
                the_post();
    ?>
  		 <li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h4 class="news-list-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
            <div class="news-list-con"><?php echo strip_tags(substr(get_the_content(get_the_ID()), 0, 300));?> ...</div>
            <a href="<?php the_permalink();?>" class="read_more news-read">Read More</a> 
        </li>
    <?php
            endwhile;
            else :
            get_template_part( 'content', 'none' );
        endif;
        wp_reset_query();
    ?>
    </ul>
    <div class="clr"></div>
</div>
<?php get_footer();?>