<?php
function new_window($location)
{
    echo '<script>' . "\r\n";
    echo 'window.open("' . $location . '")' . "\r\n";
    echo '</script>' . "\r\n";
}

function set_datecontrol_values(&$year, &$month, &$day, $offset=0, $offset_type='m')
{
    $adjusted_date = date("m-d-Y", mktime(0, 0, 0, 
                                          $month + $m_offset, 
                                          $day + $d_offset, 
                                          $year + $y_offset));
   
    $data = explode('-', $adjusted_date);
    $month = $data[0];
    $day = $data[1];
    $year = $data[2];
}
