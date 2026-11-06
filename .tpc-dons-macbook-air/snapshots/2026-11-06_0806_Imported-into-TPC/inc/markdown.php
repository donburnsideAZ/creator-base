<?php
/**
 * Creator Base Markdown Support
 *
 * Renders Markdown in Classic Editor posts, pages and excerpts using
 * Parsedown (bundled in inc/lib), a real CommonMark-style parser.
 *
 * Why Parsedown instead of the old hand-rolled regex parser:
 * - Markdown and raw HTML can be mixed freely in the same post. HTML is passed
 *   through untouched and the Markdown around it still renders. No more
 *   "one <a href> on the page turns Markdown off for everything".
 * - Linked images [![alt](img)](link), reference links [text][ref], lists,
 *   blockquotes (with or without a space after >), tables and fenced code
 *   all work the way the Markdown spec says they should.
 * - Underscores inside URLs and file names (US_UK_Apple_Badge.svg,
 *   ?_pos=3&_sid=x) are never turned into italics.
 *
 * Writing rules (same as before):
 * - A single line break becomes a <br>, a blank line starts a new paragraph.
 * - A bare YouTube / Vimeo / Spotify / etc. URL on its own line still becomes
 *   an embed, exactly like the "paste URL and publish" workflow expects.
 * - To skip Markdown on a single post, put <!-- no-markdown --> anywhere in it.
 *
 * @package Creator_Base
 * @version 3.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Parsedown')) {
    require_once __DIR__ . '/lib/Parsedown.php';
}

/**
 * Parsedown tuned for how Creator Base posts are written.
 */
class Creator_Base_Parsedown extends Parsedown {

    /**
     * Turn off "indented code blocks" (4 leading spaces = code).
     * Old HTML posts and pasted text are often indented, and nobody on a
     * creator site writes code that way. Fenced ``` code blocks still work.
     */
    protected $unmarkedBlockTypes = array();

    public function __construct() {
        $this->setBreaksEnabled(true);   // single newline = <br>, like the Classic Editor
        $this->setMarkupEscaped(false);  // allow raw HTML mixed with Markdown
        $this->setUrlsLinked(true);      // bare URLs mid-sentence become links

        // Leave straight double quotes alone instead of turning them into
        // &quot;. WordPress's wptexturize can then curl them as usual.
        unset($this->InlineTypes['"']);
        $this->inlineMarkerList = str_replace('"', '', $this->inlineMarkerList);
    }

    /**
     * A blockquote ends at the first line that doesn't start with ">".
     *
     * Strict Markdown lets the next un-prefixed line "fall into" the quote
     * (lazy continuation), which swallowed the paragraph after a quote and
     * even the [ref]: link definitions under it, breaking reference links.
     */
    protected function blockQuoteContinue($Line, array $Block) {
        if ($Line['text'][0] === '>' && preg_match('/^>[ ]?(.*)/', $Line['text'], $matches)) {
            if (isset($Block['interrupted'])) {
                $Block['element']['text'][] = '';
                unset($Block['interrupted']);
            }
            $Block['element']['text'][] = $matches[1];
            return $Block;
        }
        return null;
    }
}

/**
 * Markdown helper. Kept as a class with static methods so any child theme
 * calling Creator_Base_Markdown::parse() keeps working.
 */
class Creator_Base_Markdown {

    /** @var Creator_Base_Parsedown|null */
    private static $parser = null;

    private static function parser() {
        if (self::$parser === null) {
            self::$parser = new Creator_Base_Parsedown();
        }
        return self::$parser;
    }

    /**
     * Convert a full Markdown document (paragraphs, headings, lists...) to HTML.
     */
    public static function parse($text) {
        if (!is_string($text) || trim($text) === '') {
            return $text;
        }

        $text = str_replace(array("\r\n", "\r"), "\n", $text);

        // Protect shortcodes ([audio], [caption], [embed]...) so Markdown
        // never touches their attributes or the URLs inside them.
        $shortcodes = array();
        $shortcode_regex = self::shortcode_regex();
        if ($shortcode_regex) {
            $text = preg_replace_callback(
                '/' . $shortcode_regex . '/',
                function ($m) use (&$shortcodes) {
                    $token = 'CBMDSHORTCODE' . count($shortcodes) . 'X';
                    $shortcodes[$token] = $m[0];
                    return $token;
                },
                $text
            );
        }

        // Protect bare URLs that sit on their own line so WordPress can still
        // auto-embed them (YouTube, Spotify, Captivate...). Without this they
        // would be turned into plain links and the player would disappear.
        $embeds = array();
        $text = preg_replace_callback(
            '/^[ \t]*(https?:\/\/[^\s<>"]+)[ \t]*$/m',
            function ($m) use (&$embeds) {
                $token = 'CBMDEMBED' . count($embeds) . 'X';
                $embeds[$token] = $m[1];
                // Blank lines around it make it a paragraph of its own.
                return "\n" . $token . "\n";
            },
            $text
        );

        $html = self::parser()->text($text);

        // Put the URLs back on their own line, where WP_Embed::autoembed()
        // (which runs right after us) looks for them.
        foreach ($embeds as $token => $url) {
            $html = preg_replace(
                '/<p>\s*' . $token . '\s*<\/p>/',
                "\n" . str_replace('$', '\\$', $url) . "\n",
                $html
            );
            // Fallback: token ended up inside other markup (e.g. a list item).
            $html = str_replace($token, $url, $html);
        }

        if ($shortcodes) {
            $html = strtr($html, $shortcodes);
        }

        return $html;
    }

