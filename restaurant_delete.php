<?php
  
  include 'includes/functions.php';
  
  if ( !user_is_admin() ) {
    header( 'Location: /restaurants.php');
  }
  
  $id = $_GET[ 'id' ];
  
  if ( isset( $id ) ) {
    $db = db_connect();
    $sql = "DELETE FROM restaurants WHERE id=$id";
    $result = $db->query( $sql );
  
    if ( $result ) {
      header("Location: /restaurants.php?msg=Restaurant $id successfully deleted.");
    } else {
      header("Location: /restaurants.php?msg=Error deleting restaurant ID: $id.");
    }
  }