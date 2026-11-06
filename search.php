<?php
/**
 * The search results template
 *
 * @package Creator_Base
 */

get_header();
?>

<main id="primary" class="site-main search-results">

    <header class="search-header">
        <h1 class="search-title">
            <?php
            printf(
                /* translators: %s: search query */
                esc_html__('Search Results for: %s', 'creator-base'),
                '<span>' . get_search_query() . '</span>'
            );
            ?>
        </h1>
        
        <form role="search" method="get" class="search-form-large" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" placeholder="<?php esc_attr_e('Search...', 'creator-base'); ?>" value="<?php echo get_search_query(); ?>" name="s">
            <button type="submit"><?php esc_html_e('Search', 'creator-base'); ?></button>
        </form>
    </header>

    <section class="cards-section">
        <div class="cards-grid">
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    get_template_part('template-parts/content', 'card');
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
    </section>

</main>

<?php
get_footer();
