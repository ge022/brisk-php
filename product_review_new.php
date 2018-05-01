<?php
  
  include 'includes/functions.php';
  
  $db = db_connect();
  
  // Get post data
  $product_id = $db->real_escape_string( $_POST[ 'product_id' ] );
  $author = $db->real_escape_string( $_POST[ 'author' ] );
  $comment = $db->real_escape_string( $_POST[ 'comment' ] );
  $rating = $db->real_escape_string( $_POST[ 'rating' ] );
  
  if ( isset( $product_id ) && $product_id !== '' ) {
    
    $valid = true;
    
    if ( is_numeric( $rating ) ) {
      if ( $rating < 1 ) {
        $rating = 1;
      }
      if ( $rating > 5 ) {
        $rating = 5;
      }
    } else {
      $valid = false;
    }
    
    if ( $valid ) {
      // Insert into db
      $sql = "INSERT INTO product_reviews (product_id, author, comment, rating, created_at) VALUES ($product_id, '$author', '$comment', $rating, NOW())";
      $result = $db->query( $sql );
    }
    
  }
  
  // Redirect
  header( "Location: /product.php?product_id=$product_id" );