<?php
  
  $to = 'contact@example.com';
  
  $subject = 'Test email from my site!';
  
  $message = 'This emails is my test from my site';
  
  $headers = "From: contact@example.com\r\n";
  
  $sent = mail($to, $subject, $message, $headers);
  
  echo $sent;
  