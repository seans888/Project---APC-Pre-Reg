<?php
require 'path.php';
init_cobalt('ALLOW_ALL',FALSE);

function menuGroupWindowHeader($group)
{
    echo '<table width="180" class="listView">
          <tr class="listRowHead"><td>' . $group . '</td></tr>';
}

function menuGroupWindowFooter()
{
    echo "</table>";
}

require_once $_SESSION['header'];

$data_con = new data_abstraction;
$data_con->set_fields('a.link_id, a.descriptive_title, a.target, a.description, c.passport_group')
         ->set_table('user_links a, user_passport b, user_passport_groups c')
         ->set_where("a.link_id=b.link_id AND b.username='" . quote_smart($_SESSION['user']) . "' AND a.passport_group_id=c.passport_group_id AND a.show_in_tasklist='Yes' AND a.status='On'")
         ->set_order('c.priority DESC, c.passport_group, a.priority DESC, a.descriptive_title');
if($result = $data_con->make_query()->result)
{
    $menu_links = array();

    while($data = $result->fetch_row())
    {
        $menu_links[$data[4]]['link_id'][]     = $data[0];
        $menu_links[$data[4]]['title'][]       = $data[1];
        $menu_links[$data[4]]['target'][]      = $data[2];
        $menu_links[$data[4]]['description'][] = $data[3];
        unset($data);
    }
    $result->close();

    $current_group='';
    foreach($menu_links as $group => $link_info)
    {
        if($current_group=='')
        {
            $current_group = $group;
            menuGroupWindowHeader($group);
        }
        for($a=0; $a<count($link_info['title']); ++$a)
        {
            if($current_group!= $group)
            {
                menuGroupWindowFooter();
                menuGroupWindowHeader($group);
                $current_group = $group;
            }

            if($a%2==0) $class='listRowOdd';
            else $class='listRowEven';
            echo "<tr class=\"$class\"><td><a href='/" . BASE_DIRECTORY . "/{$link_info['target'][$a]}' target='content_frame' class='sidebar'> {$link_info['title'][$a]} </a></td></tr>";
        }
    }
    menuGroupWindowFooter();
}
else die("Fatal error: cannot retrieve modules");
?>
</body>
</html>
