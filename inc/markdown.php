<?php
/**
 * Creator Base Markdown Support
 *
 * Simple markdown processing for post content and excerpts
 *
 * @package Creator_Base
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Simple Markdown Parser
 * Handles the most common markdown syntax
 */
class Creator_Base_Markdown {
    
    /**
     * Parse markdown text to HTML
     */
    public static function parse($text) {
        if (empty($text)) {
            return $text;
        }
        
        // Preserve code blocks first
        $code_blocks = array();
        $text = preg_replace_callback('/```([\s\S]*?)```/m', function($matches) use (&$code_blocks) {
            $index = count($code_blocks);
            $code_blocks[$index] = '<pre><code>' . esc_html(trim($matches[1])) . '</code></pre>';
            return "{{CODE_BLOCK_$index}}";
        }, $text);
        
        // Inline code
        $text = preg_replace('/`([^`]+)`/', '<code>$1</code>', $text);
        
        // Headers (must be at start of line)
        $text = preg_replace('/^###### (.+)$/m', '<h6>$1</h6>', $text);
        $text = preg_replace('/^##### (.+)$/m', '<h5>$1</h5>', $text);
        $text = preg_replace('/^#### (.+)$/m', '<h4>$1</h4>', $text);
        $text = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $text);
        $text = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $text);
        $text = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $text);
        
        // Bold and italic
        $text = preg_replace('/\*\*\*(.+?)\*\*\*/', '<strong><em>$1</em></strong>', $text);
        $text = preg_replace('/___(.+?)___/', '<strong><em>$1</em></strong>', $text);
        $text = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/__(.+?)__/', '<strong>$1</strong>', $text);
        $text = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $text);
        $text = preg_replace('/_(.+?)_/', '<em>$1</em>', $text);
        
        // Strikethrough
        $text = preg_replace('/~~(.+?)~~/', '<del>$1</del>', $text);
        
        // Links [text](url)
        $text = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '<a href="$2">$1</a>', $text);
        
        // Images ![alt](url)
        $text = preg_replace('/!\[([^\]]*)\]\(([^)]+)\)/', '<img src="$2" alt="$1">', $text);
        
        // Blockquotes
        $text = preg_replace('/^> (.+)$/m', '<blockquote>$1</blockquote>', $text);
        // Merge consecutive blockquotes
        $text = preg_replace('/<\/blockquote>\s*<blockquote>/', "\n", $text);
        
        // Horizontal rules
        $text = preg_replace('/^(---|\*\*\*|___)$/m', '<hr>', $text);
        
        // Unordered lists
        $text = preg_replace_callback('/^[\*\-\+] (.+)$/m', function($matches) {
            return '<li>' . $matches[1] . '</li>';
        }, $text);
        $text = preg_replace('/(<li>.*<\/li>)/s', '<ul>$1</ul>', $text);
        $text = preg_replace('/<\/ul>\s*<ul>/', '', $text);
        
        // Ordered lists
        $text = preg_replace_callback('/^\d+\. (.+)$/m', function($matches) {
            return '<oli>' . $matches[1] . '</oli>';
        }, $text);
        $text = preg_replace('/(<oli>.*<\/oli>)/s', '<ol>$1</ol>', $text);
        $text = str_replace(array('<oli>', '</oli>'), array('<li>', '</li>'), $text);
        $text = preg_replace('/<\/ol>\s*<ol>/', '', $text);
        
        // Paragraphs - wrap remaining text blocks
        $lines = explode("\n", $text);
        $result = array();
        $in_block = false;
        
        foreach ($lines as $line) {
            $trimmed = trim($line);
            
            // Skip if already an HTML block element
            if (preg_match('/^<(h[1-6]|ul|ol|li|blockquote|pre|hr|div|p)/', $trimmed)) {
                if ($in_block) {
                    $result[] = '</p>';
                    $in_block = false;
                }
                $result[] = $line;
            } elseif (empty($trimmed)) {
                if ($in_block) {
                    $result[] = '</p>';
                    $in_block = false;
                }
                $result[] = '';
            } else {
                if (!$in_block) {
                    $result[] = '<p>' . $line;
                    $in_block = true;
                } else {
                    $result[] = '<br>' . $line;
                }
            }
        }
        
        if ($in_block) {
            $result[] = '</p>';
        }
        
        $text = implode("\n", $result);
        
        // Clean up empty paragraphs
        $text = preg_replace('/<p>\s*<\/p>/', '', $text);
        
        // Restore code blocks
        foreach ($code_blocks as $index => $code) {
            $text = str_replace("{{CODE_BLOCK_$index}}", $code, $text);
        }
        
        return $text;
    }
}

/**
 * Apply markdown to post content
 */
function creator_base_markdown_content($content) {
    // Only process if not already processed by block editor
    if (has_blocks($content)) {
        return $content;
    }
    
    // Skip markdown processing if content already contains HTML links
    // This prevents the underscore-to-italic regex from mangling URLs with query params like ?_pos=3&_sid=xxx
    if (preg_match('/<a\s+[^>]*href\s*=/i', $content)) {
        return $content;
    }
    
    return Creator_Base_Markdown::parse($content);
}
add_filter('the_content', 'creator_base_markdown_content', 5);

/**
 * Apply markdown to excerpts (but preserve embeds)
 */
function creator_base_markdown_excerpt($excerpt) {
    // Don't process if excerpt contains embed code
    if (preg_match('/<iframe|<embed|<object|<video|<audio/', $excerpt)) {
        return $excerpt;
    }
    
    // Skip markdown processing if excerpt already contains HTML links
    // This prevents the underscore-to-italic regex from mangling URLs with query params like ?_pos=3&_sid=xxx
    if (preg_match('/<a\s+[^>]*href\s*=/i', $excerpt)) {
        return $excerpt;
    }
    
    return Creator_Base_Markdown::parse($excerpt);
}
add_filter('the_excerpt', 'creator_base_markdown_excerpt', 5);
