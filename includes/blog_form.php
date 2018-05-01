<form method="post" action="<?php echo htmlentities( $_SERVER[ 'PHP_SELF' ] );
  if ( isset( $blog_id ) ) {
    echo '?blog_id=', $blog_id;
  }
?>">
  <p>
    <label for="title">Post title:</label>
    <input type="text" name="title" placeholder="Title (required)"
           value="<?php echo htmlspecialchars( stripslashes( $title ) ); ?>"
           class="fullwidth"
           id="title">
    <?php if ( !empty( $title_error ) ) {
      echo '<label for="title" class="invalid-input">', $title_error, '</label>';
    } ?>
  </p>
  <p>
    <label for="author">Author:</label>
    <input type="text" name="author" placeholder="Author (required)"
           value="<?php echo htmlspecialchars( stripslashes( $author ) ); ?>"
           class="fullwidth"
           id="author">
    <?php if ( !empty( $author_error ) ) {
      echo '<label for="author" class="invalid-input">', $author_error, '</label>';
    } ?>
  </p>
  <p>
    <label for="publish_date">Publish date:</label>
    <input type="datetime-local" name="publish_date" placeholder="Publish date"
           value="<?php
             if ( $publish_date ) { echo date('Y-m-d\TH:i', strtotime( $publish_date ) ); }
             else { echo date( 'Y-m-d\TH:i' ); }; ?>"
           class="fullwidth"
           id="publish_date">
    <?php if ( !empty( $publish_date_error ) ) {
      echo '<label for="date_posted" class="invalid-input">', $publish_date_error, '</label>';
    } ?>
  </p>
  <p>
    <label for="post_text">Post text:</label>
    <textarea id="post_text" name="blog_text" class="fullwidth"
              placeholder="Post text (required)"><?php echo htmlspecialchars( stripslashes( $blog_text ) ); ?></textarea>
    <?php if ( !empty( $blog_text_error ) ) {
      echo '<label for="post_text" class="invalid-input">', $blog_text_error, '</label>';
    } ?>
  </p>
  <p>
    <input name="submit" value="Submit" type="submit">
    <a href="/blog.php?blog_id=<?php echo $blog_id; ?>" class="button">Cancel</a>
  </p>
</form>