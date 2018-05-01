<?php
  
  require('./config/config.php');
  
  function db_connect()
  {
    $db = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
    $db->set_charset( 'utf8' );
    
    if ( $db->connect_errno ) {
      echo 'Failed to connect to database: (', $db->connect_errno, ') ', $db->connect_error;
    }
    return $db;
  }
  
  /**
   * @param $name
   * @param $options_array
   * @param $selected_option
   */
  function create_select_box( $name, $options_array, $selected_option )
  {
    echo "<select name='$name' id='$name'>";
    $count = 0;
    while ( $count < count( $options_array ) ) {
      echo '<option';
      if ( $selected_option == $options_array[ $count ] ) {
        echo ' selected="selected"';
      }
      echo '>';
      echo $options_array[ $count ];
      echo '</option>';
      $count = $count + 1;
    }
    echo '</select>';
  }
  
  function mini_calendar( $month, $year, $large )
  {
    
    $prev_month = $month - 1;
    $next_month = $month + 1;
    $prev_year = $year;
    $next_year = $year;
    
    if ( $month == 1 ) {
      $prev_month = 12;
      $prev_year = $year - 1;
    }
    
    if ( $month == 12 ) {
      $next_month = 1;
      $next_year = $year + 1;
    }
    
    $cal_title = date( 'F Y', mktime( 0, 0, 0, $month, 1, $year ) );
    
    $days_in_month = date( 't', mktime( 0, 0, 0, $month, 1, $year ) );
    $days_in_prev_month = date( 't', mktime( 0, 0, 0, $prev_month, 1, $prev_year ) );
    
    $first_of_month = mktime( 0, 0, 0, $month, 1, $year );
    
    $first_day = date( 'w', $first_of_month );
    
    // Current date for current day styling
    $current_year = date( 'Y' );
    $current_month = date( 'n' );
    
    $days_of_week = array(
        'Sunday' => 'Sun',
        'Monday' => 'Mon',
        'Tuesday' => 'Tue',
        'Wednesday' => 'Wed',
        'Thursday' => 'Thu',
        'Friday' => 'Fri',
        'Saturday' => 'Sat',
    );
    
    // Output calendar
    $ret_str = '';
    
    $ret_str .= '
    <table class="calendar-table';
    if ( $large ) {
      $ret_str .= ' large';
    }
    $ret_str .= '">';
    
    $ret_str .= '
      <thead>
        <tr>
          <td class="previous">
            <a href="?month=';
    $ret_str .= $prev_month;
    $ret_str .= '&year=';
    $ret_str .= $prev_year;
    $ret_str .= '&large=';
    $ret_str .= $large;
    $ret_str .= '">&lt;</a>
          </td>
          
          <td>
            <a class="calendar-size" href="?large=';
    $ret_str .= !$large;
    $ret_str .= '&month=' . $month . '&year=' . $year;
    $ret_str .= '">';
    if ( !$large ) {
      $ret_str .= '&#x21f1;';
    } else {
      $ret_str .= '&#x21f2;';
    }
    $ret_str .= '</a>
            </td>
          
          <td colspan="3" class="calendar-title">
            <h3>';
    $ret_str .= $cal_title;
    $ret_str .= '</h3>
          </td>
          
          <td class="blank">&nbsp;</td>
          
          <td class="next">
            <a href="?month=';
    $ret_str .= $next_month;
    $ret_str .= '&year=';
    $ret_str .= $next_year;
    $ret_str .= '&large=';
    $ret_str .= $large;
    $ret_str .= '">&gt;</a>
          </td>
        </tr>
        <tr>';
    
    foreach ( $days_of_week as $day => $abbr ) {
      $ret_str .= '
          <th scope="col" title="';
      $ret_str .= $day;
      $ret_str .= '">';
      $ret_str .= $abbr;
      $ret_str .= '</th>';
    }
    
    $ret_str .= '
        </tr>
      </thead>
      <tbody>
        <tr>';
    
    // Output last month's last days until $first_day
    for ( $blank_cells = 0; $blank_cells < $first_day; $blank_cells++ ) {
      $ret_str .= '
          <td class="day-disabled">';
      $ret_str .= $days_in_prev_month - $first_day + 1;
      $ret_str .= '</td>';
      $days_in_prev_month++;
    }
    
    // Output the rest of the first week's days
    $current_day = 1;
    while ( $current_day <= ( 7 - $first_day ) ) {
      $ret_str .= '
          <td class="day';
      if ( $current_day == date( 'j' ) && $month == $current_month && $year == $current_year ) {
        $ret_str .= ' current-day';
      };
      $ret_str .= '">';
      $ret_str .= $current_day;
      $ret_str .= '</td>';
      $current_day++;
    }
    
    $ret_str .= '
      </tr>
    ';
    
    // Output the full weeks
    $days_left = $days_in_month - $current_day;
    $whole_weeks = floor( $days_left / 7 );
    $day_in_week = 1;
    
    while ( $whole_weeks > 0 ) {
      $ret_str .= '<tr>';
      $end_of_week = $current_day + 7;
      while ( $current_day < $end_of_week ) {
        $ret_str .= '
          <td class="day';
        if ( $current_day == date( 'j' ) && $month == $current_month && $year == $current_year ) {
          $ret_str .= ' current-day';
        };
        $ret_str .= '">';
        $ret_str .= $current_day;
        $ret_str .= '</td>';
        $current_day++;
        $day_in_week++;
      }
      $whole_weeks--;
      $ret_str .= '</tr>';
    }
    
    // Output the last week
    $ret_str .= '<tr>';
    
    while ( $current_day <= $days_in_month ) {
      $ret_str .= '
          <td class="day';
      if ( $current_day == date( 'j' ) && $month == $current_month && $year == $current_year ) {
        $ret_str .= ' current-day';
      };
      $ret_str .= '">';
      $ret_str .= $current_day;
      $ret_str .= '</td>';
      $current_day++;
    }
    
    // Fill in the rest of the calendar with blank cells
    $day_of_week = date( 'w', mktime( 0, 0, 0, $month, $current_day, $year ) );
    $day = 1;
    for ( $counter = 7 - $day_of_week; $counter > 0 && $day_of_week > 0; $counter-- ) {
      $ret_str .= '
          <td class="day-disabled">';
      $ret_str .= $day;
      $ret_str .= '</td>';
      $day++;
    }
    
    $ret_str .= '</tr>';
    
    $ret_str .= '
      </tbody>
    </table>
    ';
    
    
    return $ret_str;
    
  }
  
  function validDate( $date, $format = 'Y-m-d H:i:s' )
  {
    $d = DateTime::createFromFormat( $format, $date );
    return $d && $d->format( $format ) == $date;
  }
  
  function validDateTime( $date, $format = 'Y-m-d\TH:i' )
  {
    $d = DateTime::createFromFormat( $format, $date );
    return $d && $d->format( $format ) == $date;
  }
  
  function set_user( $login_email, $login_name, $admin = false )
  {
    $_SESSION[ 'email' ] = $login_email;
    $_SESSION[ 'name' ] = $login_name;
    $_SESSION[ 'admin' ] = $admin;
    
  }
  
  function user_is_admin() {
    return ( $_SESSION[ 'admin' ] ) ? true : false;
  }
  
  function get_timeago( $time )
  {
    $estimate_time = time() - $time;
    
    if ( $estimate_time < 1 ) {
      return 'less than 1 second ago';
    }
    
    $condition = array(
        12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    );
    
    foreach ( $condition as $secs => $str ) {
      $d = $estimate_time / $secs;
      
      if ( $d >= 1 ) {
        $r = round( $d );
        return $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
      }
    }
  }