<?php
if(isset($valid_directory) && $valid_directory != '')
{
    $html = new html;

    $filename = str_replace("\0",'',cobalt_htmlentities_decode(basename(urldecode($_GET['filename']))));
    $download_name = substr($filename, $html->upload_token_length);
    $filename = $valid_directory . '/'. $filename;

    if(is_readable($filename) && dirname($filename) === $valid_directory)
    {
        log_action('Successful file download: ' . $download_name . ' (' . $filename . ')');
        header('Content-Description: File Download');
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Transfer-Encoding: binary');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $download_name . '"'); 
        header('Content-Length: ' . filesize($filename));
        @ob_clean(); //error suppression to avoid Notice if output buffering was turned off in php.ini; otherwise, Notice will corrupt the file
        flush(); 
        readfile($filename);
        die();
    }
    else 
    {
        log_action('Failed file download: ' . $download_name . ' (' . $filename . ')');
        $message = 'File not found or server error encountered.<br>
                    Please press the back button in your browser and try again.
                    <br><br>
                    If this error persists, the file must have been deleted. Please contact your system administrator.'; 
        $html->draw_header('File Download Error', $message);
        $html->draw_footer();
    }
}
