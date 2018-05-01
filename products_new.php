<?php
  
  ob_start();
  
  $page = 'New Product';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  if ( !user_is_admin() ) {
    header( 'Location: /products.php' );
  }
  
  $submit = $_POST[ 'submit' ];
  
  $db = db_connect();
  
  // Form data
  $name = $db->real_escape_string( $_POST[ 'name' ] );
  $description = $db->real_escape_string( $_POST[ 'description' ] );
  $price = $db->real_escape_string( $_POST[ 'price' ] );
  $cost = $db->real_escape_string( $_POST[ 'cost' ] );
  $qty_on_hand = $db->real_escape_string( $_POST[ 'qty_on_hand' ] );
  $image = $db->real_escape_string( $_POST[ 'image' ] );
  $image_thumb = $db->real_escape_string( $_POST[ 'image_thumb' ] );
  
  // Check and display for errors
  $valid = true;
  
  if ( !empty ( $submit ) ) {
    
    if ( empty ( $name ) ) {
      $valid = false;
      $name_error = 'Title is required.';
    }
    
    if ( empty( $description ) ) {
      $valid = false;
      $description_error = 'Description is required.';
    }
    
    // Test for null
    if ( $price === '' ) {
      $valid = false;
      $price_error = 'Price is required.';
    } elseif ( !is_numeric( $price ) ) {
      $valid = false;
      $price_error = 'Price must be a number.';
    }
    
    if ( $cost === '' ) {
      $valid = false;
      $cost_error = 'Cost is required.';
    } elseif ( !is_numeric( $cost ) ) {
      $valid = false;
      $cost_error = 'Cost must be a number.';
    }
    
    if ( $qty_on_hand === '' ) {
      $valid = false;
      $qty_on_hand_error = 'Quantity is required.';
    } elseif ( !is_numeric( $qty_on_hand ) ) {
      $valid = false;
      $qty_on_hand_error = 'Quantity must be a number.';
    }
    
    if ( empty( $image ) ) {
      $valid = false;
      $image_error = 'Image is required.';
    }
    
    if ( empty( $image_thumb ) ) {
      $valid = false;
      $image_thumb_error = 'Thumbnail image is required.';
    }
    
    if ( $valid ) {
      // Update the database
      $sql = "INSERT INTO products (name, description, price, cost, qty_on_hand, image, image_thumb, modified_at, created_at) VALUES ('$name', '$description', '$price', '$cost', '$qty_on_hand', '$image', '$image_thumb', NULL, NOW())";
      $db->query( $sql );
      header( "Location: /product.php?product_id=$db->insert_id" );
    }
    
  }

?>

  <section class="new">

    <div class="section-header">
      <h2>Create a new product</h2>
    </div>

    <div class="form-wrapper">
      
      <?php include 'includes/product_form.php'; ?>

    </div>

  </section>

<?php
  include 'includes/footer.php';
?>