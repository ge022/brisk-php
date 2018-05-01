<?php
  
  $page = 'All Articles';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  $db = db_connect();
  
  // Pagination window
  $per_page = empty( $_GET[ 'per_page' ] ) ? 10 : $_GET[ 'per_page' ];
  $page = empty( $_GET[ 'page' ] ) ? 1 : $_GET[ 'page' ];
  $start = ( $page - 1 ) * $per_page;
  
  $sql = "SELECT count(article_id) FROM articles";
  $result = $db->query( $sql );
  $records = $result->fetch_row()[ 0 ];
  //  echo 'Records: ', $records, '<br>';
  //  echo 'Per page: ', $per_page;
  //  echo '<br>Pages: ', ceil( $records / $per_page );
  //
  $sql = "SELECT * FROM articles LIMIT $per_page OFFSET $start";
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
  
  $prev_link = "<a href='/articles.php?per_page=$per_page&page=$prev_page' class='button'>Prev</a>";
  $next_link = "<a href='/articles.php?per_page=$per_page&page=$next_page' class='button'>Next</a>";
  
  $msg = $_GET[ 'msg' ];
?>


<section class="articles">

  <div class="section-header">
    <h2>Articles</h2>
  </div>
  
  <?php if ( $msg ) : ?>
    <p class="notice-message">
      <?php echo $msg; ?>
    </p>
  <?php endif; ?>
  
  <?php if ( user_is_admin() ) {
    echo '<a href="article_new.php" class="button">New Article</a>';
  } ?>

  <div class="table-wrapper">

    <table>

      <thead>
        <tr>
          <th>Article Title</th>
          <th>Author</th>
          <th>Published Date</th>
          <?php if ( user_is_admin() ) {
            echo '<th>&nbsp;</th>';
          } ?>
        </tr>
      </thead>
      <tbody>
        <?php while ( list ( $article_id, $title, $author, $article_text, $date_posted, $created_at, $modified_at ) = $result->fetch_row() ) {
          echo "<tr>
                <td><a href=\"article.php?article_id=$article_id\">$title</a></td>
                <td>$author</td>
                <td>";
          if ( $date_posted ) {
            echo $date_posted;
          } else {
            echo 'not published';
          }
          echo '</td>';
          if ( user_is_admin() ) {
            echo "<td><a href=\"article_delete.php?article_id=$article_id\">Delete</a></td>";
          }
          echo '</tr>';
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
  
  include 'includes/footer.php'

?>

