<?php
require 'Core/SCV2_Core.php';
init_SCV2();
if(!isset($_SESSION['Project_ID'])) $_SESSION['Project_ID'] = 'TEMP';
if(!isset($_SESSION['Project_Name'])) $_SESSION['Project_Name'] = '(NO PROJECT)';
drawHeader(FALSE);
drawPageTitle("JV Roig", "Cobalt Creator", 'message');
if($_SESSION['Project_ID'] == 'TEMP') unset($_SESSION['Project_ID']);
if($_SESSION['Project_Name'] == '(NO PROJECT)') unset($_SESSION['Project_Name']);

?>
<table border=0 cellpadding=2 cellspacing=2>
<tr>
	<td valign=top>
	<fieldset class="container">
	    <span class="graytext">
		&nbsp;&nbsp;&nbsp;&nbsp; Jesus Vicente "JV" Roig is the first ever <i> summa cum laude </i> of Asia Pacific College. During his May 2006 graduation JV
		also received the <i> Internship Award </i> and <i>Outstanding Project Award</i> for his internship stint at Don Bosco College, Canlubang
		which resulted in a Linux / Apache / MySQL / PHP-based ERP system for schools which he christened "SYNERGY".

        <br><br>
        &nbsp;&nbsp;&nbsp;&nbsp; JV likewise graduated top of his class in his post-grad studies (Master in Information Management), also at Asia Pacific College. Some of his friends
        jokingly refer to him now as <i>"Double"</i> - short for  <i>"Double summa cum laude"</i>.

		<br><br>
		&nbsp;&nbsp;&nbsp;&nbsp; Get in touch with JV through email: jvroig@jvroig.com <br><br>

		&nbsp;&nbsp;&nbsp;&nbsp; You may send questions, comments or feature requests about Cobalt or any of JV's other projects that you
		are a part of through any of the above contact information.
		</span>
    </fieldset>
	</td>
</tr>
</table>
<?php
drawFooter();
