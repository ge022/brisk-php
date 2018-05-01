<?php
  
  include 'includes/functions.php';
  
  $db = db_connect();
  
  // Get post data
  $restaurantID = $db->real_escape_string( $_POST[ 'restaurant' ] );
  $author = $db->real_escape_string( $_POST[ 'author' ] );
  $review = $db->real_escape_string( $_POST[ 'review' ] );
  $rating = $db->real_escape_string( $_POST[ 'rating' ] );
  
  if ( $rating < 1 ) {
    $rating = 1;
  }
  if ( $rating > 5 ) {
    $rating = 5;
  }
  
  // Insert into db
  $sql = "INSERT INTO reviews (author, review, rating, created_at, restaurantIDFK) VALUES ('$author', '$review', $rating, NOW(), $restaurantID)";
  $result = $db->query( $sql );
  
  // Redirect
  header( "Location: /restaurant.php?id=$restaurantID" );