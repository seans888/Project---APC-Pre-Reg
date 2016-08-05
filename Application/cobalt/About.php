<?php
require 'Core/SCV2_Core.php';
init_SCV2();
if(!isset($_SESSION['Project_ID'])) $_SESSION['Project_ID'] = 'TEMP';
if(!isset($_SESSION['Project_Name'])) $_SESSION['Project_Name'] = '(NO PROJECT)';
drawHeader(FALSE);
drawPageTitle("Cobalt", "Created by <a href=About_JV_Roig.php class=blue>JV Roig</a>",'message');
if($_SESSION['Project_ID'] == 'TEMP') unset($_SESSION['Project_ID']);
if($_SESSION['Project_Name'] == '(NO PROJECT)') unset($_SESSION['Project_Name']);

?>
<table border=0 cellpadding=2 cellspacing=2>
<tr>
    <td valign=top>
    <fieldset class="container">
        <span class="graytext">
        &nbsp;&nbsp;&nbsp;&nbsp; Cobalt is a web-based code generator and framework using PHP and Oracle Database, created by JV Roig. <br><br>

        &nbsp;&nbsp;&nbsp;&nbsp; It is a code generator, so it is capable of producing a complete working system
        based on the information you feed it (data dictionary and a few miscellaneous data for
        certain special cases).<br><br>

        &nbsp;&nbsp;&nbsp;&nbsp; It is also a framework. This means it contains functions that allow you to create
        applications much easier and faster than if you were to start from scratch.<br><br>

        &nbsp;&nbsp;&nbsp;&nbsp; Cobalt was previously known as "SCV2". The name "SCV2" stands for "SYNERGY Core, Version 2",
        as it was originally
        intended to be a much-needed improvement to the original SYNERGY Core which JV
        made circa 2005-2006. But as he worked on it, it started to become a lot more than just
        an overhaul of the SYNERGY Core, eventually becoming the code generator and
        framework that it is now.<br><br>

        &nbsp;&nbsp;&nbsp;&nbsp; The basic idea behind Cobalt is this: redundant development tasks (like creating
        "add/edit/delete/view" modules) should be done automatically so that we can have more
        efficient use of our time. Instead of spending 70% of our time working on redundant
        parts of the system, we should just spend a minimal amount of time on them by letting a
        code generator do most of the redundant work for us. This way, we focus most of our
        energies on the really important parts of system development: the system design, special
        modules, and the reports.<br><br>

        &nbsp;&nbsp;&nbsp;&nbsp; <a href="About_JV_Roig.php"class=blue>About JV Roig</a>
        </span>
    </fieldset>
    </td>
</tr>
</table>
<?php
drawFooter();
