<?php
/*
 * SCV2_LibSecurity.php
 * FRIDAY, November 28, 2006 
 * SCV2 library file containing security-related functions
 * JV Roig
 */

/*********** FORM SECURITY FUNCTIONS START HERE **********************/
//Create a secret (and random) key that will be checked in any form submission, to make sure
//that only forms handled by the SYNERGY Core will be processed, thus preventing
//the problem of Cross-Site Request Forgeries (CSRF) attacks.
function secureForm()
{
    $form_key = get_token();
    $form_identifier = $_SERVER['PHP_SELF'];
    $_SESSION['formKey'] = array();
    $_SESSION['formKey'][$form_identifier] = $form_key;
    echo '<input type=hidden name=formKey value="' . $form_key .'">' . "\r\n";

    //We don't want to accumulate an unlimited amount of Cobalt Form Keys, so once we exceed ten, we remove the oldest one.
    //Ten is just a reasonable number pulled out of the air, since it's probably not too often one would need ten different tabs of this app open.
    if(count($_SESSION['formKey']) > 10)
    {
        array_shift($_SESSION['formKey']);
    }
}
/*********** END OF FORM SECURITY FUNCTIONS ***************************/

/*********** DATA FILTERING FUNCTIONS START HERE **********************/
//dataFilter() will perform necessary filtering depending on the value of $type. 
//dataFilter() does not actually "clean" the data. It simply filters the data so that
//invalid content may be discovered and prevented from being processed further.
//$char_set, if supplied, contains the valid characters that the data may possess - anything
//else will mean the data will be considered invalid. 
//$valid_set, if supplied, contains a set of data, the use of which depends on the setting
//of $whitelist. If $whitelist is set to TRUE (it is by default), then $valid_set is
//considered to be a whitelist, meaning the only valid values for the submitted data should
//be in $valid_set, otherwise treat the data as invalid, whatever it is. On the other hand,
//if $whitelist is set to FALSE, then $valid_set is treated as a blacklist, meaning its 
//contents represent invalid values - if the submitted data contains a value or values that
//are in $valid_set, then the submitted data is treated as invalid.
//******************************************************************************/

function dataFilter($unclean, $type, $char_set="", $valid_set=null, $whitelist=TRUE)
{
	//First off, trim data.
	$unclean = trim($unclean);	
	
	//Initialize $validity to be FALSE at the start of every validity check.
	//As the data passes each validity check, $validity is set to TRUE.
	//If data fails even just one validity check, $validity becomes FALSE, 
	//and the validity checking is discontinued.
	$validity = FALSE;

	//First of all, if $valid_set is set, then immediately check if data
	//conforms to the defined whitelist or blacklist.
	if($valid_set!=null) //Check if there is $valid_set is specified.
	{
		//Call checkDataSet(), which will verify if the submitted
		//data conforms to the defined whitelist or blacklist.
		$validity = checkDataSet($unclean, $valid_set, $whitelist);
	}
	else 
	{
		//Set to true immediately since by default it is valid 
		//because no list of data was given
		$validity = TRUE; 
	}
	
	//If data was found valid by whitelist / blacklist check, it's time to
	//check if the data does not contain invalid characters.	
	if($validity==TRUE) 
	{
		if($char_set!="")
		{
			//NOTE: Instead of checkCharSet(), regex (regular expressions) should be
			//used for performance reasons. For now, let's stick with checkCharSet().
			$validity=checkCharSet($unclean, $char_set);
		}
	}	
	
	//Continue only if data was found valid by checkCharSet().
	if($validity==TRUE) 
	{
		//Determine type of data being validated.
		//Default is "string". If the value of $type
		//is not recognized (the "else" bracket), issue
		//a warning so that the developer will be alerted of
		//a typo in the code.
		//As usual, $validity is set to FALSE at the start of validation procedures.
		$validity = FALSE;

		if($type=="string")
		{	
			
			//Add necessary string validation here - currently none at the moment,
			//so default validity to TRUE.
			$validity=TRUE;

		}
		elseif($type=="int")
		{
			$validity = ctype_digit($unclean);
		}
		elseif($type=="float")
		{
			if($unclean == strval(floatval($unclean)))
			{
				$validity=TRUE;
			}	
		}
		elseif($type=="date")
		{
			
		}
		elseif($type=="time")
		{
			
		}
		else
		{
			echo "Source code error: given type not recognized!";
			$validity=FALSE;
		}
	}
	return $validity;
}


