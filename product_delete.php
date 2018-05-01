<?php
  
  include 'includes/functions.php';
  
  if ( !user_is_admin() ) {
    header( 'Location: /products.php');
  }
  
  $product_id = $_GET[ 'product_id' ];
  
  if ( isset( $product_id ) ) {
    $db = db_connect();
    $sql = "DELETE FROM products WHERE id=$product_id";
    $result = $db->query( $sql );
    
    if ( $result ) {
      header("Location: /products.php?msg=Product $product_id successfully deleted.");
    } else {
      header("Location: /products.php?msg=Error deleting product with ID: $product_id.");
    }
  }