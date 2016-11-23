<?php
class base_documentation
{
    var $language        = '';
    var $language_dir    = '';
    var $vocabulary      = '';
    var $vocabulary_toc  = '';
    var $document_dir    = '';
    var $doc_images_dir  = '';
    var $module_title    = '';
    var $image_formats   = array('jpg','jpeg','png');
    var $max_image_width = '1000';


    function __construct($language='default', $vocabulary='vocabulary.php', $language_dir='language_data', $document_dir='doc_pages', $doc_images_dir='images')
    {
        if($language == 'default')
        {
            $language = DEFAULT_DOC_LANGUAGE;
        }

        $this->language       = $language;
        $this->language_dir   = $language_dir;
        $this->vocabulary     = $vocabulary;
        $this->document_dir   = $document_dir;
        $this->doc_images_dir = $doc_images_dir;
    }

    function create_table_of_contents($arr_pages, $vocabulary_toc='vocabulary_toc.php')
    {
        $this->vocabulary_toc = $vocabulary_toc;
        $vocabulary = FULLPATH_BASE. 'help/' . $this->language_dir . '/' . $this->language . '/' . $this->vocabulary_toc;
        require $vocabulary;

        $html = new html;
        $html->draw_header(GLOBAL_PROJECT_NAME . ' ' . $toc_title);

        echo '<div style="padding: 30px; font-size: 16px;">';

        echo '<div style="display: inline-block;">';
        echo '<img src="../images/' . $_SESSION['icon_set'] . '/documentation.png">';
        echo '</div>';
        echo '<div style="display: inline-block; align: right; vertical-align: top">';
        if(count($arr_pages) > 0)
        {
            echo '<ul style="list-style-type: disc; padding: 10px; padding-left: 25px">';

            foreach($arr_pages as $module_name=>$dir_name)
            {
                echo '<li><a href="' . $this->document_dir . '/' . $dir_name . '/' . $dir_name . '.php">' . $module_name . '</li>';
            }
            echo '</ul>';
        }

        echo '</div>';
    }

