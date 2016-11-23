<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(xsrf_guard())
{
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);

    if($_POST['btnCancel'])
    {
        header("location: " . HOME_PAGE);
        exit();
    }

    if($_POST['btnSubmit'])
    {
        extract($_POST);

        if($errMsg=="")
        {
            //For large systems, default max execution time of PHP may not suffice (particularly on Windows).
            //Bump up max execution time if less than 3 minutes to be extremely safe
            //For further tweaks, dev will just tweak php.ini max_execution_time to suit his needs
            $limit  = ini_get('max_execution_time');
            if($limit < 180)
            {
                ini_set('max_execution_time', '180');
            }

            //******************
            //The magic is here!
            //******************

            //Set variables needed for file creations.
            //****GUIDE****
            //** $SCV2_path = full path to the SCV2 main directory in your htdocs / www directory
            //** $SCV2_core_path = full path to the SCV2 generator core files, which all Synergy projects require.
            //** $project_path = full path to the SCV2 projects directory (where all resulting project files are generated)
            //**                plus the name of the project as the subdirectory
            //** $project_core_path = the full path to the generated core files of each project; simply $project_path/Core/


            //Connection for main source file (this one).
            $d = connect_DB();

            $stmt = $d->prepare("SELECT Base_Directory FROM project WHERE Project_ID=:p_id");
            $stmt->bindValue(':p_id', $_SESSION['Project_ID']);

            if($result = $stmt->execute())
            {
                $data  = $result->fetchArray();
                extract($data);
                $SCV2_path = substr(FULLPATH_CORE,0,-5); //"-5" = remove "Core/" from FULLPATH_CORE
                $SCV2_core_path = $SCV2_path . 'Generator/Core_Files/';

                //Check if "Generator/Projects" folder is writable
                clearstatcache();
                if(is_writable($SCV2_path . TARGET_DIRECTORY))
                {
                    $SCV2_core_path = $SCV2_path . 'Generator/Core_Files/';

                    //Creating the base directory...
                    $project_path = $SCV2_path . TARGET_DIRECTORY . $Base_Directory . '/';

                    //Note that it may be necessary to create multiple, nested directories,
                    //depending on what the user specified as the project's base directory.
                    $subdirectory = explode ("/", $Base_Directory);
                    $subdirectory_count = count($subdirectory);
                    $current_directory = $SCV2_path . TARGET_DIRECTORY;

                    for($a=0;$a<$subdirectory_count;++$a)
                    {
                        $current_directory .= $subdirectory[$a] . '/';

                        //Delete existing old project, if any.
                        if(file_exists($current_directory)) obliterate_dir($current_directory);

                        mkdir(substr($current_directory,0,-1),0777);
                        chmod(substr($current_directory,0,-1),0777);
                    }

                    //Creating the Core folder inside the base directory...
                    $project_core_path = $project_path . "core/";
                    if(!file_exists($project_core_path))
                    {
                        mkdir(substr($project_core_path,0,-1), 0777);
                        chmod($project_core_path, 0777);
                    }

                    //Creating the Subclasses folder inside the Core folder inside the base directory...
                    $subclass_path = $project_path . 'core/subclasses/';
                    if(!file_exists($subclass_path))
                    {
                        mkdir(substr($subclass_path,0,-1),0777);
                        chmod(substr($subclass_path,0,-1),0777);
                    }

                    $webroot = substr($SCV2_path,0,-7); //"-7" = remove "cobalt/" from the path to get the webroot
                    $Fullpath_New_System = $webroot . $Base_Directory;

                    $path_array = array('Fullpath_New_System' => $Fullpath_New_System,
                                        'SCV2_path' => $SCV2_path,
                                        'SCV2_core_path' => $SCV2_core_path,
                                        'project_path' => $project_path,
                                        'project_core_path' => $project_core_path,
                                        'Base_Directory' => $Base_Directory);
                }
                else
                {
                    $errMsg = 'The "Projects" directory (cobalt/Generator/Projects) is not writeable. <br />Please make this directory writeable to proceed.';
                    drawHeader();
                    drawPageTitle("System Generation Failed",
                                  $errMsg . '<br><input type=submit name=BACK value=BACK>','error');
                    drawFooter();
                    die();
                }
            }
            $stmt->close();

            //Startup tasks
            //Load all functions we need for a minimal system generation (user-defined modules only, no standard/admin apps)
            require_once $SCV2_path . 'Generator/Scripts/Create_Modules.php';
            require_once $SCV2_path . 'Generator/Scripts/Create_Class.php';
            require_once $SCV2_path . 'Generator/Scripts/Create_SST_Scripts.php';
            require_once $SCV2_path . 'Generator/Scripts/Create_Doc_Scripts.php';
            require_once $SCV2_path . 'Generator/Scripts/Create_Directory_Index.php';
            require_once $SCV2_path . 'Generator/Scripts/Generic/Standard_Header.php';
            require_once $SCV2_path . 'Generator/Scripts/Generic/Standard_Footer.php';
            //Create the main path file located in the base directory
            $pathfile_content=<<<EOD
<?php
define('FULLPATH_BASE', dirname(__FILE__) . '/');
\$path_to_core = FULLPATH_BASE . 'core';
\$require = \$path_to_core . '/cobalt_core.php';
\$include_path = '.' . PATH_SEPARATOR . \$path_to_core;
set_include_path(\$include_path);
require \$require;
unset(\$require, \$path_to_core, \$include_path);
EOD;

            $filename = $project_path . '/path.php';
            if(file_exists($filename)) unlink($filename);
            $newfile=fopen($filename,"ab");
            fwrite($newfile, $pathfile_content);
            chmod($filename, 0777);

            //Create directory index in the base directory
            createDirectoryIndex($project_path);


            //Step 1: If chosen by the user, generate the core files, standard app components and admin components.
            init_var($GenerateFiles);
            if($GenerateFiles=='YES PLEASE')
            {
                //Load additional functions needed for creating the standard application components and system admin components.
                require_once $SCV2_path . 'Generator/Scripts/Create_Application_Components.php';
                createStdAppComponents($path_array);
            }

            //Step 2: Loop through each element of $classFile, generate those that were left checked.
            init_var($classFile);
            if(is_array($classFile))
            {
                //For use in DD creation specifically for SQL-based drop-down lists, we need to know how many databases we have
                $stmt = $d->prepare("SELECT DISTINCT `Database` FROM `database_connection` WHERE Project_ID = :p_id");
                $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
                if($result = $stmt->execute())
                {
                    $num_databases = 0;
                    while($result->fetchArray())
                    {
                        ++$num_databases;
                    }
                }
                $stmt->close();
                //foreach($classFile as $class) createClass($class, $subclass_path, $mysqli_con1, $mysqli_con2, $mysqli_con3, $num_databases);
                foreach($classFile as $class) createClass($class, $subclass_path, $num_databases);
            }

            //Before creating the modules, we also should delete the user links query file for the access control list if it
            //already exists, because that means that is from a previous generation. We most certainly don't want the old entries.
            $filename = $project_path . '/user_links.sql';
            if(file_exists($filename)) unlink($filename);

            //Now that any existing ACL query file is deleted, we start a new (empty) one
            $ACL_Query='';
            $filename = $project_path . '/user_links.sql';
            $newfile=fopen($filename,"ab");
            fwrite($newfile, $ACL_Query);
            chmod($filename, 0777);

            //Step 3: Loop through each element of $tableModules, generate everything that was left checked.
            $numModules = 0; //Just to count how many module permissions are needed; will be used in ACL SQL file generation.

            init_var($tableModules);
            if(!is_array($tableModules)) $tableModules=array();
            $arr_table_of_content_links = array();
            foreach($tableModules as $module)
            {
                $stmt = $d->prepare("SELECT Page_ID FROM table_pages WHERE Table_ID=:t_id");
                $stmt->bindValue(':t_id', $module);
                $arr_page_data = array();
                if($result = $stmt->execute())
                {
                    while($data = $result->fetchArray())
                    {
                        $arr_page_data[] = $data;
                    }
                }

                foreach($arr_page_data as $data)
                {
                    extract($data);
                    $module_permission_count = createModule($module, $Page_ID, $path_array);
                    $numModules += $module_permission_count;
                }

                //If standard app components were chosen, we also generate SST and Doc modules.
                if($GenerateFiles=='YES PLEASE')
                {
                    //SST modules creation - Cobalt's Super Sonic Testing feature for automated functional tests.
                    createSSTScripts($module, $path_array);

                    //Documentation creation - Cobalt's built-in auto doc feature.
                    $arr_table_of_content_links[] = createDocScripts($module, $path_array);
                }
            }

            //Still only if standard app component generation was chosen
            if($GenerateFiles=='YES PLEASE')
            {
                //Documentation creation - this will create the correct table of contents page according to the produced doc pages
                createDocContentsPage($arr_table_of_content_links, $path_array);
            }

            //Let's create the SQL to complete the Super User role, then apply the role
            $root_permissions='';
            for($a=0; $a < $numModules; ++$a)
            {
                //FIXME: make this magic number (37 right now) into a dynamic computation of some sort to get rid of it - or at least make it a setting somewhere
                $link = $a + 37; //37 (or whatever the number here becomes) refers to the number of pre-defined links (pre-built components)
                $root_permissions .= "INSERT INTO `user_role_links` (`role_id`, `link_id`) VALUES ('1', '$link');" . "\r\n";
            }
            $root_permissions .= "INSERT `user_passport` SELECT 'root', `link_id` FROM user_role_links WHERE role_id='1'";
            $filename = $project_path . '/root_permissions.sql';
            if(file_exists($filename)) unlink($filename);
            $newfile=fopen($filename,"ab");
            fwrite($newfile, $root_permissions);
            chmod($filename, 0777);

            if($GenerateFiles=='YES PLEASE')
            {
                //Create a 'new_system.sql' file, simply
                //cruizer_base.sql + user_links.sql + root_permissions.sql
                $content = file_get_contents($project_path. '/cruizer_base.sql');
                $content.= file_get_contents($project_path. '/user_links.sql');
                $content.= file_get_contents($project_path. '/root_permissions.sql');
                $filename = $project_path . '/new_system.sql';
                if(file_exists($filename)) unlink($filename);
                $newfile=fopen($filename,"ab");
                fwrite($newfile, $content);
                chmod($filename, 0777);
            }

            //Woohoo! We're done here.
            //Now, just draw a success screen.
            drawHeader();
            drawPageTitle("System Generation Completed Successfully",
                          '<br>Your system generation request was a complete and resounding success, zero errors were encountered
                          <br><br>
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="submit" name="BACK" value="BACK">','system');
            drawFooter();
            die();
        }
    }
}
else
{
    $Data_Abstraction = TRUE;
    $HTML_Class = TRUE;
    $Validation_Class = TRUE;
    $Character_Set_Class = TRUE;
    $Paged_Result_Class = TRUE;
}

