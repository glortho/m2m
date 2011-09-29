<?php

/*
$Id: sidebar.php 156907 2009-09-22 07:37:51Z jamesgpearce $

$URL: http://plugins.svn.wordpress.org/wordpress-mobile-pack/tags/1.1.3/themes/mobile_pack_base/sidebar.php $

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

<div id="sidebar">
  <?php
    ob_start();
    ob_start();
    dynamic_sidebar();
    $list = ob_get_contents();
    ob_end_clean();
    $list = ob_get_contents() . $list; //ob stack funny stuff in old widgets
    ob_end_clean();
    if ($list) {
      print "<ul>$list</ul>";
    }
  ?>
</div>
