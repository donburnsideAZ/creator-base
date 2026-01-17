<?php
/**
 * Template Name: Hero Page
 * 
 * A page template that includes the full hero section stack.
 * Use this for landing pages, portfolio pages, or any page
 * that should have the same hero treatment as the homepage.
 *
 * @package Creator_Base
 */

get_header();

// Check promo layout for wrapper class
$promo_layout = creator_base_promo_layout();
$has_promo_sidebar = creator_base_show_promo_bar() && $promo_layout === 'sidebar';
?>

<main id="primary" class="site-main hero-page<?php echo $has_promo_sidebar ? ' has-promo-sidebar' : ''; ?>">

    <?php 
    // Sidebar Promo Bar (if sidebar layout selected)
    creator_base_promo_bar('sidebar');
    ?>

    <div class="hero-page-content">
    <?php 
    // Hero Section (hero area + promo bar + featured links)
    get_template_part('template-parts/hero', 'section');
    ?>

    <?php while (have_posts()) : the_post(); ?>
    
    <?php if (get_the_content()) : ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('hero-page-article'); ?>>
        <div class="hero-page-entry entry-content">
            <?php the_content(); ?>
        </div>
    </article>
    <?php endif; ?>

    <?php endwhile; ?>
    
    </div><!-- .hero-page-content -->

</main>

<?php
get_footer();
