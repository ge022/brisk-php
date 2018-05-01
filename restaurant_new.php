<?php
  
  ob_start();
  
  $page = 'New Restaurant';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  if ( !user_is_admin() ) {
    header( 'Location: /restaurants.php');
  }
  
  $submit = $_POST[ 'submit' ];
  
  $db = db_connect();
  
  $name = $db->escape_string( $_POST[ 'name' ] );
  $location = $db->escape_string( $_POST[ 'location' ] );
  $price_range_low = $db->escape_string( $_POST[ 'price_range_low' ] );
  $price_range_high = $db->escape_string( $_POST[ 'price_range_high' ] );
  $tags = $db->escape_string( $_POST[ 'tags' ] );
  
  // Check and display for errors
  $valid = true;
  
  if ( !empty ( $submit ) ) {
    
    if ( empty ( $name ) ) {
      $valid = false;
      $name_error = 'Name is required.';
    }
    if ( empty( $location ) ) {
      $valid = false;
      $location_error = 'Location is required.';
    }
    if ( !is_numeric( $price_range_low ) ) {
      $valid = false;
      $price_range_low_error = 'Price range low must be numeric.';
    }
    if ( !is_numeric( $price_range_high ) ) {
      $valid = false;
      $price_range_high_error = 'Price range high must be numeric.';
    }
    if ( empty ( $tags ) ) {
      $valid = false;
      $tags_error = 'Tags are required.';
    }
    
    if ( $valid ) {
      // Update the database
      $sql = "INSERT INTO restaurants (name, location, price_range_low, price_range_high, tags, modified_at, created_at) VALUES ('$name', '$location', '$price_range_low', '$price_range_high', '$tags', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
      $db->query( $sql );
      header( "Location: /restaurant.php?id=$db->insert_id" );
    }
    
  }

?>

<section class="new">

  <div class="section-header">
    <h2>Create a new restaurant</h2>
  </div>

  <div class="form-wrapper">
    
    <form method="post" action="restaurant_new.php">
      <p>
        <label for="name">Restaurant name:</label>
        <input type="text" name="name" placeholder="Name"
               value="<?php echo htmlspecialchars( stripslashes( $name ) ); ?>"
               class="fullwidth"
               id="name">
        <?php if ( !empty( $name_error ) ) {
          echo '<label class="invalid-input">', $name_error, '</label>';
        } ?>
      </p>
      <p>
        <label for="location">Restaurant location:</label>
        <input type="text" name="location" placeholder="Location"
               value="<?php echo htmlspecialchars( stripslashes( $location ) ); ?>" class="fullwidth"
               id="location">
        <?php if ( !empty( $location_error ) ) {
          echo '<label class="invalid-input">', $location_error, '</label>';
        } ?>
      </p>
      <p>
        <label for="price_range_low">Price range low:</label>
        <input type="text" name="price_range_low" placeholder="Price range low"
               value="<?php echo htmlspecialchars( stripslashes( $price_range_low ) ); ?>"
               class="fullwidth"
               id="price-range-low">
        <?php if ( !empty( $price_range_low_error ) ) {
          echo '<label class="invalid-input">', $price_range_low_error, '</label>';
        } ?>
      </p>
      <p>
        <label for="price_range_high">Price range high:</label>
        <input type="text" name="price_range_high" placeholder="Price range high"
               value="<?php echo htmlspecialchars( stripslashes( $price_range_high ) ); ?>"
               class="fullwidth"
               id="price-range-high">
        <?php if ( !empty( $price_range_high_error ) ) {
          echo '<label class="invalid-input">', $price_range_high_error, '</label>';
        } ?>
      </p>
      <p>
        <label for="tags">Tags:</label>
        <input type="text" name="tags" placeholder="Tags"
               value="<?php echo htmlspecialchars( stripslashes( $tags ) ); ?>"
               class="fullwidth"
               id="tags">
        <?php if ( !empty( $tags_error ) ) {
          echo '<label class="invalid-input">', $tags_error, '</label>';
        } ?>
      </p>


      <p>
        <input name="submit" value="Create" type="submit">
        <a href="restaurants.php" class="button">Cancel</a>
      </p>
    </form>
    
  </div>


</section>


<?php
  include 'includes/footer.php';
?>

