<?php

//This file creates the module for each table page submitted.

function createModule($Table_ID, $Page_ID, $path_array)
{
    $module_link_name='';
    extract($path_array);

    $d = connect_DB();

    $stmt = $d->prepare("SELECT Base_Directory FROM project WHERE Project_ID=:p_id");
    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
    if($result=$stmt->execute())
    {
        $data = $result->fetchArray();
        $Base_Directory = $data['Base_Directory'];
    }
    $stmt->close();

    $stmt = $d->prepare("SELECT b.Generator, a.Path_Filename
                            FROM table_pages a, page b
                            WHERE a.Table_ID = '$Table_ID' AND a.Page_ID='$Page_ID' AND a.Page_ID=b.Page_ID");
    $stmt->bindValue(':t_id', $Table_ID);
    $stmt->bindValue(':p_id', $Page_ID);
    if($result=$stmt->execute())
    {
        $data = $result->fetchArray();
        extract($data);
        $Path_Filename = 'modules/' . $Path_Filename;
    }
    $stmt->close();


    $module_content=''; //This is the variable that will contain all the module text (everything which will be written to the file).

    //This is where module "sorcery" happens, depending on the "table page" the user chose.
    //First, let's get the field information (deja vu!) for this table.

    $stmt = $d->prepare("SELECT Field_ID, Field_Name, Data_Type, Length, Attribute, Control_Type, Label, In_Listview
                            FROM table_fields WHERE Table_ID=:t_id");
    $stmt->bindValue(':t_id', $Table_ID);

    $field = array(); //We'll store all field information here, so we can reuse the information without having to re-query
    if($result = $stmt->execute())
    {
        while($data = $result->fetchArray())
        {
            extract($data);
            $field[] = array('Field_ID'=>"$Field_ID",
                             'Field_Name'=>"$Field_Name",
                             'Data_Type'=>"$Data_Type",
                             'Length'=>"$Length",
                             'Attribute'=>"$Attribute",
                             'Control_Type'=>"$Control_Type",
                             'Label'=>"$Label",
                             'In_Listview'=>"$In_Listview");
        }
    }
    $stmt->close();

    //Let's get the table name so we know what subclass to require later.
    //The table name is also the class name generated, so let's call it 'class_name' in the query.
    //Additionally, let's get the name of the database that this table belongs to because this information
    //will be used by the listview module if there is a relationship to other tables.
    $stmt = $d->prepare("SELECT a.Table_Name AS class_name, b.Path_Filename AS List_View_Page, d.Database AS DB_Name
                         FROM \"table\" a, table_pages b, page c, database_connection d
                         WHERE a.Table_ID=:t_id AND
                                a.Table_ID=b.Table_ID AND
                                b.Page_ID=c.Page_ID AND
                                c.Description LIKE 'List View%' AND
                                a.DB_Connection_ID = d.DB_Connection_ID");
    $stmt->bindValue(':t_id', $Table_ID);
    if($result = $stmt->execute())
    {
        $data = $result->fetchArray();
        extract($data);
        $object_name = 'dbh_' . $class_name; //to be used by create_form_data component
        $dbh_name = '$' . $object_name; //name of instantiated data abstraction subclass.
        $class_file = $class_name . '.php';
        $html_subclass_name = $class_name . '_html';
        $html_subclass_file = $class_name . '_html.php';
        $List_View_Page = basename($List_View_Page);
    }
    $stmt->close();


    //For the ACL query generation later on, we need the module link name. This will depend on the generator file.
    //FIXME: how can this handle custom pages?
    //FIXME: this bug tagged as BUG ID: 20120420A
    if($Generator=="Add1.php") $module_link_name = 'Add_' . $class_name;
    elseif($Generator=="Delete1.php") $module_link_name = 'Delete_' . $class_name;
    elseif($Generator=="Edit1.php") $module_link_name = 'Edit_' . $class_name;
    elseif($Generator=="DetailView1.php") $module_link_name = 'View_' . $class_name;
    elseif($Generator=="CSVExport1.php") $module_link_name = 'View_' . $class_name;
    elseif($Generator=="ReporterInterface1.php") $module_link_name = 'View_' . $class_name;
    elseif($Generator=="ReporterResult1.php") $module_link_name = 'View_' . $class_name;
    elseif($Generator=="ReporterResultPDF1.php") $module_link_name = 'View_' . $class_name;
    elseif($Generator=="ListView1.php")
    {
        $module_link_name = 'View_' . $class_name;

        //'List View' modules need a link to their 'Add' module.
        //First, we set the name of their add module that will be displayed:
        //UPDATE: don't bother with the actual table name, just set to "Add new record".
        //$add_module_display_name = 'Add new ' . $class_name;
        //$add_module_display_name = str_replace('_',' ',$add_module_display_name);
        $add_module_display_name = 'Add new record';

        //Now we need the link name of the add module, so we can check if the user
        //has the necessary permission to access the add module before displaying the
        //link to it (in other words, this serves as the passport tag).
        $add_module_link_name = 'Add ' . $class_name;
        $add_module_link_name = str_replace('_',' ',$add_module_link_name);

        //Similar to above but for the view permission,needed by the CSV exporter
        $view_module_link_name = 'View ' . $class_name;
        $view_module_link_name = str_replace('_',' ',$view_module_link_name);

        //Now we get the path and filename of the add module.

        $stmt = $d->prepare("SELECT b.Path_Filename AS Add_Module_Path
                             FROM \"table\" a, table_pages b, page c
                             WHERE a.Table_ID=:t_id AND
                                   a.Table_ID=b.Table_ID AND
                                   b.Page_ID=c.Page_ID AND
                                   c.Generator LIKE 'Add%'");
        $stmt->bindValue(':t_id', $Table_ID);
        $result = $stmt->execute();
        $data = $result->fetchArray();
        $stmt->close();
        extract($data);
        $add_module_link = basename($Add_Module_Path);

        //We also need the name of their Edit and Delete modules.
        //This is actually to serve as a passport tag, so the List View module
        //can check if the user is allowed to do edit and/or delete operations.
        $edit_module_link_name = 'Edit '. $class_name;
        $edit_module_link_name = str_replace('_',' ',$edit_module_link_name);
        $delete_module_link_name = 'Delete ' . $class_name;
        $delete_module_link_name = str_replace('_',' ',$delete_module_link_name);
    }

    //Change all underscores into spaces so the module name looks better.
    $module_link_name = str_replace('_',' ',$module_link_name);

    //For the descriptive title, change "View X" to just "X"
    if(substr($module_link_name, 0, 4)=='View')
    {
        $module_desc_title = substr($module_link_name, 5);
    }
    else
    {
        $module_desc_title = $module_link_name;
    }
    $module_desc_title = ucwords($module_desc_title);

    $module_content = createStandardHeader("'$module_link_name'");

    //Require the needed generator file.
    require $SCV2_path . 'Generator/Scripts/Pages/' . $Generator;
    $module_content .= $script_content;

    if($Generator=="ListView1.php"
    || $Generator=="ReporterInterface1.php"
    || $Generator=="ReporterResult1.php"
    || $Generator=="ReporterResultPDF1.php")
    {
        //no need for footer.
        //FIXME: This determination should be data in the page generator table per record
    }
    else
    {
        $module_content .= createStandardFooter();
    }

    //Create the file (initially empty, of course) then write to it.
    //Note that it may be necessary to create multiple directories (actually, nested subdirectories) first
    //before creating the actual file, depending on what the user specified in $Path_Filename.
    $subdirectory = explode ("/", $Path_Filename); //So we can get the subdirectories we might need to create.
    $subdirectory_count = count($subdirectory) - 1; //We subtracted one because the last element is not a subdirectory;

    //We'll need this later when checking the directories (possibly recursively):
    $current_directory = $project_path;

    for($a=0;$a<$subdirectory_count;$a++)
    {
        $current_directory .= $subdirectory[$a] . '/';

        //For each subdirectory, check if it exists. If it doesn't exist, create it.
        if(!file_exists($current_directory))
        {
            mkdir(substr($current_directory,0,-1),0777);
            chmod(substr($current_directory,0,-1),0777);
            createDirectoryIndex($current_directory);
        }
    }

    $filename = $project_path . $Path_Filename;
    if(file_exists($filename)) unlink($filename);
    $newfile=fopen($filename,"ab");
    fwrite($newfile, $module_content);
    fclose($newfile);
    chmod($filename, 0777);

    //Helper pages. Some page generators also need to write additional files beyond the main one
    if(isset($helper_file_name) && is_array($helper_file_name))
    {
        //Get directory of main file - helper pages will be in the same directory
        $dir = dirname($filename);

        foreach($helper_file_name as $file)
        {
            $filename = $dir . '/'. $file;
            if(file_exists($filename))
            {
                //Skip - this means a similar helper page was already created by a previous page generator.
                //Several page generators may share dependencies on same helper pages, so this is expected to happen
            }
            else
            {
                $newfile=fopen($filename,"ab");
                fwrite($newfile, $helper_script[0]);
                fclose($newfile);
                chmod($filename, 0777);
            }
        }
    }


    //Now we just have to add a line to the SQL file that will create the access control list entry for this module we just generated.
    //The exception is for DetailView modules and CSV modules, since their ACL tags simply follow the ListView entry.
    //Newly added Reporter modules are also exempted from this; they also follow the ListView entry.
    //FIXME: how can this handle custom pages?
    //FIXME: this bug tagged as BUG ID: 20120420A

    if($Generator!='DetailView1.php' && $Generator!='CSVExport1.php' &&
       $Generator!='ReporterInterface1.php' && $Generator!='ReporterResult1.php' &&
       $Generator!='ReporterResultPDF1.php')
    {
        $module_target_path = $Path_Filename;

        //In the meantime, all other access control values are just default values; perhaps later we can allow users to indicate them too.
        $ACL_Query =<<<EOD
INSERT INTO `user_links`(link_id, name, target, descriptive_title, description, passport_group_id, show_in_tasklist, `status`, icon) VALUES(null,'$module_link_name', '$module_target_path', '$module_desc_title','','1','$show_in_tasklist','On','form3.png');

EOD;

        $filename = $project_path . '/user_links.sql';
        $newfile=fopen($filename,"ab");
        fwrite($newfile, $ACL_Query);
        fclose($newfile);
        chmod($filename, 0777);
    }

    //Note: $module_permission_count is set by the generator page
    return $module_permission_count;
}
