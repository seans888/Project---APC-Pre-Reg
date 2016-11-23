<?php
/*
 * SCV2_Lib.php
 * FRIDAY, November 28, 2006
 * SCV2 library file containing HTML-generating functions
 * JV Roig
 */

function displayErrors($errMsg)
{
    if($errMsg!="")
    {
        echo '<div class="messageError">';
        echo "<table border=0 width=100%>";
        echo '<tr><td width="60" valign="top">';
        echo "<img src='/cobalt/images/icons/warn2.png'>";
        echo "</td>";
        echo "<td>";
        echo $errMsg;
        echo "</td></tr></table></div>";
    }
}

function displayInfo($msg)
{
    if($msg!="")
    {
        echo '<div class="messageInfo">';
        echo "<table border=0 width=100%>";
        echo '<tr><td width="60" valign="top">';
        echo "<img src='/cobalt/images/icons/info.png'>";
        echo "</td>";
        echo "<td>";
        echo "$msg";
        echo "</td></tr></table></div>";
    }
}

function displayMessage($msg)
{
    if($msg!="")
    {
        echo '<div class="messageSystem">';
        echo "<table border=0 width=100%>";
        echo '<tr><td width="60" valign="top">';
        echo "<img src='/cobalt/images/icons/ok.png'>";
        echo "</td>";
        echo "<td>";
        echo "$msg";
        echo "</td></tr></table></div>";
    }
}

function displayTip($msg)
{
    if($msg!="")
    {
        echo '<div class="messageTip">';
        echo "<table border=0 width=100%>";
        echo '<tr><td width="60" valign="top">';
        echo "<img src='/cobalt/images/icons/tip.png'>";
        echo "</td>";
        echo "<td>";
        echo "$msg";
        echo "</td></tr></table></div>";
    }
}

function drawRadioField($arrayItems, $label, $name=null, $drawTableTags=TRUE)
{
    if($name==null) $name=$label;
    global $$name;

    if($drawTableTags) echo '<tr><td align="right" style="padding-right: 10px;">' . $label . ':</td><td>';
    else echo $label;

    $numItems = count($arrayItems['Items']);
    for($a=0;$a<$numItems;++$a)
    {
        $mark="";
        $ending="\n";
        if($arrayItems['PerLine']==TRUE) $ending="<br>\n";
        if($arrayItems['Values'][$a]==$$name) $mark="checked";
        echo '<input type="radio" name="' . $name . '" value="' . $arrayItems['Values'][$a] . '" ' . $mark .'>' . $arrayItems['Items'][$a] . $ending;
    }

    if($drawTableTags) echo '</td>';
}

function drawSelectField($function, $label, $name=null, $drawTableTags=TRUE, $extra='')
{
    if($name==null) $name=$label;
    global $$name;

    if($drawTableTags) echo '<tr><td align="right" style="padding-right: 10px;">' . $label . ':</td><td>';
    else echo $label;

    $function($$name, false, $name, $extra);

    if($drawTableTags) echo '</td>';
}

function drawTextField($label, $name=null, $detailView=FALSE, $controlType='', $drawTableTags=TRUE, $dynamicList=FALSE, $cntr=0, $extra='')
{
    if($name==null) $name=$label;
    if($controlType==null) $controlType='text';

    global $$name;
    if($dynamicList)
    {
        if(!isset(${$name}[$cntr])) ${$name}[$cntr] = '';
    }


    $controlType = strtolower($controlType);

    if($drawTableTags) echo '<tr><td align="right" valign="middle" width=40% style="padding-right: 10px;">' . $label . ':</td><td>';
    else echo $label;

    if($detailView==FALSE)
    {
        if($controlType=='textarea')
        {
            if($dynamicList==TRUE) echo "<textarea id= '" . $name . "' name='" . $name . "[$cntr]' rows='5' cols='30' $extra>" . ${$name}[$cntr] . "</textarea>";
            else echo "<textarea name='$name' rows='5' cols='30' $extra>" . $$name . "</textarea>";
        }
        else
        {
            if($dynamicList==TRUE) echo "<input type='$controlType' name='" . $name . "[$cntr]' value='" . ${$name}[$cntr] . "' $extra >";
            else echo "<input type='$controlType' id='$name' name='$name' value='" . htmlentities($$name, ENT_QUOTES) . "' $extra >";
        }
    }
    else
    {
            if(trim($$name)=='')
            {
                $$name = '&nbsp;';
            }
        echo '<p class="detail_view">' . nl2br($$name) . '</p>' . "\r\n";
    }

    if($drawTableTags) echo '</td></tr>';
}


