<?php
/**
 * Template Name: Links Page
 * 
 * A minimal page template for link-in-bio style pages.
 * Displays logo, page title, a vertical menu, and a widget area.
 * Perfect replacement for Linktree and similar services.
 *
 * @package Creator_Base
 */

get_header();
?>

<main id="primary" class="site-main links-page">
    
    <div class="links-page-inner">
        
        <!-- Logo -->
        <?php if (has_custom_logo()) : ?>
        <div class="links-page-logo">
            <?php the_custom_logo(); ?>
        </div>
        <?php endif; ?>
        
        <!-- Page Title -->
        <?php while (have_posts()) : the_post(); ?>
        <h1 class="links-page-title"><?php the_title(); ?></h1>
        
        <?php if (get_the_content()) : ?>
        <div class="links-page-description">
            <?php the_content(); ?>
        </div>
        <?php endif; ?>
        <?php endwhile; ?>
        
        <!-- Links Menu -->
        <?php if (has_nav_menu('links-page')) : ?>
        <nav class="links-page-menu" aria-label="<?php esc_attr_e('Links', 'creator-base'); ?>">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'links-page',
                'container'      => false,
                'depth'          => 1,
            ));
            ?>
        </nav>
        <?php else : ?>
        <p class="links-page-notice">
            <?php esc_html_e('Add a menu to the "Links Page Menu" location in Appearance → Menus.', 'creator-base'); ?>
        </p>
        <?php endif; ?>
        
        <!-- Widget Area -->
        <?php if (is_active_sidebar('links-page')) : ?>
        <div class="links-page-widgets">
            <?php dynamic_sidebar('links-page'); ?>
        </div>
        <?php endif; ?>
        
        <!-- Social Links -->
        <div class="links-page-social">
            <?php creator_base_social_links(); ?>
        </div>
        
    </div>

</main>

<?php
get_footer();
