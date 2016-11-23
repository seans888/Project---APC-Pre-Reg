<?php
function createDocScripts($Table_ID, $path_array)
{
    $doc_path = $path_array['project_path'] . 'help/doc_pages/';

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
        $doc_subclass      = $class_name . '_doc';
        $doc_subclass_file = $doc_subclass . '.php';
        $doc_directory     = $doc_path . $class_name;
    }
    $stmt->close();

    //Doc Page
    $doc_script =<<<EOD
<?php
require 'path.php';
init_cobalt();
require 'subclasses/$doc_subclass_file';
\$obj_doc = new $doc_subclass;
\$obj_doc->auto_doc();
EOD;

    //Delete existing old project, if any.
    if(file_exists($doc_directory)) obliterate_dir($doc_directory);

    mkdir($doc_directory,0777);
    chmod($doc_directory,0777);
    createDirectoryIndex($doc_directory . '/');

    mkdir($doc_directory . '/images',0777);
    chmod($doc_directory . '/images',0777);
    createDirectoryIndex($doc_directory.'/images/');

    $filename = $doc_directory . '/' . $class_name . '.php';
    if(file_exists($filename)) unlink($filename);
    $newfile=fopen($filename,"ab");
    fwrite($newfile, $doc_script);
    fclose($newfile);
    chmod($filename, 0777);

    //We should return the doc subclass and the class name (array)
    return array($doc_subclass, $class_name);
}

function createDocContentsPage($arr_pages, $path_array)
{
    $toc_contents =<<<EOD
<?php
//List of modules (tables) for the table of contents to show
//The format is doc_subclass_name => doc_dir_name
\$content_pages = array(

EOD;

    foreach($arr_pages as $page_info)
    {
        $toc_contents .= "        '$page_info[0]'=>'$page_info[1]'," . "\r\n";
    }

    $toc_contents .= ');';

    $filename = $path_array['project_path'] . 'help/pages.php';
    if(file_exists($filename)) unlink($filename);
    $newfile=fopen($filename,"ab");
    fwrite($newfile, $toc_contents);
    fclose($newfile);
    chmod($filename, 0777);
}
