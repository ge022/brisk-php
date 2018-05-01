<?php
  
  ob_start();
  
  $page = 'New Post';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  if ( !user_is_admin() ) {
    header( 'Location: /blogs.php');
  }
  
  $submit = $_POST[ 'submit' ];
  
  $db = db_connect();
  
  // Form data
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
      $sql = "INSERT INTO blogs (title, author, blog_text, publish_date, created_at, modified_at ) VALUES ('$title', '$author', '$blog_text', '$publish_date', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
      $db->query( $sql );
      
      // Send the new post to users
      header( "Location: /email_blog.php?blog_id=$db->insert_id&new=1");
      
    }
    
  }

?>
  
  <section class="new">
    
    <div class="section-header">
      <h2>Write a new blog</h2>
    </div>
    
    <div class="form-wrapper">
      
      <?php include 'includes/blog_form.php'; ?>
    
    </div>
  
  </section>

<?php
  include 'includes/footer.php';
?>