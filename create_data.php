<?php
  
  require_once 'autoload.php';
  include 'includes/functions.php';
  
  $db = db_connect();
  $faker = Faker\Factory::create();

//
//    for ( $i = 0; $i < 5; $i++ ) {
//
//      $name = $faker->company;
//      $location = $faker->address;
//      $price_range_low = rand( 1, 10 );
//      $price_range_high = rand( 11, 100 );
//      $tags = $faker->bs;
//      $sql = "INSERT INTO restaurants (name, location, price_range_low, price_range_high, tags, modified_at, created_at) VALUES ('$name', '$location', '$price_range_low', '$price_range_high', '$tags', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
//      $db->query( $sql );
//      $restaurantID = $db->insert_id;
//      echo $sql;
//
//      $num_reviews = rand(0, 5);
//
//      for ( $r = 0; $r < $num_reviews; $r++ ) {
//        $author = $faker->name();
//        $review = $faker->bs;
//        $rating = rand(1, 5);
//        $sql = "INSERT INTO reviews (author, review, rating, created_at, restaurantIDFK) VALUES ('$author', '$review', $rating, NOW(), $restaurantID)";
//        echo $sql;
//        $db->query( $sql );
//      }
//
//      echo $db->sqlstate;
//
//    }

//  for ( $i = 0; $i < 10; $i++ ) {
//    $title = $db->real_escape_string( $faker->sentence( 5 ) );
//    $author = $db->real_escape_string( $faker->name() );
//    $article_text = $db->real_escape_string( $faker->realText() );
//    sleep(1);
//    $sql = "INSERT INTO articles (title, author, article_text, date_posted, created_at, modified_at) VALUES ('$title', '$author', '$article_text', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
//    echo $sql;
//    $db->query( $sql );
//    echo $db->sqlstate;
//
//  }
  
//  for ( $i = 0; $i < 10; $i++ ) {
//    $title = $db->real_escape_string( $faker->sentence( 5 ) );
//    $author = $db->real_escape_string( $faker->name() );
//    $blog_text = $db->real_escape_string( $faker->realText() );
//    sleep( 1 );
//    $sql = "INSERT INTO blogs (title, author, blog_text, publish_date, created_at, modified_at) VALUES ('$title', '$author', '$blog_text', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
//    echo $sql;
//    $blog_id = $db->insert_id;
//    $db->query( $sql );
//    echo $db->sqlstate;
//
//    $num_comments = rand(0, 5);
//    for ( $r = 0; $r < $num_comments; $r++ ) {
//      $author = $db->real_escape_string( $faker->name() );
//      $comment = $db->real_escape_string( $faker->realText() );
//      $rating = rand( 1, 5 );
//      $sql = "INSERT INTO comments (author, comment, rating, blog_id, created_at) VALUES ('$author', '$comment', '$rating', '$blog_id', NOW())";
//      $db->query( $sql );
//    }
//}