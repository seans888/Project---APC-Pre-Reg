<?php
class base_paged_result
{
    var $total_records=0;
    var $records_per_page=0;
    var $total_pages=0;
    var $html_output='';
    var $current_page=0;
    var $offset=0;

    function __construct($total_records, $records_per_page)
    {
        $this->total_records = $total_records;
        $this->records_per_page = $records_per_page;
        $this->total_pages = ceil($total_records / $records_per_page);

        if($this->total_pages == 0) $this->total_pages = 1;
    }

    function draw_paged_result($javascript='')
    {
        $this->html_output = '';
        //If there is more than one page, show the pager
        if($this->total_pages > 1)
        {
            init_var($Result_Pager);
            $this->html_output .= "Page " . $this->current_page . " of " . $this->total_pages
                    . " | Go to page: <input type=\"text\" name=\"result_pager\" value=\"$Result_Pager\" size=\"2\" $javascript>"
                    . "<input type=\"submit\" name=\"pager_submit\" value=\"GO\">&nbsp;"
                    . "<input type=\"hidden\" name=\"current_page\" value=\"" . $this->current_page . "\">";
        }
        else
        {
            $this->html_output = "Page " . $this->current_page . " of " . $this->total_pages . '&nbsp;';
        }
        return $this->html_output;
    }

    function draw_nav_links($filter, $filter_field, $filter_sort_asc, $filter_sort_desc, $draw_table_tags=TRUE)
    {
        $this->html_output = '';

        //If there is more than one page, show navigators
        if($this->total_pages > 1)
        {
            if($draw_table_tags==TRUE)
            {
                $this->html_output = '<tr><td colspan="2"><hr></td></tr>
                                      <tr><td colspan="2" align="left">';
            }

            //Show "previous" only if we're not on page 1
            if($this->current_page > 1)
            {
                $prev_page = $this->current_page - 1;
                $this->html_output .= " <a class=\"listview\" href=\"" . $_SERVER['PHP_SELF']
                        . "?current_page=" . $prev_page . '&'
                        . "filter=" . $filter . '&'
                        . "filter_field=" . $filter_field . '&'
                        . "filter_sort_asc=" . $filter_sort_asc . '&'
                        . "filter_sort_desc=" . $filter_sort_desc
                        . "\">&lt;&lt;Previous Page</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            }
            else
            {
                $this->html_output .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            }

            //Show "next" only if we're not on the last page
            if($this->current_page < $this->total_pages)
            {
                $next_page = $this->current_page + 1;
                $this->html_output .= "<a class=\"listview\" href=\"" . $_SERVER['PHP_SELF']
                        . "?current_page=" . $next_page . '&'
                        . "filter=" . $filter . '&'
                        . "filter_field=" . $filter_field . '&'
                        . "filter_sort_asc=" . $filter_sort_asc . '&'
                        . "filter_sort_desc=" . $filter_sort_desc
                        . "\">Next Page&gt;&gt;</a> ";
            }
            else
            {
                $this->html_output .= '&nbsp;';
            }

            if($draw_table_tags==TRUE)
            {
                $this->html_output .= '</td></tr>';
            }
        }
        return $this->html_output;
    }

    function get_page_data($new_page, $current_page)
    {
        $new_page = intval($new_page);

        if($current_page > $this->total_pages) $current_page = $this->total_pages;

        if($new_page < 1)
        {
            if($current_page < 1) $new_page = 1;
            else $new_page = $current_page;
        }
        elseif($new_page > $this->total_pages) $new_page = $this->total_pages;

        $this->current_page = $new_page;
        $this->offset = ($new_page - 1) * $this->records_per_page;
    }
}