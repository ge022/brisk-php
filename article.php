<?php
  
  $page = 'Articles';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  $article_id = $_GET[ 'article_id' ];
  
  // SQL
  $db = db_connect();
  if ( isset( $article_id ) ) {
    $sql = "SELECT * FROM articles WHERE article_id=$article_id";
  } else {
    $sql = "SELECT * FROM articles WHERE date_posted = (SELECT max(date_posted) FROM articles)";
  }
  $result = $db->query( $sql );
  list( $article_id, $title, $author, $article_text, $date_posted, $created_at, $modified_at ) = $result->fetch_row();
  
  if ( $result->num_rows < 1 ) {
    $title = 'No articles published';
  }
  
?>

<section class="article">

  <div class="section-header">
    <h2><?php echo $title; ?></h2>
  </div>

  <div class="details-container">

    <ul class="single-details">
      <li><b>Author</b>: <?php echo $author; ?></li>
      <li><b>Text</b>:<br/><?php echo $article_text; ?></li>
      <li><b>Date posted</b>: <?php if ( $date_posted ) {
          echo $date_posted;
        } else {
          echo 'not published';
        }
        ?></li>
    </ul>

    <a href="articles.php" class="button">Show all</a>
    <?php if ( user_is_admin() ) {
      echo "<a href=\"article_edit.php?article_id=$article_id\" class=\"button\">Edit</a>";
    } ?>
  </div>

</section>

<?php
  
  include 'includes/footer.php'

?>
