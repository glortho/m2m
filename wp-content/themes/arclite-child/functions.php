<?php
/* Arclite/digitalnature */ 

$ratings = array();

function checkrating() {
	global $ratings ;
	$ratings_count = count( $ratings );
	if ( $ratings_count > 0 ) {
		$c = 0 ;
		foreach ( $ratings as $i ) {
			$c += $i ;
		}
		$c = ( $c/$ratings_count ) ;
		if ( strlen($c) > 1 ) {
			if ( substr( $c , -2 ) != ".5" ) {
				$c = round($c) ;
			}
		}
		echo "&nbsp;" . ratingimgs( $c , "big" ) ;
		$ratings = array() ;
	}
}

function ratingreplace() {
	$content = get_the_content(__('Read the rest of this entry &raquo;', 'arclite')) ;
	if ( strpos( $content , "[rating=") !== false ) {
		$content = preg_replace_callback( "|(\[rating=(.*?)\])|" , "ratehtml" , $content ) ;
	}
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content ;
}

function ratehtml( $matches ) {
	global $ratings ;
	$rating = $matches[2] ;	
	$ratings[] = $rating ;
	return ratingimgs( $rating , "small" ) ;
}

function ratingimgs( $rating , $zsize )	{
	$out = "" ;
	$gold = floor( $rating ) ;
	$gray = floor( 5 - $rating ) ;
	$half = ( $gold + $gray != 5 ) ? true : false ;
	if ( $zsize == "big" ) {
		$zclass = "rating_title" ;
		$zsize = "16" ;
	} else {
		$zclass = "rating" ;
		$zsize = "14" ;
	}
	
	$i = 0 ;
	while ( $i < $gold ) {
		$out .= "<img class=\"$zclass\" src=\"http://mastomillers.com/wp-content/uploads/2009/07/star_gold.png\" border=\"0\" width=\"$zsize\" height=\"$zsize\">";
		$i++;
	}
	if ( $half ) {
		$out .= "<img class=\"$zclass\" src=\"http://mastomillers.com/wp-content/uploads/2009/07/star_gold_half_grey.png\" border=\"0\" width=\"$zsize\" height=\"$zsize\">";
	}
	$i = 0 ;
	while ( $i < $gray ) {
		$out .= "<img class=\"$zclass\" src=\"http://mastomillers.com/wp-content/uploads/2009/07/star_grey.png\" border=\"0\" width=\"$zsize\" height=\"$zsize\">";
		$i++;
	}
	return $out ;
}

function dropdown_tag_cloud( $args = '' ) {
	$defaults = array(
		'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 'number' => 100,
		'format' => 'flat', 'orderby' => 'name', 'order' => 'ASC',
		'exclude' => '', 'include' => ''
	);
	$args = wp_parse_args( $args, $defaults );

	$tags = get_tags( array_merge($args, array('orderby' => 'count', 'order' => 'DESC')) ); // Always query top tags

	if ( empty($tags) )
		return;

	$return = dropdown_generate_tag_cloud( $tags, $args ); // Here's where those top tags get sorted according to $args
	if ( is_wp_error( $return ) )
		return false;
	else
		echo apply_filters( 'dropdown_tag_cloud', $return, $args );
}

function dropdown_generate_tag_cloud( $tags, $args = '' ) {
	global $wp_rewrite;
	$defaults = array(
		'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 'number' => 100,
		'format' => 'flat', 'orderby' => 'name', 'order' => 'ASC'
	);
	$args = wp_parse_args( $args, $defaults );
	extract($args);

	if ( !$tags )
		return;
	$counts = $tag_links = array();
	foreach ( (array) $tags as $tag ) {
		$counts[$tag->name] = $tag->count;
		$tag_links[$tag->name] = get_tag_link( $tag->term_id );
		if ( is_wp_error( $tag_links[$tag->name] ) )
			return $tag_links[$tag->name];
		$tag_ids[$tag->name] = $tag->term_id;
	}

	$min_count = min($counts);
	$spread = max($counts) - $min_count;
	if ( $spread <= 0 )
		$spread = 1;
	$font_spread = $largest - $smallest;
	if ( $font_spread <= 0 )
		$font_spread = 1;
	$font_step = $font_spread / $spread;

	// SQL cannot save you; this is a second (potentially different) sort on a subset of data.
	if ( 'name' == $orderby )
		uksort($counts, 'strnatcasecmp');
	else
		asort($counts);

	if ( 'DESC' == $order )
		$counts = array_reverse( $counts, true );

	$a = array();

	$rel = ( is_object($wp_rewrite) && $wp_rewrite->using_permalinks() ) ? ' rel="tag"' : '';

	foreach ( $counts as $tag => $count ) {
		$tag_id = $tag_ids[$tag];
		$tag_link = clean_url($tag_links[$tag]);
		If (!empty( $search )) {
			$tag_arr = explode( $search . ": " , $tag ) ;
			$tag = $tag_arr[1] ;
			$tag = str_replace(' ', '&nbsp;', wp_specialchars( $tag ));
			$a[] = "\t<option value='$tag_link'>$tag</option>";
			//$a[] = "\t<option value='$tag_link'>$tag ($count)</option>";
		} else {
			if ( strpos( $tag , ": ") === false ) {
				$tag = str_replace(' ', '&nbsp;', wp_specialchars( $tag ));
				$a[] = "\t<option value='$tag_link'>$tag</option>";
				//$a[] = "\t<option value='$tag_link'>$tag ($count)</option>";
			}
		}
	}

	switch ( $format ) :
	case 'array' :
		$return =& $a;
		break;
	case 'list' :
		$return = "<ul class='wp-tag-cloud'>\n\t<li>";
		$return .= join("</li>\n\t<li>", $a);
		$return .= "</li>\n</ul>\n";
		break;
	default :
		$return = join("\n", $a);
		break;
	endswitch;

	return apply_filters( 'dropdown_generate_tag_cloud', $return, $tags, $args );
}

?>