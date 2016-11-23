<?php
if($show_edit_link)
{
    echo "&nbsp;&nbsp;<a href='role_permissions.php?filter_field_used=$enc_filter_field&filter_used=$enc_filter&filter_sort_asc=$enc_filter_sort_asc&filter_sort_desc=$enc_filter_sort_desc&page_from=$current_page&$pkey_string'>[Role&nbsp;Permissions]</a>";
    echo "&nbsp;&nbsp;<a href='role_permissions_cascade.php?filter_field_used=$enc_filter_field&filter_used=$enc_filter&filter_sort_asc=$enc_filter_sort_asc&filter_sort_desc=$enc_filter_sort_desc&page_from=$current_page&$pkey_string'>[Cascade&nbsp;Update]</a>";
}
?>
