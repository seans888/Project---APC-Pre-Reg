<?php
require_once 'path.php';
init_cobalt('ALLOW_ALL',FALSE);

$html = new html;
$html->draw_header('Welcome to your Control Center', $message, $message_type, FALSE);

if(ENABLE_SIDEBAR)
{
    echo '
    <script>
    if (top.location == location)
    {
        window.location.replace("start.php");
    }
    </script>
    ';
}

if(DEBUG_MODE)
{
    $html->display_error('System is running in DEBUG MODE. Please contact the system administrator ASAP.');
}

$menu_links = '';
$data_con = new data_abstraction;
$data_con->set_fields('a.link_id, a.descriptive_title, a.target, a.description, c.passport_group, a.icon as link_icon, c.icon as `group_icon`');
$data_con->set_table('user_links a, user_passport b, user_passport_groups c');
$data_con->set_where("a.link_id=b.link_id AND b.username='" . quote_smart($_SESSION['user']) . "' AND a.passport_group_id=c.passport_group_id AND a.show_in_tasklist='Yes' AND a.status='On'");
$data_con->set_order('c.priority DESC, c.passport_group, a.priority DESC, a.descriptive_title');
if($result = $data_con->make_query()->result)
{
    while($data = $result->fetch_assoc())
    {
        extract($data);
        $menu_links[$passport_group]['title'][]       = $descriptive_title;
        $menu_links[$passport_group]['target'][]      = $target;
        $menu_links[$passport_group]['link_id'][]     = $link_id;
        $menu_links[$passport_group]['description'][] = $description;
        $menu_links[$passport_group]['link_icon'][]   = $link_icon;
        $menu_links[$passport_group]['group_icon'][]  = $group_icon;
    }
    $result->close();
}
else die("Fatal error: cannot retrieve modules");
unset($data_con);

if(isset($_SESSION['control_center_columns']) && $_SESSION['control_center_columns'] > 0)
{
    $columns_per_row = $_SESSION['control_center_columns'];
}
elseif(defined('CONTROL_CENTER_COLUMNS'))
{
    $columns_per_row = CONTROL_CENTER_COLUMNS;
}
else
{
    $columns_per_row = 3; //just an arbitrary default value based on historical Cobalt setting
}

$cntr_limit = $columns_per_row - 1; //subtraction needed due to 0-based counter
$column_width = (100 / $columns_per_row);
$current_group='';
$cntr=0;
if(is_array($menu_links))
{
    $target_frame='';
    if(ENABLE_SIDEBAR)
    {
        $target_frame = 'target="content_frame"';
    }

    echo '<fieldset class="container">';
    foreach($menu_links as $group => $link_info)
    {
        if($current_group=='')
        {
            $current_group = $group;
            menuGroupWindowHeader($group, $link_info['group_icon'][0]);
        }

        $num_links = count($link_info['title']);
        for($a=0; $a<$num_links; ++$a)
        {
            if($current_group!= $group)
            {
                echo '</tr></table></div>';
                $cntr=0;
                menuGroupWindowFooter();
                menuGroupWindowHeader($group, $link_info['group_icon'][$a]);
                $current_group = $group;
            }

            if($cntr==0)
            {
                echo '<div class="container_icons_CC">';
                echo '<table width = "100%">';
                echo '<tr>';
            }
            elseif($cntr > $cntr_limit)
            {
                echo '</tr></table>';
                echo '</div><div class="container_icons_CC">';
                echo '<table width = "100%">';
                echo '<tr>';
                $cntr = 0;
            }
            ++$cntr;
            echo '<td width="' . $column_width . '%" valign="top">
                    <a href="/' . BASE_DIRECTORY . '/' . $link_info['target'][$a] . '" $target_frame class="linkCC">
                        <img src="images/' . $_SESSION['icon_set'] . '/' . $link_info['link_icon'][$a] . '"><br>' . $link_info['title'][$a] . '
                    </a>
                  </td>';

        }

        //Just to be sure we have three columns before closing the table
        for($z = $cntr; $z<=$cntr_limit; ++$z)
        {
            echo '<td width="'. $column_width . '%"> &nbsp; </td>';
        }
    }
    echo '</tr></table></div>';
    echo '</fieldset>';
}
else
{
    $html->display_error("You have no Control Center privileges in your account. Please contact your system administrator.");
}

menuGroupWindowFooter();

function menuGroupWindowHeader($group, $icon)
{
    echo '<fieldset class="top">';
    echo "<img src='images/" . $_SESSION['icon_set'] . "/$icon'> $group";
    echo '</fieldset>';
    echo '<fieldset class="middle">';
}

function menuGroupWindowFooter()
{
    echo '</fieldset>';
}
$html->draw_footer();
