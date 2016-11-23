<?php
$result_size=0;
$arr_results=array();
foreach($arr_result_fields as $field_name)
{
    if(isset($obj_custom_report->dump[$field_name]))
    {
        $arr_results[$field_name] = $obj_custom_report->dump[$field_name];
        if($result_size==0) $result_size = count($obj_custom_report->dump[$field_name]);
    }
}
$table_size = count($arr_column_labels) * 150 + 30; //30 is for the # col

$html = cobalt_load_class($html_subclass);
$html->draw_header_printable();
$html->draw_page_title($title);

$csv_tmp_store = TMP_CSV_STORE;
$pdf_tmp_store = TMP_PDF_STORE;

$pdf_reporter_filename = $reporter->pdf_reporter_filename;
$token = generate_token(0,'fs');
$csv_filename = $token . $_SESSION['user'] . '_' . $sess_var . '_' . date('Y-m-d_h-ia') . '.csv';
$pdf_tmp_filename = $_SESSION['user'] . '_' . $sess_var . '_' . date('Y-m-d_h-ia') . '.rpt';
$csv_contents = '';
$pdf_html_table = '';


echo '<div class="no-print">
        <a href="/' . BASE_DIRECTORY . '/download_csv_tmp_store.php?filename=' . $csv_filename . '">Download as CSV</a> &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="' . $pdf_reporter_filename . '" target="_blank">Download as PDF</a>
      </div>';

//Start of report table

//Screen output, header
echo '<table width="' . $table_size . '" border="1">';
echo '<tr style="background-color: ' . $header_bgcolor . ';">';
echo '<th align="center">#</th>';

//Same data, but for CSV
$new_csv_line = '#';

//Same data, but for PDF
$pdf_html_table = <<<EOD
<table width="100%" border="1">
<tr style="background-color: $header_bgcolor;">
<th align="center">#</th>
EOD;

foreach($arr_column_labels as $label)
{
    //Screen output
    echo '<th align="center">' . $label . '</th>';

    //Same data, but for CSV
    $csv_field = str_replace('"',"''", $label);
    make_list($new_csv_line, $csv_field, ',', TRUE, '"');

    //Same data, but for PDF
    $pdf_html_table .= <<<EOD
    <th align="center"> $label </th>
EOD;

}
//Screen output, end of header row
echo '</tr>';

//Same data, but for CSV (newline)
$csv_contents .= $new_csv_line . "\r\n";

//Same data, but for PDF
    $pdf_html_table .= <<<EOD
    </tr>
EOD;


$arr_totals_aggregator = array();
for($i=0; $i<$result_size; ++$i)
{
    if($i%2==0) $class='listText';
    else $class='listTextAlt';

    $row_count = $i+1;
    //Screen output, the # column
    echo '<tr class="' . $class . '">';
    echo '<td align="center">' . ($row_count) . '</td>';

    //Same data, but for CSV
    $new_csv_line = $row_count;

    //Same data, but for PDF
    $pdf_html_table .= <<<EOD
    <tr class="$class">
    <td align="center"> $row_count </td>
EOD;

    foreach($arr_result_fields as $index=>$field_name)
    {
        $alignment = $arr_column_alignments[$index];
        $format = $arr_column_formats[$index];
        $cell_value = '';
        if(substr($format,0, 13) == 'number_format')
        {
            $decimal_places = substr($format, 13);
            $cell_value = number_format($arr_results[$field_name][$i],$decimal_places);
        }
        elseif($format == 'normal')
        {
            $cell_value = $arr_results[$field_name][$i];
        }
        else
        {
            $cell_value = $format($arr_results[$field_name][$i]);
        }

        if($arr_show_sum[$index])
        {
            if(isset($arr_totals_aggregator[$index]))
            {
                $arr_totals_aggregator[$index] += $arr_results[$field_name][$i];
            }
            else
            {
                $arr_totals_aggregator[$index] = $arr_results[$field_name][$i];
            }
        }
        else
        {
            $arr_totals_aggregator[$index] = '';
        }


        $nohtml_cell_value = nl2br(cobalt_htmlentities($cell_value));

        //Screen output of cell contents
        echo '<td align="' . $alignment . '">';
        echo $nohtml_cell_value;
        echo '</td>';

        //Same data, but for CSV
        $csv_field = str_replace('"',"''", $cell_value);
        make_list($new_csv_line, $csv_field, ',', TRUE, '"');

        //Same data, but for PDF
        $pdf_html_table .= <<<EOD
        <td align="$alignment"> $nohtml_cell_value </td>
EOD;
    }
    //Screen output, end of row
    echo '</tr>';

    //Same data, but for CSV (newline)
    $csv_contents .= $new_csv_line . "\r\n";

    //Same data, but for PDF
    $pdf_html_table .= <<<EOD
    </tr>
EOD;

}


//Screen output - last number of # col
echo '<tr style="background-color: ' . $totals_bgcolor . ';">';
echo '<th>' . $result_size .'</th>';

//Same data, but for CSV
$new_csv_line = $result_size;

//Same data, but for PDF
$pdf_html_table .= <<<EOD
<tr style="background-color: $totals_bgcolor;">
<th align="center">$result_size</th>
EOD;


foreach($arr_totals_aggregator as $index=>$total)
{
    $alignment = $arr_column_alignments[$index];
    $cell_value='';
    if($total === '')
    {
        //triple equal needed above instead of double equal so that "0" does not get evaluated as the same as the empty string.
        //Do nothing if no aggregator total
    }
    else
    {
        $format = $arr_column_formats[$index];
        $decimal_places = substr($format, 13);
        $cell_value = number_format($total,$decimal_places);
    }

    //Screen output of cell value (aggregators / final row)
    echo '<th align="' . $alignment . '">';
    echo $cell_value;
    echo '</th>';

    //Same data, but for CSV
    $csv_field = str_replace('"',"''", $cell_value);
    make_list($new_csv_line, $csv_field, ',', TRUE, '"');

    //Same data, but for PDF
    $pdf_html_table .= <<<EOD
    <th align="$alignment"> $cell_value </th>
EOD;

}
//Screen output, end of row and end of table
echo '</tr>';
echo '</table>';
$html->draw_footer_printable();

//Same data, but for CSV (newline)
$csv_contents .= $new_csv_line . "\r\n";

//Same data, but for PDF
$pdf_html_table .= <<<EOD
</tr>
</table>
EOD;

//Write the CSV file
$csv_file=fopen(TMP_DIRECTORY . '/' . $csv_tmp_store . '/' . $csv_filename,"wb");
fwrite($csv_file, $csv_contents);
fclose($csv_file);
chmod(TMP_DIRECTORY . '/' . $csv_tmp_store . '/' . $csv_filename, 0755);

//Put PDF data into tmp file
$pdf_tmp_file=fopen(TMP_DIRECTORY . '/' . $pdf_tmp_store . '/' . $pdf_tmp_filename,"wb");
fwrite($pdf_tmp_file, $pdf_html_table);
fclose($pdf_tmp_file);
chmod(TMP_DIRECTORY . '/' . $pdf_tmp_store . '/' . $pdf_tmp_filename, 0755);

//Sessionize the pdf_tmp_filename
$_SESSION[$sess_var]['pdf_tmp_filename'] = $pdf_tmp_filename;
