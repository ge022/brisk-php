<?php
  
  session_start();
  ob_start();
  
  $page = 'Edit User';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  if ( !user_is_admin() ) {
    header( 'Location: /');
  }
  
  $user_id = $_GET[ 'id' ];
  $submit = $_POST[ 'submit' ];
  
  $db = db_connect();
  
  if ( !empty ( $user_id ) && is_numeric( $user_id ) ) {
    
    if ( empty ( $submit ) ) {
      
      // Get data from the database
      $sql = "SELECT * FROM users WHERE id=$user_id";
      $result = $db->query( $sql );
      
      list ( $id, $email, $name, $password, $newsletter, $admin ) = $result->fetch_row();
      
    } else {
      
      // Get data from POST
      $email = $db->real_escape_string( $_POST[ 'email' ] );
      $name = $db->real_escape_string( $_POST[ 'name' ] );
      $newsletter = isset( $_POST[ 'newsletter' ] ) ? 1 : 0;
      $admin = isset( $_POST[ 'admin' ] ) ? 1 : 0;
      
      // Check and display for errors
      $valid = true;
      
      if ( empty ( $email ) ) {
        $valid = false;
        $email_error = 'Email is required.';
      } elseif ( filter_var( $email, FILTER_VALIDATE_EMAIL ) === false ) {
        $valid = false;
        $email_error = 'Invalid email!';
      }
      
      if ( empty( $name ) ) {
        $valid = false;
        $name_error = 'Name is required.';
      }
      
      
      if ( $valid ) {
        // Update the database
        $sql = "UPDATE users SET email='$email', name='$name', newsletter='$newsletter', admin='$admin', modified_at=NOW() WHERE id='$user_id'";
        $result = $db->query( $sql );
        
        if ( $result ) {
          
          // Update session if user updates own user
          if ( $_SESSION[ 'email' ] != $email || $_SESSION[ 'name' ] == $name || $_SESSION[ 'admin' ] == $admin ) {
            set_user( $email, $name, $admin );
          }
          
          header( "Location: /users.php?msg=User updated!" );
  
        } else {
          $msg = 'Email already registered!';
        }
        
      }
      
    }
    
  }

?>
  
  <section class="user">
    
    <div class="section-header">
      <h2>Editing user: <?php echo htmlspecialchars( stripslashes( $email ) ); ?></h2>
    </div>
    
    <div class="form-wrapper">

      <form method="post" action="<?php echo htmlentities( $_SERVER[ 'PHP_SELF' ] );
        if ( isset( $user_id ) ) {
          echo '?id=', $user_id;
        }
      ?>">
        <p>
          <label for="email">Email</label>
          <input type="email" name="email" id="email" class="fullwidth"
                 value="<?php echo htmlspecialchars( stripslashes ( $email ) ); ?>"
                 placeholder="required">
          <?php if ( !empty( $email_error ) ) {
            echo '<label for="email" class="invalid-input">', $email_error, '</label>';
          } ?>
        </p>
        <p>
          <label for="name">Name</label>
          <input type="text" name="name" id="name" class="fullwidth"
                 value="<?php echo htmlspecialchars( stripslashes ( $name ) ); ?>"
                 placeholder="required">
          <?php if ( !empty( $name_error ) ) {
            echo '<label for="name" class="invalid-input">', $name_error, '</label>';
          } ?>
        </p>
        <p>
          <input type="checkbox" name="newsletter" value="<?php echo $newsletter; ?>"
          <?php echo $newsletter ? 'checked' : '' ?> id="newsletter">
          <label for="newsletter">Newsletter</label>
        </p>
        <p>
          <input type="checkbox" name="admin" value="<?php echo $admin; ?>"
          <?php echo $admin ? 'checked' : '' ?> id="admin">
          <label for="admin">Admin</label>
        </p>
        <p>
          <input type="submit" name="submit" value="Update">
          <a href="/users.php" class="button">Back</a>
          <?php if ( !empty( $msg ) ) {
            echo '<label class="notice-message fullwidth">', $msg, '</label>';
          } ?>
        </p>
      </form>
    
    </div>
  
  </section>

<?php
  include 'includes/footer.php';