<?php
require 'Core/SCV2_Core.php';
init_SCV2();

//**** COBALT SELF-CHECK ****************************************************************************
//Set display errors to on, so that if something is wrong (missing database, tables, extensions, etc)
//the user won't be left with just a blank page if his php.ini defaults have display errors = off
if (!ini_get('display_errors')) { ini_set('display_errors', '1'); }
set_error_handler('custom_error_handler');
$stop_exec = FALSE;

//Check if the TARGET_DIRECTORY is properly set as "Generator/Projects"
//This will only be wrong if maintainer (that's me) failed to revert to original setting after tinkering with the code generator
if(TARGET_DIRECTORY != 'Generator/Projects/')
{
    trigger_error('Incorrect TARGET_DIRECTORY', E_USER_ERROR);
    $stop_exec = TRUE;
}

//Check PHP version.
if(!defined('PHP_VERSION_ID'))
{
    $version = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
    define('PHP_MAJOR_VERSION', $version[0]);
    define('PHP_MINOR_VERSION', $version[1]);
    define('PHP_RELEASE_VERSION', substr($version[2],0,1));
}

if(PHP_VERSION_ID < 50300)
{
    trigger_error('Unsupported PHP Version', E_USER_ERROR);
    $stop_exec = TRUE;
}
//Check for required extensions
$has_mbstring = extension_loaded('mbstring');
$has_openssl  = extension_loaded('openssl');
$has_sqlite   = extension_loaded('sqlite3');

$module_error_message = 'MISSING EXTENSION: ';
if($has_mbstring == FALSE)
{
    trigger_error($module_error_message . 'mbstring', E_USER_ERROR);
    $stop_exec = TRUE;
}

if($has_openssl == FALSE)
{
    trigger_error($module_error_message . 'openssl', E_USER_ERROR);
    $stop_exec = TRUE;
}
if($has_sqlite == FALSE)
{
    trigger_error($module_error_message . 'SQLite3', E_USER_ERROR);
    $stop_exec = TRUE;
}

//Check if metadata folder (sqlite3 database directory) is readable and writable
$metadata_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'metadata';
$metadata_is_readable = is_readable($metadata_path);
$metadata_is_writable = is_writable($metadata_path);
if($metadata_is_readable == FALSE)
{
    trigger_error('Cobalt "metadata" directory is not readable (' . $metadata_path . ').', E_USER_ERROR);
    $stop_exec = TRUE;
}
if($metadata_is_writable == FALSE)
{
    trigger_error('Cobalt "metadata" directory is not writable (' . $metadata_path . ').', E_USER_ERROR);
    $stop_exec = TRUE;
}

if($stop_exec) exit();

//**********************
//Create Cobalt database (sqlite3)
$f = fopen('metadata/status',"rb");
$db_status = fread($f, 8);
fclose($f);
if($db_status=="Complete")
{
    //Everything's cool, no need to recreate database.
}
else
{
    $go_create = "make it so";
    require 'create_database.php';
}

//Test the connection to trigger an error now instead of later in the drop-down list in case
//something is wrong with the connection to the database.
connect_db();

//If the connection succeeds, then we test if all the Cobalt tables are available
cobalt_tables_self_check();


//After the self-check, go back to normal PHP error-handling.
restore_error_handler();
//**** END OF COBALT SELF-CHECK **************************************************************

if(xsrf_guard())
{
    init_var($ChooseProject);
    init_var($CreateProject);
    extract($_POST);

    if($ChooseProject)
    {
        init_var($Project);
        if($Project != '')
        {
            $_SESSION['Project_ID'] = $Project;
            $_SESSION['Project_Name'] = queryProjectName($Project);
            redirect("main.php");
        }
        else $errMsg = "You need to have a project stored in the repository in order to start working on it. <br>"
                     . "If there are no projects available, please start by creating a new project.";
    }
    elseif($CreateProject)
    {
        $errMsg = scriptCheckIfNull('Project Name', $Project_Name, 'Client', $Client_Name,
                                    'Description', $Project_Description, 'Base Directory', $Base_Directory);
        if($errMsg=="")
        {
            queryCreateNewProject($_POST);
            queryCreateStandardLists();
            redirect("main.php");
        }
    }
}

drawHeader(TRUE,TRUE,FALSE);
drawPageTitle("PROJECT", $errMsg, $msgType);
?>
<script type="text/javascript">
function submit_enter(my_field,e)
{
    var keypressed = (e.keyCode ? e.keyCode : e.which);

    if (keypressed == 13)
    {
        submit_button = document.getElementById('CreateProject');
        submit_button.click();
        e.preventDefault();
    }
}
</script>
<input type="hidden" id="form_activator" name="form_activator">
<div class="container_mid_large">
    <fieldset class="top">
        CHOOSE EXISTING PROJECT
    </fieldset>
    <fieldset class="middle">
        <table border="0" cellspacing="1">
        <tr>
            <td align="right" width="80"> Project: </td>
            <td>
                <?php
                init_var($Project);
                drawProjectChooser($Project);
                ?>
                &nbsp;
            </td>
        </table>
        </tr>
    </fieldset>
    <fieldset class="bottom">
        <input type=submit value="START" name=ChooseProject>
    </fieldset>
</div>

<div class="container_mid_large">

    <fieldset class="top">
        CREATE A NEW PROJECT
    </fieldset>
    <fieldset class="middle">
        <table border="0" width="100%" cellspacing="1">
        <tr>
            <td align=right width=150> Project Name: </td>
            <?php init_var($Project_Name); ?>
            <td><input type=text size=40 maxlength=50 name="Project_Name" value="<?php echo $Project_Name;?>" onKeyPress="submit_enter(this, event)"></td>
        </tr>
        <tr>
            <td align=right> Client: </td>
            <?php init_var($Client_Name); ?>
            <td><input type=text size=40 maxlength=50 name="Client_Name" value="<?php echo $Client_Name;?>" onKeyPress="submit_enter(this, event)"></td>
        </tr>
        <tr>
            <td align=right> Description: </td>
            <?php init_var($Project_Description); ?>
            <td><textarea name="Project_Description" rows="5" cols="38"><?php echo $Project_Description;?></textarea></td>
        </tr>
        <tr>
            <td align=right> Base Directory: </td>
            <?php init_var($Base_Directory); ?>
            <td><input type=text size=40 maxlength=50 name="Base_Directory" value="<?php echo $Base_Directory;?>" onKeyPress="submit_enter(this, event)"></td>
        </tr>
        </table>
    </fieldset>
    <fieldset class="bottom">
           <input type=submit value="CREATE NEW PROJECT" name=CreateProject id=CreateProject>
    </fieldset>
</div>


<?php drawFooter(); ?>
