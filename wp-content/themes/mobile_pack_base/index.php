<?php

/*
$Id: index.php 156907 2009-09-22 07:37:51Z jamesgpearce $

$URL: http://plugins.svn.wordpress.org/wordpress-mobile-pack/tags/1.1.3/themes/mobile_pack_base/index.php $

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

get_header();

?>
<?php if (isset($_GET['archives']) && ($archives = $_GET['archives'])!='') { ?>
  <h2 class="pagetitle">Blog archives</h2>
  <div id="wrapper">
    <div id="content">
      <?php
        if ($archives=='category') {
          print "<h2>Archives by category</h2>";
          $links = array();
          foreach(get_categories() as $category) {
            $links[] = "<a href='" . get_category_link( $category->term_id ) . "'>$category->name</a>";
          }
          $links = implode(', ', $links);
        } elseif ($archives=='tag') {
          print "<h2>Archives by tag</h2>";
          $links = array();
          foreach(get_tags() as $tag) {
            $links[] = "<a href='" . get_tag_link( $tag->term_id ) . "'>$tag->name</a> ($tag->count)";
          }
          $links = implode(', ', $links);
        } elseif ($archives=='week' || $archives=='month' || $archives=='year') {
          print "<h2>Archives by $archives</h2>";
          $links = " ";
          wp_get_archives(array('type'=>$archives.'ly', 'show_post_count'=>true));
        }
        if($links) {
          print "<p>$links</p>";
        } else {
          print "<p>No archives found. Use the menu to navigate the site, or search for a keyword:</p>";
          include (TEMPLATEPATH . "/searchform.php");
        }
      ?>
    </div>
    <?php get_sidebar(); ?>
  </div>
<?php } elseif (have_posts()) { ?>
  <?php $post = $posts[0]; ?>
  <?php if (is_search()) { ?>
    <h2 class="pagetitle">Search results</h2>
  <?php } elseif (is_tag()) { ?>
    <h2 class="pagetitle">Archive for the '<?php echo single_tag_title(); ?>' tag</h2>
  <?php } elseif (is_category()) { ?>
    <h2 class="pagetitle">Archive for the '<?php echo single_cat_title(); ?>' category</h2>
  <?php } elseif (is_day()) { ?>
    <h2 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h2>
  <?php } elseif (is_month()) { ?>
    <h2 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h2>
  <?php } elseif (is_year()) { ?>
    <h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>
  <?php } elseif (is_search()) { ?>
    <h2 class="pagetitle">Search results</h2>
  <?php } elseif (is_author()) { ?>
    <h2 class="pagetitle">Author archive</h2>
  <?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    <h2 class="pagetitle">Blog archives</h2>
  <?php } ?>
  <div id="wrapper">
    <div id="content">
      <?php $summary = get_option('wpmp_theme_post_summary'); ?>
      <?php global $more; ?>
      <?php $more=(is_single() || is_page())?1:0; ?>
      <?php $first = true; ?>
      <?php while (have_posts()) { ?>
        <?php the_post(); ?>
        <div class="post" id="post-<?php the_ID(); ?>">
          <div class="titleback">
            <p class="metadata"><?php the_time('F jS, Y') ?> by <?php the_author() ?></p>
            <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
          </div>
          <?php if(is_single() || is_page() || ($summary!='none' && !($summary=='firstteaser' && !$first))) { ?>
            <div class="entry">
              <?php the_content('Read more'); ?>
            </div>
          <?php } ?>
          <p class="metadata">Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit','',' |'); ?> <?php comments_popup_link('No comments', '1 comment', '% comments'); ?>
            <?php if(is_single() || is_page()) { ?>
              <br />
              <?php if ($post->comment_status=='open') { ?>
                You can <a href="#respond">leave a comment</a> for this post.
              <?php } else { ?>
                Comments are closed for this post.
              <?php } ?>
            <?php } ?>
          </p>
        </div>
        <?php if((is_single() || is_page()) && (!function_exists('wpmp_transcoder_is_last_page') || wpmp_transcoder_is_last_page())) { comments_template(); } ?>
        <?php $first = false; ?>
     <?php } ?>
      <div class="navigation">
        <?php next_posts_link('Older') ?> <?php previous_posts_link('Newer') ?>
      </div>
    </div>
    <?php get_sidebar(); ?>
  </div>
<?php } else { ?>
  <div id="wrapper">
    <div id="content">
      <h2>Page not found</h2>
      <p>Use the menu to navigate the site, or search for a keyword:</p>
      <?php include (TEMPLATEPATH . "/searchform.php"); ?>
    </div>
    <?php get_sidebar(); ?>
  </div>
<?php } ?>
<?php get_footer(); ?>
