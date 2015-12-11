<?php namespace Datium\Tools;

/**
 * Define Day of current date.
 */
class DayOf {

  protected $date_time;

  protected $month;

  protected $day;

  protected $config;

  protected $result;

  protected $calendar_type;

  protected $geregorian_DayofWeek;

  public function __construct( $date_time, $calendar_type = 'gregorian' ) {

    $this->config = include( 'Config.php' );

    $this->date_time = $date_time;

    $this->calendar_type = $calendar_type;

    $this->day = $this->date_time->format('l');

    $this->geregorian_DayofWeek = $this->date_time->format('w');

    return $this;

  }

  /**
   * Which day of year is current day.
   * @since Aug, 03 2015
   * @return integer
   */
  public function year() {

    $config = include(  'CalendarSettings/' . ucfirst( $this->calendar_type ) . '.php' );

    return $config[ 'day_of_year' ]( $this->date_time );

  }


  /**
   * Which day of week is current day.
   * @since Aug, 09 2015
   * @return integer
   */
  public function week() {

    switch ( $this->calendar_type ) {

      case 'ir':

      $this->result = $this->persian_day_of_week();

        break;

      case 'gh':

      $this->result = $this->islamic_day_of_week();

       break;

      case 'gr':

      $this->result = date( 'w', strtotime( $this->date_time->format('Y-m-d H:i:s') ) ) + 1;

       break;
    }

    return $this->result;

  }

  /**
   * @since Sept, 14 2015
   * @return integer
   */
  protected function persian_day_of_week() {

    $this->day = str_replace( $this->config['week_days_name']['english'], $this->config['week_days_name']['persian'], $this->day);

    foreach ( $this->config['week_days_name']['persian'] as $key => $value ) {

      if( $value == $this->day ) return $key += 1;

    }

  }

    /**
   * @since Sept, 14 2015
   * @return integer
   */
  protected function islamic_day_of_week() {

    $this->day = str_replace( $this->config['week_days_name']['english'], $this->config['week_days_name']['islamic'][$this->geregorian_DayofWeek], $this->day);

    foreach ( $this->config['week_days_name']['islamic'] as $key => $value ) {

      if( $value == $this->day ) return $key += 1;

    }


  }


}
?>
