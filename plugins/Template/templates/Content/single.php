<?php
switch ( $post_type ) {
    case 'page':
      include_once('single-2.php');
      break;
    
    case 'knowledge':
    case 'topics':
      include_once('single-1.php');
      break;

    default:
        include_once('single-2.php');
        break;
}