function drawMultiFieldAuto($label, $arrayMultiField, $numParticularsVar=null, $particularsCountVar=null, $particularButtonVar=null, $drawTableTags=TRUE)
{
    if($numParticularsVar==null) $numParticularsVar='numParticulars';
    if($particularsCountVar==null) $particularsCountVar='particularsCount';
    if($particularButtonVar==null) $particularButtonVar='particularButton';

    global $$numParticularsVar, $$particularsCountVar;

    if($drawTableTags) echo '<tr><td colspan="2"><hr></td></tr>
                               <tr><td colspan="2" align="center">' . $label . '<br>';
    else echo "<hr>" . $label . "<br>";

    if($$numParticularsVar>0) ;
    else $$numParticularsVar=$$particularsCountVar;

    if($$numParticularsVar!=0)     echo "<input type=hidden name='" . $particularsCountVar . "' value=". $$numParticularsVar . ">";
    else  echo "<input type=hidden name='" . $particularsCountVar . "' value=1>";

    if($$numParticularsVar<1) $$numParticularsVar=1;
    echo '<table border=1, cellpadding=1,cellspacing=1><tr><td>&nbsp;</td>';

    //Count how many fields need to be drawn,
    //then loop the <td></td> tags with the corresponding labels.
    $numTDPairs = count($arrayMultiField['FieldLabels']);
    for($a=0;$a<$numTDPairs;++$a)
    {
        echo '<td>' . $arrayMultiField['FieldLabels'][$a] . '</td>';
    }
    echo '</tr>';

    for($a=0;$a<$$numParticularsVar;++$a)
    {
        echo '<tr><td>' . ($a + 1) . '</td>';

        for($b=0;$b<$numTDPairs;$b++)
        {
            echo '<td>';

            global ${$arrayMultiField['FieldVariables'][$b]};
            init_var(${$arrayMultiField['FieldVariables'][$b]}[$a]);
            $arrayMultiField['FieldControls'][$b](${$arrayMultiField['FieldVariables'][$b]}[$a], TRUE, $arrayMultiField['FieldVariables'][$b]);

            echo '</td>';
        }

        echo '</tr>';
    }
    echo "</table>";

    echo '<br> Change # of items to:
              <input type=text size=2 maxlength=2 name="' . $numParticularsVar . '">
              <input type=submit name="' . $particularButtonVar . '" value=GO class=button1>';
    if($drawTableTags) echo '</td></tr><tr><td colspan="2"><hr></td></tr>';
    else echo "<hr>";
}

function drawMultiFieldStart($label, $numParticularsVar=null, $particularsCountVar=null, $drawTableTags=TRUE)
{
    if($numParticularsVar==null) $numParticularsVar='numParticulars';
    if($particularsCountVar==null) $particularsCountVar='particularsCount';

    global $$numParticularsVar, $$particularsCountVar, $MultiFieldTableTags;
    $MultiFieldTableTags=$drawTableTags;

    if($drawTableTags) echo '<tr><td colspan="2"><hr></td></tr>
                               <tr><td colspan="2" align="center">' . $label . '<br>';
    else echo "<hr>" . $label . "<br>";

    if($$numParticularsVar>0) ;
    else $$numParticularsVar=$$particularsCountVar;

    if($$numParticularsVar!=0)     echo "<input type=hidden name='" . $particularsCountVar . "' value=". $$numParticularsVar . ">";
    else  echo "<input type=hidden name='" . $particularsCountVar . "' value=1>";
}

function drawMultiFieldEnd($numParticularsVar=null, $particularButtonVar=null)
{
    if($numParticularsVar==null) $numParticularsVar='numParticulars';
    if($particularButtonVar==null) $particularButtonVar='particularButton';

    echo '<br> Change # of items to:
              <input type=text size=2 maxlength=2 name="' . $numParticularsVar . '">
              <input type=submit name="' . $particularButtonVar . '" value=GO class=button1>';
    global $MultiFieldTableTags;
    if($MultiFieldTableTags) echo '</td></tr><tr><td colspan="2" lookhereplease ><hr></td></tr>';
    else echo "<hr>";
}

function drawButton($type=NULL, $buttonClass="button1", $buttonName=NULL, $buttonLabel=NULL, $drawTableTags=FALSE, $colspan="2")
{
    if($drawTableTags==TRUE)
    {
        echo "<TR>";
        echo "<TD align=center colspan=$colspan>";
    }

    switch($type)
    {
        case "CANCEL":
            $buttonName="btnCancel";
            $buttonLabel="CANCEL";
            break;
        case "BACK":
            $buttonName="btnCancel";
            $buttonLabel="BACK";
            break;
        case "GO":
            $buttonName="btnGO";
            $buttonLabel="GO";
            break;
        case "SPECIAL":
            break;
        default:
            $buttonName="btnSubmit";
            $buttonLabel="SUBMIT";
    }
    echo "<input type=submit name='" . $buttonName . "' value='" . $buttonLabel . "' class='" . $buttonClass. "'>&nbsp;";

    if($drawTableTags==TRUE)
    {
        echo "</TD>";
        echo "</TR>";
    }
}

