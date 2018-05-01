<form method="post" action="<?php echo htmlentities( $_SERVER[ 'PHP_SELF' ] );
  if ( isset( $product_id ) ) {
    echo '?product_id=', $product_id;
  }
?>">
  <p>
    <label for="name">Name:</label>
    <input type="text" name="name" placeholder="required"
           value="<?php echo htmlspecialchars( stripslashes( $name ) ); ?>"
           class="fullwidth"
           id="name">
    <?php if ( !empty( $name_error ) ) {
      echo '<label for="name" class="invalid-input">', $name_error, '</label>';
    } ?>
  </p>
  <p>
    <label for="description">Description:</label>
    <textarea id="description" name="description" class="fullwidth"
              placeholder="required"><?php echo htmlspecialchars( stripslashes( $description ) ); ?></textarea>
    <?php if ( !empty( $description_error ) ) {
      echo '<label for="description" class="invalid-input">', $description_error, '</label>';
    } ?>
  </p>
  <p>
    <label for="price">Price:</label>
    <input type="number" name="price"
           value="<?php echo !empty( $price ) ? stripslashes( $price ) : 0; ?>" step="0.01"
           class="fullwidth"
           id="price">
    <?php if ( !empty( $price_error ) ) {
      echo '<label for="price" class="invalid-input">', $price_error, '</label>';
    } ?>
  </p>
  <p>
    <label for="cost">Cost:</label>
    <input type="number" name="cost"
           value="<?php echo !empty( $cost ) ? stripslashes( $cost ) : 0; ?>" step="0.01"
           class="fullwidth"
           id="cost">
    <?php if ( !empty( $cost_error ) ) {
      echo '<label for="cost" class="invalid-input">', $cost_error, '</label>';
    } ?>
  </p>
  <p>
    <label for="qty_on_hand">Quantity on hand:</label>
    <input type="number" name="qty_on_hand"
           value="<?php echo !empty( $qty_on_hand ) ? stripslashes( $qty_on_hand ) : 0; ?>"
           class="fullwidth"
           id="qty_on_hand">
    <?php if ( !empty( $qty_on_hand_error ) ) {
      echo '<label for="qty_on_hand" class="invalid-input">', $qty_on_hand_error, '</label>';
    } ?>
  </p>
  <p>
    <label for="image">Full image:</label>
    <input type="text" name="image" placeholder="required"
           value="<?php echo htmlspecialchars( stripslashes( $image ) ); ?>"
           class="fullwidth"
           id="image">
    <?php if ( !empty( $image_error ) ) {
      echo '<label for="image" class="invalid-input">', $image_error, '</label>';
    } ?>
  </p>
  <p>
    <label for="image_thumb">Image thumbnail:</label>
    <input type="text" name="image_thumb" placeholder="required"
           value="<?php echo htmlspecialchars( stripslashes( $image_thumb ) ); ?>"
           class="fullwidth"
           id="image_thumb">
    <?php if ( !empty( $image_thumb_error ) ) {
      echo '<label for="image_thumb" class="invalid-input">', $image_thumb_error, '</label>';
    } ?>
  </p>
  <p>
    <input name="submit" value="Submit" type="submit">
    <a href="/product.php?product_id=<?php echo $product_id; ?>" class="button">Cancel</a>
  </p>
</form>