<?php
class base_validation
{
    var $validity      = FALSE;
    var $error_message = '';
    var $invalid_chars = array();

    //validateData() will perform necessary data validation depending on the value of $type.
    //$char_set, if supplied, contains the valid characters that the data may possess - anything
    //else will mean the data will be considered invalid.
    //$valid_set, if supplied, contains a set of data, the use of which depends on the setting
    //of $whitelist. If $whitelist is set to TRUE (it is by default), then $valid_set is
    //considered to be a whitelist, meaning the only valid values for the submitted data should
    //be in $valid_set, otherwise treat the data as invalid, whatever it is. On the other hand,
    //if $whitelist is set to FALSE, then $valid_set is treated as a blacklist, meaning its
    //contents represent invalid values - if the submitted data contains a value or values that
    //are in $valid_set, then the submitted data is treated as invalid.
    function validate_data($unclean, $type, $char_set="", $valid_set=null, $whitelist=TRUE)
    {
        //First off, trim data.
        $unclean = trim($unclean);

        //Make the data type case insensitive.
        $type = strtolower($type);

        //Catch variants of submitted data type.
        //If the submitted type is unrecognized, default to 'string'.
        switch($type)
        {
            case 'integer'          : $type = 'int'; break;
            case 'double or float'  : $type = 'float'; break;
            default                 : $type = 'string'; break;
        }


        //Initialize $this->validity to be FALSE at the start of every validity check.
        //As the data passes each validity check, $this->validity is set to TRUE.
        //If data fails even just one validity check, $this->validity becomes FALSE,
        //and the validity checking is discontinued.
        $this->validity = FALSE;

        //First of all, if $valid_set is set, then immediately check if data
        //conforms to the defined whitelist or blacklist.
        if($valid_set!=null) //Check if there is $valid_set is specified.
        {
            //Call checkDataSet(), which will verify if the submitted
            //data conforms to the defined whitelist or blacklist.
            $this->check_data_set($unclean, $valid_set, $whitelist);
        }
        else
        {
            //Set to true immediately since by default it is valid
            //because no list of data was given
            $this->validity = TRUE;
        }

        //If data was found valid by whitelist / blacklist check, it's time to
        //check if the data does not contain invalid characters.
        if($this->validity==TRUE)
        {
            if($char_set!="") $this->check_char_set($unclean, $char_set);
        }

        //Continue only if data was found valid by check_char_set().
        if($this->validity==TRUE)
        {
            //Determine type of data being validated.
            //Default is "string".
            //As usual, $this->validity is set to FALSE at the start of validation procedures.
            $this->validity = FALSE;

            if($type=="string")
            {
                //Add necessary string validation here - currently none at the moment,
                //so just set validity to TRUE.
                $this->validity=TRUE;
            }
            elseif($type=="int")
            {
                $this->validity = ctype_digit($unclean);
            }
            elseif($type=="float")
            {
                if($unclean == strval(floatval($unclean)))
                {
                    $this->validity=TRUE;
                }
            }
            elseif($type=="date")
            {

            }
            elseif($type=="time")
            {

            }
        }
    }

    //This function checks if the submitted data conforms to the defined
    //whitelist or blacklist, as specified in $valid_set and $whitelist.
    function check_data_set($unclean, $valid_set, $whitelist)
    {
        if($whitelist) //whitelist approach - $valid_set contains the only values allowed.
        {
            //Initialize $this->validity as FALSE, so that we need to get a match in the
            //whitelist before it becomes valid.
            $this->validity = FALSE;
            if(is_array($valid_set))
            {
                $num = count($valid_set);
                for($a=0;$a<$num;++$a)
                {
                    if($unclean == $valid_set[$a]) $this->validity=TRUE; //Valid because it matched a valid value.
                }
            }
            else
            {
                if($unclean == $valid_set) $this->validity=TRUE; //Valid because it matched a valid value.
            }

            if($this->validity==FALSE)
            {
                $this->error_message = 'Invalid value submitted in: ';
            }
        }
        else //blacklist approach - $valid_set contains the invalid (unallowable) values.
        {
            //Initialize $this->validity as TRUE, so that we need to get a match in the
            //blacklist before it becomes invalid.
            $this->validity = TRUE;
            if(is_array($valid_set))
            {
                $num = count($valid_set);
                for($a=0;$a<$num;++$a)
                {
                    if($unclean == $valid_set[$a]) $this->validity=FALSE; //Invalid because it matched a forbidden value.
                }
            }
            else
            {
                if($unclean == $valid_set) $this->validity=FALSE; //Invalid because it matched a forbidden value.
            }
        }
    }