function drawSubmitCancel($drawTableTags=FALSE, $colspan="2", $submitName="btnSubmit", $submitLabel="SUBMIT", $submitClass="submit", $cancelName="btnCancel", $cancelLabel="CANCEL", $cancelClass="cancel")
{
    if($drawTableTags==TRUE)
    {
        echo "<TR>";
        echo "<TD align=center colspan=$colspan>";
    }

    echo "<input type=submit name='" . $submitName . "' value='" . $submitLabel . "' class='" . $submitClass. "'>&nbsp;";
    echo "<input type=submit name='" . $cancelName . "' value='" . $cancelLabel . "' class='" . $cancelClass. "'>";

    if($drawTableTags==TRUE)
    {
        echo "</TD>";
        echo "</TR>";
    }
}

function drawBackButton($drawTableTags=TRUE)
{
    drawButton('BACK', "button1", NULL, NULL, $drawTableTags, 2);
}

function drawDeleteCancel($drawTableTags=FALSE, $colspan="2", $submitName="btnSubmit", $submitLabel="DELETE", $submitClass="submit", $cancelName="btnCancel", $cancelLabel="CANCEL", $cancelClass="cancel")
{
    drawSubmitCancel($drawTableTags, $colspan, $submitName, $submitLabel, $submitClass, $cancelName, $cancelLabel, $cancelClass);
}

function drawAttribute($Attribute, $dynamicList=FALSE, $name='Attribute')
{
    if($dynamicList==TRUE) echo '<select name="' . $name . '[]">';
    else echo '<select name="' . $name . '">';

    if($Attribute=="none") echo '<option value="none" selected>None</option>';
    else echo '<option value="none">None</option>';

    if($Attribute=="primary key") echo '<option value="primary key" selected>Primary Key</option>';
    else echo '<option value="primary key">Primary Key</option>';

    if($Attribute=="primary&foreign key") echo '<option value="primary&foreign key" selected>Primary&Foreign Key</option>';
    else echo '<option value="primary&foreign key">Primary&Foreign Key</option>';

    if($Attribute=="foreign key") echo '<option value="foreign key" selected>Foreign Key</option>';
    else echo '<option value="foreign key">Foreign Key</option>';

    echo '</select>';
}

function drawBookListGenerator($Book_List_Generator, $dynamicList=FALSE, $name='Book_List_Generator')
{
    if($dynamicList==TRUE) echo '<select name="' . $name . '[]">';
    else echo '<select name="' . $name . '">';

    if($Book_List_Generator=="None") echo '<option value="None" selected>None</option>';
    else echo '<option value="None">None</option>';

    if($Book_List_Generator=="StudentBooklist.php") echo '<option value="StudentBooklist.php" selected>StudentBooklist.php</option>';
    else echo '<option value="StudentBooklist.php">StudentBooklist.php</option>';

    if($Book_List_Generator=="StaffBooklist.php") echo '<option value="StaffBooklist.php" selected>StaffBooklist.php</option>';
    else echo '<option value="StaffBooklist.php">StaffBooklist.php</option>';

    if($Book_List_Generator=="StudentAndStaffBooklist.php") echo '<option value="StudentAndStaffBooklist.php" selected>StudentAndStaffBooklist.php</option>';
    else echo '<option value="StudentAndStaffBooklist.php">StudentAndStaffBooklist.php</option>';

    if($Book_List_Generator=="UsernameBooklist.php") echo '<option value="UsernameBooklist.php" selected>UsernameBooklist.php</option>';
    else echo '<option value="UsernameBooklist.php">UsernameBooklist.php</option>';

    echo '</select>';
}

function drawCharSetMethod($ignore, $dynamicList, $name)
{
    if($dynamicList)
    {
        echo '<select name="' . $name . '[]">';
    }
    else
    {
        echo '<select name="' . $name . '">';
    }

    global $$name;

    echo '<option value=""></option>';

    if($$name=="generate_alpha_set")
    {
        echo '<option value="generate_alpha_set" selected>Alpha Set</option>';
    }
    else
    {
        echo '<option value="generate_alpha_set">Alpha Set</option>';
    }

    if($$name=="generate_alphanum_set")
    {
        echo '<option value="generate_alphanum_set" selected>Alphanum Set</option>';
    }
    else
    {
        echo '<option value="generate_alphanum_set">Alphanum Set</option>';
    }

    if($$name=="generate_num_set")
    {
        echo '<option value="generate_num_set" selected>Num Set</option>';
    }
    else
    {
        echo '<option value="generate_num_set">Num Set</option>';
    }

    echo '</select>';
}

