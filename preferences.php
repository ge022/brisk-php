<?php
  
  ob_start();
  
  $page = 'Preferences';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  session_start();
  
  if ( $user = $_SESSION[ 'email' ] ) {
    
    $db = db_connect();
    
    // Get POST data
    $submit = $_POST[ 'submit' ];
    
    if ( empty ( $submit ) ) {
      
      // Query user preferences
      $sql = "SELECT newsletter FROM users WHERE email='$user'";
      $result = $db->query( $sql );
      $newsletter = $result->fetch_row()[ 0 ];
      
    } else {
      
      // POST data
      $newsletter = isset( $_POST[ 'newsletter' ] ) ? 1 : 0;
      
      // Update database
      $sql = "UPDATE users SET newsletter='$newsletter' WHERE email='$user'";
      $result = $db->query( $sql );
      
      if ( $result ) {
        $msg = 'Updated preferences!';
      } else {
        $msg = 'Failed to update preferences.';
      }
      
    }
    
  } else {
    header( 'Location: /login.php' );
  }

?>

  <section class="preferences">

    <div class="section-header">
      <h2>Preferences</h2>
    </div>

    <div class="form-wrapper">

      <form action="<?php echo htmlentities( $_SERVER[ 'PHP_SELF' ] ); ?>" method="post">

        <p>
          <label for="newsletter">Sign up for newsletter?</label>
          <input type="checkbox" name="newsletter" value="<?php echo $newsletter; ?>"
              <?php echo $newsletter ? 'checked' : '' ?> id="newsletter">
        </p>
        <p>
          <input type="submit" name="submit" value="Submit">
          <?php if ( !empty( $msg ) ) {
            echo '<label class="notice-message fullwidth">', $msg, '</label>';
          } ?>
        </p>
      </form>

    </div>

  </section>

<?php
  
  include 'includes/footer.php';