    function auto_doc()
    {
        //******************************
        //Getting documentation data
        //******************************
        $module_name = $this->readable_name;
        $vocabulary = FULLPATH_BASE. 'help/' . $this->language_dir . '/' . $this->language . '/' . $this->vocabulary;
        require $vocabulary;
        $highlight_style = 'font-weight: bold; text-decoration: underline;';

        //Get Field Info
        $arr_required=array();
        $arr_optional=array();
        $arr_field_labels=array();
        $arr_field_max_length=array();
        $arr_allow_html=array();
        $arr_allowed_chars=array();
        $arr_valid_set=array();
        $arr_date_default=array();
        foreach($this->fields as $field=>$arr_field_data)
        {
	    //REQUIRED, OPTIONAL, and MAX LENGTH
            $display_max_length    = TRUE;
            $display_allowed_chars = TRUE;
            $display_valid_set     = TRUE;
            if($arr_field_data['required'] == TRUE)
            {
                $arr_required[] = $arr_field_data['label'];
            }
            elseif($arr_field_data['control_type'] == 'none' ||
                   $arr_field_data['control_type'] == '')
            {
                //nothing for fields without control types (auto-increment, hidden / auto fields, removed fields)
                //we also disable showing max length and allowed chars
                $display_max_length    = FALSE;
                $display_allowed_chars = FALSE;
            }
            else
            {
                $arr_optional[] = $arr_field_data['label'];
            }

            if($display_max_length)
            {
                $arr_field_labels[] = $arr_field_data['label'];
                $arr_field_max_length[] = $arr_field_data['length'];
            }

            if($display_allowed_chars)
            {
                if($arr_field_data['char_set_method'] == '')
                {
                    $arr_allowed_chars[] = '***'; //This is a placeholder value that will be interpreted by the template as "all chars allowed"
                }
                else
                {
                    $extra_chars_allowed = $arr_field_data['extra_chars_allowed'];
                    $char_set_allow_space = $arr_field_data['char_set_allow_space'];
                    $char_set_method = $arr_field_data['char_set_method'];

                    require_once 'char_set_class.php';
                    $cg = new char_set;
                    $cg->allow_space = $char_set_allow_space;
                    $cg->$char_set_method($extra_chars_allowed);
                    $arr_allowed_chars[] = $cg->allowed_chars;
                    $cg = null;
                }
            }
        }

        //Scan for images
        clearstatcache();
        $arr_images = array();
        $image_dir = getcwd() . '/' . $this->doc_images_dir;
        if(is_dir($image_dir) && is_readable($image_dir))
        {
            $arr_valid_formats = $this->image_formats;
            if($dh = opendir($image_dir))
            {
                while(($file = readdir($dh)) !== false)
                {
                    $extension = pathinfo($file, PATHINFO_EXTENSION);

                    //Verify that file extension is in whitelist
                    $allowed_extension = FALSE;
                    if(in_array(strtolower($extension), $arr_valid_formats))
                    {
                        $arr_images[] = $file;

                    }
                    else
                    {
                        //ignore
                    }
                }
            }
            sort($arr_images);
        }

        if(count($arr_images) > 0)
        {
            //Make sure images fit -- width should be no more than max_image_width
            $arr_image_widths = array();
            foreach($arr_images as $file)
            {
                $image_data = getimagesize($image_dir . '/' . $file);
                $dimensions = $image_data[3];
                $quote1_pos = strpos($dimensions, '"');
                $quote2_pos = strpos($dimensions, '"', $quote1_pos+1);
                $quote3_pos = strpos($dimensions, '"', $quote2_pos+1);
                $quote4_pos = strpos($dimensions, '"', $quote3_pos+1);
                $width  = substr($dimensions, $quote1_pos+1, $quote2_pos - $quote1_pos -1);
                $height = substr($dimensions, $quote3_pos+1, $quote4_pos - $quote3_pos -1);
                //echo $dimensions . ' with quotes at positions: ' . " $quote1_pos $quote2_pos $quote3_pos $quote4_pos " . '<br>';
                //echo "$file width is $width and height is $height" . '<hr>';

                if($width > 1000)
                {
                    $width = 1000;
                }

                $arr_image_widths[] = $width;
            }
        }

        //Set path to images for image links
        $path_to_images = '/' . BASE_DIRECTORY . '/help/' . $this->document_dir . '/' . basename(getcwd()) . '/' . $this->doc_images_dir . '/';

        //******************************
        //Output
        //******************************
        $html = new html;
        $html->draw_header($this->readable_name);


        echo '<div style="padding: 30px;">';
        echo '<a href="../../contents.php">[Back to Table of Contents]</a>';
        echo '<hr><br>';


        if(isset($arr_images[0]))
        {
            echo '<div style="display: block">';
            echo '<img src="' . $path_to_images . $arr_images[0] . '" width="' . $arr_image_widths[0] . '">';
            echo '</div>';
        }

        echo $how_to_add_intro;
        echo '&nbsp;';
        echo $how_to_add_required;

        if(count($arr_required) > 0)
        {
            echo '<ul style="list-style-type: disc; ' . $highlight_style . '; padding: 10px; padding-left: 25px">';
            foreach($arr_required as $field_name)
            {
                echo '<li>' . $field_name . '</li>';
            }
            echo '</ul>';
        }

        if(count($arr_optional) > 0)
        {
            echo $how_to_add_optional;

            echo '<ul style="list-style-type: circle; ' . $highlight_style . '; padding: 10px; padding-left: 25px">';
            foreach($arr_optional as $field_name)
            {
                echo '<li>' . $field_name . '</li>';
            }
            echo '</ul>';

        }


        if(isset($arr_images[1]))
        {
            echo '<div style="display: block">';
            echo '<img src="' . $path_to_images . $arr_images[1] . '" width="' . $arr_image_widths[1] . '">';
            echo '</div>';
        }


        echo '<br>';
        echo $how_to_add_working_with_fields_0;

        echo '<ul style="list-style-type: circle; padding: 10px; padding-left: 25px">';
        foreach($arr_field_labels as $index=>$field_name)
        {
            echo '<li>';
            echo $how_to_add_working_with_fields_1;
            echo ' <span style="' . $highlight_style . '">' . $field_name . '</span> ';

            if($arr_field_max_length[$index] == 0)
            {
                echo $how_to_add_working_with_fields_4;
            }
            else
            {
                echo $how_to_add_working_with_fields_2;
                echo ' ' . $arr_field_max_length[$index] . ' ';
                echo $how_to_add_working_with_fields_3;
            }
            echo '</li>';
        }
        echo '</ul>';

        if(isset($arr_images[2]))
        {
            $limit = count($arr_images);
            for($a=2; $a<$limit; ++$a)
            {
                echo '<div style="display: block">';
                echo '<img src="' . $path_to_images . $arr_images[$a] . '" width="' . $arr_image_widths[$a] . '">';
                echo '</div>';
                echo '<br>';
            }
        }

        echo '<br>';
        echo $how_to_add_allowed_chars_0;

        echo '<ul style="list-style-type: circle; padding: 10px; padding-left: 25px">';
        $char_limit = 15; //this should probably be a setting of some sort, perhaps in base_documentation_class
        foreach($arr_field_labels as $index=>$field_name)
        {
            echo '<li>';
            echo $how_to_add_allowed_chars_1;
            echo ' <span style="' . $highlight_style . '">' . $field_name . '</span> ';

            if($arr_allowed_chars[$index] == '***')
            {
                echo $how_to_add_allowed_chars_2;
                echo '<br>';
                echo '<table>';
                echo '<tr>';
                echo '<td style="text-align: center; border-style: solid; border-width: 1px; padding-top: 5px; padding-bottom: 5px; width: ' . (40 * $char_limit + 14) . 'px;" colspan="' . $char_limit . '">';
                echo $how_to_add_allowed_chars_4;
                echo '</td>';
                echo '</tr>';
                echo '</table><br>';
            }
            else
            {
                echo $how_to_add_allowed_chars_3;
                echo '<br>';
                echo '<table>';
                echo '<tr>';
                $char_counter=0;
                foreach($arr_allowed_chars[$index] as $char)
                {
                    echo '<td style="text-align: center; border-style: solid; border-width: 1px; padding-top: 5px; padding-bottom: 5px; width: 40px;">';
                    if($char == ' ')
                    {
                        echo '<span style="font-size: 9px">[space]</span>';
                    }
                    elseif($char == "\r")
                    {
                        echo '\r';
                    }
                    elseif($char == "\n")
                    {
                        echo '\n';
                    }
                    else
                    {
                        echo $char;
                    }
                    echo '</td>';
                    ++$char_counter;
                    if($char_counter==$char_limit)
                    {
                        $char_counter=0;
                        echo '</tr>';
                        echo '<tr>';
                    }
                }
                echo '</tr>';

                echo '</table><br>';
            }
            echo '</li>';
        }
        echo '</ul>';


        echo '<br><hr>';
        echo '<a href="../../contents.php">[Back to Table of Contents]</a>';

        echo '</div>';
    }
}