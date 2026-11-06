<?php
/**
 * The main template file (fallback)
 *
 * @package Creator_Base
 */

get_header();
?>

<main id="primary" class="site-main">

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
