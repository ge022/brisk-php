<?php
  $websiteName = 'Brisk';
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <title>
    <?php if ( $page != '' ) {
        echo $websiteName . ' | ' . $page;
    } else {
        echo $websiteName;
    } ?>
  </title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="none">

  <link rel="stylesheet" href="/css/main.css" type="text/css" media="all">
  <link rel="stylesheet" href="/css/post-formats.css" type="text/css">
  <link rel="stylesheet" id="wm-google-fonts-css"
        href="//fonts.googleapis.com/css?family=Ubuntu%3A400%2C300&amp;subset=latin" type="text/css" media="all">
  <link rel="stylesheet" href="/fonts/genericons/genericons.css" type="text/css">
  <link rel="stylesheet" href="/css/style.css" type="text/css">

</head>

<body id="top">

<div id="page" class="site">

  <header id="masthead" class="site-header">
    <div class="site-header-inner">

      <div class="site-branding">
        <h1 id="site-title" class="site-title logo type-text">
          <span class="text-logo">
            <a href="index.php">Brisk</a>
          </span>
        </h1>
        <div class="site-description">Welcome to Brisk!</div>
      </div>
      
      <?php
        include 'navigation.php'
      ?>

    </div>
  </header>

  <main>