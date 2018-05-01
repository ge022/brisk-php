<?php
  
  $page = 'Blog';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  $db = db_connect();
  
  // Pagination window
  $per_page = empty( $_GET[ 'per_page' ] ) ? 10 : $_GET[ 'per_page' ];
  $page = empty( $_GET[ 'page' ] ) ? 1 : $_GET[ 'page' ];
  $start = ( $page - 1 ) * $per_page;
  
  $sql = "SELECT count(id) FROM blogs";
  $result = $db->query( $sql );
  $records = $result->fetch_row()[ 0 ];
  $sql = "SELECT * FROM blogs LIMIT $per_page OFFSET $start";
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
  
  $prev_link = "<a href='/blogs.php?per_page=$per_page&page=$prev_page' class='button'>Prev</a>";
  $next_link = "<a href='/blogs.php?per_page=$per_page&page=$next_page' class='button'>Next</a>";
  
  $msg = $_GET[ 'msg' ];
  
?>
  
  <section class="articles">
    
    <div class="section-header">
      <h2>Blog</h2>
    </div>
    
    <?php if ( $msg ) : ?>
      <p class="notice-message">
        <?php echo $msg; ?>
      </p>
    <?php endif; ?>
  
    <?php if ( user_is_admin() ) {
      echo '<a href="blog_new.php" class="button">New post</a>';
    } ?>
    
    <div class="table-wrapper">
      
      <table>
        
        <thead>
          <tr>
            <th>Post Title</th>
            <th>Author</th>
            <th>Published Date</th>
            <?php if ( user_is_admin() ) {
              echo '<th>&nbsp;</th>';
            } ?>
          </tr>
        </thead>
        <tbody>
          <?php while (   list( $blog_id, $title, $author, $blog_text, $publish_date, $created_at, $modified_at ) = $result->fetch_row() ) {
            echo "<tr>
                <td><a href=\"blog.php?blog_id=$blog_id\">$title</a></td>
                <td>$author</td>
                <td>";
            if ( $publish_date ) {
              echo $publish_date;
            } else {
              echo 'not published';
            }
            echo "</td>";
            if ( user_is_admin() ) {
              echo "<td>
                <a href=\"blog_delete.php?blog_id=$blog_id\">Delete</a><br>
                <a href='email_blog.php?blog_id=$blog_id'>Email</a>
                </td>";
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
