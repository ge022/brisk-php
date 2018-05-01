<?php
  
  ob_start();
  session_start();
  include 'includes/functions.php';
  
  if ( !user_is_admin() ) {
    header( 'Location: /blogs.php' );
  }
  
  $db = db_connect();
  
  $blog_id = $_GET[ 'blog_id' ];
  $new_post = $_GET[ 'new' ];
  
  // Default email result message
  // blog not found, or mail failed to send.
  $msg = 'Email(s) failed to send.';
  
  if ( isset( $blog_id ) ) {
    
    // Query for the blog
    $sql = "SELECT * FROM blogs WHERE id=$blog_id";
    $result = $db->query( $sql );
    
    if ( $result->num_rows > 0 ) {
      
      // Blog found
      list ( $blog, $title, $author, $blog_text, $publish_date ) = $result->fetch_row();
      
      // Query for users who receive newsletters
      $sql = "SELECT * FROM users WHERE newsletter=1";
      $result = $db->query( $sql );
      
      if ( $result->num_rows > 0 ) {
        
        // Users receiving newsletters found
        while ( list ( $id, $user_email, $user_name ) = $result->fetch_row() ) {
          
          // Generate message for email
          $to = "$user_email";
          $subject = isset( $new_post ) ? "$user_name, we've got a new post at the Brisk blog!" : "$user_name, check out this post at the Brisk blog!";
          
          $body = "
          <h4>$title</h4>
          <p>$blog_text</p>
          <p>
            <b>Written by:</b> $author,<br>
            at <a href='http://example.com/blog.php?blog_id=$blog_id'>http://example.com/blog</a>
          </p>
        ";
          
          $headers = "From: newsletter@example.com\r\n";
          $headers .= "MIME-VERSION: 1.0\r\n";
          $headers .= "Content-Type: text/html;charset=UTF-8\r\n";
          
          $sent = mail( $to, $subject, $body, $headers );
          
        }
        
        if ( $sent ) {
          
          $msg = 'Email(s) sent!';
          
        }
        
      } else {
  
        // No users receive newsletters
        $msg = 'Email(s) not sent. No users receive newsletters.';
  
      }
      
    }
  
    // If emailing a new post, redirect to the new post's single page
    // else redirect to the index page
    isset( $new_post ) ? header( "Location: /blog.php?blog_id=$blog_id&msg=$msg" ) : header( "Location: /blogs.php?msg=$msg" );
    
  }