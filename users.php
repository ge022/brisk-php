<?php
  
  ob_start();
  
  $page = 'Users';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  if ( !user_is_admin() ) {
    header( 'Location: /' );
  }
  
  $db = db_connect();
  
  // Pagination window
  $per_page = empty( $_GET[ 'per_page' ] ) ? 10 : $_GET[ 'per_page' ];
  $page = empty( $_GET[ 'page' ] ) ? 1 : $_GET[ 'page' ];
  $start = ( $page - 1 ) * $per_page;
  
  $sql = "SELECT count(id) FROM users";
  $result = $db->query( $sql );
  $records = $result->fetch_row()[ 0 ];
  $sql = "SELECT * FROM users LIMIT $per_page OFFSET $start";
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
  
  $prev_link = "<a href='/users.php?per_page=$per_page&page=$prev_page' class='button'>Prev</a>";
  $next_link = "<a href='/users.php?per_page=$per_page&page=$next_page' class='button'>Next</a>";
  
  $msg = $_GET[ 'msg' ];

?>
  
  <section class="index">
    
    <div class="section-header">
      <h2>Users</h2>
    </div>
    
    <?php if ( $msg ) : ?>
      <p class="notice-message">
        <?php echo $msg; ?>
      </p>
    <?php endif; ?>
    
    <div class="table-wrapper">
      
      <table>
        
        <thead>
          <tr>
            <th>Email</th>
            <th>Name</th>
            <th>Newsletter</th>
            <th>Admin</th>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </thead>
        <tbody>
          <?php while ( list( $id, $email, $name, $password, $newsletter, $admin ) = $result->fetch_row() ) {
            echo "<tr>
                <td>$email</td>
                <td>$name</td>
                <td>$newsletter</td>
                <td>$admin</td>
                <td><a href=\"/user_edit.php?id=$id\">Update</a></td>
                <td><a href=\"/user_delete.php?id=$id\">Delete</a></td>";
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
