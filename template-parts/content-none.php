<?php
/**
 * Template part for displaying a message when no posts are found
 *
 * @package Creator_Base
 */
?>

<section class="no-results not-found" style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem;">
    <h2><?php esc_html_e('Nothing Found', 'creator-base'); ?></h2>
    
    <?php if (is_search()) : ?>
        <p><?php esc_html_e('Sorry, no results matched your search. Try different keywords.', 'creator-base'); ?></p>
    <?php else : ?>
        <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for.', 'creator-base'); ?></p>
    <?php endif; ?>
    
    <p style="margin-top: 2rem;">
        <a href="<?php echo esc_url(home_url('/')); ?>">&larr; <?php esc_html_e('Back to Home', 'creator-base'); ?></a>
    </p>
</section>
