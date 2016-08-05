<?php
class base_char_set
{
    var $allowed_chars = array();
    var $allow_space=TRUE;

    //The functions below are used to generate useful character sets that can be used in
    //tandem with the filtering functions. For example, generate_alphanum_set() is used to create
    //an array that contains alphanumeric characters (a-z, A-z, 0-9), plus anything else that
    //you may want to add (like a dash '-' or an underscore '_'), then use the generated char set
    //as the $char_set parameter to validation->validate_data().

    function add_allowed_chars($allow)
    {
        if($allow != '')
        {
            $add_chars = explode(" ",$allow);
            $num_chars=count($add_chars);
            for($a=0;$a<$num_chars;++$a)
            {
                $this->allowed_chars[] = $add_chars[$a];
            }
        }

        if($this->allow_space)
        {
            $this->allowed_chars[] = ' ';
        }
    }

    function generate_alphanum_set($allow=null)
    {
        $this->allowed_chars = array(
            '0','1','2','3','4','5','6','7','8','9',
            'A','B','C','D','E','F','G','H','I','J','K','L','M',
            'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'a','b','c','d','e','f','g','h','i','j','k','l','m',
            'n','o','p','q','r','s','t','u','v','w','x','y','z',
            "\n", "\r"
        );

        $this->add_allowed_chars($allow);
    }

    function generate_num_set($allow=null)
    {
        $this->allowed_chars = array(
            '0','1','2','3','4','5','6','7','8','9'
        );

        $this->add_allowed_chars($allow);
    }

    function generate_alpha_set($allow=null)
    {
        $this->allowed_chars = array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M',
            'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'a','b','c','d','e','f','g','h','i','j','k','l','m',
            'n','o','p','q','r','s','t','u','v','w','x','y','z',
            "\n", "\r"
        );

        $this->add_allowed_chars($allow);
    }
}