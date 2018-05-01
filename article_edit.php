<?php
  
  ob_start();
  
  $page = 'Edit Article';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  if ( !user_is_admin() ) {
    header( 'Location: /articles.php');
  }
  
  $article_id = $_GET[ 'article_id' ];
  $submit = $_POST[ 'submit' ];
  $db = db_connect();
  
  
  // Process form if editing an article
  if ( !empty ( $article_id ) && is_numeric( $article_id ) ) {
    
    if ( empty ( $submit ) ) {
  
      // Get data from the database
      $sql = "SELECT * FROM articles WHERE article_id=$article_id";
      $result = $db->query( $sql );
      list ( $article_id, $title, $author, $article_text, $date_posted, $created_at, $modified_at ) = $result->fetch_row();
      
    } else {
      
      // Get data from POST
      $title = $db->real_escape_string( $_POST[ 'title' ] );
      $author = $db->real_escape_string( $_POST[ 'author' ] );
      $article_text = $db->real_escape_string( $_POST[ 'article_text' ] );
      $date_posted = $db->real_escape_string( $_POST[ 'date_posted' ] );
      
      // Check and display for errors
      $valid = true;
      
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
          $sql = "UPDATE articles SET title='$title', author='$author', article_text='$article_text', date_posted=NULL, modified_at=NOW() WHERE article_id=$article_id";
        } else {
          $sql = "UPDATE articles SET title='$title', author='$author', article_text='$article_text', date_posted='$date_posted', modified_at=NOW() WHERE article_id=$article_id";
        }
        $db->query( $sql );
        header( "Location: /article.php?article_id=$article_id" );
      }
      
    }
    
  }


?>

<section class="edit">

  <div class="section-header">
    <h2>Editing: <?php echo htmlspecialchars( stripslashes( $title ) ); ?></h2>
  </div>

  <div class="form-wrapper">
    
    <?php include 'includes/article_form.php'; ?>

  </div>

</section>

<?php
  include 'includes/footer.php';
?>


