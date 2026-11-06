<?php
/**
 * The header template
 *
 * @package Creator_Base
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'creator-base'); ?></a>

    <header id="masthead" class="site-header">
        <div class="header-inner">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                <?php endif; ?>
            </div>

            <button class="menu-toggle" aria-controls="primary-navigation" aria-expanded="false">
                <span class="screen-reader-text"><?php esc_html_e('Menu', 'creator-base'); ?></span>
                <?php echo creator_base_menu_icon(); ?>
            </button>

            <div class="nav-area">
                <nav id="site-navigation" class="primary-navigation" aria-label="<?php esc_attr_e('Primary Menu', 'creator-base'); ?>">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => 'creator_base_fallback_menu',
                    ));
                    ?>
                </nav>

                <?php creator_base_header_social_links(); ?>

                <form role="search" method="get" class="header-search" action="<?php echo esc_url(home_url('/')); ?>">
                    <button type="submit" aria-label="<?php esc_attr_e('Search', 'creator-base'); ?>">
                        <?php echo creator_base_search_icon(); ?>
                    </button>
                    <input type="search" placeholder="<?php esc_attr_e('Search...', 'creator-base'); ?>" value="<?php echo get_search_query(); ?>" name="s">
                </form>
            </div>
        </div>
    </header>

    <div id="content" class="site-content">
