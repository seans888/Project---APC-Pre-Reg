<?php
$html = new $html_subclass;
$html->draw_header($page_title, $message, $message_type);
require_once FULLPATH_BASE . 'javascript/submitenter.php';
?>
<input type="hidden" name="filter_sort_asc" value="<?php echo $filter_sort_asc; ?>">
<input type="hidden" name="filter_sort_desc" value="<?php echo $filter_sort_desc; ?>">
<fieldset class="container">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
    <td align="left" colspan="2">
    <?php
    $html->draw_button('back');
    if($add_page != '')
    {
        $show_add_link = check_link($add_link);
        if($show_add_link)
        {
            echo "&nbsp; &nbsp; <a id=\"top_add_link\" class=\"listview\" href=\"$add_page?filter_field_used=$enc_filter_field&filter_used=$enc_filter&filter_sort_asc=$enc_filter_sort_asc&filter_sort_desc=$enc_filter_sort_desc&page_from=$current_page\">Add new record</a>";
        }
    }

    if($csv_page != '')
    {
        echo "&nbsp; &nbsp; <a class=\"listview\" href=\"$csv_page\">Export data</a>";
    }

    if($report_page != '')
    {
        echo "&nbsp; &nbsp; <a class=\"listview\" href=\"$report_page\">Reporting</a>";
    }
    ?>
    <br><br>
    </td>
</tr>
<tr class="listViewBar">
    <td align="left">
    &nbsp; &nbsp; Filter:
    <?php
    $config_items = array();
    $config_values = array();
    foreach($arr_filter_field_labels as $label) $config_items[] = ucwords($label);
    $data = explode(',', $lst_filter_fields);
    foreach($data as $field) $config_values[] = trim($field);
    $config = array('items'=>$config_items,
                    'values'=>$config_values);

    $html->draw_select_field($config,'','filter_field',FALSE);
    echo '&nbsp;';
    $filter = stripslashes($filter);
    $html->draw_text_field('','filter',FALSE,'',FALSE,'onKeyPress="submitenter(this,event)"');
    echo '&nbsp;';
    $html->draw_button('GO'); ?>

    </td>
    <td align=right>

    <?php echo $pager->draw_paged_result('onKeyPress="submitenter(this,event)"'); ?>

    </td>
</tr>
<?php echo $pager->draw_nav_links($enc_filter, $enc_filter_field, $enc_filter_sort_asc, $enc_filter_sort_desc);?>
<tr>
    <td colspan="2">
    <hr>
    </td>
</tr>
</table>
<table width="100%" class="listView">
<tr class="listRowHead">
    <td>Operations</td>
    <?php
    foreach($arr_field_labels as $key=>$label)
    {


        echo '<td>' . $label . ' '
              .'<a class="listRowHead" href="?filter_sort_asc=' . $key . '&amp;'
                                           . 'filter=' . $enc_filter . '&amp;'
                                           . 'filter_field=' . $enc_filter_field . '">&#8593;</a>'
              .'<a class="listRowHead" href="?filter_sort_desc=' . $key . '&amp;'
                                           . 'filter=' . $enc_filter . '&amp;'
                                           . 'filter_field=' . $enc_filter_field . '">&#8595;</a></td>';
    }
    ?>
</tr>
