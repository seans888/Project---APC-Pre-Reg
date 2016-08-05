<?php
/*
 * SCV2_Lib.php
 * FRIDAY, November 24, 2006
 * SCV2 library file containing common PHP scripts.
 * JV Roig
 */

function checkActiveProject()
{
	//Checks if there is an active project.
	//Redirect to chooseProject.php if no project is active.
	if(!isset($_SESSION['Project_Name']) || !isset($_SESSION['Project_ID'])) header('location: /cobalt/chooseProject.php');
}

function scriptCheckIfNull()
{
	$errMsg="";
	$numargs = func_num_args();
	for($cntr=0;$cntr<$numargs;$cntr+=2)
	{
		//Create keys for the label-value pair. First in the pair is the label of the field,
		//followed by the value that was submitted for that field.
		$key1 = $cntr;
		$key2 = $cntr+1;

		$label = func_get_arg($key1); //This gets the label that was passed.
		$value = func_get_arg($key2); //This gets the value that was passed.

		if(!is_Array($value))
		{
			if($value=="") $errMsg .= "No value detected: $label <BR>";
		}
		else
		{
			$elements = count($value);
			for($arrCnt=0;$arrCnt<$elements;$arrCnt++)
			{
				if($value[$arrCnt]=='') $errMsg .= "No value detected: $label in Line #" . ($arrCnt+1) . ".<BR>";
			}
		}
	}
	return $errMsg;
}

function scriptCheckIfUnique_del($select, $delete)
{
	if($select=="" || $delete=="") die("Incomplete parameters passed to scriptCheckIfUnique_del()!");
	$query=mysql_query($select);
	$numrows=mysql_num_rows($query);
	if($numrows>0) mysql_query($delete); //delete the old value so, in effect, we will be overwriting it.
}

function scriptCheckIfUnique($select, $errMsg)
{
	$mysqli = connect_DB();
	$message="";
	$result = $mysqli->query($select);
	$numrows= $result->num_rows;
	if($numrows>0) $message = $errMsg;
	return $message;
}

