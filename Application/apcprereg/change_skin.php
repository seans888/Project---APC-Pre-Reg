<?php
require_once 'path.php';
init_cobalt('ALLOW_ALL',FALSE);

if(xsrf_guard())
{
    init_var($_POST['btn_cancel']);
    init_var($_POST['btn_submit']);

    if($_POST['btn_cancel'])
    {
        redirect(HOME_PAGE);
    }

    if($_POST['btn_submit'])
    {
        $skin_id = quote_smart($_POST['skin_id']);

        $data_con = new data_abstraction;
        $data_con->set_query_type('UPDATE');
        $data_con->set_table('user');
        $data_con->set_update("skin_id='$skin_id'");
        $data_con->set_where("username='" . quote_smart($_SESSION['user']) . "'");
        $data_con->make_query();
        $data_con->close_db();

        //If the update went ok, we should update the session variables for this.
        $data_con = new data_abstraction;
        $data_con->set_fields('skin_name, header, footer, master_css, colors_css, fonts_css, override_css, icon_set');
        $data_con->set_table('system_skins');
        $data_con->set_where("skin_id='$skin_id'");
        $result = $data_con->make_query()->result;
        $numrows = $data_con->num_rows;
        $data_con->close_db();

        if($numrows==1)
        {
            $data = $result->fetch_assoc();
            extract($data);
            $_SESSION['header']       = $header;
            $_SESSION['footer']       = $footer;
            $_SESSION['skin']         = $skin_name;
            $_SESSION['master_css']   = $master_css;
            $_SESSION['colors_css']   = $colors_css;
            $_SESSION['fonts_css']    = $fonts_css;
            $_SESSION['override_css'] = $override_css;
            $_SESSION['icon_set']     = $icon_set;
            if(trim($_SESSION['icon_set'] == ''))
            {
                $_SESSION['icon_set'] = 'cobalt';
            }
        }

        $redraw=TRUE;
    }
}

$html = new html;
$html->draw_header('Change Skin',$message);

$html->display_info('Changing the System Skin does not affect functionality.<br>All changes are merely aesthetic.');

echo '<div class="container">
      <fieldset class="container_invisible">
    <fieldset class="top"> Skin (UI Theme) Management
    </fieldset>
    <fieldset class="middle">
    <table class="input_form">';
echo '<tr><td class="label">System Skin:</td><td> <select name="skin_id">';

$data_con = new data_abstraction;
$data_con->set_fields('skin_id AS new_skin_id, skin_name');
$data_con->set_table('system_skins');
$data_con->set_order('skin_name');
$result = $data_con->make_query()->result;
$numrows = $data_con->num_rows;
if($data_con->error) echo die($data_con->error);
$data_con->close_db();

for($a=0;$a<$numrows;$a++)
{
    $data = $result->fetch_assoc();
    extract($data);
    $selected='';
    if($skin_name==$_SESSION['skin']) $selected='selected';
    echo "<option value='$new_skin_id' $selected> $skin_name </option>";
}
echo '</select></td></tr>';
echo '</table>';
echo '</fieldset>
    <fieldset class="bottom">';

$html->draw_submit_cancel();

echo '</fieldset>';
echo '</fieldset>';
echo '</div>';

if(isset($redraw) && $redraw==TRUE)
{
?>
    <script>
    window.top.frames['header_frame'].location="header.php";
    window.top.frames['menu_frame'].location="menus.php";
    window.top.frames['content_frame'].location="change_skin.php";
    </script>
<?php
}

$html->draw_footer();
