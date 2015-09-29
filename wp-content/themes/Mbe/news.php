<?php
/* Template Name: News */
get_header();
?>
<style>
.navigation li a,
.navigation li a:hover,
.navigation li.active a,
.navigation li.disabled {
    color: #fff;
    text-decoration:none;
}

.navigation li {
    display: inline;
}

.navigation li a,
.navigation li a:hover,
.navigation li.active a,
.navigation li.disabled {
    background-color: #6FB7E9;
    border-radius: 3px;
    cursor: pointer;
    padding: 12px;
    padding: 0.75rem;
}

.navigation li a:hover,
.navigation li.active a {
    background-color: #3C8DC5;
}
</style>
<div class="main_contaner news-page-lists">
    <h2 class="page-title"><?php the_title();?></h2>
    <ul class="news-list">
    <?php 
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        query_posts(array('post_type' => 'news', 'posts_per_page' => 10, 'paged' => $paged));
        if(have_posts()):
            while(have_posts()):
            the_post();
    ?>
    
        <li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h3 class="news-list-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
            <div class="news-list-con"><?php echo substr(get_the_content(get_the_ID()), 0, 500);?> ...</div>
            <a href="<?php the_permalink();?>" class="read_more news-read">Read More</a> 
        </li>
    
    <?php    
            endwhile;
            custom_numeric_posts_nav();
        endif;
        wp_reset_postdata();
    ?></ul>
    <div class="clr"></div>
</div>
<?php get_footer();?>

