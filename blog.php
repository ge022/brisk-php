<?php
  $page = 'Blog';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  $blog_id = $_GET[ 'blog_id' ];
  
  // SQL
  $db = db_connect();
  
  $msg = $db->escape_string( $_GET[ 'msg' ] );
  
  if ( isset( $blog_id ) && $blog_id !== '' ) {
    $sql = "SELECT * FROM blogs WHERE id=$blog_id";
  } else {
    $sql = "SELECT * FROM blogs WHERE publish_date = (SELECT max(publish_date) FROM blogs WHERE publish_date < current_timestamp)";
  }
  $result = $db->query( $sql );
  list ( $blog_id, $title, $author, $blog_text, $publish_date, $created_at, $modified_at ) = $result->fetch_row();
  $blog_publish_timestamp = strtotime( $publish_date );
  $comments_count = 0;
  
  if ( $result->num_rows < 1 ) {
    $title = 'No blogs published';
  } else {
    
    // Average rating based on comments
    $sql = "SELECT AVG(rating) FROM comments WHERE blog_id=$blog_id";
    $result = $db->query( $sql );
    $avg_rating = $result->fetch_row()[ 0 ];
    
    // Comments
    $sql = "SELECT * FROM comments where blog_id=$blog_id";
    $result = $db->query( $sql );
    $comments_count = $result->num_rows;
  }

?>


  <section class="blog">
  
    <?php if ( $msg ) : ?>
      <p class="notice-message">
        <?php echo $msg; ?>
      </p>
    <?php endif; ?>

    <article class="details-container single">

      <header class="entry-header">
        <h2 class="entry-title">
          <?php echo $title; ?><br>
          <?php echo str_repeat( '<span class="genericons-neue-star"></span>', $avg_rating ); ?>
        </h2>
      </header>

      <footer class="entry-meta entry-meta-top">
        <span class="entry-date entry-meta-element">
          Posted on:
          <?php if ( $publish_date ) {
            echo '<time datetime="', $publish_date, '"';
            echo 'title="', date( "jS F, Y g:i:s a", $blog_publish_timestamp ), '">';
            echo date( "jS F, Y", $blog_publish_timestamp ), '</time>';
          } else {
            echo 'not published';
          } ?>
        </span>
        
        <span class="author entry-meta-element">
          Written by: <?php echo $author; ?>
        </span>
      </footer>

      <div class="entry-content">
        <p><?php echo $blog_text; ?></p>
      </div>

      <div class="links">
        <a href="blogs.php" class="button">All posts</a>
        <?php if ( user_is_admin() ) {
          echo "<a href=\"blog_new.php\" class=\"button\">New post</a>
                <a href=\"blog_edit.php?blog_id=$blog_id\" class=\"button\">Edit post</a>";
        } ?>
      </div>

      <div class="comments-area">
        <h3 class="comments-title">
          <?php echo $comments_count; ?> comment(s)
        </h3>
        <ul class="comment-list">
          <?php while ( list ( $id, $author, $comment, $rating, $blog, $created_at ) = $result->fetch_row() ) : ?>
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
          <form class="comment-form" action="/comment_new.php" method="post">
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
              <input type="submit" class="submit" name="submit" value="Post Comment">
              <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
            </p>
          </form>
        </div>

      </div>
      
    </article>


  </section>


<?php
  
  include 'includes/footer.php';
