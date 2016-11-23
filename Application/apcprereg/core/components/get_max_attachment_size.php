<?php
require_once 'subclasses/system_settings.php';
$obj_settings = new system_settings;
$max_attachment_size_MB = $obj_settings->get('Max Attachment Size (MB)',FALSE)->dump['value'];
if($max_attachment_size_MB < 1)
{
    //This means the setting is set to auto-detect ini values, misconfigured, or has been removed.
    //Whatever the case, get sensible max size by getting post_max_size and upload_max_filesize, and using the lower value

    if(!function_exists('return_bytes'))
    {
        function return_bytes($val)
        {
            //This is taken from phpmanual, as their recommended way of querying for memory size values
            $val = trim($val);
            $last = strtoupper($val[strlen($val)-1]);
            switch($last)
            {
                case 'G':   $val *= 1024;
                case 'M':   $val *= 1024;
                case 'K':   $val *= 1024;
            }
            return $val;
        }
    }
    $ini_post_max_size = return_bytes(ini_get('post_max_size'));
    $ini_upload_max_filesize = return_bytes(ini_get('upload_max_filesize'));

    if($ini_post_max_size < $ini_upload_max_filesize)
    {
        $max_attachment_size = $ini_post_max_size;
    }
    else
    {
        $max_attachment_size = $ini_upload_max_filesize;
    }
    $max_attachment_size_MB = $max_attachment_size / 1024 / 1024;

}
else
{
    $max_attachment_size = $max_attachment_size_MB * 1024 * 1024; //Transform to bytes
}
