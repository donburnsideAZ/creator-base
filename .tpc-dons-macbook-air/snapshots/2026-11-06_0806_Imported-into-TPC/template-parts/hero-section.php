<?php
/**
 * Template part for displaying the hero section stack
 * 
 * Includes: Hero area, horizontal promo bar, featured links menu
 * Used by: front-page.php, single.php (when enabled), page-hero.php template
 *
 * @package Creator_Base
 */

// Hero Section
$hero_type = get_theme_mod('creator_base_hero_type', 'video');

if ($hero_type === 'video') :
    // Get sticky post first, otherwise latest
    $sticky = get_option('sticky_posts');
    
    if (!empty($sticky)) {
        $hero_query = new WP_Query(array(
            'post__in'            => $sticky,
            'posts_per_page'      => 1,
            'ignore_sticky_posts' => 1,
        ));
    } else {
        $hero_query = new WP_Query(array(
            'posts_per_page' => 1,
        ));
    }
    
    if ($hero_query->have_posts()) :
        $hero_query->the_post();
        // Store hero post ID for excluding from card grid (used by front-page.php)
        $GLOBALS['creator_base_hero_post_id'] = get_the_ID();
?>
<section class="hero-section">
    <div class="hero-inner<?php echo !is_active_sidebar('hero-sidebar') ? ' hero-inner--centered' : ''; ?>">
        <div class="hero-main">
            <span class="hero-category">
                <?php creator_base_category_badge(); ?>
            </span>
            
            <h1 class="hero-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h1>
            
            <div class="hero-excerpt">
                <?php 
                $excerpt = creator_base_get_excerpt_with_embeds();
                if ($excerpt) {
                    // Already sanitized in the function, output directly
                    echo $excerpt;
                } else {
                    the_excerpt();
                }
                ?>
            </div>
            
            <div class="hero-meta">
                <span class="hero-date"><?php echo get_the_date(); ?></span>
                <div class="hero-tags">
                    <?php echo creator_base_get_hashtags(); ?>
                </div>
            </div>
        </div>
        
        <?php if (is_active_sidebar('hero-sidebar')) : ?>
        <aside class="hero-sidebar">
            <?php dynamic_sidebar('hero-sidebar'); ?>
        </aside>
        <?php endif; ?>
    </div>
</section>
<?php 
    wp_reset_postdata();
    endif;

elseif ($hero_type === 'banner') : 
    // Banner hero content
    $hero_title = get_theme_mod('creator_base_hero_title', '');
    $hero_desc = get_theme_mod('creator_base_hero_description', '');
    $hero_btn_text = get_theme_mod('creator_base_hero_button_text', '');
    $hero_btn_url = get_theme_mod('creator_base_hero_button_url', '');
    $hero_bg_image = get_theme_mod('creator_base_hero_bg_image', '');
    
    // Show banner if there's an image OR any text content
    if ($hero_bg_image || $hero_title || $hero_desc) :
        // Check if we have any text content to overlay
        $has_content = $hero_title || $hero_desc || ($hero_btn_text && $hero_btn_url);
?>
<section class="hero-section hero-section--banner">
    <?php if ($has_content) : ?>
    <div class="hero-inner">
        <div class="hero-main">
            <?php if ($hero_title) : ?>
                <h1 class="hero-title"><?php echo esc_html($hero_title); ?></h1>
            <?php endif; ?>
            
            <?php if ($hero_desc) : ?>
                <div class="hero-excerpt">
                    <p><?php echo esc_html($hero_desc); ?></p>
                </div>
            <?php endif; ?>
            
            <?php if ($hero_btn_text && $hero_btn_url) : ?>
                <div class="hero-meta">
                    <a href="<?php echo esc_url($hero_btn_url); ?>" class="button"><?php echo esc_html($hero_btn_text); ?></a>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if (is_active_sidebar('hero-sidebar')) : ?>
        <aside class="hero-sidebar">
            <?php dynamic_sidebar('hero-sidebar'); ?>
        </aside>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</section>
<?php 
    endif;

elseif ($hero_type === 'carousel') :
    // Carousel hero - collect slides that have images
    $slides = array();
    for ($i = 1; $i <= 4; $i++) {
        $image = get_theme_mod("creator_base_carousel_image_{$i}", '');
        if ($image) {
            $slides[] = array(
                'image' => $image,
                'title' => get_theme_mod("creator_base_carousel_title_{$i}", ''),
                'desc'  => get_theme_mod("creator_base_carousel_desc_{$i}", ''),
                'url'   => get_theme_mod("creator_base_carousel_url_{$i}", ''),
            );
        }
    }
    
    if (!empty($slides)) :
?>
<section class="hero-section hero-section--carousel">
    <div class="carousel-container">
        <div class="carousel-track">
            <?php foreach ($slides as $index => $slide) : ?>
            <div class="carousel-slide<?php echo $index === 0 ? ' active' : ''; ?>">
                <?php if ($slide['url']) : ?>
                <a href="<?php echo esc_url($slide['url']); ?>" class="carousel-link">
                <?php endif; ?>
                    <div class="carousel-image" style="background-image: url('<?php echo esc_url($slide['image']); ?>');"></div>
                    <?php if ($slide['title'] || $slide['desc']) : ?>
                    <div class="carousel-content">
                        <?php if ($slide['title']) : ?>
                            <h2 class="carousel-title"><?php echo esc_html($slide['title']); ?></h2>
                        <?php endif; ?>
                        <?php if ($slide['desc']) : ?>
                            <p class="carousel-desc"><?php echo esc_html($slide['desc']); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                <?php if ($slide['url']) : ?>
                </a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php if (count($slides) > 1) : ?>
        <div class="carousel-dots">
            <?php foreach ($slides as $index => $slide) : ?>
            <button class="carousel-dot<?php echo $index === 0 ? ' active' : ''; ?>" aria-label="<?php echo esc_attr(sprintf(__('Go to slide %d', 'creator-base'), $index + 1)); ?>" data-slide="<?php echo $index; ?>"></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php 
    endif;

elseif ($hero_type === 'widgets') :
    // Widgets hero mode - only show if at least one widget area has content
    // Layout: Left side for featured images/media, Right side for text/signup content
    if (is_active_sidebar('hero-left') || is_active_sidebar('hero-right')) :
?>
<section class="hero-section hero-section--widgets">
    <div class="hero-widgets-inner">
        <div class="hero-widget-left">
            <?php if (is_active_sidebar('hero-left')) : ?>
                <?php dynamic_sidebar('hero-left'); ?>
            <?php endif; ?>
        </div>
        <div class="hero-widget-right">
            <?php if (is_active_sidebar('hero-right')) : ?>
                <?php dynamic_sidebar('hero-right'); ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php 
    endif;
endif; 
?>

<?php 
// Horizontal Promo Bar (between hero and category nav)
creator_base_promo_bar('horizontal');
?>

<?php if (get_theme_mod('creator_base_show_category_nav', true) && has_nav_menu('featured-links')) : ?>
<!-- Featured Links -->
<nav class="category-nav" aria-label="<?php esc_attr_e('Featured Links', 'creator-base'); ?>">
    <div class="category-nav-inner">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'featured-links',
            'container'      => false,
            'items_wrap'     => '%3$s',
            'depth'          => 1,
            'fallback_cb'    => false,
        ));
        ?>
    </div>
</nav>
<?php endif; ?>