drawHeader();
drawPageTitle('Generate Project','All checked files will be generated when you click the "GENERATE!" button. <br> You may uncheck files as necessary.','info');
?>

<script language="JavaScript" type="text/JavaScript">
function checkAll(field)
{
    if(field.length > 1)
    {
        for (i = 0; i < field.length; i++)
            field[i].checked = true ;
    }
    else field.checked = true;
}
function uncheckAll(field)
{
    if(field.length > 1)
    {
        for (i = 0; i < field.length; i++)
            field[i].checked = false ;
    }
    else field.checked = false;
}
</script>

<div class="container_mid_huge2">
<fieldset class="top">
CODE GENERATOR - Create Project Files
</fieldset>

<fieldset class="middle">
<table class="listView" border="1" width="900">
<?php
echo '<tr class="listRowHead">'
        .'<td width="320"> Table </td>'
        .'<td width="290"> Subclass </td>'
        .'<td width="290"> Modules </td>'
    .'</tr>'
    .'<tr class="listRowOdd"><td>&nbsp;</td>
          <td align=center>
              <input type=button name=CHECK value="CHECK ALL" class=button1 onClick=\'checkAll(checkfield_s);\'>
              <input type=button name=UNCHECK value="UNCHECK ALL" class=button1 onClick=\'uncheckAll(checkfield_s);\'>
          </td>
          <td align=center>
              <input type=button name=CHECK value="CHECK ALL" class=button1 onClick=\'checkAll(checkfield_m);\'>
              <input type=button name=UNCHECK value="UNCHECK ALL" class=button1 onClick=\'uncheckAll(checkfield_m);\'>
          </td>
      </tr>';


