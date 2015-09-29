<?php
/* Template Name: Current Openings */
get_header();
global $post;
?>
<div class="main_contaner news-page-list">
    <h2 class="page-title"><?php the_title();?></h2>
    <ul class="news-list">
<?php 
    query_posts(array('post_type' => 'current-openings', 'posts_per_page' => 5));
    if(have_posts()):
        while(have_posts()):
        the_post();
?>
	<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h3 class="news-list-title"><?php the_title();?></h3>
        <div class="news-list-con">
            <table class="table table-bordered">
                <tr>
                    <th>Details</th>
                    <th>Description</th>
                </tr>
                <tr>
                    <td>Location</td>
                    <td><?php echo get_field('location');?></td>
                </tr>
                <tr>
                    <td>Qualification & Experience</td>
                    <td><?php the_content();?></td>
                </tr>
                <tr>
                    <td>Qualification & Experience</td>
                    <td><?php echo get_field('age');?></td>
                </tr>
            </table>
    	</div>
    </li>
<?php    
        endwhile;
    endif;
    wp_reset_query();
?></ul>
    <div class="clr"></div>
</div>
<?php get_footer();?>