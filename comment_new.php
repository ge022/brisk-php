<?php
  
  include 'includes/functions.php';
  
  $db = db_connect();
  
  // Get post data
  $blog_id = $db->real_escape_string( $_POST[ 'blog_id' ] );
  $author = $db->real_escape_string( $_POST[ 'author' ] );
  $comment = $db->real_escape_string( $_POST[ 'comment' ] );
  $rating = $db->real_escape_string( $_POST[ 'rating' ] );
  
  if ( isset( $blog_id ) && $blog_id !== '' ) {
    
    $valid = true;
    
    if ( is_numeric( $rating ) ) {
      if ( $rating < 1 ) {
        $rating = 1;
      }
    } else {
      $valid = false;
    }
  
    if ( is_numeric( $rating ) ) {
      if ( $rating > 5 ) {
        $rating = 5;
      }
    } else {
      $valid = false;
    }
    
    if ( $valid ) {
      // Insert into db
      $sql = "INSERT INTO comments (author, comment, rating, blog_id, created_at) VALUES ('$author', '$comment', $rating, $blog_id, NOW())";
      $result = $db->query( $sql );
    }
    
  }
  
  // Redirect
  header( "Location: /blog.php?blog_id=$blog_id" );
