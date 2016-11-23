<table width="100%">
<?php echo $pager->draw_nav_links($enc_filter, $enc_filter_field, $enc_filter_sort_asc, $enc_filter_sort_desc);?>
<tr>
    <td colspan="2"><hr><br></td>
</tr>
</table>
<?php
$html->draw_button('back');
if($add_page != '')
{
    if($show_add_link)
    {
        echo "&nbsp; &nbsp; &nbsp;<a id=\"bottom_add_link\" class=\"listview\" href=\"$add_page?filter_field_used=$enc_filter_field&filter_used=$enc_filter&filter_sort_asc=$enc_filter_sort_asc&filter_sort_desc=$enc_filter_sort_desc&page_from=$current_page\">Add new record</a>";
    }
}
echo '</fieldset>';
$html->draw_footer();
