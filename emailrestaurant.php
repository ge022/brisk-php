<?php
  
  session_start();
  include 'includes/functions.php';
  
  $db = db_connect();
  
  $id = $db->escape_string( $_GET[ 'id' ] );
  
  if ( isset( $id ) ) {
  
    // Query for the restaurant
    $sql = "SELECT * FROM restaurants WHERE id=$id";
    $result = $db->query( $sql );
    list ( $restaurantID, $name, $location, $price_range_low, $price_range_high, $tags, $modified_at, $created_at ) = $result->fetch_row();
  
    // Query for users who receive newsletters
    $sql = "SELECT * FROM users WHERE newsletter=1";
    $result = $db->query( $sql );
    while ( list ( $id, $user_email, $user_name, $password, $newsletter ) = $result->fetch_row() ) {
      
      // Generate message for email
      
      $message = <<<END_OF_MESSAGE
    
Hello $user_name,

Here is the latest restaurant:
Name: $name
Location: $location
Price Range: $price_range_low - $price_range_high
    
    
END_OF_MESSAGE;
      
      $to = $user_email;
      
      $subject = 'Message from Brisk';
      
      $headers = "From: contact@example.com\r\n";
      $headers .= "BCC: example@example.com\r\n";
      
      $sent = mail( $to, $subject, $message, $headers );
      
      echo "Sent<br>";
      
      
    }
    
  }