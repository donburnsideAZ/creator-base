<?php
/**
 * The comments template
 *
 * @package Creator_Base
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            printf(
                /* translators: 1: number of comments */
                esc_html(_n('%1$s Comment', '%1$s Comments', $comment_count, 'creator-base')),
                number_format_i18n($comment_count)
            );
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size' => 50,
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation();

        if (!comments_open()) :
        ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'creator-base'); ?></p>
        <?php endif; ?>

    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply'        => esc_html__('Leave a Comment', 'creator-base'),
        'title_reply_to'     => esc_html__('Leave a Reply to %s', 'creator-base'),
        'cancel_reply_link'  => esc_html__('Cancel Reply', 'creator-base'),
        'label_submit'       => esc_html__('Post Comment', 'creator-base'),
    ));
    ?>

</div>
