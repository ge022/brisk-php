<?php
  
  ob_start();
  
  session_start();
  
  $page = 'Login';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  $db = db_connect();
  
  // Get POST data
  $submit = $_POST[ 'submit' ];
  $login_email = $db->escape_string( $_POST[ 'email' ] );
  $login_password = $db->escape_string( $_POST[ 'password' ] );
  
  if ( !empty ( $submit ) ) {
    
    $valid = true;
  
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
    
    if ( $valid ) {
      
      // Lookup user
      $sql = "SELECT * FROM users WHERE email='$login_email'";
      $result = $db->query( $sql );
      list( $id, $email, $name, $password, $newsletter, $admin ) = $result->fetch_row();
      
      if ( password_verify( $login_password, $password ) ) {
  
        set_user( $email, $name, $admin );
        // Redirect to top level
        header( 'Location: /' );
        
      } else {
        $login_error = 'Invalid email or password.';
      }
      
    }
    
  }

?>

<section class="login">

  <div class="section-header">
    <h2>Login</h2>
  </div>

  <div class="form-wrapper">

    <form action="/login.php" method="post">
      <p>
        <label for="email">Email address:</label>
        <input type="email" name="email" id="email"
               placeholder="Email address" value="<?php echo htmlspecialchars( stripslashes( $login_email ) ); ?>" class="fullwidth">
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
        <input type="submit" name="submit" value="Login">
        <?php if ( !empty( $login_error ) ) {
          echo '<label class="invalid-input fullwidth">', $login_error, '</label>';
        } ?>
      </p>
    </form>

  </div>

</section>

<?php
  
  include 'includes/footer.php';
