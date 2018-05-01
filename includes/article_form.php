<form method="post" action="<?php echo htmlentities( $_SERVER[ 'PHP_SELF' ] );
  if ( isset( $article_id ) ) {
    echo '?article_id=', $article_id;
  }
?>">
  <p>
    <label for="title">Article title:</label>
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
    <label for="date_posted">Date posted:</label>
    <input type="text" name="date_posted" placeholder="Date posted"
           value="<?php echo htmlspecialchars( stripslashes( $date_posted ) ); ?>"
           class="fullwidth"
           id="date_posted">
    <?php if ( !empty( $date_posted_error ) ) {
      echo '<label for="date_posted" class="invalid-input">', $date_posted_error, '</label>';
    } ?>
  </p>
  <p>
    <label for="article_text">Article text:</label>
    <textarea id="article_text" name="article_text" class="fullwidth"
              placeholder="Article text (required)"><?php echo htmlspecialchars( stripslashes( $article_text ) ); ?></textarea>
    <?php if ( !empty( $article_text_error ) ) {
      echo '<label for="article_text" class="invalid-input">', $article_text_error, '</label>';
    } ?>
  </p>
  <p>
    <input name="submit" value="Submit" type="submit">
    <a href="articles.php" class="button">Cancel</a>
  </p>
</form>