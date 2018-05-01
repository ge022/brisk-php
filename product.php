<?php
  ob_start();
  
  $page = 'Products';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  $product_id = $_GET[ 'product_id' ];
  
  // SQL
  $db = db_connect();
  if ( isset( $product_id ) && $product_id !== '' ) {
    $sql = "SELECT * FROM products WHERE id=$product_id";
  } else {
    header( 'Location: /products.php');
  }
  $result = $db->query( $sql );
  
  if ( $result->num_rows < 1 ) {
    header( 'Location: /products.php');
  }
  
  list( $product_id, $name, $description, $price, $cost, $qty_on_hand, $image, $image_thumb, $modified_at, $created_at ) = $result->fetch_row();
  
  $reviews_count = 0;
  // Average rating based on reviews
  $sql = "SELECT AVG(rating) FROM product_reviews WHERE product_id=$product_id";
  $result = $db->query( $sql );
  $avg_rating = $result->fetch_row()[ 0 ];
  
  // Comments
  $sql = "SELECT * FROM product_reviews where product_id=$product_id";
  $result = $db->query( $sql );
  $reviews_count = $result->num_rows;

?>
  
  
  <section class="product">
    
    <article class="details-container single">
      
      <div class="entry-media">
        <figure class="post-thumbnail">
          <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>">
        </figure>
      </div>
      
      <header class="entry-header">
        <h2 class="entry-title">
          <?php echo $name; ?><br>
          <?php echo str_repeat( '<span class="genericons-neue-star"></span>', $avg_rating ); ?>
        </h2>
        <p></p>
      </header>
      
      <footer class="entry-meta entry-meta-top">
        <span class="entry-meta-element">
          <b>Price: </b>$<?php echo $price; ?>
        </span>
        <?php if ( user_is_admin() ) : ?>
        <span class="entry-meta-element">
          <b>Cost: </b>$<?php echo $cost; ?>
        </span>
        <?php endif; ?>
        <span class="entry-meta-element">
          <b>Quantity on hand: </b><?php echo $qty_on_hand; ?>
        </span>
      </footer>
      
      <div class="entry-content">
        <p><?php echo $description; ?></p>
      </div>
      
      <div class="links">
        <a href="products.php" class="button">All products</a>
        <?php if ( user_is_admin() ) {
          echo "<a href=\"products_new.php\" class=\"button\">New product</a>
                <a href=\"products_edit.php?product_id=$product_id\" class=\"button\">Edit product</a>";
        } ?>
      </div>
      <?php if ( user_is_admin() ) : ?>
        <footer class="entry-meta entry-meta-bottom">
          <span class="entry-meta-element">
            <b>Created: </b>
            <time
              datetime="<?php echo $created_at; ?>"
              title="<?php echo date( "jS F, Y g:i:s A", strtotime( $created_at ) ); ?>">
                <?php echo date( "jS F, Y g:i:s A", strtotime( $created_at ) ); ?>
            </time>
          </span>
          <?php if ( $modified_at ) : ?>
            <span class="entry-meta-element">
              <b>Modified: </b>
              <time
                datetime="<?php echo $modified_at; ?>"
                title="<?php echo date( "jS F, Y g:i:s A", strtotime( $modified_at ) ); ?>">
                  <?php echo get_timeago( strtotime( $modified_at ) ); ?>
              </time>
            </span>
          <?php endif; ?>
        </footer>
      <?php endif; ?>
      
      <div class="comments-area">
        <h3 class="comments-title">
          <?php echo $reviews_count; ?> comment(s)
        </h3>
        <ul class="comment-list">
          <?php while ( list ( $id, $product, $author, $comment, $rating, $created_at ) = $result->fetch_row() ) : ?>
            <li class="comment bypostauthor">
              <article class="comment-body">
                <footer class="comment-meta">
                  <div class="comment-author">
                    <b><?php echo $author; ?></b> says:
                  </div>
                  <div class="comment-metadata">
                    <time
                        datetime="<?php echo $created_at; ?>"
                        title="<?php echo date( "jS F, Y g:i:s a", strtotime( $created_at ) ); ?>">
                      <?php echo get_timeago( strtotime( $created_at ) ); ?>
                    </time>
                  </div>
                </footer>
                <div class="comment-content">
                  <p><?php echo $comment; ?></p>
                </div>
                <div>
                  <?php echo str_repeat( '<span class="genericons-neue-star"></span>', $rating ) ?>
                </div>
              </article>
            </li>
          <?php endwhile; ?>
        </ul>
        
        <div class="comment-respond">
          <h4 class="comment-reply-title">Leave a reply</h4>
          <form class="comment-form" action="/product_review_new.php" method="post">
            <p class="comment-form-comment">
              <label for="comment">Comment</label>
              <textarea name="comment" id="comment" cols="30" rows="5"></textarea>
            </p>
            <p class="comment-form-author">
              <label for="author">Name</label>
              <input type="text" name="author" id="author" size="30">
            </p>
            <p class="comment-form-email">
              <label for="rating">Rating</label>
              <?php create_select_box( 'rating', [ '', 1, 2, 3, 4, 5 ], '' ); ?>
            </p>
            <p class="form-submit">
              <input type="submit" class="submit" name="submit" value="Add Review">
              <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            </p>
          </form>
        </div>
      
      </div>
    
    
    </article>
  
  
  </section>


<?php
  
  include 'includes/footer.php';