//This function checks if the submitted data conforms to the defined 
//whitelist or blacklist, as specified in $valid_set and $whitelist.
function checkDataSet($unclean, $valid_set, $whitelist)
{
	if($whitelist) //whitelist approach - $valid_set contains the only values allowed.
	{
		//Initialize $validity as FALSE, so that we need to get a match in the
		//whitelist before it becomes valid.
		$validity = FALSE;
		if(is_array($valid_set))
		{
			$num = count($valid_set);
			for($a=0;$a<$num;$a++)
			{
				if($unclean == $valid_set[$a]) $validity=TRUE; //Valid because it matched a valid value.
			}
		}
		else
		{
			if($unclean == $valid_set) $validity=TRUE; //Valid because it matched a valid value.
		}
	}
	else //blacklist approach - $valid_set contains the invalid (unallowable) values.
	{
		echo $unclean . " === " . $valid_set;
		//Initialize $validity as TRUE, so that we need to get a match in the
		//blacklist before it becomes invalid.
		$validity = TRUE;
		if(is_array($valid_set))
		{
			$num = count($valid_set);
			for($a=0;$a<$num;$a++)
			{
				if($unclean == $valid_set[$a]) $validity=FALSE; //Invalid because it matched a forbidden value.
			}
		}
		else
		{
			if($unclean == $valid_set) $validity=FALSE; //Invalid because it matched a forbidden value.
		}
	}
	
	return $validity;
}

function checkCharSet($unclean, $char_set)
{
	//Initialize $validity to TRUE because the logic below makes the
	//data invalid only if there is a match found anytime within the loop.
	$validity=TRUE;
	$num = strlen($unclean);
	for($a=0;$a<$num;$a++)
	{
		if (!in_array($unclean[$a], $char_set)) $validity=FALSE; 
	}
	return $validity;
}

/*********** DATA FILTERING FUNCTIONS END HERE **********************/

/*********** CHARACTER SET GENERATING FUNCTIONS START HERE ****************/
//The functions below are used to generate useful character sets that can be used in
//tandem with the filtering functions. For example, generateAlphaNumSet() is used to create
//an array that contains alpha numeric characters (a-z, A-z, 0-9), plus anything else that
//you may want to add (like a dash '-' or an underscore '_'), then use the generated char set
//as the $char_set parameter to dataFilter().

//This function generates a set of alphanumeric characters, and allows additional characters
//to be added to the set, specified in $allow. Note that the each character you want to
//allow must be separated by a space. For example, if you with to allow a dash and an underscore,
//the syntax would be generateAlphaNum("- _");. This is true for all other functions that follow.
//NOTE: This function includes the space (" ") character. If you don't want spaces,
//you can use generateAlphaNumSetNS();
function generateAlphaNumSet($allow=null)
{
	$dataSet = array(
		'0','1','2','3','4','5','6','7','8','9',' ',
		'A','B','C','D','E','F','G','H','I','J','K','L','M',
		'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
		'a','b','c','d','e','f','g','h','i','j','k','l','m',
		'n','o','p','q','r','s','t','u','v','w','x','y','z'
	);
	
	if($allow != null)
	{
		//explode using space character (" ")
		$addChars = explode(" ",$allow);
		$num=count($addChars);
		for($a=0;$a<$num;$a++)
		{
			//We add the allowed character to the data set.
			$dataSet[] = $addChars[$a];
		}
	}
	return $dataSet;
}

//The "No Space" equivalent of generateAlphaNumSet();
function generateAlphaNumSetNS($allow=null)
{
	$dataSet = array(
		'0','1','2','3','4','5','6','7','8','9',
		'A','B','C','D','E','F','G','H','I','J','K','L','M',
		'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
		'a','b','c','d','e','f','g','h','i','j','k','l','m',
		'n','o','p','q','r','s','t','u','v','w','x','y','z'
	);
	
	if($allow != null)
	{
		//explode using space character (" ")
		$addChars = explode(" ",$allow);
		$num=count($addChars);
		for($a=0;$a<$num;$a++)
		{
			//We add the allowed character to the data set.
			$dataSet[] = $addChars[$a];
		}
	}
	return $dataSet;
}


//This function generates a set of numeric characters.
//NOTE: This function includes the space (" ") character. If you don't want spaces,
//you can use generateNumSetNS();
function generateNumSet($allow=null)
{
	$dataSet = array(
		'0','1','2','3','4','5','6','7','8','9',' '
	);
	
	if($allow != null)
	{
		//explode using space character (" ")
		$addChars = explode(" ",$allow);
		$num=count($addChars);
		for($a=0;$a<$num;$a++)
		{
			//We add the allowed character to the data set.
			$dataSet[] = $addChars[$a];
		}
	}
	return $dataSet;
}

