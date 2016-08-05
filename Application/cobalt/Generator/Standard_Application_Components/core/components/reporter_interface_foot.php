<?php
$reporter->draw_report_interface_footer();

$html->draw_fieldset_body_end();
$html->draw_fieldset_footer_start();
$html->draw_submit_cancel();

$html->draw_fieldset_footer_end();

echo '<br>';
$html->draw_fieldset_header('Manage Reports');
$html->draw_fieldset_body_start();

echo '<table class="input_form">';
echo '<tr>';
echo '<td class="label">Report Name: </td>';
echo '<td>';
echo '<input type="text" name="saved_report_title" value="" size="40">';
echo '<input type="submit" name="btn_save" value="SAVE AS...">';
echo '</td></tr>';

if(isset($arr_saved_reports['report_name']))
{
    $options = array('items' =>$arr_saved_reports['report_name'],
                     'values'=>$arr_saved_reports['report_name']);
}
else
{
    $options = array('items'=>array(),
                     'values'=>array());
}
echo '<tr><td class="label">';
echo 'Saved Reports: ';
echo '</td><td>';
$html->draw_select_field($options, '', 'chosen_report',FALSE);
echo '<input type="submit" name="btn_load" class="submit" value="RUN REPORT">';
echo '<input type="submit" name="btn_delete" class="cancel" value="DELETE" onClick="return confirm(\'Are you sure you wish to delete this report?\')">';
echo '</td></tr>';
echo '</table>';

$html->draw_fieldset_body_end();
$html->draw_fieldset_footer_start();
$html->draw_fieldset_footer_end();
$html->draw_container_div_end();

if(isset($open_result_page) && $open_result_page==TRUE)
{
    echo '<script>';
    echo "window.open(\"$result_page?token=$token\")";
    echo '</script>';
}
$html->draw_footer();
