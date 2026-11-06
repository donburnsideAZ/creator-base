<?php
/**
 * The page template
 *
 * @package Creator_Base
 */

get_header();

$has_sidebar = get_theme_mod('creator_base_page_sidebar', false) && is_active_sidebar('page-sidebar');
?>

<main id="primary" class="site-main">

    <?php
    while (have_posts()) :
        the_post();
    ?>
    
    <header class="page-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </header>
    
    <div class="page-content <?php echo $has_sidebar ? 'has-sidebar' : 'no-sidebar'; ?>">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="entry-content">
                <?php
                the_content();

                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'creator-base'),
                    'after'  => '</div>',
                ));
                ?>
            </div>
        </article>

        <?php if ($has_sidebar) : ?>
        <aside class="page-sidebar">
            <?php dynamic_sidebar('page-sidebar'); ?>
        </aside>
        <?php endif; ?>
    </div>

    <?php
    // If comments are open or we have at least one comment, load up the comment template.
    if (comments_open() || get_comments_number()) :
        comments_template();
    endif;
    
    endwhile;
    ?>

</main>

<?php
get_footer();
