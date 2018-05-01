<?php
  
  session_start();
  
  $page = 'Restaurants';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  $db = db_connect();
  
  // Pagination window
  $per_page = empty( $_GET[ 'per_page' ] ) ? 10 : $_GET[ 'per_page' ];
  $page = empty( $_GET[ 'page' ] ) ? 1 : $_GET[ 'page' ];
  $start = ( $page - 1 ) * $per_page;
  
  $sql = "SELECT count(id) FROM restaurants";
  $result = $db->query( $sql );
  $records = $result->fetch_row()[ 0 ];
  //  echo 'Records: ', $records, '<br>';
  //  echo 'Per page: ', $per_page;
  //  echo '<br>Pages: ', ceil( $records / $per_page );
  //
  $sql = "SELECT * FROM restaurants LIMIT $per_page OFFSET $start";
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
  
  $prev_link = "<a href='/restaurants.php?per_page=$per_page&page=$prev_page' class='button'>Prev</a>";
  $next_link = "<a href='/restaurants.php?per_page=$per_page&page=$next_page' class='button'>Next</a>";
  
  $msg = $_GET[ 'msg' ];
?>


<section class="restaurants">

  <div class="section-header">
    <h2>Restaurants</h2>
  </div>
  
  
  <?php if ( $msg ) : ?>
    <p class="notice-message">
      <?php echo $msg; ?>
    </p>
  <?php endif; ?>
  
  
  <?php if ( user_is_admin() ) {
    echo '<a href="restaurant_new.php" class="button">New Restaurant</a>';
  }
  ?>

  <div class="table-wrapper">

    <table>

      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Location</th>
          <th>Price Range Low</th>
          <th>Price Range High</th>
          <th>Tags</th>
          <?php if ( user_is_admin() ) {
            echo '<th>&nbsp;</th>';
          }
          ?>
        </tr>
      </thead>
      <tbody>
        <?php while ( list ( $id, $name, $location, $price_range_low, $price_range_high, $tags, $modified_at, $created_at ) = $result->fetch_row() ) : ?>
          <tr>
            <?php echo
            "<td>$id</td>
            <td><a href=\"restaurant.php?id=$id\">$name</a></td>
            <td>$location</td>
            <td>$price_range_low</td>
            <td>$price_range_high</td>
            <td>$tags</td>";
            ?>
              <?php if ( user_is_admin() ) {
                echo '<td>',
                     "<a href=\"restaurant_delete.php?id=$id\">Delete</a><br>
                     <a href=\"emailrestaurant.php?id=$id\">Email</a>",
                     '</td>';
              }
              ?>
            
          </tr>
        <?php endwhile; ?>
      </tbody>

    </table>

  </div>
  
  <?php if ( $records > $per_page ) {
    echo $prev_link, '&nbsp;', $next_link;
  }
  ?>
</section>


<?php
  
  include 'includes/footer.php'

?>
