<?php

/*
$Id: comments.php 156907 2009-09-22 07:37:51Z jamesgpearce $

$URL: http://plugins.svn.wordpress.org/wordpress-mobile-pack/tags/1.1.3/themes/mobile_pack_base/comments.php $

Copyright (c) 2009 mTLD Top Level Domain Limited

Online support: http://mobiforge.com/forum/dotmobi/wordpress

This file is part of the WordPress Mobile Pack.

The WordPress Mobile Pack is Licensed under the Apache License, Version 2.0
(the "License"); you may not use this file except in compliance with the
License.

You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software distributed
under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR
CONDITIONS OF ANY KIND, either express or implied. See the License for the
specific language governing permissions and limitations under the License.
*/

?>

<?php if (basename($_SERVER['SCRIPT_FILENAME'])=='comments.php') { die(); } ?>

<?php if (!empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) { ?>
  <p class="nocomments">This post is password protected. Enter the password to view comments.</p>
  <?php return; ?>
<?php } ?>

<?php if ($comments) { ?>
  <h3 id="comments"><?php comments_number('No comments', '1 comment', '% comments' );?> on this post.</h3>
  <ol class="commentlist">
    <?php foreach ($comments as $comment) { ?>
      <li>
        <a name="#comment-<?php comment_ID() ?>"></a>
        <p><?php comment_author_link() ?>:</p>
        <?php if ($comment->comment_approved == '0') { ?>
          <em>Your comment is awaiting moderation.</em>
        <?php } ?>
        <p class="metadata"><?php comment_date('F jS, Y') ?> at <?php comment_time() ?> <?php edit_comment_link('Edit','',''); ?></p>
        <?php comment_text() ?>
      </li>
    <?php } ?>
  </ol>
<?php } ?>
<?php if ($post->comment_status == 'open') { ?>
  <h3 id="respond">Leave a comment</h3>
  <?php if ( get_option('comment_registration') && !$user_ID ) { ?>
    <p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
  <?php } else { ?>
    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
      <?php if ( $user_ID ) { ?>
        <p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout</a></p>
      <?php } else { ?>
        <p>
          <label for="author">Name <?php if ($req) echo "(required)"; ?></label>
          <br />
          <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" />
        </p>
        <p>
          <label for="email">Mail (<?php if ($req) echo "required, but "; ?>not published)</label>
          <br />
          <input type="text" name="email" id="email" value="<?php print empty($comment_author_email)?"":$comment_author_email; ?>" />
        </p>
        <p>
          <label for="url">Website</label>
          <br />
          <input type="text" name="url" id="url" value="<?php print empty($comment_author_url)?"http://":$comment_author_url; ?>"/>
        </p>
      <?php } ?>
      <p>
        <label for="comment">Comment</label>
        <br />
        <textarea name="comment" id="comment" rows="3"></textarea>
      </p>
      <p>
        <input name="submit" type="submit" id="submit" value="Submit comment" />
        <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
      </p>
      <?php do_action('comment_form', $post->ID); ?>
    </form>
  <?php } ?>
<?php } ?>
