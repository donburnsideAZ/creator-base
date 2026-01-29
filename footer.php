<?php
/**
 * The footer template
 *
 * @package Creator_Base
 */
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        
        <?php if (is_active_sidebar('footer-left') || is_active_sidebar('footer-right') || is_active_sidebar('footer-widget')) : ?>
        <div class="footer-widgets">
            <div class="footer-widgets-inner">
                
                <!-- Footer Left Widget Area -->
                <div class="footer-widget footer-left">
                    <?php if (is_active_sidebar('footer-left')) : ?>
                        <?php dynamic_sidebar('footer-left'); ?>
                    <?php elseif (is_active_sidebar('footer-widget')) : ?>
                        <?php // Legacy support: render old footer-widget here ?>
                        <?php dynamic_sidebar('footer-widget'); ?>
                    <?php endif; ?>
                    <?php creator_base_social_links(); ?>
                </div>
                
                <!-- Footer Right Widget Area -->
                <div class="footer-widget footer-right">
                    <?php if (is_active_sidebar('footer-right')) : ?>
                        <?php dynamic_sidebar('footer-right'); ?>
                    <?php endif; ?>
                </div>
                
            </div>
        </div>
        <?php endif; ?>
        
        <?php if (has_nav_menu('footer') || has_nav_menu('footer-1') || has_nav_menu('footer-2')) : ?>
        <div class="footer-menu-wrap">
            <nav class="footer-menu" aria-label="<?php esc_attr_e('Footer Menu', 'creator-base'); ?>">
                <?php
                if (has_nav_menu('footer')) {
                    // New single footer menu
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'depth'          => 1,
                    ));
                } else {
                    // Legacy: combine footer-1 and footer-2 menus
                    if (has_nav_menu('footer-1')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer-1',
                            'container'      => false,
                            'depth'          => 1,
                        ));
                    }
                    if (has_nav_menu('footer-2')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer-2',
                            'container'      => false,
                            'depth'          => 1,
                        ));
                    }
                }
                ?>
            </nav>
        </div>
        <?php endif; ?>
        
        <div class="footer-copyright">
            <?php echo creator_base_copyright(); ?>
        </div>
    </footer>

</div><!-- #page -->

<!-- Gallery Lightbox -->
<div id="portfolio-lightbox" class="portfolio-lightbox" aria-hidden="true">
    <div class="lightbox-content">
        <button class="lightbox-close" aria-label="<?php esc_attr_e('Close', 'creator-base'); ?>">&times;</button>
        <button class="lightbox-prev" aria-label="<?php esc_attr_e('Previous', 'creator-base'); ?>">
            <svg viewBox="0 0 24 24" width="32" height="32"><polyline points="15 18 9 12 15 6" fill="none" stroke="currentColor" stroke-width="2"></polyline></svg>
        </button>
        <img src="" alt="" class="lightbox-image">
        <button class="lightbox-next" aria-label="<?php esc_attr_e('Next', 'creator-base'); ?>">
            <svg viewBox="0 0 24 24" width="32" height="32"><polyline points="9 18 15 12 9 6" fill="none" stroke="currentColor" stroke-width="2"></polyline></svg>
        </button>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>
