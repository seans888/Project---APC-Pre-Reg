<?php
function createDirectoryIndex($current_directory)
{
    $index_content = createStandardHeader("'ALLOW_ALL'");
    $index_content.=<<<EOD

redirect(INDEX_TARGET);
EOD;

    $filename = $current_directory . 'index.php';
    if(file_exists($filename)) unlink($filename);
    $newfile=fopen($filename,"ab");
    fwrite($newfile, $index_content);
    fclose($newfile);
    chmod($filename, 0777);

    createPathFile($current_directory);
}

//This function will create a path file if it detects the current directory is a subdirectory
//of the base directory, no matter how deep. The created path file simply points to the main path file
//found in the base directory.
function createPathFile($current_directory)
{
    global $path_array;
    $start = strlen($path_array['project_path']);
    $trimmed_path = substr($current_directory, $start);

    $pathfile = '';
    if(trim($trimmed_path) != '')
    {
        $depth = substr_count($trimmed_path, '/');
        for($a=0; $a<$depth; ++$a)
        {
            $pathfile .= '../';
        }
        $pathfile .= 'path.php';

        $pathfile_content=<<<EOD
<?php require_once '$pathfile';
EOD;

        $filename = $current_directory . '/path.php';
        if(file_exists($filename)) unlink($filename);
        $newfile=fopen($filename,"ab");
        fwrite($newfile, $pathfile_content);
        fclose($newfile);
        chmod($filename, 0777);
    }
}
