<?php
/* Template Name: Product Brochure */
get_header();
?>
<div class="main_contaner">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h2 class="page-title"><?php the_title();?></h2>
        <div class="page-con clearfix" style="text-align: justify;"> 
	   <div class="page-con clearfix">
               <?php query_posts(array('post_type' => 'product-brochures', 'posts_per_page' => -1, 'order' => 'ASC'));  ?>
               <?php if(have_posts()) : ?>
                <ul class="download-list download-list3">
                    <?php while(have_posts()) : the_post(); ?>
                    <?php $pdf_id = get_field('product_brochure_pdf'); ?>
                    <?php $thumbnail_id = get_post_meta( $pdf_id, '_thumbnail_id', true ); ?>
                    <?php $thumb_src = wp_get_attachment_image_src ( $thumbnail_id, 'medium' ); ?>
                    <li class="download-list-pdf">
                        <a href="<?php echo wp_get_attachment_url( $pdf_id ); ?>" target="_blank" title="<?php echo esc_attr( get_the_title( $pdf_id ) ); ?>">			<div class="product_img_part">
                            <?php if(!empty($thumb_src[0])): ?>
                            <img src="<?php echo $thumb_src[0]; ?>" width="<?php echo $thumb_src[1]; ?>" height="<?php echo $thumb_src[2]; ?>" alt="" />						</div>
                            <?php endif; ?>
                            <p><?php the_title(); ?></p>
                        </a> 
                    </li>
                    <?php endwhile; ?>
                    <?php wp_reset_query(); ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="clr"></div>
    </article>
</div>
<?php get_footer(); ?>
