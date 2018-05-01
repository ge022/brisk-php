<?php
  session_start();
  include 'includes/functions.php';
  
  if ( !user_is_admin() ) {
    header( 'Location: /');
  }
  
  $id = $_GET[ 'id' ];
  
  if ( isset( $id ) && is_numeric( $id ) ) {
    $db = db_connect();
    
    $sql = "SELECT email FROM users WHERE id='$id'";
    $user = $db->query( $sql )->fetch_row()[0];
    
    $sql = "DELETE FROM users WHERE id=$id";
    $result = $db->query( $sql );
    
    if ( $result ) {
      
      // Update session if user updates own user
      if ( $_SESSION['email'] == $user ) {
        session_destroy();
      }
      
      header("Location: /users.php?msg=User $id successfully deleted.");
      
    } else {
      
      header("Location: /users.php?msg=Error deleting User $id.");
      
    }
  }