function drawColumnAlignment($ignore, $dynamicList, $name)
{
    if($dynamicList)
    {
        echo '<select name="' . $name . '[]">';
    }
    else
    {
        echo '<select name="' . $name . '">';
    }

    global $$name;

    if($$name=="left")
    {
        echo '<option value="left" selected>Left</option>';
    }
    else
    {
        echo '<option value="left">Left</option>';
    }

    if($$name=="center")
    {
        echo '<option value="center" selected>Center</option>';
    }
    else
    {
        echo '<option value="center">Center</option>';
    }

    if($$name=="right")
    {
        echo '<option value="right" selected>Right</option>';
    }
    else
    {
        echo '<option value="right">Right</option>';
    }

    echo '</select>';
}

function drawControlType($Control_Type, $dynamicList=FALSE, $name='Control_Type')
{
    if($dynamicList==TRUE) echo '<select name="' . $name . '[]">';
    else echo '<select name="' . $name . '">';

    if($Control_Type=="textbox") echo '<option value="textbox" selected>Textbox</option>';
    else echo '<option value="textbox">Textbox</option>';

    if($Control_Type=="date controls") echo '<option value="date controls" selected>Date Controls</option>';
    else echo '<option value="date controls">Date Controls</option>';

    if($Control_Type=="drop-down list") echo '<option value="drop-down list" selected>Drop-down List</option>';
    else echo '<option value="drop-down list">Drop-down List</option>';

    if($Control_Type=="radio buttons") echo '<option value="radio buttons" selected>Radio Buttons</option>';
    else echo '<option value="radio buttons">Radio Buttons</option>';

    if($Control_Type=="textarea") echo '<option value="textarea" selected>Textarea</option>';
    else echo '<option value="textarea">Textarea</option>';

    if($Control_Type=="upload") echo '<option value="upload" selected>File Upload</option>';
    else echo '<option value="upload">File Upload</option>';

    if($Control_Type=="none") echo '<option value="none" selected>None</option>';
    else echo '<option value="none">None</option>';

    if($Control_Type=="hidden") echo '<option value="hidden" selected>Hidden</option>';
    else echo '<option value="hidden">Hidden</option>';

    echo '</select>';
}

function drawDataType($Data_Type, $dynamicList=FALSE, $name='Data_Type')
{
    if($dynamicList==TRUE) echo '<select name="' . $name . '[]">';
    else echo '<select name="' . $name . '">';

    if($Data_Type=="varchar") echo '<option value="varchar" selected>Varchar</option>';
    else echo '<option value="varchar">Varchar</option>';

    if($Data_Type=="integer") echo '<option value="integer" selected>Integer</option>';
    else echo '<option value="integer">Integer</option>';

    if($Data_Type=="date") echo '<option value="date" selected>Date</option>';
    else echo '<option value="date">Date</option>';

    if($Data_Type=="unix timestamp") echo '<option value="unix timestamp" selected>UNIX Timestamp</option>';
    else echo '<option value="unix timestamp">UNIX Timestamp</option>';

    if($Data_Type=="double or float") echo '<option value="double or float" selected>Double or Float</option>';
    else echo '<option value="double or float">Double or Float</option>';

    if($Data_Type=="bool") echo '<option value="bool" selected>Boolean</option>';
    else echo '<option value="bool">Boolean</option>';

    if($Data_Type=="binary") echo '<option value="binary" selected>Binary</option>';
    else echo '<option value="binary">Binary</option>';

    if($Data_Type=="text") echo '<option value="text" selected>Text</option>';
    else echo '<option value="text">Text</option>';

    echo '</select>';
}