//The "No Space" equivalent of generateNumSet();
function generateNumSetNS($allow=null)
{
	$dataSet = array(
		'0','1','2','3','4','5','6','7','8','9'
	);
	
	if($allow != null)
	{
		//explode using space character (" ")
		$addChars = explode(" ",$allow);
		$num=count($addChars);
		for($a=0;$a<$num;$a++)
		{
			//We add the allowed character to the data set.
			$dataSet[] = $addChars[$a];
		}
	}
	return $dataSet;
}

//This function generates an alphabetical set of characters.
//NOTE: This function includes the space (" ") character. If you don't want spaces,
//you can use generateAlphaSetNS();
function generateAlphaSet($allow=null)
{
	$dataSet = array(
		'A','B','C','D','E','F','G','H','I','J','K','L','M',
		'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
		'a','b','c','d','e','f','g','h','i','j','k','l','m',
		'n','o','p','q','r','s','t','u','v','w','x','y','z',' '
	);
	
	if($allow != null)
	{
		//explode using space character (" ")
		$addChars = explode(" ",$allow);
		$num=count($addChars);
		for($a=0;$a<$num;$a++)
		{
			//We add the allowed character to the data set.
			$dataSet[] = $addChars[$a];
		}
	}
	return $dataSet;
}

//The "No Space" equivalent of generateAlphaSet();
function generateAlphaSetNS($allow=null)
{
	$dataSet = array(
		'A','B','C','D','E','F','G','H','I','J','K','L','M',
		'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
		'a','b','c','d','e','f','g','h','i','j','k','l','m',
		'n','o','p','q','r','s','t','u','v','w','x','y','z'
	);
	
	if($allow != null)
	{
		//explode using space character (" ")
		$addChars = explode(" ",$allow);
		$num=count($addChars);
		for($a=0;$a<$num;$a++)
		{
			//We add the allowed character to the data set.
			$dataSet[] = $addChars[$a];
		}
	}
	return $dataSet;
}
/*********** CHARACTER SET GENERATING FUNCTIONS END HERE ****************/

/*********** UNCLASSIFIED SECURITY FUNCTIONS *************************************/
function getShowSQLErrors()
{
	$select = "SELECT Value FROM system_settings WHERE Setting='Show SQL Errors'";
	$query = mysql_query($select);
	$numrows = mysql_num_rows($query);
	if($numrows==1) $data = mysql_fetch_array($query);
	else die("Missing critical system setting - 'Show SQL Errors' <br> Please contact the system administrator.");
	
	return $data['Value'];
}

function restrictedFileProtection($restrictedFile)
{
	if($_SERVER['PHP_SELF'] == $restrictedFile)
	{
		InsertLogEntry("HACK ATTEMPT TYPE II - Tried to access restricted file '$_SERVER[PHP_SELF]'.", basename($_SERVER['PHP_SELF']));
		
		//Just redirect back to home page.
		header("location: /SYNERGY/Home.php");
		exit();
	}
}

function InsertLogEntry($actiontaken, $module = "Undetermined")
{
	session_start();
	if($_SESSION['logged'] != "Logged")
	{
		header("location: /SYNERGY/Login.php");
	}
	else
	{
		$username = $_SESSION['username'];
		$Date = date("m-d-Y");
		$realTime = date("G:i:s");
		$newDate= explode("-", $Date);
		$newTime= explode(":", $realTime);

		$TimeStamp = mktime($newTime[0],$newTime[1],$newTime[2],$newDate[0],$newDate[1],$newDate[2]);	
		$DateTime = date("l, F d, Y -- h:i:s a");

$LogContent = <<<EOD
$username -- $DateTime -- $actiontaken -- $module;

EOD;

		$filename = FULLPATH_CORE . "SCV2_AccessLog.php";
		
		$newfile=fopen($filename,"ab");
		fwrite($newfile, $LogContent);
		
		$actiontaken = addslashes($actiontaken);
		
		$qstring = "INSERT INTO security_log(Username, DateTime, Action, Module) VALUES('$username', '$TimeStamp', '$actiontaken','$module')";
		$query = mysql_query($qstring) or die ("Error inserting new log: " . mysql_error());
	}
}
/****** END OF UNCLASSIFIED SECURITY FUNCTIONS **************************************/
