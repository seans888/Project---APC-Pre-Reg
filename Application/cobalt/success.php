<?php
require 'Core/SCV2_Core.php';
init_SCV2();

if(xsrf_guard())
{
    init_var($_POST['btnSubmit']);
    init_var($_POST['CreateDBConnections']);
    init_var($_POST['CreatePages']);
    init_var($_POST['CreatePredefinedLists']);
    init_var($_POST['CreateTables']);
    init_var($_POST['CreateUsers']);
    init_var($_POST['DefineTableFields']);
    init_var($_POST['DefineTableRelations']);
    init_var($_POST['ImportDBConnection']);

    if($_POST['btnSubmit'])
    {
        header("location: $_POST[location]");
        exit();
    }
    elseif($_POST['CreateDBConnections'])
    {
        header("location: /cobalt/Screens/CreateDBConnections.php");
        exit();
    }
    elseif($_POST['CreatePages'])
    {
        header("location: /cobalt/Screens/CreatePages.php");
        exit();
    }
    elseif($_POST['CreatePredefinedLists'])
    {
        header("location: /cobalt/Screens/CreatePredefinedLists.php");
        exit();
    }
    elseif($_POST['CreateTables'])
    {
        header("location: /cobalt/Screens/CreateTables.php");
        exit();
    }
    elseif($_POST['CreateUsers'])
    {
        header("location: /cobalt/Screens/CreateUsers.php");
        exit();
    }
    elseif($_POST['DefineTableFields'])
    {
        header("location: /cobalt/Screens/DefineTableFields.php");
        exit();
    }
    elseif($_POST['DefineTableRelations'])
    {
        header("location: /cobalt/Screens/DefineTableRelations.php");
        exit();
    }
    elseif($_POST['ImportDBConnection'])
    {
        $DB_ID = rawurlencode($_POST['DB_ID']);
        header("location: /cobalt/Screens/Import_Tables.php?DB_ID=$DB_ID");
        exit();
    }

    exit();
}

if(!isset($_GET['success_tag'])) header("location: " . HOME_PAGE);
else $success_tag = $_GET['success_tag'];

drawHeader();
drawPageTitle('Success');
echo '<div class="container_mid_prompt">';
echo '<div class="messageSystem">';
echo '<table width="100%">';
echo '<tr><td width="60"><img src="/cobalt/images/icons/ok.png"></td><td>';
echo '<table width="100%">';


