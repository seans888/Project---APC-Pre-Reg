<?php
require 'components/processing_grayout.php';
if(FOOTER_RESOURCE_USAGE)
{
    $cpu_time = microtime(true) - PROCESS_START_TIME;
    $ram_used = memory_get_peak_usage(false) / 1024;
    $max_ram_used = memory_get_peak_usage(true) / 1024;

    echo "\r\n"
        .'<table class="Footer">' . "\r\n"
        .'<tr><td class="Footer"><img src="/' . BASE_DIRECTORY . '/images/co_mk4_poweredby_s.png"></td>' . "\r\n"
        .'    <td class="Footer"> Page Statistics <br>' . "\r\n"
        .'         CPU Time : ' . $cpu_time . ' seconds <br>' . "\r\n"
        .'         RAM usage: ' . number_format($ram_used,0,'.',',') .' KB <br> ' . "\r\n"
        .'         Allocated RAM: ' . number_format($max_ram_used,0,'.',',') .' KB </td></tr>' . "\r\n"
        .'</table>' . "\r\n";
}
?>
</body>
</html>
