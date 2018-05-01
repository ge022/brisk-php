<?php
  
  include 'includes/functions.php';
  
  if ( !user_is_admin() ) {
    header( 'Location: /articles.php');
  }
  
  $article_id = $_GET[ 'article_id' ];
  
  if ( isset( $article_id ) ) {
    $db = db_connect();
    $sql = "DELETE FROM articles WHERE article_id=$article_id";
    $result = $db->query( $sql );
    
    if ( $result ) {
      header("Location: /articles.php?msg=Article $article_id successfully deleted.");
    } else {
      header("Location: /articles.php?msg=Error deleting Article with ID: $article_id.");
    }
  }