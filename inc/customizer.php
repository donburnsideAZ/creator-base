<?php
/**
 * Creator Base Customizer
 *
 * @package Creator_Base
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add customizer settings
 */
function creator_base_customize_register($wp_customize) {
    
    // ==========================================================================
    // Theme Options Panel
    // ==========================================================================
    
    $wp_customize->add_panel('creator_base_options', array(
        'title'       => __('Creator Base Options', 'creator-base'),
        'description' => __('Customize your Creator Base theme settings.', 'creator-base'),
        'priority'    => 30,
    ));

    // ==========================================================================
    // Colors Section
    // ==========================================================================
    
    $wp_customize->add_section('creator_base_colors', array(
        'title'    => __('Colors', 'creator-base'),
        'panel'    => 'creator_base_options',
        'priority' => 10,
    ));

    // Homepage Color Split Toggle
    $wp_customize->add_setting('creator_base_homepage_colors_enabled', array(
        'default'           => false,
        'sanitize_callback' => 'creator_base_sanitize_checkbox',
    ));

    $wp_customize->add_control('creator_base_homepage_colors_enabled', array(
        'label'       => __('Use different colors on homepage', 'creator-base'),
        'section'     => 'creator_base_colors',
        'type'        => 'checkbox',
        'priority'    => 5,
    ));

    // ==========================================================================
    // Homepage Colors (shown when split is enabled)
    // ==========================================================================

    // Homepage Accent Color
    $wp_customize->add_setting('creator_base_homepage_accent_color', array(
        'default'           => '#f59e0b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'creator_base_homepage_accent_color', array(
        'label'       => __('Homepage Accent', 'creator-base'),
        'section'     => 'creator_base_colors',
        'settings'    => 'creator_base_homepage_accent_color',
        'priority'    => 10,
        'active_callback' => 'creator_base_homepage_colors_enabled',
    )));

    // Homepage Background Color
    $wp_customize->add_setting('creator_base_homepage_bg_color', array(
        'default'           => '#0a0a0a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'creator_base_homepage_bg_color', array(
        'label'       => __('Homepage Background', 'creator-base'),
        'section'     => 'creator_base_colors',
        'settings'    => 'creator_base_homepage_bg_color',
        'priority'    => 11,
        'active_callback' => 'creator_base_homepage_colors_enabled',
    )));

    // Homepage Card Background
    $wp_customize->add_setting('creator_base_homepage_card_bg_color', array(
        'default'           => '#1a1a1a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'creator_base_homepage_card_bg_color', array(
        'label'       => __('Homepage Card Background', 'creator-base'),
        'section'     => 'creator_base_colors',
        'settings'    => 'creator_base_homepage_card_bg_color',
        'priority'    => 12,
        'active_callback' => 'creator_base_homepage_colors_enabled',
    )));

    // Homepage Text Color
    $wp_customize->add_setting('creator_base_homepage_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'creator_base_homepage_text_color', array(
        'label'       => __('Homepage Text', 'creator-base'),
        'section'     => 'creator_base_colors',
        'settings'    => 'creator_base_homepage_text_color',
        'priority'    => 13,
        'active_callback' => 'creator_base_homepage_colors_enabled',
    )));

    // Separator (using a heading control hack)
    $wp_customize->add_setting('creator_base_colors_separator', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('creator_base_colors_separator', array(
        'label'       => __('─────── Site Colors ───────', 'creator-base'),
        'description' => __('Homepage colors are above.', 'creator-base'),
        'section'     => 'creator_base_colors',
        'type'        => 'hidden',
        'priority'    => 19,
        'active_callback' => 'creator_base_homepage_colors_enabled',
    ));

    // ==========================================================================
    // Site Colors (always shown, relabeled when split enabled)
    // ==========================================================================

    // Accent Color
    $wp_customize->add_setting('creator_base_accent_color', array(
        'default'           => '#f59e0b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'creator_base_accent_color', array(
        'label'       => __('Accent Color', 'creator-base'),
        'description' => __('Used for links, buttons, category labels, and highlights.', 'creator-base'),
        'section'     => 'creator_base_colors',
        'settings'    => 'creator_base_accent_color',
        'priority'    => 20,
    )));

    // Background Color
    $wp_customize->add_setting('creator_base_bg_color', array(
        'default'           => '#0a0a0a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'creator_base_bg_color', array(
        'label'       => __('Background Color', 'creator-base'),
        'description' => __('Main page background color.', 'creator-base'),
        'section'     => 'creator_base_colors',
        'settings'    => 'creator_base_bg_color',
        'priority'    => 21,
    )));

    // Card/Content Background Color
    $wp_customize->add_setting('creator_base_card_bg_color', array(
        'default'           => '#1a1a1a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'creator_base_card_bg_color', array(
        'label'       => __('Card & Content Background', 'creator-base'),
        'description' => __('Background for cards, hero section, and content areas.', 'creator-base'),
        'section'     => 'creator_base_colors',
        'settings'    => 'creator_base_card_bg_color',
        'priority'    => 22,
    )));

    // Text Color
    $wp_customize->add_setting('creator_base_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'creator_base_text_color', array(
        'label'       => __('Text Color', 'creator-base'),
        'description' => __('Primary text color. Secondary shades are calculated automatically.', 'creator-base'),
        'section'     => 'creator_base_colors',
        'settings'    => 'creator_base_text_color',
        'priority'    => 23,
    )));

    // Footer Background Color
    $wp_customize->add_setting('creator_base_footer_bg_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'creator_base_footer_bg_color', array(
        'label'       => __('Footer Background', 'creator-base'),
        'description' => __('Background color for the site footer.', 'creator-base'),
        'section'     => 'creator_base_colors',
        'settings'    => 'creator_base_footer_bg_color',
        'priority'    => 24,
    )));

    // Remove WordPress background color control to avoid confusion
    $wp_customize->remove_control('background_color');

    // ==========================================================================
    // Hero Mode
    // ==========================================================================
    
    $wp_customize->add_section('creator_base_hero', array(
        'title'    => __('Hero Section', 'creator-base'),
        'panel'    => 'creator_base_options',
        'priority' => 20,
    ));

    // Hero Display Location
    $wp_customize->add_setting('creator_base_hero_display', array(
        'default'           => 'homepage',
        'sanitize_callback' => 'creator_base_sanitize_hero_display',
    ));

    $wp_customize->add_control('creator_base_hero_display', array(
        'label'       => __('Show Hero On', 'creator-base'),
        'description' => __('Pages can use the "Hero Page" template to show the hero.', 'creator-base'),
        'section'     => 'creator_base_hero',
        'type'        => 'radio',
        'choices'     => array(
            'homepage'       => __('Homepage Only', 'creator-base'),
            'homepage_posts' => __('Homepage + Posts', 'creator-base'),
        ),
        'priority'    => 5,
    ));

    // Hero Type (Video/Banner/Carousel/Widgets)
    $wp_customize->add_setting('creator_base_hero_type', array(
        'default'           => 'video',
        'sanitize_callback' => 'creator_base_sanitize_hero_type',
    ));

    $wp_customize->add_control('creator_base_hero_type', array(
        'label'   => __('Hero Display', 'creator-base'),
        'section' => 'creator_base_hero',
        'type'    => 'radio',
        'choices' => array(
            'video'    => __('Video (Latest Post or Sticky)', 'creator-base'),
            'banner'   => __('Banner (Static Content)', 'creator-base'),
            'carousel' => __('Carousel (Up to 4 Slides)', 'creator-base'),
            'widgets'  => __('Widgets (Two Widget Areas)', 'creator-base'),
        ),
        'priority' => 10,
    ));

    // Banner Hero Title
    $wp_customize->add_setting('creator_base_hero_title', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('creator_base_hero_title', array(
        'label'       => __('Banner Title', 'creator-base'),
        'description' => __('Only used when Hero Mode is set to Banner.', 'creator-base'),
        'section'     => 'creator_base_hero',
        'type'        => 'text',
    ));

    // Banner Hero Description
    $wp_customize->add_setting('creator_base_hero_description', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('creator_base_hero_description', array(
        'label'       => __('Banner Description', 'creator-base'),
        'description' => __('Only used when Hero Mode is set to Banner.', 'creator-base'),
        'section'     => 'creator_base_hero',
        'type'        => 'textarea',
    ));

    // Banner Hero Button Text
    $wp_customize->add_setting('creator_base_hero_button_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('creator_base_hero_button_text', array(
        'label'       => __('Banner Button Text', 'creator-base'),
        'description' => __('Only used when Hero Mode is set to Banner.', 'creator-base'),
        'section'     => 'creator_base_hero',
        'type'        => 'text',
    ));

    // Banner Hero Button URL
    $wp_customize->add_setting('creator_base_hero_button_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('creator_base_hero_button_url', array(
        'label'       => __('Banner Button URL', 'creator-base'),
        'description' => __('Only used when Hero Mode is set to Banner.', 'creator-base'),
        'section'     => 'creator_base_hero',
        'type'        => 'url',
    ));

    // Hero Background Image
    $wp_customize->add_setting('creator_base_hero_bg_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'creator_base_hero_bg_image', array(
        'label'       => __('Hero Background Image', 'creator-base'),
        'description' => __('Optional background image for the hero section. Use a step-and-repeat pattern, photo, or go wild!', 'creator-base'),
        'section'     => 'creator_base_hero',
        'settings'    => 'creator_base_hero_bg_image',
    )));

    // Hero Background Size
    $wp_customize->add_setting('creator_base_hero_bg_size', array(
        'default'           => 'cover',
        'sanitize_callback' => 'creator_base_sanitize_bg_size',
    ));

    $wp_customize->add_control('creator_base_hero_bg_size', array(
        'label'       => __('Background Size', 'creator-base'),
        'description' => __('Cover fills the area, Contain shows full image, Auto/Tile repeats the image.', 'creator-base'),
        'section'     => 'creator_base_hero',
        'type'        => 'select',
        'choices'     => array(
            'cover'   => __('Cover (fill area)', 'creator-base'),
            'contain' => __('Contain (show full image)', 'creator-base'),
            'auto'    => __('Auto/Tile (repeat pattern)', 'creator-base'),
        ),
    ));

    // Hero Background Position
    $wp_customize->add_setting('creator_base_hero_bg_position', array(
        'default'           => 'center center',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('creator_base_hero_bg_position', array(
        'label'       => __('Background Position', 'creator-base'),
        'section'     => 'creator_base_hero',
        'type'        => 'select',
        'choices'     => array(
            'center center' => __('Center', 'creator-base'),
            'top center'    => __('Top', 'creator-base'),
            'bottom center' => __('Bottom', 'creator-base'),
            'left center'   => __('Left', 'creator-base'),
            'right center'  => __('Right', 'creator-base'),
        ),
    ));

    // ==========================================================================
    // Carousel Slides (only used when Hero Display is set to Carousel)
    // ==========================================================================
    
    for ($i = 1; $i <= 4; $i++) {
        // Slide Image
        $wp_customize->add_setting("creator_base_carousel_image_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "creator_base_carousel_image_{$i}", array(
            'label'       => sprintf(__('Slide %d Image', 'creator-base'), $i),
            'description' => $i === 1 ? __('Recommended size: 1280×400px. Slides without images are skipped.', 'creator-base') : '',
            'section'     => 'creator_base_hero',
            'settings'    => "creator_base_carousel_image_{$i}",
        )));

        // Slide Title
        $wp_customize->add_setting("creator_base_carousel_title_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("creator_base_carousel_title_{$i}", array(
            'label'   => sprintf(__('Slide %d Title', 'creator-base'), $i),
            'section' => 'creator_base_hero',
            'type'    => 'text',
        ));

        // Slide Description
        $wp_customize->add_setting("creator_base_carousel_desc_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));

        $wp_customize->add_control("creator_base_carousel_desc_{$i}", array(
            'label'   => sprintf(__('Slide %d Description', 'creator-base'), $i),
            'section' => 'creator_base_hero',
            'type'    => 'textarea',
        ));

        // Slide URL
        $wp_customize->add_setting("creator_base_carousel_url_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("creator_base_carousel_url_{$i}", array(
            'label'   => sprintf(__('Slide %d Link URL', 'creator-base'), $i),
            'section' => 'creator_base_hero',
            'type'    => 'url',
        ));
    }

    // ==========================================================================
    // Layout Section
    // ==========================================================================
    
    $wp_customize->add_section('creator_base_layout', array(
        'title'    => __('Layout Options', 'creator-base'),
        'panel'    => 'creator_base_options',
        'priority' => 25,
    ));

    // Homepage Rows
    $wp_customize->add_setting('creator_base_homepage_rows', array(
        'default'           => 3,
        'sanitize_callback' => 'creator_base_sanitize_homepage_rows',
    ));

    $wp_customize->add_control('creator_base_homepage_rows', array(
        'label'       => __('Homepage Rows', 'creator-base'),
        'description' => __('Number of rows to display on the homepage (3 posts per row).', 'creator-base'),
        'section'     => 'creator_base_layout',
        'type'        => 'select',
        'choices'     => array(
            1 => __('1 row (3 posts)', 'creator-base'),
            2 => __('2 rows (6 posts)', 'creator-base'),
            3 => __('3 rows (9 posts)', 'creator-base'),
            4 => __('4 rows (12 posts)', 'creator-base'),
            5 => __('5 rows (15 posts)', 'creator-base'),
        ),
    ));

    // Page Sidebar Toggle
    $wp_customize->add_setting('creator_base_page_sidebar', array(
        'default'           => false,
        'sanitize_callback' => 'creator_base_sanitize_checkbox',
    ));

    $wp_customize->add_control('creator_base_page_sidebar', array(
        'label'   => __('Show Sidebar on Pages', 'creator-base'),
        'section' => 'creator_base_layout',
        'type'    => 'checkbox',
    ));

    // Promo Bar Toggle
    $wp_customize->add_setting('creator_base_promo_bar', array(
        'default'           => false,
        'sanitize_callback' => 'creator_base_sanitize_checkbox',
    ));

    $wp_customize->add_control('creator_base_promo_bar', array(
        'label'       => __('Show Promo Bar', 'creator-base'),
        'description' => __('Displays promotional widgets on the front page and single posts. Add widgets under Appearance > Widgets.', 'creator-base'),
        'section'     => 'creator_base_layout',
        'type'        => 'checkbox',
    ));

    // Promo Bar Layout
    $wp_customize->add_setting('creator_base_promo_layout', array(
        'default'           => 'horizontal',
        'sanitize_callback' => 'creator_base_sanitize_promo_layout',
    ));

    $wp_customize->add_control('creator_base_promo_layout', array(
        'label'       => __('Promo Bar Layout', 'creator-base'),
        'description' => __('Horizontal displays promos in a row. Sidebar stacks them vertically on the right.', 'creator-base'),
        'section'     => 'creator_base_layout',
        'type'        => 'radio',
        'choices'     => array(
            'horizontal' => __('Horizontal', 'creator-base'),
            'sidebar'    => __('Sidebar', 'creator-base'),
        ),
    ));

    // Featured Links Toggle
    $wp_customize->add_setting('creator_base_show_category_nav', array(
        'default'           => true,
        'sanitize_callback' => 'creator_base_sanitize_checkbox',
    ));

    $wp_customize->add_control('creator_base_show_category_nav', array(
        'label'       => __('Show Featured Links', 'creator-base'),
        'description' => __('Displays the Featured Links menu on the front page. Configure links in Appearance → Menus.', 'creator-base'),
        'section'     => 'creator_base_layout',
        'type'        => 'checkbox',
    ));

    // ==========================================================================
    // Social Links Section
    // ==========================================================================
    
    $wp_customize->add_section('creator_base_social', array(
        'title'    => __('Social Links', 'creator-base'),
        'panel'    => 'creator_base_options',
        'priority' => 30,
    ));

    // Header Social Icons Toggle
    $wp_customize->add_setting('creator_base_header_social', array(
        'default'           => false,
        'sanitize_callback' => 'creator_base_sanitize_checkbox',
    ));

    $wp_customize->add_control('creator_base_header_social', array(
        'label'       => __('Show Social Icons in Header', 'creator-base'),
        'description' => __('Display social icons in the navigation bar.', 'creator-base'),
        'section'     => 'creator_base_social',
        'type'        => 'checkbox',
    ));

    // Header Social Icon Color
    $wp_customize->add_setting('creator_base_header_social_color', array(
        'default'           => 'white',
        'sanitize_callback' => 'creator_base_sanitize_header_social_color',
    ));

    $wp_customize->add_control('creator_base_header_social_color', array(
        'label'   => __('Header Icon Color', 'creator-base'),
        'section' => 'creator_base_social',
        'type'    => 'radio',
        'choices' => array(
            'white' => __('White', 'creator-base'),
            'black' => __('Black', 'creator-base'),
        ),
    ));

    $social_platforms = array(
        'youtube'   => __('YouTube URL', 'creator-base'),
        'twitter'   => __('Twitter URL', 'creator-base'),
        'instagram' => __('Instagram URL', 'creator-base'),
        'tiktok'    => __('TikTok URL', 'creator-base'),
        'facebook'  => __('Facebook URL', 'creator-base'),
        'linkedin'  => __('LinkedIn URL', 'creator-base'),
        'pinterest' => __('Pinterest URL', 'creator-base'),
        'bluesky'   => __('Bluesky URL', 'creator-base'),
        'threads'   => __('Threads URL', 'creator-base'),
        'patreon'   => __('Patreon URL', 'creator-base'),
        'spotify'   => __('Spotify URL', 'creator-base'),
        'apple'     => __('Apple Podcasts URL', 'creator-base'),
    );

    foreach ($social_platforms as $platform => $label) {
        $wp_customize->add_setting('creator_base_social_' . $platform, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('creator_base_social_' . $platform, array(
            'label'   => $label,
            'section' => 'creator_base_social',
            'type'    => 'url',
        ));
    }

    // ==========================================================================
    // Footer Section
    // ==========================================================================
    
    $wp_customize->add_section('creator_base_footer', array(
        'title'    => __('Footer', 'creator-base'),
        'panel'    => 'creator_base_options',
        'priority' => 40,
    ));

    // Footer Title (if no widget)
    $wp_customize->add_setting('creator_base_footer_title', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('creator_base_footer_title', array(
        'label'       => __('Footer Title', 'creator-base'),
        'description' => __('Used if Footer Widget area is empty. Defaults to site title.', 'creator-base'),
        'section'     => 'creator_base_footer',
        'type'        => 'text',
    ));

    // Footer Description
    $wp_customize->add_setting('creator_base_footer_description', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('creator_base_footer_description', array(
        'label'       => __('Footer Description', 'creator-base'),
        'description' => __('Used if Footer Widget area is empty.', 'creator-base'),
        'section'     => 'creator_base_footer',
        'type'        => 'textarea',
    ));

    // Copyright Text
    $wp_customize->add_setting('creator_base_copyright', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('creator_base_copyright', array(
        'label'       => __('Copyright Text', 'creator-base'),
        'description' => __('Leave empty to use site title. Use %year% for current year.', 'creator-base'),
        'section'     => 'creator_base_footer',
        'type'        => 'text',
    ));
}
add_action('customize_register', 'creator_base_customize_register');

/**
 * Active callback for homepage color controls
 */
function creator_base_homepage_colors_enabled() {
    return get_theme_mod('creator_base_homepage_colors_enabled', false);
}

/**
 * Sanitize checkbox
 */
function creator_base_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Sanitize hero type
 */
function creator_base_sanitize_hero_type($value) {
    $valid = array('video', 'banner', 'carousel', 'widgets');
    return in_array($value, $valid) ? $value : 'video';
}

/**
 * Sanitize promo layout
 */
function creator_base_sanitize_promo_layout($value) {
    $valid = array('horizontal', 'sidebar');
    return in_array($value, $valid) ? $value : 'horizontal';
}

/**
 * Sanitize background size
 */
function creator_base_sanitize_bg_size($value) {
    $valid = array('cover', 'contain', 'auto');
    return in_array($value, $valid) ? $value : 'cover';
}

/**
 * Sanitize header social icon color
 */
function creator_base_sanitize_header_social_color($value) {
    $valid = array('white', 'black');
    return in_array($value, $valid) ? $value : 'white';
}

/**
 * Sanitize hero display location
 */
function creator_base_sanitize_hero_display($value) {
    $valid = array('homepage', 'homepage_posts');
    return in_array($value, $valid) ? $value : 'homepage';
}

/**
 * Sanitize homepage rows
 */
function creator_base_sanitize_homepage_rows($value) {
    $value = absint($value);
    return ($value >= 1 && $value <= 5) ? $value : 3;
}

/**
 * Output customizer CSS
 */
function creator_base_customizer_css() {
    // Site colors (used everywhere, or just non-homepage when split enabled)
    $accent_color = get_theme_mod('creator_base_accent_color', '#f59e0b');
    $bg_color = get_theme_mod('creator_base_bg_color', '#0a0a0a');
    $card_bg = get_theme_mod('creator_base_card_bg_color', '#1a1a1a');
    $text_color = get_theme_mod('creator_base_text_color', '#ffffff');
    
    // Calculate secondary colors based on primary text
    $is_light_text = creator_base_is_light_color($text_color);
    
    $colors = array(
        'bg'             => $bg_color,
        'bg-secondary'   => $card_bg,
        'bg-tertiary'    => creator_base_adjust_brightness($card_bg, $is_light_text ? 20 : -10),
        'text-primary'   => $text_color,
        'text-secondary' => creator_base_adjust_brightness($text_color, $is_light_text ? -40 : 40),
        'text-muted'     => creator_base_adjust_brightness($text_color, $is_light_text ? -80 : 80),
        'text-light'     => creator_base_adjust_brightness($text_color, $is_light_text ? -120 : 120),
        'border'         => creator_base_adjust_brightness($card_bg, $is_light_text ? 40 : -20),
    );
    
    // Extract RGB values from accent color for glow effects
    $accent_rgb = creator_base_hex_to_rgb($accent_color);
    
    // Check if homepage color split is enabled
    $homepage_split = get_theme_mod('creator_base_homepage_colors_enabled', false);
    
    ?>
    <style type="text/css">
        :root {
            --cb-color-accent: <?php echo esc_attr($accent_color); ?>;
            --cb-color-accent-rgb: <?php echo esc_attr($accent_rgb); ?>;
            --cb-color-accent-hover: <?php echo esc_attr(creator_base_adjust_brightness($accent_color, -20)); ?>;
            --cb-color-bg: <?php echo esc_attr($colors['bg']); ?>;
            --cb-color-bg-secondary: <?php echo esc_attr($colors['bg-secondary']); ?>;
            --cb-color-bg-tertiary: <?php echo esc_attr($colors['bg-tertiary']); ?>;
            --cb-color-text-primary: <?php echo esc_attr($colors['text-primary']); ?>;
            --cb-color-text-secondary: <?php echo esc_attr($colors['text-secondary']); ?>;
            --cb-color-text-muted: <?php echo esc_attr($colors['text-muted']); ?>;
            --cb-color-text-light: <?php echo esc_attr($colors['text-light']); ?>;
            --cb-color-border: <?php echo esc_attr($colors['border']); ?>;
        }
        body,
        body.custom-background {
            background-color: <?php echo esc_attr($colors['bg']); ?> !important;
        }
        <?php 
        // Homepage color overrides when split is enabled
        if ($homepage_split) :
            $hp_accent = get_theme_mod('creator_base_homepage_accent_color', '#f59e0b');
            $hp_bg = get_theme_mod('creator_base_homepage_bg_color', '#0a0a0a');
            $hp_card_bg = get_theme_mod('creator_base_homepage_card_bg_color', '#1a1a1a');
            $hp_text = get_theme_mod('creator_base_homepage_text_color', '#ffffff');
            
            $hp_is_light_text = creator_base_is_light_color($hp_text);
            $hp_accent_rgb = creator_base_hex_to_rgb($hp_accent);
            
            $hp_colors = array(
                'bg'             => $hp_bg,
                'bg-secondary'   => $hp_card_bg,
                'bg-tertiary'    => creator_base_adjust_brightness($hp_card_bg, $hp_is_light_text ? 20 : -10),
                'text-primary'   => $hp_text,
                'text-secondary' => creator_base_adjust_brightness($hp_text, $hp_is_light_text ? -40 : 40),
                'text-muted'     => creator_base_adjust_brightness($hp_text, $hp_is_light_text ? -80 : 80),
                'text-light'     => creator_base_adjust_brightness($hp_text, $hp_is_light_text ? -120 : 120),
                'border'         => creator_base_adjust_brightness($hp_card_bg, $hp_is_light_text ? 40 : -20),
            );
        ?>
        body.home,
        body.front-page {
            --cb-color-accent: <?php echo esc_attr($hp_accent); ?>;
            --cb-color-accent-rgb: <?php echo esc_attr($hp_accent_rgb); ?>;
            --cb-color-accent-hover: <?php echo esc_attr(creator_base_adjust_brightness($hp_accent, -20)); ?>;
            --cb-color-bg: <?php echo esc_attr($hp_colors['bg']); ?>;
            --cb-color-bg-secondary: <?php echo esc_attr($hp_colors['bg-secondary']); ?>;
            --cb-color-bg-tertiary: <?php echo esc_attr($hp_colors['bg-tertiary']); ?>;
            --cb-color-text-primary: <?php echo esc_attr($hp_colors['text-primary']); ?>;
            --cb-color-text-secondary: <?php echo esc_attr($hp_colors['text-secondary']); ?>;
            --cb-color-text-muted: <?php echo esc_attr($hp_colors['text-muted']); ?>;
            --cb-color-text-light: <?php echo esc_attr($hp_colors['text-light']); ?>;
            --cb-color-border: <?php echo esc_attr($hp_colors['border']); ?>;
            background-color: <?php echo esc_attr($hp_colors['bg']); ?> !important;
        }
        <?php endif; ?>
        <?php 
        // Hero background image
        $hero_bg_image = get_theme_mod('creator_base_hero_bg_image', '');
        if ($hero_bg_image) :
            $hero_bg_size = get_theme_mod('creator_base_hero_bg_size', 'cover');
            $hero_bg_position = get_theme_mod('creator_base_hero_bg_position', 'center center');
            $bg_repeat = ($hero_bg_size === 'auto') ? 'repeat' : 'no-repeat';
        ?>
        .hero-section {
            background-image: url('<?php echo esc_url($hero_bg_image); ?>');
            background-size: <?php echo esc_attr($hero_bg_size); ?>;
            background-position: <?php echo esc_attr($hero_bg_position); ?>;
            background-repeat: <?php echo esc_attr($bg_repeat); ?>;
        }
        <?php endif; ?>
        <?php 
        // Header social icon color
        $header_social_color = get_theme_mod('creator_base_header_social_color', 'white');
        $icon_color = ($header_social_color === 'black') ? '#000000' : '#ffffff';
        ?>
        .header-social a {
            color: <?php echo esc_attr($icon_color); ?> !important;
        }
        .header-social a:hover {
            color: var(--cb-color-accent) !important;
        }
        <?php 
        // Footer background color
        $footer_bg_color = get_theme_mod('creator_base_footer_bg_color', '#000000');
        ?>
        .site-footer {
            --cb-color-footer-bg: <?php echo esc_attr($footer_bg_color); ?>;
            background-color: <?php echo esc_attr($footer_bg_color); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'creator_base_customizer_css', 99);

/**
 * Convert hex color to RGB string
 */
function creator_base_hex_to_rgb($hex) {
    $hex = str_replace('#', '', $hex);
    
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    return "{$r}, {$g}, {$b}";
}

/**
 * Adjust color brightness
 */
function creator_base_adjust_brightness($hex, $steps) {
    $hex = str_replace('#', '', $hex);
    
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));
    
    return '#' . sprintf('%02x%02x%02x', $r, $g, $b);
}

/**
 * Check if a color is light (for contrast calculations)
 */
function creator_base_is_light_color($hex) {
    $hex = str_replace('#', '', $hex);
    
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    // Calculate luminance
    $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
    
    return $luminance > 0.5;
}

/**
 * Enqueue customizer control scripts (for the customizer panel itself)
 */
function creator_base_customize_controls_enqueue() {
    wp_enqueue_script(
        'creator-base-customizer-controls',
        get_template_directory_uri() . '/assets/js/customizer.js',
        array('customize-controls', 'jquery'),
        CREATOR_BASE_VERSION,
        true
    );
}
add_action('customize_controls_enqueue_scripts', 'creator_base_customize_controls_enqueue');

/**
 * Enqueue customizer preview scripts (for live preview in the iframe)
 */
function creator_base_customize_preview_enqueue() {
    wp_enqueue_script(
        'creator-base-customizer-preview',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array('customize-preview', 'jquery'),
        CREATOR_BASE_VERSION,
        true
    );
}
add_action('customize_preview_init', 'creator_base_customize_preview_enqueue');
