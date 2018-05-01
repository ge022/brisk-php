<?php
  
  ob_start();
  
  $page = 'Edit Restaurant';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  if ( !user_is_admin() ) {
    header( 'Location: /restaurants.php');
  }
  
  $id = $_GET[ 'id' ];
  
  $submit = $_POST[ 'submit' ];
  
  $db = db_connect();
  
  // Process form if editing a restaurant
  if ( !empty ( $id ) && is_numeric( $id ) ) {
    
    if ( empty ( $submit ) ) {
      // Get data from the database
      $sql = "SELECT * FROM restaurants WHERE id=$id";
      $result = $db->query( $sql );
      list ( $id, $name, $location, $price_range_low, $price_range_high, $tags, $modified_at, $created_at ) = $result->fetch_row();
    } else {
      // Get data from POST
      $name = $_POST[ 'name' ];
      $location = $_POST[ 'location' ];
      $price_range_low = $_POST[ 'price_range_low' ];
      $price_range_high = $_POST[ 'price_range_high' ];
      $tags = $_POST[ 'tags' ];
      
      // Check and display for errors
      $valid = true;
      $name_error = '';
      $location_error = '';
      $price_range_low_error = '';
      $price_range_high_error = '';
      $tags_error = '';
      
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
        // Escape input before inserting into database
        $name = $db->real_escape_string( $name );
        $location = $db->real_escape_string( $location );
        $price_range_low = $db->real_escape_string( $price_range_low );
        $price_range_high = $db->real_escape_string( $price_range_high );
        $tags = $db->real_escape_string( $tags );
        
        // Update the database
        $sql = "UPDATE restaurants SET name='$name', location='$location', price_range_low='$price_range_low', price_range_high='$price_range_high', tags='$tags', modified_at=CURRENT_TIMESTAMP WHERE id='$id'";
        $db->query( $sql );
        header( "Location: /restaurant.php?id=$id" );
      }
    }
  }

?>

<section class="edit">

  <div class="section-header">
    <h2>Editing: <?php echo htmlspecialchars( stripslashes( $name ) ); ?></h2>
  </div>

  <div class="form-wrapper">

    <form method="post" action="restaurant_edit.php<?php if ( isset( $id ) ) {
      echo "?id=$id";
    } ?>">
      <p>
        <label for="name">Restaurant name:</label>
        <input type="text" name="name" placeholder="Name"
               value="<?php echo htmlspecialchars( stripslashes( $name ) ); ?>" class="fullwidth"
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
        <label for="price-range-low">Price range low:</label>
        <input type="text" name="price_range_low" placeholder="Price range low"
               value="<?php echo htmlspecialchars( stripslashes( $price_range_low ) ); ?>"
               class="fullwidth"
               id="price-range-low">
        <?php if ( !empty( $price_range_low_error ) ) {
          echo '<label class="invalid-input">', $price_range_low_error, '</label>';
        } ?>
      </p>
      <p>
        <label for="price-range-high">Price range high:</label>
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
               value="<?php echo htmlspecialchars( stripslashes( $tags ) ); ?>" class="fullwidth"
               id="tags">
        <?php if ( !empty( $tags_error ) ) {
          echo '<label class="invalid-input">', $tags_error, '</label>';
        } ?>
      </p>


      <p>
        <input name="submit" value="Update" type="submit">
        <a href="restaurant.php<?php if ( isset( $id ) ) {
          echo "?id=$id";
        } ?>" class="button cancel">Cancel</a>
      </p>
    </form>

  </div>


</section>


<?php
  include 'includes/footer.php';
?>

