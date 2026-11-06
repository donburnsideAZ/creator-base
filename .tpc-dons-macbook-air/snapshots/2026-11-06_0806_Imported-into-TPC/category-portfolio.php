<?php
/**
 * Template for Portfolio category and its children
 * 
 * Full-width list layout with image galleries that support lightbox.
 * Posts display: sub-category label, title, description, and media grid.
 *
 * @package Creator_Base
 */

get_header();

$category = get_queried_object();
$is_parent = ($category->parent == 0);
?>

<main id="primary" class="site-main portfolio-archive">

    <!-- Portfolio Header -->
    <header class="portfolio-header">
        <div class="portfolio-header-inner">
            <h1 class="portfolio-title"><?php single_cat_title(); ?></h1>
            <?php if (category_description()) : ?>
                <div class="portfolio-description">
                    <?php echo category_description(); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($is_parent) : ?>
                <?php
                // Show sub-category navigation for parent Portfolio category
                $subcats = get_categories(array(
                    'parent' => $category->term_id,
                    'hide_empty' => true,
                ));
                
                if ($subcats) :
                ?>
                <nav class="portfolio-subnav">
                    <ul>
                        <li class="current"><a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">All</a></li>
                        <?php foreach ($subcats as $subcat) : ?>
                        <li><a href="<?php echo esc_url(get_category_link($subcat->term_id)); ?>"><?php echo esc_html($subcat->name); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </header>

    <!-- Portfolio Items -->
    <div class="portfolio-items">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                
                // Get the most specific category (child category if exists)
                $post_cats = get_the_category();
                $display_cat = null;
                foreach ($post_cats as $cat) {
                    if ($cat->parent != 0) {
                        $display_cat = $cat;
                        break;
                    }
                }
                // Fallback to first category if no child found
                if (!$display_cat && !empty($post_cats)) {
                    $display_cat = $post_cats[0];
                }
        ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class('portfolio-item'); ?>>
            
            <?php if ($display_cat && $is_parent) : ?>
            <span class="portfolio-item-category">
                <a href="<?php echo esc_url(get_category_link($display_cat->term_id)); ?>">
                    <?php echo esc_html($display_cat->name); ?>
                </a>
            </span>
            <?php endif; ?>
            
            <h2 class="portfolio-item-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            
            <div class="portfolio-item-content">
                <?php the_content(); ?>
            </div>
            
            <?php
            // Check for gallery images in the post
            $gallery_images = get_post_gallery_images(get_the_ID());
            
            // Also check for attached images if no gallery
            if (empty($gallery_images)) {
                $attachments = get_attached_media('image', get_the_ID());
                if ($attachments) {
                    $gallery_images = array();
                    foreach ($attachments as $attachment) {
                        $gallery_images[] = wp_get_attachment_url($attachment->ID);
                    }
                }
            }
            
            if (!empty($gallery_images)) :
            ?>
            <div class="portfolio-gallery" data-lightbox-gallery>
                <?php 
                $count = count($gallery_images);
                $grid_class = ($count <= 3) ? 'gallery-cols-' . $count : 'gallery-cols-4';
                ?>
                <div class="portfolio-gallery-grid <?php echo esc_attr($grid_class); ?>">
                    <?php foreach ($gallery_images as $image_url) : ?>
                    <a href="<?php echo esc_url($image_url); ?>" class="portfolio-gallery-item" data-lightbox>
                        <img src="<?php echo esc_url($image_url); ?>" alt="" loading="lazy">
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php 
            // Show featured image if no gallery and has thumbnail
            if (empty($gallery_images) && has_post_thumbnail()) :
            ?>
            <div class="portfolio-featured-image">
                <a href="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" data-lightbox>
                    <?php the_post_thumbnail('large'); ?>
                </a>
            </div>
            <?php endif; ?>
            
        </article>
        
        <?php
            endwhile;
        else :
            get_template_part('template-parts/content', 'none');
        endif;
        ?>
    </div>
    
    <?php the_posts_pagination(array(
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
    )); ?>

</main>

<!-- Lightbox Modal -->
<div id="portfolio-lightbox" class="portfolio-lightbox" aria-hidden="true">
    <button class="lightbox-close" aria-label="Close lightbox">&times;</button>
    <button class="lightbox-prev" aria-label="Previous image">&lsaquo;</button>
    <button class="lightbox-next" aria-label="Next image">&rsaquo;</button>
    <div class="lightbox-content">
        <img src="" alt="" class="lightbox-image">
    </div>
</div>

<?php
get_footer();
