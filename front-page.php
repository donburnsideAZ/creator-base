<?php
/**
 * The front page template
 *
 * @package Creator_Base
 */

get_header();

// Check promo layout for wrapper class
$promo_layout = creator_base_promo_layout();
$has_promo_sidebar = creator_base_show_promo_bar() && $promo_layout === 'sidebar';
?>

<main id="primary" class="site-main front-page<?php echo $has_promo_sidebar ? ' has-promo-sidebar' : ''; ?>">
    
    <?php 
    // Sidebar Promo Bar (if sidebar layout selected)
    creator_base_promo_bar('sidebar');
    ?>

    <div class="front-page-content">
    <?php 
    // Hero Section (hero area + promo bar + featured links)
    get_template_part('template-parts/hero', 'section');
    
    // Get hero post ID if it was set by the hero section
    $hero_post_id = isset($GLOBALS['creator_base_hero_post_id']) ? $GLOBALS['creator_base_hero_post_id'] : 0;
    ?>

    <!-- Cards Grid -->
    <section class="cards-section">
        <div class="cards-grid">
            <?php
            // Get posts excluding the hero post and Portfolio category
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $exclude = $hero_post_id ? array($hero_post_id) : array();
            
            // Exclude Portfolio category (and its children) from homepage
            $portfolio_cat = get_category_by_slug('portfolio');
            $exclude_cats = array();
            if ($portfolio_cat) {
                $exclude_cats[] = $portfolio_cat->term_id;
                // Also exclude child categories
                $child_cats = get_categories(array(
                    'parent' => $portfolio_cat->term_id,
                    'hide_empty' => false,
                ));
                foreach ($child_cats as $child) {
                    $exclude_cats[] = $child->term_id;
                }
            }
            
            $cards_query = new WP_Query(array(
                'posts_per_page'   => 9,
                'paged'            => $paged,
                'post__not_in'     => $exclude,
                'category__not_in' => $exclude_cats,
            ));
            
            if ($cards_query->have_posts()) :
                while ($cards_query->have_posts()) :
                    $cards_query->the_post();
                    get_template_part('template-parts/content', 'card');
                endwhile;
                wp_reset_postdata();
            else :
                get_template_part('template-parts/content', 'none');
            endif;
            ?>
        </div>
        
        <?php if ($cards_query->max_num_pages > 1) : ?>
        <div class="pagination">
            <?php
            echo paginate_links(array(
                'total'     => $cards_query->max_num_pages,
                'current'   => $paged,
                'prev_text' => '&larr;',
                'next_text' => '&rarr;',
            ));
            ?>
        </div>
        <?php endif; ?>
    </section>

    </div><!-- .front-page-content -->

</main>

<?php
get_footer();
