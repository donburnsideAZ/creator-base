<?php
/**
 * The single post template
 *
 * @package Creator_Base
 */

get_header();

// Check if hero should show on posts
$hero_display = get_theme_mod('creator_base_hero_display', 'homepage');
$show_hero = ($hero_display === 'homepage_posts');

// Check promo layout for wrapper class
$promo_layout = creator_base_promo_layout();
$has_promo_sidebar = creator_base_show_promo_bar() && $promo_layout === 'sidebar';
?>

<main id="primary" class="site-main single-post<?php echo $has_promo_sidebar ? ' has-promo-sidebar' : ''; ?><?php echo $show_hero ? ' has-hero' : ''; ?>">

    <?php if ($show_hero) : ?>
        <?php 
        // Sidebar Promo Bar (if sidebar layout selected)
        creator_base_promo_bar('sidebar');
        ?>
        
        <div class="single-post-hero-content">
        <?php // Hero Section (hero area + promo bar + featured links)
        get_template_part('template-parts/hero', 'section'); ?>
        
        <div class="single-post-wrapper">
        <?php while (have_posts()) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="single-post-content entry-content">
                <?php
                the_content();

                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'creator-base'),
                    'after'  => '</div>',
                ));
                ?>
                
                <?php 
                $tags = get_the_tags();
                if ($tags) : 
                ?>
                <div class="single-post-tags">
                    <?php foreach ($tags as $tag) : ?>
                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">#<?php echo esc_html($tag->name); ?></a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </article>

        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        
        endwhile;
        ?>
        </div><!-- .single-post-wrapper -->
        </div><!-- .single-post-hero-content -->
        
    <?php else : ?>
        <?php 
        // Sidebar Promo Bar (if sidebar layout selected)
        creator_base_promo_bar('sidebar');
        ?>

        <div class="single-post-wrapper">
        <?php
        while (have_posts()) :
            the_post();
        ?>
        
        <header class="single-post-header">
            <div class="container">
                <span class="single-post-category">
                    <?php creator_base_category_badge(); ?>
                </span>
                
                <h1 class="single-post-title"><?php the_title(); ?></h1>
                
                <div class="single-post-meta">
                    <?php creator_base_posted_on(); ?>
                    <?php creator_base_posted_by(); ?>
                </div>
            </div>
        </header>

        <?php 
        // Horizontal Promo Bar (between header and content)
        creator_base_promo_bar('horizontal');
        ?>
        
        <?php if (has_post_thumbnail()) : ?>
        <div class="single-featured-image">
            <?php the_post_thumbnail('large'); ?>
        </div>
        <?php endif; ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="single-post-content entry-content">
                <?php
                the_content();

                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'creator-base'),
                    'after'  => '</div>',
                ));
                ?>
                
                <?php 
                $tags = get_the_tags();
                if ($tags) : 
                ?>
                <div class="single-post-tags">
                    <?php foreach ($tags as $tag) : ?>
                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">#<?php echo esc_html($tag->name); ?></a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </article>

        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        
        endwhile;
        ?>
        </div><!-- .single-post-wrapper -->
    <?php endif; ?>

</main>

<?php
get_footer();
