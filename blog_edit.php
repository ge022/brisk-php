<?php
  
  ob_start();
  
  $page = 'Edit Post';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  if ( !user_is_admin() ) {
    header( 'Location: /blogs.php');
  }
  
  $blog_id = $_GET[ 'blog_id' ];
  
  $submit = $_POST[ 'submit' ];
  
  $db = db_connect();
  
  if ( !empty ( $blog_id ) && is_numeric( $blog_id ) ) {
    
    if ( empty ( $submit ) ) {
      
      // Get data from the database
      $sql = "SELECT * FROM blogs WHERE id=$blog_id";
      $result = $db->query( $sql );
      
      list ( $blog_id, $title, $author, $blog_text, $publish_date, $created_at, $modified_at ) = $result->fetch_row();
      
    } else {
  
      // Get data from POST
      $title = $db->real_escape_string( $_POST[ 'title' ] );
      $author = $db->real_escape_string( $_POST[ 'author' ] );
      $blog_text = $db->real_escape_string( $_POST[ 'blog_text' ] );
      $publish_date = $db->real_escape_string( $_POST[ 'publish_date' ] );
      
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
  
        if ( empty( $publish_date ) ) {
          $valid = false;
          $publish_date_error = 'Publish date is required.';
        } elseif ( !validDateTime( $publish_date ) ) {
          $valid = false;
          $publish_date_error = 'Publish date must be in the format: 2017-12-30T23:59';
        }
        
        if ( empty ( $blog_text ) ) {
          $valid = false;
          $blog_text_error = 'Blog text is required.';
        }
        
        if ( $valid ) {
          // Update the database
          $sql = "UPDATE blogs SET title='$title', author='$author', blog_text='$blog_text', publish_date='$publish_date', modified_at=NOW() WHERE id='$blog_id'";
          $db->query( $sql );
          echo $db->sqlstate;
          header( "Location: /blog.php?blog_id=$blog_id" );
        }
        
      }
      
    }
    
  }

?>

  <section class="edit">

    <div class="section-header">
      <h2>Editing: <?php echo htmlspecialchars( stripslashes( $title ) ); ?></h2>
    </div>

    <div class="form-wrapper">
      
      <?php include 'includes/blog_form.php'; ?>

    </div>

  </section>

<?php
  include 'includes/footer.php';