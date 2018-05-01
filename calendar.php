<?php
  $page = 'Calendar';
  include 'includes/header.php';
  include 'includes/functions.php';
  
  
  $month = $_GET[ 'month' ];
  if ( empty( $month ) ) {
    $month = date( 'n' );
  }
  
  
  $year = $_GET[ 'year' ];
  if ( empty( $year ) ) {
    $year = date( 'Y' );
  }
  
  $large = $_GET[ 'large' ];

?>

<section class="calendar">

  <div class="section-header">
    <h2>Calendar</h2>
  </div>

  <div class="calendar-wrapper">
    
    <?php echo mini_calendar($month, $year, $large); ?>

  </div>

</section>

<?php
  
  include 'includes/footer.php'

?>
