<?php
  
  include 'includes/functions.php';
  
  if ( !user_is_admin() ) {
    header( 'Location: /blogs.php');
  }
  
  $blog_id = $_GET[ 'blog_id' ];
  
  if ( isset( $blog_id ) ) {
    $db = db_connect();
    $sql = "DELETE FROM blogs WHERE id=$blog_id";
    $result = $db->query( $sql );
    
    if ( $result ) {
      header("Location: /blogs.php?msg=Post $blog_id successfully deleted.");
    } else {
      header("Location: /blogs.php?msg=Error deleting Blog with ID: $blog_id.");
    }
  }