<?php
/**
 * Creator Base Theme Functions
 *
 * @package Creator_Base
 * @version 2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('CREATOR_BASE_VERSION', '3.1.0');
define('CREATOR_BASE_DIR', get_template_directory());
define('CREATOR_BASE_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function creator_base_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');
    add_image_size('creator-base-card', 640, 360, true);      // 16:9 card
    add_image_size('creator-base-hero', 1280, 720, true);     // 16:9 hero

    // Register navigation menus
    register_nav_menus(array(
        'primary'        => esc_html__('Primary Menu', 'creator-base'),
        'featured-links' => esc_html__('Featured Links', 'creator-base'),
        'footer'         => esc_html__('Footer Menu', 'creator-base'),
        'footer-1'       => esc_html__('Footer Menu 1 (Legacy)', 'creator-base'),
        'footer-2'       => esc_html__('Footer Menu 2 (Legacy)', 'creator-base'),
        'links-page'     => esc_html__('Links Page Menu', 'creator-base'),
    ));

    // Switch default core markup to valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add support for core custom logo
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Add support for custom background
    add_theme_support('custom-background', array(
        'default-color' => 'f8f9fa',
    ));

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');

    // Add support for editor styles
    add_theme_support('editor-styles');

    // Content width
    if (!isset($content_width)) {
        $content_width = 800;
    }
}
add_action('after_setup_theme', 'creator_base_setup');

/**
 * Enqueue scripts and styles
 */
function creator_base_scripts() {
    // Google Fonts - Inter
    wp_enqueue_style(
        'creator-base-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'creator-base-style',
        get_stylesheet_uri(),
        array('creator-base-fonts'),
        CREATOR_BASE_VERSION
    );

    // Main JavaScript
    wp_enqueue_script(
        'creator-base-script',
        CREATOR_BASE_URI . '/assets/js/main.js',
        array(),
        CREATOR_BASE_VERSION,
        true
    );

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'creator_base_scripts');

/**
 * Register widget areas
 */
