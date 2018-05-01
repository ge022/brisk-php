<?php
  
  $page = 'Products';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  $db = db_connect();
  
  // Pagination window
  $per_page = empty( $_GET[ 'per_page' ] ) ? 10 : $_GET[ 'per_page' ];
  $page = empty( $_GET[ 'page' ] ) ? 1 : $_GET[ 'page' ];
  $start = ( $page - 1 ) * $per_page;
  
  $sql = "SELECT count(id) FROM products";
  $result = $db->query( $sql );
  $records = $result->fetch_row()[ 0 ];
  $sql = "SELECT * FROM products LIMIT $per_page OFFSET $start";
  $result = $db->query( $sql );
  
  // Pagination links
  $prev_page = $page - 1;
  if ( $prev_page <= 0 ) {
    $prev_page = 1;
  }
  
  $next_page = $page + 1;
  if ( $next_page > ceil( $records / $per_page ) ) {
    $next_page = $page;
  }
  
  $prev_link = "<a href='/products.php?per_page=$per_page&page=$prev_page' class='button'>Prev</a>";
  $next_link = "<a href='/products.php?per_page=$per_page&page=$next_page' class='button'>Next</a>";
  
  $msg = $_GET[ 'msg' ];

?>
  
  <section class="products">
    
    <div class="section-header">
      <h2>Products</h2>
    </div>
    
    <?php if ( $msg ) : ?>
      <p class="notice-message">
        <?php echo $msg; ?>
      </p>
    <?php endif; ?>
    
    <?php if ( user_is_admin() ) {
      echo '<a href="products_new.php" class="button">New product</a>';
    } ?>
    
    <div class="table-wrapper">
      
      <table>
        
        <thead>
          <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Qty on hand</th>
            <?php if ( user_is_admin() ) {
              echo '<th>Cost</th>
                    <th>&nbsp;</th>';
            } ?>
          </tr>
        </thead>
        <tbody>
          <?php while ( list( $product_id, $name, $description, $price, $cost, $qty_on_hand, $image, $image_thumb ) = $result->fetch_row() ) {
            echo "<tr>
                <td>
                  <a href=\"/product.php?product_id=$product_id\">
                  <img class='img-fluid' src='$image_thumb'>
                  </a>
                </td>
                <td><a href=\"product.php?product_id=$product_id\">$name</a></td>
                <td>$description</td>
                <td>$$price</td>
                <td>$qty_on_hand</td>";
            if ( user_is_admin() ) {
              echo "<td>$$cost</td>
                    <td><a href=\"product_delete.php?product_id=$product_id\">Delete</a></td>";
            }
            echo "</tr>";
          } ?>
        </tbody>
      
      </table>
    
    </div>
    
    <?php {
      echo $prev_link, '&nbsp;', $next_link;
    }
    ?>
  
  </section>


<?php
  
  include 'includes/footer.php';
