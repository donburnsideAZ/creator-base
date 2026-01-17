<?php
/**
 * Template part for displaying post cards
 *
 * @package Creator_Base
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('content-card'); ?>>
    
    <div class="card-media">
        <?php 
        $excerpt = creator_base_get_excerpt_with_embeds();
        $has_embed = creator_base_excerpt_has_embed();
        
        if ($has_embed) : 
            // Show embed from excerpt - already sanitized and wrapped by creator_base_get_excerpt_with_embeds()
            echo $excerpt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Sanitized by creator_base_sanitize_embed_html()
        ?>
        <?php elseif (has_post_thumbnail()) : ?>
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('creator-base-card'); ?>
            </a>
        <?php elseif ($excerpt) : ?>
            <a href="<?php the_permalink(); ?>" class="card-text-excerpt">
                <?php echo wp_kses_post(wp_trim_words($excerpt, 30)); ?>
            </a>
        <?php else : ?>
            <a href="<?php the_permalink(); ?>" class="card-text-excerpt">
                <?php echo wp_kses_post(get_the_excerpt()); ?>
            </a>
        <?php endif; ?>
        
        <?php 
        // View count badge
        $views = get_post_meta(get_the_ID(), '_youtube_views', true);
        if ($views && is_numeric($views) && $views > 0) :
            $formatted_views = creator_base_format_view_count($views);
        ?>
        <span class="card-views-badge">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
            <?php echo esc_html($formatted_views); ?>
        </span>
        <?php endif; ?>
    </div>
    
    <div class="card-body">
        <span class="card-category">
            <?php
            $categories = get_the_category();
            if (!empty($categories)) {
                echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
            }
            ?>
        </span>
        
        <h2 class="card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        
        <div class="card-meta">
            <span class="card-date"><?php echo get_the_date(); ?></span>
        </div>
        
        <?php 
        // Get excerpt text (skip if it's just a URL - those are embed-only posts)
        // Also skip excerpts entirely in Video hero mode (compact cards for video creators)
        $hero_type = get_theme_mod('creator_base_hero_type', 'video');
        $card_excerpt = get_the_excerpt();
        $is_just_url = preg_match('/^\s*https?:\/\/\S+\s*$/', $card_excerpt);
        
        if ($hero_type !== 'video' && $card_excerpt && !$is_just_url) :
        ?>
        <p class="card-excerpt"><?php echo esc_html(wp_trim_words($card_excerpt, 20, '...')); ?></p>
        <?php endif; ?>
        
        <?php 
        $tags = creator_base_get_hashtags();
        if ($tags) : 
        ?>
        <div class="card-tags">
            <?php echo $tags; ?>
        </div>
        <?php endif; ?>
    </div>
    
</article>