function creator_base_widgets_init() {
    // Hero Sidebar (next to featured post on homepage)
    register_sidebar(array(
        'name'          => esc_html__('Hero Sidebar', 'creator-base'),
        'id'            => 'hero-sidebar',
        'description'   => esc_html__('Widgets displayed next to the hero post on the homepage.', 'creator-base'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // Hero Left (Featured) - for Widgets hero mode
    register_sidebar(array(
        'name'          => esc_html__('Hero Left (Image/Media)', 'creator-base'),
        'id'            => 'hero-left',
        'description'   => esc_html__('Left side of the hero area when Hero Mode is set to Widgets. Best for images, videos, or featured media. Takes up most of the width.', 'creator-base'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // Hero Right (Signup) - for Widgets hero mode
    register_sidebar(array(
        'name'          => esc_html__('Hero Right (Text/Promo)', 'creator-base'),
        'id'            => 'hero-right',
        'description'   => esc_html__('Right side of the hero area when Hero Mode is set to Widgets. Perfect for text widgets, email signup forms, or promotional content. Fixed 350px width.', 'creator-base'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // Footer Left Widget
    register_sidebar(array(
        'name'          => esc_html__('Footer Left', 'creator-base'),
        'id'            => 'footer-left',
        'description'   => esc_html__('Left column of the footer. Great for about text or logo.', 'creator-base'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    // Footer Right Widget
    register_sidebar(array(
        'name'          => esc_html__('Footer Right', 'creator-base'),
        'id'            => 'footer-right',
        'description'   => esc_html__('Right column of the footer. Great for newsletter signup or contact info.', 'creator-base'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    // Legacy Footer Widget (for backwards compatibility)
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget (Legacy)', 'creator-base'),
        'id'            => 'footer-widget',
        'description'   => esc_html__('Legacy widget area. Move widgets to Footer Left or Footer Right.', 'creator-base'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    // Links Page Widget
    register_sidebar(array(
        'name'          => esc_html__('Links Page', 'creator-base'),
        'id'            => 'links-page',
        'description'   => esc_html__('Widget area for the Links page template. Add social icons or additional content below the menu.', 'creator-base'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    // Page Sidebar (optional)
    register_sidebar(array(
        'name'          => esc_html__('Page Sidebar', 'creator-base'),
        'id'            => 'page-sidebar',
        'description'   => esc_html__('Sidebar for pages when enabled in Customizer.', 'creator-base'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    // Promo Bar Widget Area
    register_sidebar(array(
        'name'          => esc_html__('Promo Bar', 'creator-base'),
        'id'            => 'promo-bar',
        'description'   => esc_html__('Promotional widgets for front page and single posts. Choose horizontal or sidebar layout in Customizer. Works great with image widgets linked to promotional content.', 'creator-base'),
        'before_widget' => '<div id="%1$s" class="widget promo-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<span class="promo-title screen-reader-text">',
        'after_title'   => '</span>',
    ));
}
add_action('widgets_init', 'creator_base_widgets_init');

/**
 * Featured Post Widget
 * Displays latest post or sticky post with featured image/embed
 */
class Creator_Base_Featured_Post_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'creator_base_featured_post',
            __('Featured Post (Auto)', 'creator-base'),
            array('description' => __('Automatically displays the latest or sticky post with featured image or video embed.', 'creator-base'))
        );
    }

    public function widget($args, $instance) {
        $source = !empty($instance['source']) ? $instance['source'] : 'latest';
        $show_title = !empty($instance['show_title']) ? (bool) $instance['show_title'] : true;
        $show_excerpt = !empty($instance['show_excerpt']) ? (bool) $instance['show_excerpt'] : true;
        $show_button = !empty($instance['show_button']) ? (bool) $instance['show_button'] : true;
        $button_text = !empty($instance['button_text']) ? $instance['button_text'] : __('Read More', 'creator-base');

        // Get the post
        if ($source === 'sticky') {
            $sticky = get_option('sticky_posts');
            if (!empty($sticky)) {
                $query = new WP_Query(array(
                    'post__in' => $sticky,
                    'posts_per_page' => 1,
                    'ignore_sticky_posts' => 1,
                ));
            } else {
                // Fallback to latest if no sticky
                $query = new WP_Query(array('posts_per_page' => 1));
            }
        } else {
            $query = new WP_Query(array('posts_per_page' => 1));
        }

        if (!$query->have_posts()) {
            return;
        }

        $query->the_post();
        
        echo $args['before_widget'];
        ?>
        <div class="featured-post-widget">
            <?php 
            // Check for embed in excerpt first
            $excerpt = creator_base_get_excerpt_with_embeds();
            $has_embed = creator_base_excerpt_has_embed();
            
            if ($has_embed) : ?>
                <div class="featured-post-media featured-post-embed">
                    <?php echo $excerpt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            <?php elseif (has_post_thumbnail()) : ?>
                <div class="featured-post-media">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('large'); ?>
                    </a>
                </div>
            <?php endif; ?>
            
            <div class="featured-post-content">
                <?php if ($show_title) : ?>
                    <h2 class="featured-post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                <?php endif; ?>
                
                <?php if ($show_excerpt) : 
                    $text_excerpt = get_the_excerpt();
                    $is_just_url = preg_match('/^\s*https?:\/\/\S+\s*$/', $text_excerpt);
                    if ($text_excerpt && !$is_just_url) :
                ?>
                    <p class="featured-post-excerpt"><?php echo esc_html(wp_trim_words($text_excerpt, 25, '...')); ?></p>
                <?php 
                    endif;
                endif; ?>
                
                <?php if ($show_button) : ?>
                    <a href="<?php the_permalink(); ?>" class="featured-post-button"><?php echo esc_html($button_text); ?></a>
                <?php endif; ?>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
        
        wp_reset_postdata();
    }

    public function form($instance) {
        $source = !empty($instance['source']) ? $instance['source'] : 'latest';
        $show_title = isset($instance['show_title']) ? (bool) $instance['show_title'] : true;
        $show_excerpt = isset($instance['show_excerpt']) ? (bool) $instance['show_excerpt'] : true;
        $show_button = isset($instance['show_button']) ? (bool) $instance['show_button'] : true;
        $button_text = !empty($instance['button_text']) ? $instance['button_text'] : __('Read More', 'creator-base');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('source')); ?>"><?php esc_html_e('Post Source:', 'creator-base'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('source')); ?>" name="<?php echo esc_attr($this->get_field_name('source')); ?>">
                <option value="latest" <?php selected($source, 'latest'); ?>><?php esc_html_e('Latest Post', 'creator-base'); ?></option>
                <option value="sticky" <?php selected($source, 'sticky'); ?>><?php esc_html_e('Sticky Post', 'creator-base'); ?></option>
            </select>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_title); ?> id="<?php echo esc_attr($this->get_field_id('show_title')); ?>" name="<?php echo esc_attr($this->get_field_name('show_title')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_title')); ?>"><?php esc_html_e('Show Title', 'creator-base'); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_excerpt); ?> id="<?php echo esc_attr($this->get_field_id('show_excerpt')); ?>" name="<?php echo esc_attr($this->get_field_name('show_excerpt')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_excerpt')); ?>"><?php esc_html_e('Show Excerpt', 'creator-base'); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_button); ?> id="<?php echo esc_attr($this->get_field_id('show_button')); ?>" name="<?php echo esc_attr($this->get_field_name('show_button')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_button')); ?>"><?php esc_html_e('Show Read More Button', 'creator-base'); ?></label>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('button_text')); ?>"><?php esc_html_e('Button Text:', 'creator-base'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('button_text')); ?>" name="<?php echo esc_attr($this->get_field_name('button_text')); ?>" type="text" value="<?php echo esc_attr($button_text); ?>" />
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['source'] = (!empty($new_instance['source'])) ? sanitize_text_field($new_instance['source']) : 'latest';
        $instance['show_title'] = !empty($new_instance['show_title']);
        $instance['show_excerpt'] = !empty($new_instance['show_excerpt']);
        $instance['show_button'] = !empty($new_instance['show_button']);
        $instance['button_text'] = (!empty($new_instance['button_text'])) ? sanitize_text_field($new_instance['button_text']) : __('Read More', 'creator-base');
        return $instance;
    }
}

function creator_base_register_featured_post_widget() {
    register_widget('Creator_Base_Featured_Post_Widget');
}
add_action('widgets_init', 'creator_base_register_featured_post_widget');

/**
 * Include required files
 */
require CREATOR_BASE_DIR . '/inc/customizer.php';
require CREATOR_BASE_DIR . '/inc/template-tags.php';
require CREATOR_BASE_DIR . '/inc/markdown.php';

/**
 * Custom excerpt length
 */
function creator_base_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'creator_base_excerpt_length');

/**
 * Custom excerpt more
 */
function creator_base_excerpt_more($more) {
    return '&hellip;';
}
add_filter('excerpt_more', 'creator_base_excerpt_more');

/**
 * Add custom body classes
 */
function creator_base_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'front-page';
    }

    if (get_theme_mod('creator_base_page_sidebar', false) && is_page()) {
        $classes[] = 'has-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'creator_base_body_classes');

/**
 * Wrap embeds in container for responsive sizing
 */
function creator_base_embed_wrapper($html, $url, $attr) {
    // Check if it's a video embed
    $video_hosts = array('youtube.com', 'youtu.be', 'vimeo.com', 'dailymotion.com');
    $audio_hosts = array('spotify.com', 'soundcloud.com', 'captivate.fm', 'anchor.fm', 'podcasts.apple.com');
    
    $is_video = false;
    $is_audio = false;
    
    foreach ($video_hosts as $host) {
        if (strpos($url, $host) !== false) {
            $is_video = true;
            break;
        }
    }
    
    if (!$is_video) {
        foreach ($audio_hosts as $host) {
            if (strpos($url, $host) !== false) {
                $is_audio = true;
                break;
            }
        }
    }

    if ($is_video) {
        return '<div class="embed-container">' . $html . '</div>';
    } elseif ($is_audio) {
        return '<div class="embed-container embed-audio">' . $html . '</div>';
    }

    return $html;
}
add_filter('embed_oembed_html', 'creator_base_embed_wrapper', 10, 3);

/**
 * Allow iframes in excerpts for embeds
 */
function creator_base_allowed_excerpt_tags() {
    return '<iframe><embed><object><video><audio><source><p><br><a><strong><em>';
}

/**
 * Get excerpt with embeds preserved
 * 
 * Supports:
 * - Bare YouTube/Vimeo URLs (will be converted to embeds)
 * - Already-embedded iframes (will be preserved)
 * - Shortcodes like [embed] or [video]
 */
function creator_base_get_excerpt_with_embeds($post = null) {
    if (!$post) {
        $post = get_post();
    }
    
    $excerpt = $post->post_excerpt;
    
    if (empty($excerpt)) {
        return '';
    }
    
    // First, process any shortcodes (like [embed] or [video])
    $excerpt = do_shortcode($excerpt);
    
    // Check if excerpt already contains an iframe (user pasted embed code)
    if (stripos($excerpt, '<iframe') !== false) {
        // Already has iframe, just sanitize and wrap it
        $excerpt = creator_base_sanitize_embed_html($excerpt);
        return $excerpt;
    }
    
    // Try to extract and convert YouTube URLs manually
    $excerpt = creator_base_convert_video_urls($excerpt);
    
    // If still no iframe, try WordPress oEmbed as fallback
    if (stripos($excerpt, '<iframe') === false) {
        global $wp_embed;
        if ($wp_embed) {
            $excerpt = $wp_embed->autoembed($excerpt);
            $excerpt = $wp_embed->run_shortcode($excerpt);
        }
    }
    
    // Sanitize while preserving embed HTML
    $excerpt = creator_base_sanitize_embed_html($excerpt);
    
    return $excerpt;
}

/**
 * Convert video URLs to embed iframes
 * Handles YouTube (both youtube.com and youtu.be), Vimeo
 */
function creator_base_convert_video_urls($content) {
    // YouTube patterns - both full URLs and short URLs
    $youtube_patterns = array(
        // youtu.be/VIDEO_ID or youtu.be/VIDEO_ID?si=XXX
        '/https?:\/\/(?:www\.)?youtu\.be\/([a-zA-Z0-9_-]+)(?:\?[^\s]*)?\s*/i',
        // youtube.com/watch?v=VIDEO_ID
        '/https?:\/\/(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)(?:&[^\s]*)?\s*/i',
        // youtube.com/embed/VIDEO_ID
        '/https?:\/\/(?:www\.)?youtube\.com\/embed\/([a-zA-Z0-9_-]+)(?:\?[^\s]*)?\s*/i',
    );
    
    foreach ($youtube_patterns as $pattern) {
        if (preg_match($pattern, $content, $matches)) {
            $video_id = $matches[1];
            $iframe = sprintf(
                '<div class="embed-container"><iframe src="https://www.youtube.com/embed/%s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen title="YouTube video"></iframe></div>',
                esc_attr($video_id)
            );
            // Replace the URL with the iframe
            $content = preg_replace($pattern, $iframe, $content, 1);
            return $content; // Return after first match for hero
        }
    }
    
    // Vimeo pattern
    $vimeo_pattern = '/https?:\/\/(?:www\.)?vimeo\.com\/(\d+)(?:\?[^\s]*)?\s*/i';
    if (preg_match($vimeo_pattern, $content, $matches)) {
        $video_id = $matches[1];
        $iframe = sprintf(
            '<div class="embed-container"><iframe src="https://player.vimeo.com/video/%s" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen title="Vimeo video"></iframe></div>',
            esc_attr($video_id)
        );
        $content = preg_replace($vimeo_pattern, $iframe, $content, 1);
        return $content;
    }
    
    return $content;
}

/**
 * Sanitize HTML while preserving embed elements and wrap in responsive container
 */
function creator_base_sanitize_embed_html($html) {
    // Define allowed HTML for embeds
    $allowed_html = array(
        'iframe' => array(
            'src'             => true,
            'width'           => true,
            'height'          => true,
            'frameborder'     => true,
            'allow'           => true,
            'allowfullscreen' => true,
            'title'           => true,
            'class'           => true,
            'style'           => true,
            'loading'         => true,
            'referrerpolicy'  => true,
        ),
        'div' => array(
            'class' => true,
            'style' => true,
        ),
        'video' => array(
            'src'      => true,
            'width'    => true,
            'height'   => true,
            'controls' => true,
            'autoplay' => true,
            'muted'    => true,
            'loop'     => true,
            'poster'   => true,
            'preload'  => true,
            'class'    => true,
        ),
        'source' => array(
            'src'  => true,
            'type' => true,
        ),
        'audio' => array(
            'src'      => true,
            'controls' => true,
            'autoplay' => true,
            'muted'    => true,
            'loop'     => true,
            'preload'  => true,
            'class'    => true,
        ),
        'embed' => array(
            'src'    => true,
            'type'   => true,
            'width'  => true,
            'height' => true,
        ),
        'object' => array(
            'data'   => true,
            'type'   => true,
            'width'  => true,
            'height' => true,
        ),
        'param' => array(
            'name'  => true,
            'value' => true,
        ),
        'p'      => array('class' => true),
        'br'     => array(),
        'a'      => array('href' => true, 'target' => true, 'rel' => true),
        'strong' => array(),
        'em'     => array(),
    );
    
    $html = wp_kses($html, $allowed_html);
    
    // Wrap bare iframes in responsive container if not already wrapped
    if (stripos($html, '<iframe') !== false && stripos($html, 'embed-container') === false) {
        // Determine if it's video or audio based on src
        $is_audio = false;
        $audio_hosts = array('spotify.com', 'soundcloud.com', 'captivate.fm', 'anchor.fm', 'podcasts.apple.com');
        foreach ($audio_hosts as $host) {
            if (stripos($html, $host) !== false) {
                $is_audio = true;
                break;
            }
        }
        
        $container_class = $is_audio ? 'embed-container embed-audio' : 'embed-container';
        
        // Wrap iframe in container
        $html = preg_replace(
            '/(<iframe[^>]*>.*?<\/iframe>)/is',
            '<div class="' . $container_class . '">$1</div>',
            $html
        );
    }
    
    return $html;
}

/**
 * Check if excerpt contains embed code
 */
function creator_base_excerpt_has_embed($post = null) {
    if (!$post) {
        $post = get_post();
    }
    
    $excerpt = $post->post_excerpt;
    
    if (empty($excerpt)) {
        return false;
    }
    
    // Check for iframe or common embed patterns
    $embed_patterns = array(
        '<iframe',
        'youtube.com',
        'youtu.be',
        'vimeo.com',
        'spotify.com',
        'soundcloud.com',
        'captivate.fm',
        'anchor.fm',
        '<embed',
        '<object',
        '<video',
        '<audio',
    );
    
    foreach ($embed_patterns as $pattern) {
        if (stripos($excerpt, $pattern) !== false) {
            return true;
        }
    }
    
    return false;
}

/**
 * Format view count for display (1.2M, 450K, etc.)
 */
function creator_base_format_view_count($count) {
    $count = (int) $count;
    
    if ($count >= 1000000) {
        $formatted = $count / 1000000;
        // Show one decimal if less than 10M, otherwise round
        if ($formatted < 10) {
            return number_format($formatted, 1) . 'M';
        }
        return round($formatted) . 'M';
    }
    
    if ($count >= 1000) {
        $formatted = $count / 1000;
        // Show one decimal if less than 100K, otherwise round
        if ($formatted < 100) {
            return number_format($formatted, 1) . 'K';
        }
        return round($formatted) . 'K';
    }
    
    return number_format($count);
}

/**
 * Format tags with hashtag style
 */
function creator_base_get_hashtags($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $tags = get_the_tags($post_id);
    
    if (!$tags) {
        return '';
    }
    
    $output = '';
    foreach ($tags as $tag) {
        $output .= '<a href="' . esc_url(get_tag_link($tag->term_id)) . '">#' . esc_html($tag->name) . '</a> ';
    }
    
    return trim($output);
}

/**
 * Load theme textdomain for translations
 */
function creator_base_load_textdomain() {
    load_theme_textdomain('creator-base', CREATOR_BASE_DIR . '/languages');
}
add_action('after_setup_theme', 'creator_base_load_textdomain');

/**
 * Fallback menu
 */
function creator_base_fallback_menu() {
    echo '<ul>';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'creator-base') . '</a></li>';
    wp_list_pages(array(
        'title_li' => '',
        'depth'    => 1,
    ));
    echo '</ul>';
}

/**
 * Check if promo bar should display
 */
function creator_base_show_promo_bar() {
    return get_theme_mod('creator_base_promo_bar', false) && is_active_sidebar('promo-bar');
}

/**
 * Get promo bar layout setting
 */
function creator_base_promo_layout() {
    return get_theme_mod('creator_base_promo_layout', 'horizontal');
}

/**
 * Output promo bar HTML
 * 
 * @param string $location Which layout to output ('horizontal' or 'sidebar')
 */
function creator_base_promo_bar($location = 'horizontal') {
    if (!creator_base_show_promo_bar()) {
        return;
    }
    
    $layout = creator_base_promo_layout();
    
    if ($location === 'sidebar') {
        // Only output sidebar if that's the selected layout
        if ($layout !== 'sidebar') {
            return;
        }
        ?>
        <div class="promo-bar promo-bar--sidebar promo-bar--desktop-only">
            <div class="promo-bar-inner">
                <?php dynamic_sidebar('promo-bar'); ?>
            </div>
        </div>
        <?php
    } else {
        // Horizontal location - output for both horizontal layout AND sidebar mobile fallback
        ?>
        <div class="promo-bar promo-bar--horizontal<?php echo ($layout === 'sidebar') ? ' promo-bar--mobile-only' : ''; ?>">
            <button class="promo-bar-nav promo-bar-nav--prev" aria-label="<?php esc_attr_e('Previous', 'creator-base'); ?>">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <div class="promo-bar-inner">
                <?php dynamic_sidebar('promo-bar'); ?>
            </div>
            <button class="promo-bar-nav promo-bar-nav--next" aria-label="<?php esc_attr_e('Next', 'creator-base'); ?>">
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
        </div>
        <?php
    }
}

/**
 * YouTube Promo Widget
 * 
 * Displays a YouTube video thumbnail that links to the video or a custom URL.
 * Perfect for promo bars - no image uploading needed.
 */
class Creator_Base_YouTube_Promo_Widget extends WP_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'creator_base_youtube_promo',
            __('YouTube Promo', 'creator-base'),
            array(
                'description' => __('Display a YouTube thumbnail as a promo image. Auto-extracts thumbnail from any YouTube URL.', 'creator-base'),
                'classname'   => 'widget_youtube_promo',
            )
        );
    }

    /**
     * Frontend display
     */
    public function widget($args, $instance) {
        $youtube_url = !empty($instance['youtube_url']) ? $instance['youtube_url'] : '';
        $link_url = !empty($instance['link_url']) ? $instance['link_url'] : $youtube_url;
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $badge_text = !empty($instance['badge_text']) ? $instance['badge_text'] : '';
        
        if (empty($youtube_url)) {
            return;
        }
        
        // Extract video ID
        $video_id = $this->extract_video_id($youtube_url);
        
        if (!$video_id) {
            return;
        }
        
        // Build thumbnail URL - try maxres first, fallback handled by onerror
        $thumbnail_url = 'https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg';
        $fallback_url = 'https://img.youtube.com/vi/' . $video_id . '/hqdefault.jpg';
        
        echo $args['before_widget'];
        
        if ($title && strpos($args['before_title'], 'screen-reader-text') === false) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }
        ?>
        <a href="<?php echo esc_url($link_url); ?>" class="youtube-promo-link" target="_blank" rel="noopener noreferrer">
            <img 
                src="<?php echo esc_url($thumbnail_url); ?>" 
                alt="<?php echo esc_attr($title ? $title : __('YouTube Video', 'creator-base')); ?>"
                onerror="this.onerror=null; this.src='<?php echo esc_url($fallback_url); ?>';"
                loading="lazy"
            />
            <?php if ($badge_text) : ?>
            <span class="youtube-promo-badge"><?php echo esc_html($badge_text); ?></span>
            <?php endif; ?>
        </a>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Admin form
     */
    public function form($instance) {
        $youtube_url = !empty($instance['youtube_url']) ? $instance['youtube_url'] : '';
        $link_url = !empty($instance['link_url']) ? $instance['link_url'] : '';
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $badge_text = !empty($instance['badge_text']) ? $instance['badge_text'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('youtube_url')); ?>">
                <?php esc_html_e('YouTube URL:', 'creator-base'); ?>
            </label>
            <input 
                class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('youtube_url')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('youtube_url')); ?>" 
                type="url" 
                value="<?php echo esc_url($youtube_url); ?>"
                placeholder="https://youtube.com/watch?v=... or youtu.be/..."
            />
            <small><?php esc_html_e('Paste any YouTube video URL. Thumbnail will be extracted automatically.', 'creator-base'); ?></small>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('link_url')); ?>">
                <?php esc_html_e('Link URL (optional):', 'creator-base'); ?>
            </label>
            <input 
                class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('link_url')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('link_url')); ?>" 
                type="url" 
                value="<?php echo esc_url($link_url); ?>"
                placeholder="<?php esc_attr_e('Leave empty to link to the YouTube video', 'creator-base'); ?>"
            />
            <small><?php esc_html_e('Override where the thumbnail links to (e.g., a playlist or external site).', 'creator-base'); ?></small>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('badge_text')); ?>">
                <?php esc_html_e('Badge Text (optional):', 'creator-base'); ?>
            </label>
            <input 
                class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('badge_text')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('badge_text')); ?>" 
                type="text" 
                value="<?php echo esc_attr($badge_text); ?>"
                placeholder="<?php esc_attr_e('e.g., PLAYLIST, NEW, SERIES', 'creator-base'); ?>"
            />
            <small><?php esc_html_e('Shows as an overlay badge on the thumbnail.', 'creator-base'); ?></small>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Alt Text (optional):', 'creator-base'); ?>
            </label>
            <input 
                class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                type="text" 
                value="<?php echo esc_attr($title); ?>"
                placeholder="<?php esc_attr_e('Descriptive text for accessibility', 'creator-base'); ?>"
            />
        </p>
        <?php
    }

    /**
     * Save widget settings
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['youtube_url'] = !empty($new_instance['youtube_url']) ? esc_url_raw($new_instance['youtube_url']) : '';
        $instance['link_url'] = !empty($new_instance['link_url']) ? esc_url_raw($new_instance['link_url']) : '';
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['badge_text'] = !empty($new_instance['badge_text']) ? sanitize_text_field($new_instance['badge_text']) : '';
        return $instance;
    }

    /**
     * Extract video ID from various YouTube URL formats
     */
    private function extract_video_id($url) {
        $patterns = array(
            // youtu.be/VIDEO_ID
            '/youtu\.be\/([a-zA-Z0-9_-]+)/',
            // youtube.com/watch?v=VIDEO_ID
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
            // youtube.com/embed/VIDEO_ID
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/',
            // youtube.com/v/VIDEO_ID
            '/youtube\.com\/v\/([a-zA-Z0-9_-]+)/',
            // youtube.com/shorts/VIDEO_ID
            '/youtube\.com\/shorts\/([a-zA-Z0-9_-]+)/',
        );
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }
        
        return false;
    }
}

/**
 * Register the YouTube Promo widget
 */
function creator_base_register_youtube_promo_widget() {
    register_widget('Creator_Base_YouTube_Promo_Widget');
}
add_action('widgets_init', 'creator_base_register_youtube_promo_widget');

/**
 * Gallery Lightbox Enhancement
 * 
 * Changes gallery links to point to full-size images instead of attachment pages
 * and adds data-lightbox attribute to trigger the existing lightbox.
 */
function creator_base_gallery_lightbox_links( $html, $id, $size, $permalink, $icon, $text ) {
    // Only modify if not explicitly linking to permalink
    if ( $permalink ) {
        return $html;
    }
    
    // Get full-size image URL
    $full_src = wp_get_attachment_image_src( $id, 'full' );
    if ( $full_src ) {
        // Replace href and add data-lightbox attribute
        $html = preg_replace(
            '/href=["\'][^"\']+["\']/',
            'href="' . esc_url( $full_src[0] ) . '" data-lightbox="gallery"',
            $html
        );
    }
    
    return $html;
}
add_filter( 'wp_get_attachment_link', 'creator_base_gallery_lightbox_links', 10, 6 );

/**
 * Child Pages Shortcode
 * 
 * Displays child pages of the current page (or specified parent) with
 * featured image, title, and excerpt in a card grid layout.
 * 
 * Usage:
 *   [child_pages]                          - Shows children of current page
 *   [child_pages parent="products"]        - Shows children of page with slug "products"
 *   [child_pages parent="123"]             - Shows children of page ID 123
 *   [child_pages orderby="title"]          - Sort by title (default: menu_order)
 *   [child_pages order="DESC"]             - Descending order (default: ASC)
 *   [child_pages columns="2"]              - 2-column grid (default: 3)
 * 
 * Add this to your theme's functions.php
 */

function creator_base_child_pages_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'parent'  => 'current',    // 'current', page slug, or page ID
        'orderby' => 'menu_order', // menu_order, title, date, modified
        'order'   => 'ASC',        // ASC or DESC
        'columns' => 3,            // Grid columns (2, 3, or 4)
    ), $atts, 'child_pages' );

    // Determine parent page ID
    if ( $atts['parent'] === 'current' ) {
        $parent_id = get_the_ID();
    } elseif ( is_numeric( $atts['parent'] ) ) {
        $parent_id = intval( $atts['parent'] );
    } else {
        // It's a slug - find the page
        $parent_page = get_page_by_path( $atts['parent'] );
        $parent_id = $parent_page ? $parent_page->ID : 0;
    }

    if ( ! $parent_id ) {
        return '<!-- child_pages: No valid parent page found -->';
    }

    // Query child pages
    $child_pages = new WP_Query( array(
        'post_type'      => 'page',
        'post_parent'    => $parent_id,
        'posts_per_page' => -1,
        'orderby'        => sanitize_key( $atts['orderby'] ),
        'order'          => strtoupper( $atts['order'] ) === 'DESC' ? 'DESC' : 'ASC',
        'post_status'    => 'publish',
    ) );

    if ( ! $child_pages->have_posts() ) {
        return '<!-- child_pages: No child pages found -->';
    }

    // Sanitize columns
    $columns = intval( $atts['columns'] );
    if ( $columns < 2 ) $columns = 2;
    if ( $columns > 4 ) $columns = 4;

    // Build output
    ob_start();
    ?>
    <div class="child-pages-grid child-pages-grid--cols-<?php echo esc_attr( $columns ); ?>">
        <?php while ( $child_pages->have_posts() ) : $child_pages->the_post(); ?>
            <article class="child-page-card">
                <a href="<?php the_permalink(); ?>" class="child-page-card__link">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="child-page-card__image">
                            <?php the_post_thumbnail( 'medium_large' ); ?>
                        </div>
                    <?php endif; ?>
                    <div class="child-page-card__content">
                        <h3 class="child-page-card__title"><?php the_title(); ?></h3>
                        <?php if ( has_excerpt() || get_the_content() ) : ?>
                            <p class="child-page-card__excerpt">
                                <?php echo wp_trim_words( get_the_excerpt(), 20, '&hellip;' ); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </a>
            </article>
        <?php endwhile; ?>
    </div>
    <?php
    wp_reset_postdata();
    
    return ob_get_clean();
}
add_shortcode( 'child_pages', 'creator_base_child_pages_shortcode' );


