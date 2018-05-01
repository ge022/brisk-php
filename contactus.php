<?php
  $page = 'Contact Us';
  include 'includes/header.php';
  include 'includes/functions.php';
?>

<section class="contact-us">

  <div class="section-header">
    <h2>Contact Us</h2>
  </div>

  <div class="contact-wrapper">

    <div class="contact-info">

      <p class="uppercase">Amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
        magna aliquam erat volutpat.</p>
      <p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea
        commodo consequat. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>
      <hr>
      <h4>Lorem ipsum dolor</h4>
      <p><strong>Ut wisi enim ad</strong><br>
        minim veniam, quis nostrud<br>
        exerci tation ullamcorper</p>

    </div>

    <div class="contact-form-wrapper">
      
      <?php include 'includes/form.php' ?>
      
    </div>

  </div>

</section>

<?php

  include 'includes/footer.php'

?>
