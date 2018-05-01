<?php
  
  ob_start();
  
  $page = 'New Article';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  if ( !user_is_admin() ) {
    header( 'Location: /articles.php');
  }
  
  $submit = $_POST[ 'submit' ];
  
  $db = db_connect();
  
  // Form data
  $title = $db->real_escape_string( $_POST[ 'title' ] );
  $author = $db->real_escape_string( $_POST[ 'author' ] );
  $article_text = $db->real_escape_string( $_POST[ 'article_text' ] );
  $date_posted = $db->real_escape_string( $_POST[ 'date_posted' ] );
  
  // Check and display for errors
  $valid = true;
  
  if ( !empty ( $submit ) ) {
    
    if ( empty ( $title ) ) {
      $valid = false;
      $title_error = 'Title is required.';
    }
    
    if ( empty( $author ) ) {
      $valid = false;
      $author_error = 'Author is required.';
    }

    if ( ( !( $date_posted === '' ) ) && !validDate( $date_posted ) ) {
      // Date entered is not valid
      $valid = false;
      $date_posted_error = 'Date must be valid and in the format: 2017-11-06 19:48:25';
    }
    
    if ( empty ( $article_text ) ) {
      $valid = false;
      $article_text_error = 'Article text is required.';
    }
    
    if ( $valid ) {
      // Update the database
      // Insert null date if not set
      if ( empty( $date_posted ) ) {
        $sql = "INSERT INTO articles (title, author, article_text, date_posted, created_at, modified_at) VALUES ('$title', '$author', '$article_text', NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
      } else {
        $sql = "INSERT INTO articles (title, author, article_text, date_posted, created_at, modified_at) VALUES ('$title', '$author', '$article_text', '$date_posted', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
      }
      $db->query( $sql );
      header( "Location: /article.php?article_id=$db->insert_id" );
    }
    
  }

?>

<section class="new">

  <div class="section-header">
    <h2>Write a new article</h2>
  </div>

  <div class="form-wrapper">

    <?php include 'includes/article_form.php'; ?>
    
  </div>

</section>

<?php
  include 'includes/footer.php';