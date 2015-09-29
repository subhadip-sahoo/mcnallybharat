<?php get_header();?>
<div class="main_contaner">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php
            if(have_posts()):
                while(have_posts()):
                    the_post();
        ?>
        <h2 class="page-title"><?php the_title();?></h2>
        <div class="page-con clearfix" style="text-align: justify;"> 
	   <?php
                the_content();
                endwhile;
            endif;
        ?>
        </div>
        <div class="clr"></div>
    </article>
</div>
<?php get_footer();?>