<?php
function createSSTScripts($Table_ID, $path_array)
{
    $sst_path = $path_array['project_path'] . 'sst/';

    $d = connect_DB();
    //Let's get the table name so we know what subclass to require later.
    //The table name is also the class name generated, so let's call it 'class_name' in the query.
    $stmt = $d->prepare("SELECT a.Table_Name AS class_name, b.Path_Filename AS List_View_Page
                         FROM \"table\" a, table_pages b, page c
                         WHERE a.Table_ID = :t_id AND
                                a.Table_ID = b.Table_ID AND
                                b.Page_ID = c.Page_ID AND
                                c.Description LIKE 'List View%'");
    $stmt->bindValue(':t_id', $Table_ID);
    if($result = $stmt->execute())
    {
        $data = $result->fetchArray();
        extract($data);
        $sst_subclass      = $class_name . '_sst';
        $sst_subclass_file = $sst_subclass . '.php';
    }
    $stmt->close();

    $modules_directory   = 'modules/';
    $location_add        = '';
    $location_edit       = '';
    $location_delete     = '';
    $location_detailview = '';
    //Let's get the active pages and path&filenames for the table.
    $stmt = $d->prepare("SELECT b.Path_Filename, c.Page_Name
                         FROM \"table\" a, table_pages b, page c
                         WHERE a.Table_ID = :t_id AND
                                a.Table_ID = b.Table_ID AND
                                b.Page_ID = c.Page_ID AND
                                c.Page_Name IN ('Add1','Edit1','Delete1','DetailView1')"); //we only care about standard view, add, edit and delete for testing
    $stmt->bindValue(':t_id', $Table_ID);
    if($result = $stmt->execute())
    {
        while($data = $result->fetchArray())
        {
            extract($data);
            if($Page_Name == 'Add1')
            {
                $location_add =  $modules_directory . $Path_Filename;
            }
            elseif($Page_Name == 'Edit1')
            {
                $location_edit = $modules_directory . $Path_Filename;
            }
            elseif($Page_Name == 'Delete1')
            {
                $location_delete = $modules_directory . $Path_Filename;
            }
            elseif($Page_Name == 'DetailView1')
            {
                $location_detailview = $modules_directory . $Path_Filename;
            }
        }
    }
    $stmt->close();


    //FIXME: In production-grade version, this should really check actual page generators instead of just assuming add/edit/del
    //Create the "pre" (automation) scripts for add, edit, delete
    $sst_script_add    = $sst_subclass . '_add.php';
    $sst_script_edit   = $sst_subclass . '_edit.php';
    $sst_script_delete = $sst_subclass . '_delete.php';
    $sst_script_detailview = $sst_subclass . '_detailview.php';

    //ADD & EDIT
    $sst_script =<<<EOD
<?php
require 'subclasses/$sst_subclass_file';
\$sst = new $sst_subclass;
\$sst->auto_test();
\$sst_script = \$sst->script;
EOD;
    $filename = $sst_path . 'pre/' . $sst_script_add;
    if(file_exists($filename)) unlink($filename);
    $newfile=fopen($filename,"ab");
    fwrite($newfile, $sst_script);
    fclose($newfile);
    chmod($filename, 0777);

    $filename = $sst_path . 'pre/' . $sst_script_edit;
    if(file_exists($filename)) unlink($filename);
    $newfile=fopen($filename,"ab");
    fwrite($newfile, $sst_script);
    fclose($newfile);
    chmod($filename, 0777);

    //DELETE
    $sst_script =<<<EOD
<?php
require 'subclasses/$sst_subclass_file';
\$sst = new $sst_subclass;
\$sst->auto_test('delete');
\$sst_script = \$sst->script;
EOD;
    $filename = $sst_path . 'pre/' . $sst_script_delete;
    if(file_exists($filename)) unlink($filename);
    $newfile=fopen($filename,"ab");
    fwrite($newfile, $sst_script);
    fclose($newfile);
    chmod($filename, 0777);

    //DETAIL_VIEW
    $sst_script =<<<EOD
<?php
require 'subclasses/$sst_subclass_file';
\$sst = new $sst_subclass;
\$sst->auto_test('detail_view');
\$sst_script = \$sst->script;
EOD;
    $filename = $sst_path . 'pre/' . $sst_script_detailview;
    if(file_exists($filename)) unlink($filename);
    $newfile=fopen($filename,"ab");
    fwrite($newfile, $sst_script);
    fclose($newfile);
    chmod($filename, 0777);


    //************************************************
    //Create the config scripts for add, edit, delete

    //ADD CONFIG
    $sst_script =<<<EOD
<?php
\$config = array(
                ['location'=>'$location_add',
                'pre'=>'$sst_script_add',
                'post'=>''],
               );

\$_SESSION['sst']['tasks'] = \$config;
EOD;
    $filename = $sst_path . 'config/' . $sst_script_add;
    if(file_exists($filename)) unlink($filename);
    $newfile=fopen($filename,"ab");
    fwrite($newfile, $sst_script);
    fclose($newfile);
    chmod($filename, 0777);



    //EDIT CONFIG
    $sst_script =<<<EOD
<?php
\$config = array(
                ['location'=>'$location_edit',
                'pre'=>'$sst_script_edit',
                'post'=>''],
               );

\$_SESSION['sst']['tasks'] = \$config;
EOD;
    $filename = $sst_path . 'config/' . $sst_script_edit;
    if(file_exists($filename)) unlink($filename);
    $newfile=fopen($filename,"ab");
    fwrite($newfile, $sst_script);
    fclose($newfile);
    chmod($filename, 0777);


    //DEL CONFIG
    $sst_script =<<<EOD
<?php
\$config = array(
                ['location'=>'$location_delete',
                'pre'=>'$sst_script_delete',
                'post'=>''],
               );

\$_SESSION['sst']['tasks'] = \$config;
EOD;
    $filename = $sst_path . 'config/' . $sst_script_delete;
    if(file_exists($filename)) unlink($filename);
    $newfile=fopen($filename,"ab");
    fwrite($newfile, $sst_script);
    fclose($newfile);
    chmod($filename, 0777);

    //DETAILVIEW CONFIG
    $sst_script =<<<EOD
<?php
\$config = array(
                ['location'=>'$location_detailview',
                'pre'=>'$sst_script_detailview',
                'post'=>''],
               );

\$_SESSION['sst']['tasks'] = \$config;
EOD;
    $filename = $sst_path . 'config/' . $sst_script_detailview;
    if(file_exists($filename)) unlink($filename);
    $newfile=fopen($filename,"ab");
    fwrite($newfile, $sst_script);
    fclose($newfile);
    chmod($filename, 0777);
}