function drawDBConnection($DB_Connection_ID,  $dynamicList=FALSE, $name='DB_Connection_ID')
{
    if($dynamicList==TRUE) echo '<select name="' . $name . '[]">';
    else echo '<select name="' . $name . '">';

    $d = connect_DB();
    $stmt = $d->prepare("SELECT DB_Connection_ID, DB_Connection_Name FROM database_connection
                            WHERE Project_ID=:p_id ORDER BY DB_Connection_Name");
    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
    $result = $stmt->execute();
    while($row = $result->fetchArray())
    {
        $mark="";
        if($row['DB_Connection_ID'] == $DB_Connection_ID) $mark='selected';
        printf("<option value='%s' $mark>%s</option>\n", $row['DB_Connection_ID'], $row['DB_Connection_Name']);
    }
    echo '</select>';
}

function drawFooter()
{
    echo '    </div>';
    if(defined('WITH_FORM') && WITH_FORM)
    {
        echo '    </form>';
    }
    $cpu_time = microtime(true) - PROCESS_START_TIME;
    $ram_used = memory_get_peak_usage(false) / 1024;
    $max_ram_used = memory_get_peak_usage(true) / 1024;

    require FULLPATH_CORE . '../version_info.php';

    echo '
    <div class="Footer">
        <div class="container_footer">
            <fieldset>
                <table>
                <tr><td colspan="2">Cobalt ' . COBALT_MAJOR_VERSION . ' ' . COBALT_BUILD_VERSION . '</td></tr>
                <tr><td colspan="2">Page Resource Usage Statistics</td></tr>
                <tr><td align="right"> CPU Time: </td><td> &nbsp;' . $cpu_time . ' seconds </td></tr>
                <tr><td align="right"> RAM usage: </td><td> &nbsp;' . number_format($ram_used,0,'.',',') .'KB </td></tr>
                <tr><td align="right"> Allocated RAM: </td><td> &nbsp;' . number_format($max_ram_used,0,'.',',') .'KB </td></tr>
                <tr><td colspan="2">
                    &copy; 2011-2016, JV Roig <br>
                    <a class="footer" href="http://jvroig.com/main/cobalt" target="_blank"> Cobalt Homepage @ JVRoig.com</a>
                </td></tr>
                </table>
            </fieldset>
        </div>
    </div>
</div>
</body>
</html>';
}

function drawFieldSetStart($outer_width='', $class='', $label='', $inner_width='')
{
    if($outer_width=='') $outer_width='600';
    if($class=='') $class='controlsContainerShort';
    if($inner_width=='') $inner_width = $outer_width - 20;
    if($label=='') $label='<br>';

    echo '<table align="center" width="' . $outer_width. '"><tr><td>
            <div class="'. $class . '">
                <span class="corner-top-left"></span>
                <span class="corner-top-right"></span>
                <div class="controlsContainerTop">
                </div>
                <span class="controlsContainerHeading">'. $label . '</span>
                <table align="center" width="'. $inner_width . '" class="tableContent">';
}

function drawFieldSetEnd()
{
    echo '</table>
            <div class="controlsContainerBottom">
                <span class="corner-bottom-left"></span>
                <span class="corner-bottom-right"></span>
            </div>
        </div>
        </td></tr>
        </table>';
}

function drawHeader($drawForm=TRUE, $drawHeaderMenu=TRUE, $requireProject=TRUE)
{
    //If a project is required, check for an active project.
    if($requireProject==TRUE) checkActiveProject();

    echo '<!DOCTYPE html>'. "\n"
        .'<html>'. "\n"
        .'<head><title>Cobalt</title>'. "\n"
        .'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'. "\n"
        .'<link href="/cobalt/css/cobalt.css" rel="stylesheet" type="text/css">'. "\n"
        .'</head>'. "\n"
        .'<body leftmargin=0 topmargin=0 rightmargin=0>'. "\n"
        .'<div class="superUltraHyperMegaOMFGBBQContainer">'. "\n";

    echo '<div class="HeaderBanner">
            COBALT<span>mark V   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Enterprise-Class Rapid Application Development</span>
          </div>';

    if($drawHeaderMenu==TRUE) drawHeaderMenu();

    if($drawForm==TRUE)
    {
        define('WITH_FORM',TRUE);
        echo '<form method="POST" action="' . $_SERVER['PHP_SELF'] . '">';
        secureForm();
    }
}

function drawHeaderMenu()
{
    init_var($_SESSION['Project_Name']);
    echo '<div class="HeaderMenu">
          <table border=0 width=98% cellspacing=0 cellpadding=0 class="tableContent" align="center">
            <tr class=printText>
            <td class="menu" align=left width=15%>
            <a class="menu" href="/cobalt/main.php"> HOME </a>
            </td>

            <td class="menu" align=left width=15%>
            <a class="menu" href="/cobalt/chooseProject.php"> CHANGE PROJECT </a>
            </td>

            <td class="menu" align=left width=15%>
            <a class="menu" href="/cobalt/About.php"> ABOUT </a>
            </td>

            <td align=right> Active Project: ' . htmlentities($_SESSION['Project_Name'], ENT_QUOTES) .'</td></tr>
            </table>
          </div>';
}

function drawFields($Field_ID, $dynamicList=FALSE, $name='Field_ID')
{
    if($dynamicList==TRUE) echo '<select name="' . $name . '[]">';
    else echo '<select name="' . $name . '">';

    $d = connect_DB();
    $stmt = $d->prepare("SELECT a.Field_ID, a.Field_Name, b.Table_Name
                            FROM table_fields a, \"table\" b
                            WHERE a.Table_ID = b.Table_ID AND b.Project_ID=:p_id
                            ORDER BY b.Table_Name, a.Field_Name");
    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
    $result = $stmt->execute();
    while($row = $result->fetchArray())
    {
        $mark="";
        if($row['Field_ID'] == $Field_ID) $mark='selected';
        printf("<option value='%s' $mark>%s.%s</option>\n", $row['Field_ID'], $row['Table_Name'], $row['Field_Name']);
    }
    echo '</select>';
}

function drawFieldsParent($Field_ID, $dynamicList=FALSE, $name='Field_ID')
{
    if($dynamicList==TRUE) echo '<select name="' . $name . '[]">';
    else
    {
        echo '<select name="' . $name . '" id="' . $name . '" onChange="this.form.submit()">';
        echo '<option disabled selected></option>';
    }

    $d = connect_DB();
    $stmt = $d->prepare("SELECT a.Field_ID, a.Field_Name, b.Table_Name
                            FROM table_fields a, \"table\" b
                            WHERE a.Table_ID = b.Table_ID AND b.Project_ID=:p_id AND a.Attribute='primary key'
                            ORDER BY b.Table_Name, a.Field_Name");
    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
    $result = $stmt->execute();
    while($row = $result->fetchArray())
    {
        $mark="";
        if($row['Field_ID'] == $Field_ID) $mark='selected';
        printf("<option value='%s' $mark>%s.%s</option>\n", $row['Field_ID'], $row['Table_Name'], $row['Field_Name']);
    }
    echo '</select>';
}

function drawListSourceSelectField($Select_Field_ID, $dynamicList=FALSE, $name='Select_Field_ID')
{
    if($dynamicList==TRUE) echo '<select name="' . $name . '[]">';
    else echo '<select name="' . $name . '">';

    $d = connect_DB();
    $stmt = $d->prepare("SELECT a.Field_ID, a.Field_Name, b.Table_Name
                            FROM table_fields a, \"table\" b
                            WHERE a.Table_ID = b.Table_ID AND b.Project_ID=:p_id
                            ORDER BY b.Table_Name, a.Field_Name ");
    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
    $result = $stmt->execute();
    while($row = $result->fetchArray())
    {
        $mark="";
        if($row['Field_ID'] == $Select_Field_ID) $mark='selected';
        printf("<option value='%s' $mark>%s.%s</option>\n", $row['Field_ID'], $row['Table_Name'], $row['Field_Name']);
    }
    echo '</select>';
}

function drawListSourceSelectFieldDisplay($Select_Field_Display, $dynamicList=FALSE, $name='Select_Field_Display')
{
    if($dynamicList==TRUE) echo '<select name="' . $name . '[]">';
    else echo '<select name="' . $name . '">';

    if($Select_Field_Display=="Yes") echo '<option value="Yes" selected>Yes</option>';
    else echo '<option value="Yes">Yes</option>';

    if($Select_Field_Display=="No") echo '<option value="No" selected>No</option>';
    else echo '<option value="No">No</option>';

    echo '</select>';
}

function drawListSourceWhereField($Where_Field_ID, $dynamicList=FALSE)
{
    if($dynamicList==TRUE) echo '<select name="Where_Field_ID[]">';
    else echo '<select name="Where_Field_ID">';
    echo '<option value="(NONE)"> (NONE) </option>';

    $d = connect_DB();
    $stmt = $d->prepare("SELECT a.Field_ID, a.Field_Name, b.Table_Name
                            FROM table_fields a, \"table\" b
                            WHERE a.Table_ID = b.Table_ID AND b.Project_ID=:p_id
                            ORDER BY b.Table_Name, a.Field_Name");
    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
    $result = $stmt->execute();
    while($row = $result->fetchArray())
    {
        $mark="";
        if($row['Field_ID'] == $Where_Field_ID) $mark='selected';
        printf("<option value='%s' $mark>%s.%s</option>\n", $row['Field_ID'], $row['Table_Name'], $row['Field_Name']);
    }
    echo '</select>';
}

function drawListSourceWhereFieldConnector($Where_Field_Connector, $dynamicList=FALSE, $name='Where_Field_Connector')
{
    if($dynamicList==TRUE) echo '<select name="'. $name .'[]">';
    else echo '<select name="' . $name .'">';

    if($Where_Field_Connector=="NONE") echo '<option value="NONE" selected>NONE</option>';
    else echo '<option value="NONE">NONE</option>';

    if($Where_Field_Connector=="AND") echo '<option value="AND" selected>AND</option>';
    else echo '<option value="AND">AND</option>';

    if($Where_Field_Connector=="OR") echo '<option value="OR" selected>OR</option>';
    else echo '<option value="OR">OR</option>';

    echo '</select>';
}

function drawListSourceWhereFieldOperand($Where_Field_Operand, $dynamicList=FALSE, $name='Where_Field_Operand')
{
    if($dynamicList==TRUE) echo '<select name="' . $name . '[]">';
    else echo '<select name="' . $name . '">';

    if($Where_Field_Operand=="=") echo '<option value="=" selected>=</option>';
    else echo '<option value="=">=</option>';

    if($Where_Field_Operand=="!=") echo '<option value="!=" selected>!=</option>';
    else echo '<option value="!=">!=</option>';

    if($Where_Field_Operand==">") echo '<option value=">" selected>></option>';
    else echo '<option value=">">></option>';

    if($Where_Field_Operand=="<") echo '<option value="<" selected><</option>';
    else echo '<option value="<"><</option>';

    if($Where_Field_Operand==">=") echo '<option value=">=" selected>>=</option>';
    else echo '<option value=">=">>=</option>';

    if($Where_Field_Operand=="<=") echo '<option value="<=" selected><=</option>';
    else echo '<option value="<="><=</option>';

    if($Where_Field_Operand=="LIKE %...") echo '<option value="LIKE %..." selected>LIKE %...</option>';
    else echo '<option value="LIKE %...">LIKE %...</option>';

    if($Where_Field_Operand=="LIKE ...%") echo '<option value="LIKE ...%" selected>LIKE ...%</option>';
    else echo '<option value="LIKE ...%">LIKE ...%</option>';

    if($Where_Field_Operand=="LIKE %...%") echo '<option value="LIKE %...%" selected>LIKE %...%</option>';
    else echo '<option value="LIKE %...%">LIKE %...%</option>';

    if($Where_Field_Operand=="NOT LIKE %...") echo '<option value="NOT LIKE %..." selected>NOT LIKE %...</option>';
    else echo '<option value="NOT LIKE %...">NOT LIKE %...</option>';

    if($Where_Field_Operand=="NOT LIKE ...%") echo '<option value="NOT LIKE ...%" selected>NOT LIKE ...%</option>';
    else echo '<option value="NOT LIKE ...%">NOT LIKE ...%</option>';

    if($Where_Field_Operand=="NOT LIKE %...%") echo '<option value="NOT LIKE %...%" selected>NOT LIKE %...%</option>';
    else echo '<option value="NOT LIKE %...%">NOT LIKE %...%</option>';

    echo '</select>';
}

function drawListSourceWhereFieldValue($Where_Field_Value, $dynamicList=FALSE, $name='Where_Field_Value')
{
    if($dynamicList==TRUE) echo '<input type=text name="' . $name . '[]" value="' . $Where_Field_Value . '">';
    else echo '<input type=text name="'. $name .'" value="' . $Where_Field_Value . '">';
}

function drawNullable($Nullable, $dynamicList=FALSE, $name='Nullable')
{
    if($dynamicList==TRUE) echo '<select name="' . $name . '[]">';
    else echo '<select name="' . $name . '">';

    if($Nullable=="NO") echo '<option value="NO" selected>NO</option>';
    else echo '<option value="NO">NO</option>';

    if($Nullable=="YES") echo '<option value="YES" selected>YES</option>';
    else echo '<option value="YES">YES</option>';

    echo '</select>';
}

function drawPageTitle($title, $message=null, $message_type='')
{
    echo '<div class="HeaderPageTitle">'. $title .'</div>';
    echo '<div class="Content">';

    if($message != null)
    {
        if($message_type=='')
        {
            $message_type = 'error';
        }

        if(strtolower($message_type) == 'error')
        {
            displayErrors($message);
        }
        elseif(strtolower($message_type) == 'system')
        {
            displayMessage($message);
        }
        elseif(strtolower($message_type) == 'tip')
        {
            displayTip($message);
        }
        else
        {
            displayInfo($message);
        }
    }
}

function drawPredefinedList($List_ID, $dynamicList=FALSE, $name='List_ID')
{
    if($dynamicList==TRUE) echo '<select name="' . $name . '[]">';
    else echo '<select name="' . $name . '">';

    $d = connect_DB();
    $stmt = $d->prepare("SELECT List_ID, List_Name FROM table_fields_predefined_list WHERE Project_ID=:p_id ORDER BY List_Name");
    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
    $result = $stmt->execute();

    while($row = $result->fetchArray())
    {
        $mark="";
        echo "<hr>rowlsitID: $row[List_ID] while ListID is $List_ID <br>";
        if($row['List_ID'] == $List_ID) $mark='selected';
        printf("<option value='%s' $mark>%s</option>\n", $row['List_ID'], $row['List_Name']);
    }
    echo '</select>';
}

function drawProjectChooser($Project, $dynamicList=FALSE, $name="Project")
{
    if($dynamicList==TRUE) echo '<select name="' . $name . '[]">';
    else echo '<select name="' . $name . '">';

    $d = connect_DB();
    $result = $d->query("SELECT Project_ID, Project_Name FROM project ORDER BY Project_Name") or die("<hr>Fatal Error: " . $db_handle->error . '<hr>');
    while($row = $result->fetchArray())
    {
        $mark="";
        if($row['Project_ID'] == $Project) $mark='selected';
        printf("<option value='%s' $mark>%s</option>\n", $row['Project_ID'], $row['Project_Name']);
    }

    echo '</select>';
}

function drawSubtextFields($Parent_Field_ID)
{
    //Get Table ID
    $Table_ID = '';
    $d = connect_DB();
    $stmt = $d->prepare("SELECT Table_ID FROM `table_fields` WHERE Field_ID = :f_id");
    $stmt->bindValue(':f_id', $Parent_Field_ID);
    $result = $stmt->execute();
    while($row = $result->fetchArray())
    {
        $Table_ID = $row['Table_ID'];
    }

    //Get the fields of this table
    $arr_fields = array();
    $d = connect_DB();
    $stmt = $d->prepare("SELECT Field_Name FROM `table_fields` WHERE Table_ID = :t_id ORDER BY Field_Name");
    $stmt->bindValue(':t_id', $Table_ID);
    $result = $stmt->execute();
    while($row = $result->fetchArray())
    {
        $arr_fields[] = $row['Field_Name'];
    }

    echo '<div name="subtext_div" id="subtext_div" style="width: 100%;">';

    $msg = '';
    $msg .= 'Possible fields for Child Field Subtext:<br/>';
    $fields = '';
    foreach($arr_fields as $field_name)
    {
        //make_list($fields, $field_name, ', ', FALSE);
        $fields .= $field_name .'<br/>';
    }
    $msg .= $fields;
    displayTip($msg);

    echo '</div>';
}

function drawTable($Table_ID, $dynamicList=FALSE, $name="Table_ID")
{
    if($dynamicList==TRUE) echo '<select name="' . $name . '[]">';
    else echo '<select name="' . $name . '">';

    $d = connect_DB();
    $result = $d->query("SELECT Table_ID, Table_Name FROM `table` WHERE Project_ID='$_SESSION[Project_ID]' ORDER BY Table_Name");
    while($row = $result->fetchArray())
    {
        $mark="";
        if($row['Table_ID'] == $Table_ID) $mark='selected';
        printf("<option value='%s' $mark>%s</option>\n", $row['Table_ID'], $row['Table_Name']);
    }
}

function drawTablePage($Page_ID, $dynamicList=FALSE, $name='Page_ID')
{
    if($dynamicList==TRUE) echo '<select name="' . $name . '[]">';
    else echo '<select name="' . $name . '">';

    $d = connect_DB();
    $result = $d->query("SELECT Page_ID, Page_Name FROM page ORDER BY Page_Name");
    while($row = $result->fetchArray())
    {
        $mark="";
        if($row['Page_ID'] == $Page_ID) $mark='selected';
        printf("<option value='%s' $mark>%s</option>\n", $row['Page_ID'], $row['Page_Name']);
    }
}
function drawTableRelationType($Relation, $dynamicList=FALSE, $name='Relation', $extra='')
{
    if($dynamicList==TRUE) echo '<select name="' . $name . '[]">';
    else echo '<select name="' . $name . '" ' . $extra . ' >';

    if($Relation=="ONE-to-ONE") echo '<option value="ONE-to-ONE" selected>ONE-to-ONE</option>';
    else echo '<option value="ONE-to-ONE">ONE-to-ONE</option>';

    if($Relation=="ONE-to-MANY") echo '<option value="ONE-to-MANY" selected>ONE-to-MANY</option>';
    else echo '<option value="ONE-to-MANY">ONE-to-MANY</option>';

    echo '</select>';
}

function drawTrimValue($ignore, $dynamicList, $name)
{
    if($dynamicList)
    {
        echo '<select name="' . $name . '[]">';
    }
    else
    {
        echo '<select name="' . $name . '">';
    }

    global $$name;

    if($$name=="trim")
    {
        echo '<option value="trim" selected>Left and Right Trim</option>';
    }
    else
    {
        echo '<option value="trim">Left and Right Trim</option>';
    }

    if($$name=="ltrim")
    {
        echo '<option value="ltrim" selected>Left Trim Only</option>';
    }
    else
    {
        echo '<option value="ltrim">Left Trim Only</option>';
    }

    if($$name=="rtrim")
    {
        echo '<option value="rtrim" selected>Right Trim Only</option>';
    }
    else
    {
        echo '<option value="rtrim">Right Trim Only</option>';
    }

    echo '</select>';
}

function drawValidationRoutine($Validation_Routine, $dynamicList=FALSE, $name='Validation_Routine')
{
    if($dynamicList==TRUE) echo '<input type=text name="' . $name . '[]" value="' . $Validation_Routine . '">';
    else echo '<input type=text name="' . $name . '" value="' . $Validation_Routine . '">';
}

function fieldsetStart($title)
{
    echo '<fieldset style="margin: 10px; padding: 10px; background: #c8cfd6; border-style: none">';
    echo '<legend style="background: #535f6b; color: #ffffff">' . $title . '</legend>';
    echo '<table class="inputForm" style="width: 100%">';
}

function fieldsetEnd()
{
    echo '</table></fieldset>';
}