$d = connect_DB();
$stmt = $d->prepare("SELECT a.Table_ID, a.Table_Name
                        FROM \"table\" a, database_connection b
                        WHERE a.Project_ID=:p_id AND
                              a.DB_Connection_ID = b.DB_Connection_ID
                        ORDER BY a.Table_Name");
$stmt->bindValue(':p_id',$_SESSION['Project_ID']);

if($result = $stmt->execute())
{
    $a=0;
    while($data = $result->fetchArray())
    {
        extract($data);
        if($a%2==0) $class='listRowEven';
        else $class='listRowOdd';
        echo '<tr class="'. $class . '">'
                .'<td>' . $Table_Name . '</td>'
                .'<td align=center> <input type=checkbox ID=checkfield_s name=classFile[' . $a . '] value="' . $Table_ID . '" checked> </td>'
                .'<td align=center> <input type=checkbox ID=checkfield_m name=tableModules[' . $a . '] value="' . $Table_ID . '" checked> </td>'
            .'</tr>';
        ++$a;
    }
}

if($a%2==0) $class='listRowEven';
else $class='listRowOdd';
echo '<tr class="' . $class . '">'
        .'<td colspan=2> Generate standard application components, <br> core files, and system administration components </td>'
        .'<td align=center> <input type=checkbox ID=checkfield_m name=GenerateFiles value="YES PLEASE" checked>  </td>'
    .'</tr>';
?>
</table>
</fieldset>

<fieldset class="bottom">
<?php
drawSubmitCancel(FALSE,1,'btnSubmit','GENERATE!');
?>
</fieldset>
</div>
<?php
drawFooter();
?>
