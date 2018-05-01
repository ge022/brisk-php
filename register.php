<?php
  
  ob_start();
  
  session_start();
  
  $page = 'Register';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  $db = db_connect();
  
  // Get POST data
  $submit = $_POST[ 'submit' ];
  $login_name = $db->escape_string( $_POST[ 'name' ] );
  $login_email = $db->escape_string( $_POST[ 'email' ] );
  $login_password = $db->escape_string( $_POST[ 'password' ] );
  $login_password_confirm = $db->escape_string( $_POST[ 'password_confirm' ] );
  $newsletter = isset( $_POST[ 'newsletter' ] ) ? 1 : 0;
  
  if ( !empty ( $submit ) ) {
    
    $valid = true;
    
    if ( empty ( $login_name ) ) {
      $valid = false;
      $name_error = 'Name is required.';
    }
    if ( empty ( $login_email ) ) {
      $valid = false;
      $email_error = 'Email is required.';
    } elseif ( filter_var( $login_email, FILTER_VALIDATE_EMAIL ) === false ) {
      $valid = false;
      $email_error = 'Invalid email!';
    }
    if ( empty ( $login_password ) ) {
      $valid = false;
      $password_error = 'Password is required.';
    }
    if ( empty ( $login_password_confirm ) ) {
      $valid = false;
      $password_confirm_error = 'Confirmation is required.';
    }
    
    if ( $valid ) {
      
      // Compare passwords
      if ( $login_password == $login_password_confirm ) {
        // Register user
        
        // Encrypt password
        $encrypted_password = password_hash( $login_password, PASSWORD_DEFAULT );
        
        $sql = "INSERT INTO users (email, name, password, newsletter, admin, modified_at, created_at) VALUES ('$login_email', '$login_name', '$encrypted_password', '$newsletter', '0', NULL, NOW())";
        $result = $db->query( $sql );
        
        if ( $result ) {
          set_user( $login_email, $login_name );
          // Redirect to top level
          header( 'Location: /' );
        } else {
          $email_error = 'Email already registered.';
        }
        
      } else {
        $password_confirm_error = 'Passwords do not match.';
      }
      
    }
    
  }

?>

  <section class="login">

    <div class="section-header">
      <h2>Register</h2>
    </div>

    <div class="form-wrapper">

      <form action="/register.php" method="post">
        <p>
          <label for="name">Your name:</label>
          <input type="text" name="name" id="name"
                 placeholder="Name" value="<?php echo htmlspecialchars( stripslashes( $login_name ) ); ?>"
                 class="fullwidth">
          <?php if ( !empty( $name_error ) ) {
            echo '<label class="invalid-input">', $name_error, '</label>';
          } ?>
        </p>
        <p>
          <label for="email">Email address:</label>
          <input type="email" name="email" id="email"
                 placeholder="Email Address" value="<?php echo htmlspecialchars( stripslashes( $login_email ) ); ?>"
                 class="fullwidth">
          <?php if ( !empty( $email_error ) ) {
            echo '<label class="invalid-input">', $email_error, '</label>';
          } ?>
        </p>
        <p>
          <label for="password">Password:</label>
          <input type="password" name="password" id="password"
                 placeholder="Password" class="fullwidth">
          <?php if ( !empty( $password_error ) ) {
            echo '<label class="invalid-input">', $password_error, '</label>';
          } ?>
        </p>
        <p>
          <label for="password-confirm">Confirm password:</label>
          <input type="password" name="password_confirm" id="password-confirm"
                 placeholder="Password" class="fullwidth">
          <?php if ( !empty( $password_confirm_error ) ) {
            echo '<label class="invalid-input">', $password_confirm_error, '</label>';
          } ?>
        </p>
        <p>
          <label for="newsletter">Sign up for newsletter?</label>
          <input type="checkbox" name="newsletter" value="<?php echo $newsletter; ?>"
              <?php echo $newsletter ? 'checked' : '' ?>
                 id="newsletter">
        </p>
        <p>
          <input type="submit" name="submit" value="Register">
          <?php if ( !empty( $login_error ) ) {
            echo '<label class="invalid-input fullwidth">', $login_error, '</label>';
          } ?>
        </p>
      </form>

    </div>

  </section>

<?php
  
  include 'includes/footer.php'

?>