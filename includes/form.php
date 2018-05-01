<?php
  
  $db = db_connect();
  
  $sql = "SELECT name FROM restaurants";
  $result = $db->query( $sql );
  $restaurants = [''];
  while ( list ( $name ) = $result->fetch_row() ) {
    array_push( $restaurants, $name );
  }
  
  $submit = $_POST[ 'submit' ];
  $name = htmlspecialchars( $_POST[ 'name' ] );
  $email = htmlspecialchars( $_POST[ 'email' ] );
  $phone = htmlspecialchars( $_POST[ 'phone' ] );
  
  $question = htmlspecialchars( $_POST[ 'question' ] );
  // Question about restaurant
  $restaurant = htmlspecialchars( $_POST[ 'restaurants' ] );
  
  // Contact method
  $contact = htmlspecialchars( $_POST[ 'contact' ] );
  
  $newsletter = htmlspecialchars( $_POST[ 'newsletter' ] );
  $notifications = htmlspecialchars( $_POST[ 'notifications' ] );
  
  // Validation
  $valid = true;
  
  if ( !empty ( $submit ) ) {
    
    // Sticky radio buttons
    if ( $newsletter == 'subscribe' ) {
      $subscribe = 'checked="checked"';
    }
    if ( $notifications == 'subscribe' ) {
      $notify = 'checked="checked"';
    }
    
    // Validate input
    if ( empty ( $name ) ) {
      $valid = false;
      $name_error = 'Name is required.';
    }
    
    if ( empty ( $email ) ) {
      $valid = false;
      $email_error = 'Email is required.';
    } elseif ( filter_var( $email, FILTER_VALIDATE_EMAIL ) === false ) {
      $valid = false;
      $email_error = 'Invalid email!';
    }
    
    if ( empty ( $question ) ) {
      $valid = false;
      $question_error = 'We need to know your question.';
    }
    
    if ( $contact == 'email' ) {
      $to_email = 'checked';
    } elseif ( $contact == 'phone' ) {
      $to_call = 'checked';
      if ( empty( $phone ) ) {
        $valid = false;
        $phone_error = 'Phone is required.';
      }
    }
  
    if ( $valid ) {
      
      // Contact site owner
      $to = 'contact@example.com';
      $subject = "Contact request from Brisk";
      $body = "<h2>Contact request</h2>
        <h4>Name: </h4><p>$name</p>
        <h4>Email: </h4><p>$email</p>
        <h4>Phone: </h4><p>$phone</p>
        <h4>Asking about: </h4><p>$restaurant</p>
        <h4>Question: </h4><p>$question</p>
        <h4>Preferred contact method:</h4><p>$contact</p>
        <h4>Newsletter: </h4><p>$newsletter</p>
        <h4>Notifications: </h4><p>$notifications</p>
      ";
      $headers = "MIME-VERSION: 1.0\r\n";
      $headers .= "Content-Type: text/html;charset=UTF-8\r\n";
      $headers .= "From: <$name>\r\n";
      $headers .= "BCC: example@example.com\r\n";
  
      if ( $sent = mail($to, $subject, $body, $headers) ) {
        
        // Send a response to user
        $to = "$email";
        $subject = "$name, thanks for contacting Brisk!";
  
        $body = "Thanks for contacting Brisk. We will get back to you as soon as possible!";
        if ( !empty ( $restaurant ) ) {
          $body = "Thanks for contacting Brisk. We will get back to you with your question about $restaurant as soon as possible!";
        }
        $headers = "From: example@example.com\r\n";
  
        if ( $sent = mail($to, $subject, $body, $headers) ) {
          // Message sent
          unset( $name, $email, $phone, $question, $restaurant, $contact, $to_email, $to_call, $subscribe, $notify );
          $success_message = 'Message sent!';
    
        } else {
          $success_message = 'Message could not send';
        }
        
      } else {
        $success_message = 'Message could not send';
      }
      
    }
  
  }

?>

<?php if ( isset( $success_message ) ) {
  echo '<br><label class="success">', $success_message, '</label>';
} ?>
<form action="contactus.php" method="post">
  <p>
    <label for="name" class="screen-reader-text">Your name</label>
    <input type="text" name="name" placeholder="Name (required)" value="<?php echo $name; ?>" class="fullwidth"
           id="name">
    <?php if ( !empty( $name_error ) ) {
      echo '<label class="invalid-input">', $name_error, '</label>';
    } ?>
  </p>
  <p>
    <label for="email" class="screen-reader-text">Your email</label>
    <input type="text" name="email" placeholder="Email address (required)" value="<?php echo $email; ?>"
           class="fullwidth"
           id="email">
    <?php if ( !empty( $email_error ) ) {
      echo '<label for="email" class="invalid-input">', $email_error, '</label>';
    } ?>
  </p>
  <p>
    <label for="phone" class="screen-reader-text">Your phone number</label>
    <input type="tel" name="phone" placeholder="Phone number" value="<?php echo $phone; ?>" class="fullwidth"
           id="phone">
    <?php if ( !empty( $phone_error ) ) {
      echo '<label for="phone" class="invalid-input">', $phone_error, '</label>';
    } ?>
  </p>
  <p>
    <label for="question" class="screen-reader-text">Your question</label>
    <textarea name="question" placeholder="Your question (required)" rows="5" class="fullwidth"
              id="question"><?php echo $question; ?></textarea>
    <?php if ( !empty( $question_error ) ) {
      echo '<label for="question" class="invalid-input">', $question_error, '</label>';
    } ?>
  </p>
  <p class="contact-method">
    <label>Preferred contact method:</label><br>
    <label for="to-email">Email</label>
    <input type="radio" name="contact" value="email" <?php echo $to_email; ?> id="to-email">

    <label for="to-call">Phone</label>
    <input type="radio" name="contact" value="phone" <?php echo $to_call; ?> id="to-call">
  </p><p class="ask-about">
    <label for="restaurants">Ask about:</label><br>
    <?php
      create_select_box( 'restaurants', $restaurants, $restaurant );
    ?>
  </p>
  <p class="subscribe">
    <label for="newsletter">
      <input type="checkbox" name="newsletter" value="subscribe" <?php echo $subscribe; ?> id="newsletter">
      Subscribe to Newsletter
    </label><br>
    <label for="notifications">
      <input type="checkbox" name="notifications" value="subscribe" <?php echo $notify; ?> id="notifications">
      Notify me when new restaurants are opened
    </label>
  </p>
  <p>
    <input name="submit" value="Submit" type="submit">
    <?php if ( isset( $success_message ) ) {
      echo '<br><label class="success">', $success_message, '</label>';
    } ?>
  </p>
</form>