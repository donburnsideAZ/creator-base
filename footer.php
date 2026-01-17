<?php
/**
 * The footer template
 *
 * @package Creator_Base
 */
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="footer-inner">
            
            <!-- Footer Widget Area (Left) -->
            <div class="footer-widget">
                <?php if (is_active_sidebar('footer-widget')) : ?>
                    <?php dynamic_sidebar('footer-widget'); ?>
                <?php else : ?>
                    <h4 class="footer-title">
                        <?php 
                        $footer_title = get_theme_mod('creator_base_footer_title', '');
                        echo esc_html($footer_title ? $footer_title : get_bloginfo('name')); 
                        ?>
                    </h4>
                    <?php 
                    $footer_desc = get_theme_mod('creator_base_footer_description', '');
                    if ($footer_desc) : ?>
                        <p><?php echo esc_html($footer_desc); ?></p>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php creator_base_social_links(); ?>
            </div>
            
            <!-- Footer Menu 1 -->
            <div class="footer-menu">
                <?php if (has_nav_menu('footer-1')) : ?>
                    <h4 class="footer-menu-title"><?php esc_html_e('Navigate', 'creator-base'); ?></h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-1',
                        'container'      => false,
                        'depth'          => 1,
                    ));
                    ?>
                <?php endif; ?>
            </div>
            
            <!-- Footer Menu 2 -->
            <div class="footer-menu">
                <?php if (has_nav_menu('footer-2')) : ?>
                    <h4 class="footer-menu-title"><?php esc_html_e('Legal', 'creator-base'); ?></h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-2',
                        'container'      => false,
                        'depth'          => 1,
                    ));
                    ?>
                <?php endif; ?>
            </div>
            
        </div>
        
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