/**
 * Child Pages Shortcode Styles
 * 
 * Add this to your theme's style.css or output via wp_head
 */

function creator_base_child_pages_styles() {
    ?>
    <style>
    /* Child Pages Grid */
    .child-pages-grid {
        display: grid;
        gap: 1.5rem;
        margin: 2rem 0;
    }
    
    .child-pages-grid--cols-2 { grid-template-columns: repeat(2, 1fr); }
    .child-pages-grid--cols-3 { grid-template-columns: repeat(3, 1fr); }
    .child-pages-grid--cols-4 { grid-template-columns: repeat(4, 1fr); }
    
    @media (max-width: 768px) {
        .child-pages-grid--cols-3,
        .child-pages-grid--cols-4 {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 480px) {
        .child-pages-grid {
            grid-template-columns: 1fr;
        }
    }
    
    /* Child Page Card */
    .child-page-card {
        background: var(--cb-color-bg-secondary, #1a1a1a);
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .child-page-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    }
    
    .child-page-card__link {
        display: block;
        text-decoration: none;
        color: inherit;
    }
    
    .child-page-card__image {
        aspect-ratio: 16 / 9;
        overflow: hidden;
    }
    
    .child-page-card__image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .child-page-card:hover .child-page-card__image img {
        transform: scale(1.05);
    }
    
    .child-page-card__content {
        padding: 1rem 1.25rem 1.25rem;
    }
    
    .child-page-card__title {
        font-size: 1.125rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
        color: var(--cb-color-text-primary, #ffffff);
        line-height: 1.3;
    }
    
    .child-page-card__excerpt {
        font-size: 0.875rem;
        color: var(--cb-color-text-secondary, #a0a0a0);
        margin: 0;
        line-height: 1.5;
    }
    </style>
    <?php
}
add_action( 'wp_head', 'creator_base_child_pages_styles' );

/**
 * GitHub Theme Updater
 * 
 * Checks GitHub releases for updates and integrates with WordPress update system.
 * No plugin required.
 */
class Creator_Base_GitHub_Updater {
    
    private $slug = 'creator-base';
    private $github_username = 'donburnside';
    private $github_repo = 'creator-base';
    private $current_version;
    private $github_response;
    
    public function __construct() {
        $this->current_version = CREATOR_BASE_VERSION;
        
        add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_for_update' ) );
        add_filter( 'themes_api', array( $this, 'theme_info' ), 20, 3 );
        add_filter( 'upgrader_source_selection', array( $this, 'fix_directory_name' ), 10, 4 );
    }
    
    /**
     * Get release info from GitHub API
     */
    private function get_github_release() {
        if ( ! empty( $this->github_response ) ) {
            return $this->github_response;
        }
        
        $url = sprintf(
            'https://api.github.com/repos/%s/%s/releases/latest',
            $this->github_username,
            $this->github_repo
        );
        
        $response = wp_remote_get( $url, array(
            'headers' => array(
                'Accept' => 'application/vnd.github.v3+json',
            ),
            'timeout' => 10,
        ) );
        
        if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) !== 200 ) {
            return false;
        }
        
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body );
        
        if ( empty( $data ) || ! isset( $data->tag_name ) ) {
            return false;
        }
        
        $this->github_response = $data;
        return $data;
    }
    
    /**
     * Check GitHub for theme updates
     */
    public function check_for_update( $transient ) {
        if ( empty( $transient->checked ) ) {
            return $transient;
        }
        
        $release = $this->get_github_release();
        
        if ( ! $release ) {
            return $transient;
        }
        
        // Remove 'v' prefix from tag if present (e.g., v3.0.3 -> 3.0.3)
        $github_version = ltrim( $release->tag_name, 'v' );
        
        if ( version_compare( $github_version, $this->current_version, '>' ) ) {
            // Find the zip asset
            $download_url = '';
            
            if ( ! empty( $release->assets ) ) {
                foreach ( $release->assets as $asset ) {
                    if ( strpos( $asset->name, '.zip' ) !== false ) {
                        $download_url = $asset->browser_download_url;
                        break;
                    }
                }
            }
            
            // Fallback to zipball if no asset found
            if ( empty( $download_url ) ) {
                $download_url = $release->zipball_url;
            }
            
            $transient->response[ $this->slug ] = array(
                'theme'       => $this->slug,
                'new_version' => $github_version,
                'url'         => $release->html_url,
                'package'     => $download_url,
            );
        }
        
        return $transient;
    }
    
    /**
     * Provide theme info for the update details popup
     */
    public function theme_info( $result, $action, $args ) {
        if ( $action !== 'theme_information' || $args->slug !== $this->slug ) {
            return $result;
        }
        
        $release = $this->get_github_release();
        
        if ( ! $release ) {
            return $result;
        }
        
        $github_version = ltrim( $release->tag_name, 'v' );
        
        return (object) array(
            'name'           => 'Creator Base',
            'slug'           => $this->slug,
            'version'        => $github_version,
            'author'         => '<a href="https://donburnside.com">Don Burnside</a>',
            'homepage'       => 'https://github.com/' . $this->github_username . '/' . $this->github_repo,
            'sections'       => array(
                'description' => 'A WordPress theme for Podcasters, YouTubers and content creators. Own your content.',
                'changelog'   => nl2br( esc_html( $release->body ) ),
            ),
            'download_link'  => $release->zipball_url,
            'requires'       => '5.0',
            'tested'         => '6.4',
            'last_updated'   => $release->published_at,
        );
    }
    
    /**
     * Fix directory name after extraction
     * GitHub zipballs extract to username-repo-hash, we need creator-base
     */
    public function fix_directory_name( $source, $remote_source, $upgrader, $hook_extra ) {
        if ( ! isset( $hook_extra['theme'] ) || $hook_extra['theme'] !== $this->slug ) {
            return $source;
        }
        
        global $wp_filesystem;
        
        $corrected_source = trailingslashit( $remote_source ) . $this->slug . '/';
        
        if ( $wp_filesystem->move( $source, $corrected_source ) ) {
            return $corrected_source;
        }
        
        return $source;
    }
}

// Initialize the updater
function creator_base_init_updater() {
    new Creator_Base_GitHub_Updater();
}
add_action( 'admin_init', 'creator_base_init_updater' );

