<?php
  
  session_start();
  
  $page = 'Restaurant';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  
  $id = $_GET[ 'id' ];
  
  if ( isset( $id ) ) {
    $db = db_connect();
    // Restaurant
    $sql = "SELECT * FROM restaurants WHERE id=$id";
    $result = $db->query( $sql );
    list ( $restaurantID, $name, $location, $price_range_low, $price_range_high, $tags, $modified_at, $created_at ) = $result->fetch_row();
    // Average review rating
    $sql = "SELECT AVG(rating) FROM reviews WHERE restaurantIDFK=$restaurantID";
    $result = $db->query( $sql );
    if ( $result ) {
      $avg_rating = $result->fetch_row()[ 0 ];
    }
    // Reviews
    $sql = "SELECT * FROM reviews WHERE restaurantIDFK=$restaurantID";
    $result = $db->query( $sql );
  }


?>


<section class="restaurant">

  <div class="section-header">
    <h2><?php echo $name; ?></h2>
  </div>

  <div class="details-container">
    <ul class="single-details">
      <li><b>Location</b>: <?php echo $location; ?></li>
      <li><b>Price Range Low</b>: <?php echo $price_range_low; ?></li>
      <li><b>Price Range High</b>: <?php echo $price_range_high; ?></li>
      <li><b>Tags</b>: <?php echo $tags; ?></li>
      <li><b>Modified At</b>: <?php echo $modified_at; ?></li>
      <li><b>Created At</b>: <?php echo $created_at; ?></li>
      <li><strong>Average Rating:</strong>
        <?php
          echo str_repeat( '<img src="/images/fork.png" height="25px" width="25px">', $avg_rating );
        ?>
      </li>
    </ul>

    <a href="restaurants.php" class="button">Back</a>
    <?php if ( isset( $id ) && user_is_admin() ) : ?>
      <a href="/restaurant_edit.php?id=<?php echo $id; ?>" class="button">Edit</a>
      <a href="/emailrestaurant.php?id=<?php echo $id; ?>" class="button">Email details</a>
    <?php endif; ?>

    <div class="reviews">
      <h3>Reviews:</h3>
      <?php while ( list ( $id, $author, $review, $rating, $created_at, $restaurantIDFK ) = $result->fetch_row() ) : ?>
        <ul class="review">
          <li>
            <strong>Name:</strong>
            <?php echo $author; ?>
          </li>
          <li>
            <strong>Review:</strong>
            <?php echo $review; ?>
          </li>
          <li>
            <strong>Rating:</strong>
            <?php
              echo str_repeat( '<img src="/images/fork.png" height="25px" width="25px">', $rating );
            ?>
          </li>
        </ul>
        <hr>
      <?php endwhile; ?>
    </div>

    <div class="add-review">
      <h4>Add a new review:</h4>
      <form method="post" action="/review_new.php">
        <p>
          <label for="author">Author:</label>
          <input type="text" name="author" placeholder="Author"
                 value="<?php echo htmlspecialchars( stripslashes( $author ) ); ?>"
                 class="fullwidth"
                 id="author">
        </p>
        <p>
          <label for="review">Review:</label>
          <textarea name="review" placeholder="Review"
                    class="fullwidth" id="review"><?php echo htmlspecialchars( stripslashes( $review ) ); ?></textarea>
        </p>
        <p>
          <label for="rating">Rating:</label>
          <input type="number" name="rating" id="rating" placeholder="Rating" class="fullwidth"
                 value="<?php echo htmlspecialchars( stripslashes( $rating ) ); ?>">
        </p>
        <p>
          <input type="hidden" name="restaurant" value="<?php echo $restaurantID; ?>">
          <input type="submit" name="submit" value="Post review">
        </p>

      </form>
    </div>

  </div>


</section>


<?php
  include 'includes/footer.php';

?>