    /**
     * Regex matching registered shortcodes, plus [embed] (WordPress only
     * registers that one for a moment while it processes embeds).
     */
    private static function shortcode_regex() {
        global $shortcode_tags;
        if (!function_exists('get_shortcode_regex')) {
            return '';
        }
        $tags = array_keys(is_array($shortcode_tags) ? $shortcode_tags : array());
        $tags[] = 'embed';
        return get_shortcode_regex(array_unique($tags));
    }

    /**
     * Convert inline Markdown only (links, bold, italics, code) with no
     * paragraph wrapping. Used for short bits of text such as excerpts.
     */
    public static function inline($text) {
        if (!is_string($text) || trim($text) === '') {
            return $text;
        }
        return self::parser()->line($text);
    }

    /**
     * Inline Markdown rendered down to plain text, for places that print
     * escaped text (post cards, widgets).
     */
    public static function to_text($text) {
        if (!is_string($text) || trim($text) === '') {
            return $text;
        }
        return trim(wp_strip_all_tags(self::inline($text)));
    }
}

/**
 * Check if content has complex Gutenberg blocks that shouldn't be
 * Markdown-processed (those posts were built in the block editor).
 */
function creator_base_has_complex_blocks($content) {
    if (strpos($content, '<!-- wp:') === false) {
        return false;
    }

    $simple_blocks = array(
        'paragraph',
        'heading',
        'list',
        'list-item',
        'quote',
        'separator',
        'freeform',
    );

    preg_match_all('/<!-- wp:(?:[a-z0-9-]+\/)?([a-z0-9-]+)/', $content, $matches);

    foreach ($matches[1] as $block_name) {
        if (!in_array($block_name, $simple_blocks, true)) {
            return true;
        }
    }

    return false;
}

/**
 * Strip simple Gutenberg block wrappers (<!-- wp:paragraph --> etc.)
 * that sometimes sneak into Classic Editor posts.
 */
function creator_base_strip_block_wrappers($content) {
    $content = preg_replace('/<!-- \/?wp:[^>]*?-->[ \t]*\n?/', '', $content);
    return trim($content);
}

/**
 * Should this content be run through Markdown?
 */
function creator_base_should_render_markdown($content) {
    if (!is_string($content) || trim($content) === '') {
        return false;
    }

    // Per-post opt out.
    if (stripos($content, '<!-- no-markdown -->') !== false) {
        return false;
    }

    if (creator_base_has_complex_blocks($content)) {
        return false;
    }

    /**
     * Filter: turn Creator Base Markdown off (return false), e.g. from a
     * child theme or for specific post types.
     */
    return (bool) apply_filters('creator_base_markdown_enabled', true, get_post());
}

/**
 * Render Markdown in post and page content.
 *
 * Runs at priority 5, before WordPress's own embed (8), shortcode (11) and
 * wpautop (10) filters. Parsedown already builds the paragraphs, so wpautop
 * is switched off for this one pass. Running both is what used to scatter
 * stray <br> and <p> tags through Markdown posts.
 */
function creator_base_markdown_content($content) {
    if (!creator_base_should_render_markdown($content)) {
        return $content;
    }

    $content = creator_base_strip_block_wrappers($content);
    $content = Creator_Base_Markdown::parse($content);

    $autop_priority = has_filter('the_content', 'wpautop');
    if ($autop_priority !== false) {
        remove_filter('the_content', 'wpautop', $autop_priority);
        $GLOBALS['creator_base_autop_priority'] = $autop_priority;
        add_filter('the_content', 'creator_base_markdown_restore_autop', PHP_INT_MAX);
    }

    return $content;
}
add_filter('the_content', 'creator_base_markdown_content', 5);

/**
 * Put wpautop back once this content pass is finished, so anything else
 * that uses the_content later (widgets, other plugins) behaves normally.
 */
function creator_base_markdown_restore_autop($content) {
    remove_filter('the_content', 'creator_base_markdown_restore_autop', PHP_INT_MAX);
    if (isset($GLOBALS['creator_base_autop_priority'])) {
        add_filter('the_content', 'wpautop', $GLOBALS['creator_base_autop_priority']);
        unset($GLOBALS['creator_base_autop_priority']);
    }
    return $content;
}

/**
 * Render inline Markdown in excerpts (the_excerpt()).
 * WordPress's own wpautop on the_excerpt still adds the paragraph.
 */
function creator_base_markdown_excerpt($excerpt) {
    if (!is_string($excerpt) || trim($excerpt) === '') {
        return $excerpt;
    }

    // Leave embed code alone.
    if (preg_match('/<(iframe|embed|object|video|audio)\b/i', $excerpt)) {
        return $excerpt;
    }

    $excerpt = creator_base_strip_block_wrappers($excerpt);

    return Creator_Base_Markdown::inline($excerpt);
}
add_filter('the_excerpt', 'creator_base_markdown_excerpt', 5);