    function check_char_set($unclean, $char_set)
    {
        //Initialize $this->validity to TRUE because the logic below makes the
        //data invalid only if there is a match found anytime within the loop.
        $this->validity=TRUE;
        $num = mb_strlen($unclean);
        for($a=0;$a<$num;++$a)
        {
            if (!in_array(mb_substr($unclean,$a,1), $char_set))
            {
                $this->validity=FALSE;
                if(!in_array(mb_substr($unclean,$a,1), $this->invalid_chars))
                {
                    if(mb_substr($unclean,$a,1) == ' ')
                    {
                        //Space character was detected as an invalid char. For display purposes, add
                        //something the user can actually see so that he will be properly informed that
                        //the space character is not allowed in the field.
                        $this->invalid_chars[] = '[space]';
                    }
                    $this->invalid_chars[] = mb_substr($unclean,$a,1);
                }
            }
        }
    }

    function check_if_null()
    {
        $this->error_message = '';
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
                if(trim($value)=="") $this->error_message .= "No value detected: $label <BR>";
            }
            else
            {
                $elements = count($value);
                for($arrCnt=0;$arrCnt<$elements;$arrCnt++)
                {
                    if($value[$arrCnt]=='') $this->error_message .= "No value detected: $label in Line #" . ($arrCnt+1) . ".<BR>";
                }
            }
        }
        return $this->error_message;
    }

    function check_if_unique_del($db, $table, $where)
    {
        $data_con = new data_abstraction;
        $data_con->set_database($db);
        $data_con->set_table($table);
        $data_con->set_where($where);
        $data_con->make_query();
        if($data_con->Num_Rows > 0)
        {
            $data_con_del = new data_abstraction;
            $data_con_del->set_query_type('DELETE');
            $data_con_del->set_table($table);
            $data_con_del->set_where($where);
            $data_con_del->make_query();
        }
    }

    function check_if_unique($db, $table, $where, $errMsg)
    {
        $error_message='';
        $data_con  = new data_abstraction;
        $data_con->set_database($db);
        $data_con->set_table($table);
        $data_con->set_where($where);
        $data_con->make_query();
        if($data_con->Num_Rows > 0) $error_message = $errMsg;
        return $error_message;
    }

    function clean_currency(&$number)
    {
        $decimal_split = explode('.', $number);
        $pesos    = $decimal_split[0];

        $num_peso = '';
        $len = strlen($pesos);
        $new_pesos = array();
        for($a=0; $a<$len; ++$a)
        {
            if(ctype_digit($pesos[$a])) $new_pesos[] = $pesos[$a];
        }
        if(is_array($new_pesos))
        {
            foreach($new_pesos AS $peso)
            {
                $num_peso .= $peso;
            }
        }

        $num_centavo = '';
        if(isset($decimal_split[1]))
        {
            $centavos = $decimal_split[1];
            $len = strlen($centavos);
            $new_centavos = array();
            for($a=0; $a<$len; ++$a)
            {
                if(ctype_digit($centavos[$a])) $new_centavos[] = $centavos[$a];
            }
            if(is_array($new_centavos))
            {
                foreach($new_centavos AS $centavo)
                {
                    $num_centavo .= $centavo;
                }
            }
        }

        if($num_peso . $num_centavo != '')
        {
            if($num_centavo == '')
            {
                $num_centavo = '00';
            }
            $number = $num_peso . '.' . $num_centavo;
        }
    }
}