if($success_tag=="CreateDBConnections")
{
    echo '<tr><td align="left">Cobalt has successfully added the database connection. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_DBConnections.php">'
        .'<input type=hidden name=DB_ID value="' . rawurldecode($_GET['DB_ID']) . '">';
    drawSuccessContinue('<input type=submit name=CreateDBConnections value="ADD ANOTHER CONNECTION" class=button1>',
                        '<input type=submit name=ImportDBConnection value="IMPORT TABLES" class=button1>');
}
elseif($success_tag=="CreatePages")
{
    echo '<tr><td align="left">Cobalt has successfully added the page. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_Pages.php">';
    drawSuccessContinue('<input type=submit name=CreatePages value="ADD ANOTHER PAGE" class=button1>');
}
elseif($success_tag=="CreatePredefinedLists")
{
    echo '<tr><td align="left">Cobalt has successfully added the predefined list. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_PredefinedLists.php">';
    drawSuccessContinue('<input type=submit name=CreatePredefinedLists value="ADD ANOTHER LIST" class=button1>');
}
elseif($success_tag=="CreateTables")
{
    echo '<tr><td align="left">Cobalt has successfully added the table. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_Tables.php">';
    drawSuccessContinue('<input type=submit name=CreateTables value="ADD ANOTHER TABLE" class=button1>');
}
elseif($success_tag=="CreateUsers")
{
    echo '<tr><td align="left">Cobalt has successfully added the new user. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_Users.php">';
    drawSuccessContinue('<input type=submit name=CreateUsers value="ADD ANOTHER USER" class=button1>');
}
elseif($success_tag=="DefineTableFields")
{
    echo '<tr><td align="left">Cobalt has successfully added the field information. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_TableFields.php">';
    drawSuccessContinue('<input type=submit name=DefineTableFields value="ADD ANOTHER FIELD" class=button1>');
}
elseif($success_tag=="DefineTableRelations")
{
    echo '<tr><td align="left">Cobalt has successfully added the relationship. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_TableRelations.php">';
    drawSuccessContinue('<input type=submit name=DefineTableRelations value="ADD ANOTHER RELATION" class=button1>');
}
elseif($success_tag=="DeleteDBConnections")
{
    echo '<tr><td align="left">Cobalt has successfully deleted the database connection. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_DBConnections.php">';
    drawSuccessContinue();
}
elseif($success_tag=="DeletePages")
{
    echo '<tr><td align="left">Cobalt has successfully deleted the page. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_Pages.php">';
    drawSuccessContinue();
}
elseif($success_tag=="DeletePredefinedLists")
{
    echo '<tr><td align="left">Cobalt has successfully deleted the predefined list. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_PredefinedLists.php">';
    drawSuccessContinue();
}
elseif($success_tag=="DeleteTables")
{
    echo '<tr><td align="left">Cobalt has successfully deleted the table. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_Tables.php">';
    drawSuccessContinue();
}
elseif($success_tag=="DeleteTableFields")
{
    echo '<tr><td align="left">Cobalt has successfully deleted the table field. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_TableFields.php">';
    drawSuccessContinue();
}
elseif($success_tag=="DeleteTableRelations")
{
    echo '<tr><td align="left">Cobalt has successfully deleted the relationship. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_TableRelations.php">';
    drawSuccessContinue();
}
elseif($success_tag=="DeleteUsers")
{
    echo '<tr><td align="left">Cobalt has successfully deleted the user. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_Users.php">';
    drawSuccessContinue();
}
elseif($success_tag=="EditDBConnections")
{
    echo '<tr><td align=left>Cobalt has successfully updated the database connection. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_DBConnections.php">';
    drawSuccessContinue();
}
elseif($success_tag=="EditPages")
{
    echo '<tr><td align="left">Cobalt has successfully updated the page. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_Pages.php">';
    drawSuccessContinue();
}
elseif($success_tag=="EditPredefinedLists")
{
    echo '<tr><td align="left">Cobalt has successfully updated the predefined list. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_PredefinedLists.php">';
    drawSuccessContinue();
}
elseif($success_tag=="EditProject")
{
    echo '<tr><td align="left">Cobalt has successfully updated the project information. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/main.php">';
    drawSuccessContinue();
}
elseif($success_tag=="EditTables")
{
    echo '<tr><td align="left">Cobalt has successfully updated the table. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_Tables.php">';
    drawSuccessContinue();
}
elseif($success_tag=="EditTableFields")
{
    echo '<tr><td align="left">Cobalt has successfully updated the table field. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_TableFields.php">';
    drawSuccessContinue();
}
elseif($success_tag=="EditTableRelations")
{
    echo '<tr><td align="left">Cobalt has successfully updated the relationship. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_TableRelations.php">';
    drawSuccessContinue();
}
elseif($success_tag=="EditUsers")
{
    echo '<tr><td align="left">Cobalt has successfully updated the user. </td></tr>'
        .'<input type=hidden name=location value="/cobalt/Screens/ListView_Users.php">';
    drawSuccessContinue();
}

echo '</table>';
echo '</div>';
echo '</div>';
drawFooter();


function drawSuccessContinue($extra1=null, $extra2=null)
{
    echo '</table>';
    echo '</td></tr>';
    echo '<tr><td colspan="2" align="center">';
    echo '<input type=submit name=btnSubmit value=CONTINUE class=button1>';
    if($extra1)
    {
        echo $extra1;
    }
    if($extra2)
    {
        echo $extra2;
    }
    echo '</td></tr>';
}

?>
