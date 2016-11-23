<?php
class base_graph_creator
{
    //VERSION INFO: 2.02, 2014-07-17
    //Basic members: image dimensions, color, and array of data points
    var $font_directory = GRAPH_CREATOR_FONTDIR; //absolute filesystem path to the fonts directory
    var $image ='';
    var $bg_color = '';
    var $bg_color_rgb = array(85,115,115); //default background color components used if not set by dev
    var $height = 400;
    var $width = 400;
    var $enable_gradient=TRUE;
    var $softening_factor=2.5; //higher value = lighter gradient. 1=normal (no softening).
    var $arr_data_point = array();
    var $right_margin = 30;
    var $image_label_bottom_margin = 30; //height in px of margin between the image label box and the top of the bars. This eats up image label area space. Image label area space is ditcated by $this->image_label_height, and additional space is eaten up by $this->three_dimensional_thickness
    var $image_label_box_color = ''; //color of the box of the image label (topmost portion of image)
    var $image_label_box_color_preset = 'LABEL BOX ORANGE'; //color of the box of the image label (topmost portion of image), set color code here before "init_dataset" is called. Otherwise, for manual graphs, just use the "choose_" or "set_" color functions.
    var $image_label_box_color_rgb = array(0,0,0); //rgb components of the color for the image label box;
    var $image_label_text_color = ''; //color of the text inside the image label box
    var $image_label_text_color_preset = 'WHITE'; //color of the text inside the image label box, set color code here before "init_dataset" is called. Otherwise, for manual graphs, just use the "choose_" or "set_" color functions.
    var $image_label_text_color_rgb = array(0,0,0); //rgb components of the color for the text inside the image label box;
    var $image_label_subtitle_color = ''; //color of the subtitle inside the image label box
    var $image_label_subtitle_color_preset = 'DARK GRAY'; //color of the subtitle inside the image label box, set color code here before "init_dataset" is called. Otherwise, for manual graphs, just use the "choose_" or "set_" color functions.
    var $image_label_subtitle_color_rgb = array(0,0,0); //rgb components of the color for the subtitle inside the image label box;
    var $image_label_font = 'liberation/LiberationMono-Bold.ttf'; //ttf fontfile for the image label
    var $image_label_main_font_size = 16; //font size of the main title of the image label
    var $image_label_subtitle_font_size = 3; //font size of the subtitle of the image label
    var $image_label_height = 100; //specifies the vertical area alloted for the image label;
    var $minimum_data_point = 0; //minimum value that the graph will render. Usually zero, but some graphs can choose to start at a different number
    var $lower_portion_height = 0; //An abstraction, this is filled with the total height of all elements below the actual graph (legend, footer, and anything else that may be added to the lower portion in the future)

    //For legend
    var $legend_enabled = TRUE; //toggle to set whether the legend will be drawn or not
    var $legend_colors = array(); //stores colors used, in order of appearance
    var $legend_labels = array(); //stores labels for a particular color
    var $legend_left_offset = 30; //margin from left side before rendering the legend
    var $legend_item_height = 25; //vertical allotment for each legend item
    var $legend_space_height = 99; //amount of vertical space in the image needed to be allocated for the legend
    var $legend_bottom_margin = 20; //height in px of the margin between the last entry of the legend and the image's lower border or start of footer
    var $legend_top_margin = 30; //height in px of the margin between the first entry of the legend and the bottom coordinate of the space for the labels for the x coordinate
    var $legend_box_color =''; //color of the legend box;
    var $legend_box_color_preset = 'DARK GRAY'; //color of the legend box, set color code here before "init_dataset" is called. Otherwise, for manual graphs, just use the "choose_" or "set_" color functions.
    var $legend_box_color_rgb = array(0,0,0); //rgb components of the color for the legend box;
    var $legend_label_color=''; //color of the legend text;
    var $legend_label_color_preset = 'WHITE'; //color of the legend text, set color code here before "init_dataset" is called. Otherwise, for manual graphs, just use the "choose_" or "set_" color functions.
    var $legend_label_color_rgb= array(0,0,0); //rgb components of the color for the legend text;

    //Footer
    var $footer_enabled = TRUE; //toggle to set whether the footer will be drawn or not
    var $footer_space_height = 20; //amount of vertical space in the image needed to be allocated for the footer
    var $footer_top_margin = 5; //height in px of the margin between the footer and the bottom coordinate of the legend or space for the labels for the x coordinate (whichever is the preceding element)
    var $footer_box_color =''; //color of the footer box;
    var $footer_box_color_preset = 'LIGHT GRAY'; //color of the legend box, set color code here before "init_dataset" is called. Otherwise, for manual graphs, just use the "choose_" or "set_" color functions.
    var $footer_box_color_rgb = array(0,0,0); //rgb components of the color for the legend box;
    var $footer_label_color=''; //color of the legend text;
    var $footer_label_color_preset = 'WHITE'; //color of the legend text, set color code here before "init_dataset" is called. Otherwise, for manual graphs, just use the "choose_" or "set_" color functions.
    var $footer_label_color_rgb= array(0,0,0); //rgb components of the color for the legend text;
    var $footer_label_font = 'liberation/LiberationMono-Italic.ttf'; //ttf fontfile for the image label
    var $footer_label_font_size = 7; //font size of the main title of the image label
    var $footer_label_left_offset = 10; //margin from left side for the footer text.
    var $footer_label_top_offset = 10; //margin from left side for the footer text.
    var $footer_text = 'Cobalt Enterprise Analytics Suite';

    //Chart lines and labels (non data points)
    var $chartline_color = ''; //color for the chart lines (x-axis, y-axis, and the incremental lines in the y-axis)
    var $chartline_color_rgb = array(0,0,0); //rgb components of the color for the chart lines (x-axis, y-axis, and the incremental lines in the y-axis)
    var $chartline_h_coords = array();
    var $chartline_v_coords = array();
    var $write_label = TRUE;
    var $data_labels = array(); //contains color labels for the legend
    var $label_color = ''; //color for the chart labels
    var $label_color_rgb = array(0,0,0); //rgb components of the color for the label
    var $label_font_size = 4;
    var $label_y_coord = '';
    var $label_space_y = 100; //how much area of the image's width is alloted for labels in the y coordinate
    var $label_space_x = 30; //how much area of the image's height is alloted for labels in the x coordinate
    var $write_data_text = TRUE; //whether to write the figure text above the bar or not
    var $data_text_font_size = 2; //size of the data text written above the bar


    //Common to bar graphs and column charts
    var $bar_width = 40; //thickness of an individual bar
    var $bar_space = 10; //how much space in between individual bars
    var $pixels_per_point = 0; //how many pixels to draw per 1 unit in a data point. Value is derived from the data_highest (highest data point) and the bar_height.


    //For bar graphs
    var $bar_length = 200; //vertical space a full-sized bar will take up.
    var $h_adjust = 0; //to position the bar in a different horizontal starting point but still retain its true length.

    //For columnar bar graphs / column charts
    var $bar_height = 200; //vertical space a full-sized bar will take up.
    var $bar_left_offset = 10; //how much horizontal space between first bar and the vertical chart line
    var $bottom_of_bars = 0; //specifies the y-coordinate where bars will be drawn as their starting point. Initialized to zero as this is computed using height of the image, label space for the x coord, and the height of the legend space needed
    var $v_adjust = 0; //to position the bar in a different vertical point but still retain its true height.
    var $three_dimensional_height_px=0; //Not a settable property. Used by column bar graph function

    //For pie charts
    var $pie_center_x = 0; //x coordinate of the central point of the pie chart
    var $pie_center_y = 0; //y coordinate of the central point of the pie chart
    var $pie_width = 300;
    var $pie_height = 300;
    var $pie_total_degrees = 360; //You can lower this if you intend not to render a complete circle
    var $pie_gradient_limiter = 10; //Gradient limiter. Formula: (pie_height + pie_width) / pie_gradient_limiter. The smaller the value, the more compute intensive creating the pie gradient becomes.
                                        //Default of "10" is good enough for 300x300 pie. For smaller pies, you may need to lessen the number to avoid seeing rings in the pie (rough gradient).
                                        //For pies larger than 300x300, you may try to increase the value in order to mitigate processing time somewhat, until the point where rings start to appear. The bigger the pie, the higher this max value possible.

    //3D members
    var $three_dimensional = TRUE;
    var $three_dimensional_outline_color = 'WHITE';
    var $three_dimensional_thickness = 10;

    //dataset members
    var $data_initialized = FALSE;
    var $data_count = 0;
    var $data_highest = 0;
    var $data_lowest = 0;

    //color members and predefined color constants
    var $color = '';
    var $color_rgb = array(0,0,0); //rgb components of allocated color
    var $color_3d = '';
    var $color_3d_rgb = array(0,0,0);//rgb component of allocated color for the 3D portions of a graph element
    var $color_constants = array('RED' => array(255,0,0),
                                 'DARK RED' => array(170,0,0),
                                 'DARKER RED' => array(130,0,0),
                                 'GREEN' => array(0,255,0),
                                 'DARK GREEN' => array(0,170,0),
                                 'DARKER GREEN' => array(0,120,0),
                                 'BLUE' => array(0,0,255),
                                 'DARK BLUE' => array(0,0,170),
                                 'DARKER BLUE' => array(0,0,120),
                                 'YELLOW' => array(255,255,0),
                                 'DARK YELLOW' => array(215,215,0),
                                 'DARKER YELLOW' => array(195,195,0),
                                 'ORANGE' => array(255,130,0),
                                 'DARK ORANGE' => array(255,80,0),
                                 'DARKER ORANGE' => array(200,80,0),
                                 'BROWN'=> array(190,120,0),
                                 'DARK BROWN' => array(150,90,0),
                                 'DARKER BROWN' => array(110,60,0),
                                 'PURPLE' => array(200,0,160),
                                 'DARK PURPLE' => array(170,0,140),
                                 'DARKER PURPLE' => array(130,0,110),
                                 'SKY BLUE' => array(183,207,255),
                                 'DARK SKY BLUE' => array(163,188,217),
                                 'DARKER SKY BLUE' => array(128,171,219),
                                 'PINK' => array(255,158,222),
                                 'DARK PINK' => array(255,119,209),
                                 'DARKER PINK' => array(255,85,197),
                                 'LIGHT GRAY' => array(140,140,140),
                                 'MEDIUM GRAY' => array(100,100,100),
                                 'DARK GRAY' => array(70,70,70),
                                 'WHITE' => array(255,255,255),
                                 'BLACK' => array(0,0,0),
                                 'LABEL GRAY' => array(200,200,200),
                                 'LABEL BOX ORANGE' => array(248,182,53)
                                 );
    var $color_set_2d = array('RED','GREEN','BLUE','YELLOW','BROWN','PURPLE','ORANGE','SKY BLUE','PINK','LIGHT GRAY',
                              'DARK RED','DARK GREEN','DARK BLUE','DARK YELLOW','DARK BROWN','DARK PURPLE','DARK ORANGE','DARK SKY BLUE','DARK PINK','MEDIUM GRAY',
                              'DARKER RED','DARKER GREEN','DARKER BLUE','DARKER YELLOW','DARKER BROWN','DARKER PURPLE','DARKER ORANGE','DARKER SKY BLUE','DARKER PINK','DARK GRAY'
                             );
    var $color_set_3d = array('DARK RED','DARK GREEN','DARK BLUE','DARK YELLOW','DARK BROWN','DARK PURPLE','DARK ORANGE','DARK SKY BLUE','DARK PINK','MEDIUM GRAY',
                              'DARKER RED','DARKER GREEN','DARKER BLUE','DARKER YELLOW','DARKER BROWN','DARKER PURPLE','DARKER ORANGE','DARKER SKY BLUE','DARKER PINK','DARK GRAY');


    function __construct($width=0, $height=0)
    {
        $this->width = $width;
        $this->height = $height;
    }

    function init_dataset($dataset, $subtitle)
    {
        //note: $dataset is expected to be an array
        if(is_array($dataset))
        {
            $this->arr_data_point = $dataset;
        }
        else
        {
            die("Invalid data set, cannot initialize.");
        }

        //Get # of data points
        $this->data_count = count($dataset);

        //Get highest value, then round up
        //Highest value is "normalized" to a round figure for purposes of the label, for example if the highest point in the dataset is 173, data_highest will contain 180.
        //However, the data point that corresponds to 173 will still be drawn to the proper scale, not rounded up.
        //Values with 3 digits will be rounded to the nearest ten, whiles 4 digits and above will be rounded to the nearest hundred.
        rsort($dataset);
        $max_figure = ceil($dataset[0]); //ceil() to remove any decimal portion by rounding up before counting the digits
        $num_digits = strlen($max_figure);
        if($num_digits > 3)
        {
            $rounding_factor = 0 - ($num_digits - 2);
        }
        elseif($num_digits > 1)
        {
            $rounding_factor = -1;
        }
        else
        {
            $rounding_factor = -1;
        }

        if($this->data_highest==0 || $this->data_highest < $max_figure)
        {
            if($max_figure <= 4)
            {
                $this->data_highest = 4;
            }
            elseif($max_figure <= 8)
            {
                $this->data_highest = 8;
            }
            else
            {
                //No max value was manually specified by the dev, or max value specified is too small, so derive highest value from max figure in data set
                $this->data_highest = round($max_figure, $rounding_factor);
                if($this->data_highest < $dataset[0]) //this happens if round() ends up rounding down instead of up
                {
                    $this->data_highest += pow(10,  abs($rounding_factor));
                }
            }
        }

        //Get lowest value
        $this->data_lowest = $dataset[$this->data_count - 1];

        //Set initialized flag to TRUE to activate related methods.
        $this->data_initialized = TRUE;

        if($this->legend_enabled)
        {
            //Compute vertical space needed for legend
            $legend_height_needed = ($this->data_count * $this->legend_item_height) + $this->legend_bottom_margin + $this->legend_top_margin;
            if($legend_height_needed > $this->legend_space_height)
            {
                $this->legend_space_height = $legend_height_needed;
            }
        }
        else
        {
            $this->legend_space_height = 0;
        }

        if($this->footer_enabled)
        {
            $this->footer_space_height; //whatever is default value, no change.
        }
        else
        {
            $this->footer_space_height = 0;
        }

        //Set lower_portion_height for benefit of other methods
        $this->lower_portion_height = $this->legend_space_height + $this->footer_space_height;

        //If subtitle has multiple lines, image_label_height might need to be adjusted if the user did not adjust it himself
        if(is_array($subtitle))
        {
            $num_extra_lines = count($subtitle) - 1;
            $needed_image_label_height = 100 + ($num_extra_lines * 20);
            if($needed_image_label_height > $this->image_label_height)
            {
                $this->image_label_height = $needed_image_label_height;
            }
        }

        //Compute vertical space needed overall
        $height_needed = $this->footer_space_height +
                         $this->legend_space_height +
                         $this->image_label_height +
                         $this->bar_height +
                         $this->label_space_x;
        if($height_needed > $this->height)
        {
            $this->height = $height_needed;
        }
        elseif($height_needed < $this->height)
        {
            //This could mean that the user specified a custom height, and exceeds needed space.
            //We need to get the excess and override the value of $this->bar_height to accomodate this change
            $this->bar_height += $this->height - $height_needed;
        }

        //Compute horizontal space, given the bar width, bar space, number of data points, and label space of the y coordinate
        $width_needed = $this->label_space_y + $this->bar_left_offset + (($this->bar_width + $this->bar_space) * $this->data_count) + $this->right_margin;

        if($this->three_dimensional)  $width_needed += ($this->three_dimensional_thickness * $this->data_count);


        if($width_needed > $this->width)
        {
            $this->width = $width_needed;
        }

        $this->bottom_of_bars = $this->height -
                                $this->legend_space_height -
                                $this->footer_space_height -
                                $this->label_space_x - 1; //-1 is needed so the bars do not overlap with the chart line
        $this->label_y_coord = $this->bottom_of_bars + 3;

        $this->image = imagecreatetruecolor($this->width, $this->height)
            or die("Cannot Initialize new GD image stream");

        $this->set_background();
        $this->choose_image_label_box_color($this->image_label_box_color_preset);
        $this->choose_image_label_text_color($this->image_label_text_color_preset);
        $this->choose_image_label_subtitle_color($this->image_label_subtitle_color_preset);

        if($this->legend_enabled)
        {
            $this->choose_legend_box_color($this->legend_box_color_preset);
            $this->choose_legend_label_color($this->legend_label_color_preset);
        }

        if($this->footer_enabled)
        {
            $this->choose_footer_box_color($this->footer_box_color_preset);
            $this->choose_footer_label_color($this->footer_label_color_preset);
        }

        //Get pixels per point
        $this->pixels_per_point = $this->bar_height / $this->data_highest;
    }

    function init_dataset_bar($dataset, $subtitle)
    {
        //note: $dataset is expected to be an array
        if(is_array($dataset))
        {
            $this->arr_data_point = $dataset;
        }
        else
        {
            die("Invalid data set, cannot initialize.");
        }

        //Get # of data points
        $this->data_count = count($dataset);

        //Get highest value, then round up
        //Highest value is "normalized" to a round figure for purposes of the label, for example if the highest point in the dataset is 173, data_highest will contain 180.
        //However, the data point that corresponds to 173 will still be drawn to the proper scale, not rounded up.
        //Values with 3 digits will be rounded to the nearest ten, whiles 4 digits and above will be rounded to the nearest hundred.
        rsort($dataset);
        $max_figure = ceil($dataset[0]); //ceil() to remove any decimal portion by rounding up before counting the digits
        $num_digits = strlen($max_figure);
        if($num_digits > 3)
        {
            $rounding_factor = 0 - ($num_digits - 2);
        }
        elseif($num_digits > 1)
        {
            $rounding_factor = -1;
        }
        else
        {
            $rounding_factor = -1;
        }

        if($this->data_highest==0 || $this->data_highest < $max_figure)
        {
            if($max_figure <= 4)
            {
                $this->data_highest = 4;
            }
            elseif($max_figure <= 8)
            {
                $this->data_highest = 8;
            }
            else
            {
                //No max value was manually specified by the dev, or max value specified is too small, so derive highest value from max figure in data set
                $this->data_highest = round($max_figure, $rounding_factor);
                if($this->data_highest < $dataset[0]) //this happens if round() ends up rounding down instead of up
                {
                    $this->data_highest += pow(10,  abs($rounding_factor));
                }
            }
        }

        //Get lowest value
        $this->data_lowest = $dataset[$this->data_count - 1];

        //Set initialized flag to TRUE to activate related methods.
        $this->data_initialized = TRUE;

        if($this->legend_enabled)
        {
            //Compute vertical space needed for legend
            $legend_height_needed = ($this->data_count * $this->legend_item_height) + $this->legend_bottom_margin + $this->legend_top_margin;
            if($legend_height_needed > $this->legend_space_height)
            {
                $this->legend_space_height = $legend_height_needed;
            }
        }
        else
        {
            $this->legend_space_height = 0;
        }

        if($this->footer_enabled)
        {
            $this->footer_space_height; //whatever is default value, no change.
        }
        else
        {
            $this->footer_space_height = 0;
        }

        //Set lower_portion_height for benefit of other methods
        $this->lower_portion_height = $this->legend_space_height + $this->footer_space_height;

        //If subtitle has multiple lines, image_label_height might need to be adjusted if the user did not adjust it himself
        if(is_array($subtitle))
        {
            $num_extra_lines = count($subtitle) - 1;
            $needed_image_label_height = 100 + ($num_extra_lines * 20);
            if($needed_image_label_height > $this->image_label_height)
            {
                $this->image_label_height = $needed_image_label_height;
            }
        }

        //Compute vertical space needed overall
        $height_needed = $this->footer_space_height +
                         $this->legend_space_height +
                         $this->image_label_height +
                         $this->bar_height +
                         $this->label_space_x;
        if($height_needed > $this->height)
        {
            $this->height = $height_needed;
        }
        elseif($height_needed < $this->height)
        {
            //This could mean that the user specified a custom height, and exceeds needed space.
            //We need to get the excess and override the value of $this->bar_height to accomodate this change
            $this->bar_height += $this->height - $height_needed;
        }

        //Compute horizontal space, given the bar width, bar space, number of data points, and label space of the y coordinate
        $width_needed = $this->label_space_y + $this->bar_left_offset + (($this->bar_width + $this->bar_space) * $this->data_count) + $this->right_margin;

        if($this->three_dimensional)  $width_needed += ($this->three_dimensional_thickness * $this->data_count);


        if($width_needed > $this->width)
        {
            $this->width = $width_needed;
        }

        $this->bottom_of_bars = $this->height -
                                $this->legend_space_height -
                                $this->footer_space_height -
                                $this->label_space_x - 1; //-1 is needed so the bars do not overlap with the chart line
        $this->label_y_coord = $this->bottom_of_bars + 3;

        $this->image = imagecreatetruecolor($this->width, $this->height)
            or die("Cannot Initialize new GD image stream");

        $this->set_background();
        $this->choose_image_label_box_color($this->image_label_box_color_preset);
        $this->choose_image_label_text_color($this->image_label_text_color_preset);
        $this->choose_image_label_subtitle_color($this->image_label_subtitle_color_preset);

        if($this->legend_enabled)
        {
            $this->choose_legend_box_color($this->legend_box_color_preset);
            $this->choose_legend_label_color($this->legend_label_color_preset);
        }

        if($this->footer_enabled)
        {
            $this->choose_footer_box_color($this->footer_box_color_preset);
            $this->choose_footer_label_color($this->footer_label_color_preset);
        }

        //Get pixels per point
        $this->pixels_per_point = $this->bar_height / $this->data_highest;
    }

    function init_dataset_pie($dataset)
    {
        //note: $dataset is expected to be an array
        if(is_array($dataset))
        {
            $this->arr_data_point = $dataset;
        }
        else
        {
            die("Invalid data set, cannot initialize.");
        }

        //Get # of data points
        $this->data_count = count($dataset);

        //Get highest value
        rsort($dataset);
        $max_figure =  $dataset[0];
        $num_digits = strlen($max_figure);
        $this->data_lowest = $dataset[$this->data_count - 1];

        //Set initialized flag to TRUE to activate related methods.
        $this->data_initialized = TRUE;

        if($this->legend_enabled)
        {
            //Compute vertical space needed for legend
            $legend_height_needed = ($this->data_count * $this->legend_item_height) + $this->legend_bottom_margin + $this->legend_top_margin;
            if($legend_height_needed > $this->legend_space_height)
            {
                $this->legend_space_height = $legend_height_needed;
            }
        }
        else
        {
            $this->legend_space_height = 0;
        }

        if($this->footer_enabled)
        {
            $this->footer_space_height; //whatever is default value, no change.
        }
        else
        {
            $this->footer_space_height = 0;
        }

        //Set lower_portion_height for benefit of other methods
        $this->lower_portion_height = $this->legend_space_height + $this->footer_space_height;

        //If subtitle has multiple lines, image_label_height might need to be adjusted if the user did not adjust it himself
        if(isset($subtitle) && is_array($subtitle))
        {
            $num_extra_lines = count($subtitle) - 1;
            $needed_image_label_height = 100 + ($num_extra_lines * 20);
            if($needed_image_label_height > $this->image_label_height)
            {
                $this->image_label_height = $needed_image_label_height;
            }
        }

        //Compute vertical space needed overall
        if($this->three_dimensional)
        {
            //For three dimensional rendering, height is reduced to 2/3 original so that resulting shape is not a perfect circle.
            //End result is that the 3D pie chart is rendered as seen from an isometric view, rather than looking at the pie from a plain top-view persepective.
            $this->pie_height = $this->pie_height * (2/3);
            $height_needed = $this->lower_portion_height + $this->image_label_height + $this->pie_height;
            $height_needed += $this->three_dimensional_thickness;
        }
        else
        {
            $height_needed = $this->lower_portion_height + $this->image_label_height + $this->pie_height;
        }

        if($height_needed > $this->height)
        {
            $this->height = $height_needed;
        }

        //Compute horizontal space, given the pie width, bar space, number of data points, and label space of the y coordinate
        $width_needed = $this->label_space_y + $this->pie_width + $this->right_margin;

        if($width_needed > $this->width)
        {
            $this->width = $width_needed;
        }

        $this->image = imagecreatetruecolor($this->width, $this->height)
            or die("Cannot Initialize new GD image stream");

        //Based on image width, image label height and pie height, get the values for the pie_center_x and pie_center_y coordinates.
        $this->pie_center_x = $this->width / 2;
        $this->pie_center_y = ($this->pie_height / 2) + $this->image_label_height;

        $this->set_background();
        $this->choose_image_label_box_color($this->image_label_box_color_preset);
        $this->choose_image_label_text_color($this->image_label_text_color_preset);
        $this->choose_image_label_subtitle_color($this->image_label_subtitle_color_preset);

        if($this->legend_enabled)
        {
            $this->choose_legend_box_color($this->legend_box_color_preset);
            $this->choose_legend_label_color($this->legend_label_color_preset);
        }

        if($this->footer_enabled)
        {
            $this->choose_footer_box_color($this->footer_box_color_preset);
            $this->choose_footer_label_color($this->footer_label_color_preset);
        }

    }

    function set_background($red=null, $green=null, $blue=null)
    {
        if($red != null) $this->bg_color_rgb[0] = $red;
        if($green != null) $this->bg_color_rgb[1] = $green;
        if($blue != null) $this->bg_color_rgb[2] = $blue;

        $this->bg_color = imagecolorallocate($this->image,
                                             $this->bg_color_rgb[0],
                                             $this->bg_color_rgb[1],
                                             $this->bg_color_rgb[2]);

        imagefilledrectangle($this->image, 0, 0, $this->width, $this->height, $this->bg_color);

    }

    //accepts RGB component colors, then applies gradient algorithm
    function apply_gradient_step(&$red, &$green, &$blue, $orig_red, $orig_green, $orig_blue, $gradient_color_step_red, $gradient_color_step_green, $gradient_color_step_blue)
    {
        $color_has_changed=false;
        if($red < $orig_red)
        {
            $red += $gradient_color_step_red;
            $color_has_changed=true;
        }
        if($green < $orig_green)
        {
            $green += $gradient_color_step_green;
            $color_has_changed=true;
        }
        if($blue < $orig_blue)
        {
            $blue += $gradient_color_step_blue;
            $color_has_changed=true;
        }
        if($color_has_changed == false)
        {
            $red=$orig_red;
            $green=$orig_green;
            $blue=$orig_blue;
        }
    }

    function compute_gradient_step($color, $num_gradiations, $softening_factor)
    {
        if($num_gradiations * $softening_factor == 0)
        {
            $gradient_step = $color / 1;
        }
        else
        {
            $gradient_step = $color / ($num_gradiations * $softening_factor);
        }
        return $gradient_step;
    }

    function apply_gradient_step_reverse(&$red, &$green, &$blue, $orig_red, $orig_green, $orig_blue, $gradient_color_step_red, $gradient_color_step_green, $gradient_color_step_blue)
    {
        $color_has_changed=false;
        if($red > $final_red)
        {
            $red -= $gradient_color_step_red;
            $color_has_changed=true;
        }
        if($green > $final_green)
        {
            $green -= $gradient_color_step_green;
            $color_has_changed=true;
        }
        if($blue > $final_blue)
        {
            $blue -= $gradient_color_step_blue;
            $color_has_changed=true;
        }
        if($color_has_changed == false)
        {
            $red=$orig_red;
            $green=$orig_green;
            $blue=$orig_blue;
        }
    }


    function choose_3d_color($color)
    {
        $color = strtoupper($color);
        if(is_array($this->color_constants[$color]))
        {
            if(is_int($this->color_3d)) imagecolordeallocate($this->image,$this->color_3d);
            $this->color_3d = imagecolorallocate($this->image,
                                                 $this->color_constants[$color][0],
                                                 $this->color_constants[$color][1],
                                                 $this->color_constants[$color][2]);

            $this->color_3d_rgb = array($this->color_constants[$color][0],
                                        $this->color_constants[$color][1],
                                        $this->color_constants[$color][2]);
        }
        else
        {
            echo "<hr>Graph Creator Error: Color Constant '$color' does not exist!<hr>";
        }
    }

    function derive_3d_color($red, $green, $blue)
    {
        $color_has_changed=false;
        if($red > 50)
        {
            $red -= 50;
            $color_has_changed=true;
        }
        if($green > 50)
        {
            $green -= 50;
            $color_has_changed=true;
        }
        if($blue > 50)
        {
            $blue -= 50;
            $color_has_changed=true;
        }

        if($color_has_changed == false)
        {
            //Color is already very dark, use black
            $red=0;
            $green=0;
            $blue=0;
        }

        $this->set_3d_color($red, $green, $blue);
    }

    function set_3d_color($red=0, $green=0, $blue=0)
    {
        if(is_int($this->color_3d)) imagecolordeallocate($this->image,$this->color_3d);
        $this->color_3d = imagecolorallocate($this->image,
                                             $red,
                                             $green,
                                             $blue);
        $this->color_3d_rgb = array($red, $green, $blue);
    }

    function choose_color($color)
    {
        $color = strtoupper($color);
        if(is_array($this->color_constants[$color]))
        {
            //if(is_int($this->color)) imagecolordeallocate($this->image,$this->color);
            $this->color = imagecolorallocate($this->image,
                                              $this->color_constants[$color][0],
                                              $this->color_constants[$color][1],
                                              $this->color_constants[$color][2]);

            $this->color_rgb = array($this->color_constants[$color][0],
                                     $this->color_constants[$color][1],
                                     $this->color_constants[$color][2]);
        }
        else
        {
            echo "<hr>Graph Creator Error: Color Constant '$color' does not exist!<hr>";
        }
    }

    function set_color($red=0, $green=0, $blue=0)
    {
        $this->color = imagecolorallocate($this->image,
                                          $red,
                                          $green,
                                          $blue);
        $this->color_rgb = array($red, $green, $blue);
    }

    function choose_chartline_color($color)
    {
        $color = strtoupper($color);
        if(is_array($this->color_constants[$color]))
        {
            if(is_int($this->chartline_color)) imagecolordeallocate($this->image,$this->chartline_color);
            $this->chartline_color = imagecolorallocate($this->image,
                                                        $this->color_constants[$color][0],
                                                        $this->color_constants[$color][1],
                                                        $this->color_constants[$color][2]);
            $this->chartline_color_rgb = array($this->color_constants[$color][0],
                                               $this->color_constants[$color][1],
                                               $this->color_constants[$color][2]);
        }
        else
        {
            echo "<hr>Graph Creator Error: Color Constant '$color' does not exist!<hr>";
        }
    }

    function set_chartline_color($red=0, $green=0, $blue=0)
    {
        if(is_int($this->chartline_color)) imagecolordeallocate($this->image,$this->chartline_color);
        $this->chartline_color = imagecolorallocate($this->image,
                                                    $red,
                                                    $green,
                                                    $blue);
        $this->chartline_color_rgb = array($red, $green, $blue);
    }

    function choose_label_color($color)
    {
        $color = strtoupper($color);
        if(is_array($this->color_constants[$color]))
        {
            if(is_int($this->label_color)) imagecolordeallocate($this->image,$this->label_color);
            $this->label_color = imagecolorallocate($this->image,
                                                    $this->color_constants[$color][0],
                                                    $this->color_constants[$color][1],
                                                    $this->color_constants[$color][2]);
            $this->label_color_rgb = array($this->color_constants[$color][0],
                                           $this->color_constants[$color][1],
                                           $this->color_constants[$color][2]);
        }
        else
        {
            echo "<hr>Graph Creator Error: Color Constant '$color' does not exist!<hr>";
        }
    }

    function set_label_color($red=0, $green=0, $blue=0)
    {
        if(is_int($this->label_color)) imagecolordeallocate($this->image,$this->label_color);
        $this->label_color = imagecolorallocate($this->image,
                                                $red,
                                                $green,
                                                $blue);
        $this->label_color_rgb = array($red, $green, $blue);
    }


    /*** FOOTER COLOR HELPER ***/
    function choose_footer_box_color($color)
    {
        $color = strtoupper($color);
        if(is_array($this->color_constants[$color]))
        {
            if(is_int($this->footer_box_color)) imagecolordeallocate($this->image,$this->footer_box_color);
            $this->footer_box_color = imagecolorallocate($this->image,
                                                        $this->color_constants[$color][0],
                                                        $this->color_constants[$color][1],
                                                        $this->color_constants[$color][2]);
            $this->footer_box_color_rgb = array($this->color_constants[$color][0],
                                                $this->color_constants[$color][1],
                                                $this->color_constants[$color][2]);
        }
        else
        {
            echo "<hr>Graph Creator Error: Color Constant '$color' does not exist!<hr>";
        }
    }

    function set_footer_box_color($red=0, $green=0, $blue=0)
    {
        if(is_int($this->footer_box_color)) imagecolordeallocate($this->image,$this->footer_box_color);
        $this->footer_box_color = imagecolorallocate($this->image,
                                                    $red,
                                                    $green,
                                                    $blue);
        $this->footer_box_color_rgb = array($red, $green, $blue);
    }

    function choose_footer_label_color($color)
    {
        $color = strtoupper($color);
        if(is_array($this->color_constants[$color]))
        {
            if(is_int($this->footer_label_color)) imagecolordeallocate($this->image,$this->footer_label_color);
            $this->footer_label_color = imagecolorallocate($this->image,
                                                           $this->color_constants[$color][0],
                                                           $this->color_constants[$color][1],
                                                           $this->color_constants[$color][2]);
            $this->footer_label_color_rgb = array($this->color_constants[$color][0],
                                                  $this->color_constants[$color][1],
                                                  $this->color_constants[$color][2]);
        }
        else
        {
            echo "<hr>Graph Creator Error: Color Constant '$color' does not exist!<hr>";
        }
    }

    function set_footer_label_color($red=0, $green=0, $blue=0)
    {
        if(is_int($this->footer_label_color)) imagecolordeallocate($this->image,$this->footer_label_color);
        $this->footer_label_color = imagecolorallocate($this->image,
                                                       $red,
                                                       $green,
                                                       $blue);
        $this->footer_label_color_rgb = array($red, $green, $blue);
    }



    /*** LEGEND COLOR HELPERS ***/
    function choose_legend_box_color($color)
    {
        $color = strtoupper($color);
        if(is_array($this->color_constants[$color]))
        {
            if(is_int($this->legend_box_color)) imagecolordeallocate($this->image,$this->legend_box_color);
            $this->legend_box_color = imagecolorallocate($this->image,
                                                        $this->color_constants[$color][0],
                                                        $this->color_constants[$color][1],
                                                        $this->color_constants[$color][2]);
            $this->legend_box_color_rgb = array($this->color_constants[$color][0],
                                                $this->color_constants[$color][1],
                                                $this->color_constants[$color][2]);
        }
        else
        {
            echo "<hr>Graph Creator Error: Color Constant '$color' does not exist!<hr>";
        }
    }

    function set_legend_box_color($red=0, $green=0, $blue=0)
    {
        if(is_int($this->legend_box_color)) imagecolordeallocate($this->image,$this->legend_box_color);
        $this->legend_box_color = imagecolorallocate($this->image,
                                                    $red,
                                                    $green,
                                                    $blue);
        $this->legend_box_color_rgb = array($red, $green, $blue);
    }

    function choose_legend_label_color($color)
    {
        $color = strtoupper($color);
        if(is_array($this->color_constants[$color]))
        {
            if(is_int($this->legend_label_color)) imagecolordeallocate($this->image,$this->legend_label_color);
            $this->legend_label_color = imagecolorallocate($this->image,
                                                           $this->color_constants[$color][0],
                                                           $this->color_constants[$color][1],
                                                           $this->color_constants[$color][2]);
            $this->legend_label_color_rgb = array($this->color_constants[$color][0],
                                                  $this->color_constants[$color][1],
                                                  $this->color_constants[$color][2]);
        }
        else
        {
            echo "<hr>Graph Creator Error: Color Constant '$color' does not exist!<hr>";
        }
    }

    function set_legend_label_color($red=0, $green=0, $blue=0)
    {
        if(is_int($this->legend_label_color)) imagecolordeallocate($this->image,$this->legend_label_color);
        $this->legend_label_color = imagecolorallocate($this->image,
                                                       $red,
                                                       $green,
                                                       $blue);
        $this->legend_label_color_rgb = array($red, $green, $blue);
    }

    function choose_image_label_box_color($color)
    {
        $color = strtoupper($color);
        if(is_array($this->color_constants[$color]))
        {
            if(is_int($this->image_label_box_color)) imagecolordeallocate($this->image,$this->image_label_box_color);
            $this->image_label_box_color = imagecolorallocate($this->image,
                                                              $this->color_constants[$color][0],
                                                              $this->color_constants[$color][1],
                                                              $this->color_constants[$color][2]);
            $this->image_label_box_color_rgb = array($this->color_constants[$color][0],
                                                     $this->color_constants[$color][1],
                                                     $this->color_constants[$color][2]);
        }
        else
        {
            echo "<hr>Graph Creator Error: Color Constant '$color' does not exist!<hr>";
        }
    }

    function set_image_label_box_color($red=0, $green=0, $blue=0)
    {
        if(is_int($this->image_label_box_color)) imagecolordeallocate($this->image,$this->image_label_box_color);
        $this->image_label_box_color = imagecolorallocate($this->image,
                                                          $red,
                                                          $green,
                                                          $blue);
        $this->image_label_box_color_rgb = array($red, $green, $blue);
    }

    function choose_image_label_text_color($color)
    {
        $color = strtoupper($color);
        if(is_array($this->color_constants[$color]))
        {
            if(is_int($this->image_label_text_color)) imagecolordeallocate($this->image,$this->image_label_text_color);
            $this->image_label_text_color = imagecolorallocate($this->image,
                                                               $this->color_constants[$color][0],
                                                               $this->color_constants[$color][1],
                                                               $this->color_constants[$color][2]);
            $this->image_label_text_color_rgb = array($this->color_constants[$color][0],
                                                      $this->color_constants[$color][1],
                                                      $this->color_constants[$color][2]);
        }
        else
        {
            echo "<hr>Graph Creator Error: Color Constant '$color' does not exist!<hr>";
        }
    }

    function set_image_label_text_color($red=0, $green=0, $blue=0)
    {
        if(is_int($this->image_label_text_color)) imagecolordeallocate($this->image,$this->image_label_text_color);
        $this->image_label_text_color = imagecolorallocate($this->image,
                                                          $red,
                                                          $green,
                                                          $blue);
        $this->image_label_text_color_rgb = array($red, $green, $blue);
    }

    function choose_image_label_subtitle_color($color)
    {
        $color = strtoupper($color);
        if(is_array($this->color_constants[$color]))
        {
            if(is_int($this->image_label_subtitle_color)) imagecolordeallocate($this->image,$this->image_label_subtitle_color);
            $this->image_label_subtitle_color = imagecolorallocate($this->image,
                                                               $this->color_constants[$color][0],
                                                               $this->color_constants[$color][1],
                                                               $this->color_constants[$color][2]);
            $this->image_label_subtitle_color_rgb = array($this->color_constants[$color][0],
                                                     $this->color_constants[$color][1],
                                                     $this->color_constants[$color][2]);
        }
        else
        {
            echo "<hr>Graph Creator Error: Color Constant '$color' does not exist!<hr>";
        }
    }

    function set_image_label_subtitle_color($red=0, $green=0, $blue=0)
    {
        if(is_int($this->image_label_subtitle_color)) imagecolordeallocate($this->image, $this->image_label_subtitle_color);
        $this->image_label_subtitle_color = imagecolorallocate($this->image,
                                                          $red,
                                                          $green,
                                                          $blue);
        $this->image_label_subtitle_color_rgb = array($red, $green, $blue);
    }


    //*************************
    //START: COLUMN BAR METHODS
    //*************************
    function draw_col_bar($x_pos, $data, $label)
    {
        $data_text = $data;

        if($data < $this->minimum_data_point)
        {
            $data = 1;
        }
        else
        {
            $data -= $this->minimum_data_point;
        }


        if($this->data_initialized == FALSE)
        {
            die("Please initialize data set first through init_dataset() before attempting to draw a data point");
        }

        $bottom = $this->bottom_of_bars + $this->v_adjust;
        $width = $this->bar_width;

        //convert data to bar pixels using pixels per point
        $height = $data * $this->pixels_per_point;

        //If three dimensional, height should be subtracted by the 3d bar thickness
        if($this->three_dimensional)
        {
            $height -= $this->three_dimensional_thickness;
            if($height < 0) $height=0; //make sure no negative value gets stored in height
        }

        //convert height info to usable top coordinate for rendering the bar
        //image_label_height + (bar_height - $height)
        $top = $this->image_label_height + ($this->bar_height - $height);

        if($this->three_dimensional)
        {
            $this->three_dimensional_height_px = $height;
            $this->draw_3D_col_bar($x_pos, $top, $width);
        }

        imagefilledrectangle($this->image,
                             $x_pos,          $top,
                             $x_pos + $width, $bottom,
                             $this->color);

        $this->legend_colors[] = $this->color;



        if($this->enable_gradient)
        {
            $this->draw_col_bar_gradient($bottom, $top, $x_pos, $width);
        }


        if($this->write_label)
        {
            $this->choose_label_color('LABEL GRAY');
            imagestring($this->image,
                        $this->label_font_size,
                        $x_pos,
                        $this->label_y_coord,
                        $label, $this->label_color);
        }

        if($this->write_data_text)
        {
            $y_adjust = 14;
            if($this->three_dimensional)
            {
                $y_adjust+=$this->three_dimensional_thickness;
                $x_pos+=$this->three_dimensional_thickness;
            }

            //Decide if formatted_data_text should have a decimal portion or not.
            // If the raw data text has no decimal portion, do not display any.
            // If the raw data text has a decimal portion, show up to two decimal places only.
            if(ceil($data_text) == $data_text)
            {
                $formatted_data_text = number_format($data_text,0);
            }
            else
            {
                $formatted_data_text = number_format($data_text,2);
            }

            $this->choose_label_color('LABEL GRAY');
            imagestring($this->image,
                        $this->data_text_font_size,
                        $x_pos,
                        $top-$y_adjust,
                        $formatted_data_text, $this->label_color);
        }
    }

    function draw_col_bar_gradient($bottom, $top, $x_pos, $width)
    {
        $total_height = floor($bottom - $top);
        $num_gradiations = $total_height;
        if($num_gradiations == 0) $num_gradiations=1;
        $gradient_steps_px = floor($total_height / $num_gradiations);

        $red   = $orig_red   = $this->color_rgb[0];
        $green = $orig_green = $this->color_rgb[1];
        $blue  = $orig_blue  = $this->color_rgb[2];

        $softening_factor = $this->softening_factor;
        $gradient_color_step_red = $this->compute_gradient_step($red, $num_gradiations, $softening_factor);
        $gradient_color_step_green = $this->compute_gradient_step($green, $num_gradiations, $softening_factor);
        $gradient_color_step_blue = $this->compute_gradient_step($blue, $num_gradiations, $softening_factor);

        $red -= $gradient_color_step_red * $num_gradiations;
        $green -= $gradient_color_step_green * $num_gradiations;
        $blue -= $gradient_color_step_blue * $num_gradiations;

        for($a=0; $a<$num_gradiations; $a++)
        {
            $this->apply_gradient_step($red, $green, $blue,
                                       $orig_red, $orig_green, $orig_blue,
                                       $gradient_color_step_red, $gradient_color_step_green, $gradient_color_step_blue);
            $this->set_color($red,$green,$blue);

            if(!isset($gradient_bottom) || $gradient_bottom==0) $gradient_bottom = $bottom;
            $gradient_top = $gradient_bottom - $gradient_steps_px;

            imagefilledrectangle($this->image,
                                 $x_pos,          $gradient_top,
                                 $x_pos + $width, $gradient_bottom,
                                 $this->color);

            $gradient_bottom = $gradient_top;
        }
    }

    function draw_3D_col_bar($x_pos, $top, $width)
    {
        $thickness_3d = $this->three_dimensional_thickness;

        imagefilledrectangle($this->image,
                             $x_pos + $thickness_3d,
                             $top - $thickness_3d,
                             $x_pos + $width + $thickness_3d,
                             $this->bottom_of_bars - $thickness_3d + $this->v_adjust,
                             $this->color_3d);

        for($a=0; $a<$this->bar_width; $a++)
        {
            imageline($this->image,
                      $x_pos + $a,
                      $top,
                      $x_pos + $thickness_3d +$a,
                      $top - $thickness_3d,
                      $this->color_3d);
        }

        if($this->enable_gradient)
        {
            $this->draw_3D_col_bar_gradient($this->bottom_of_bars, $top, $x_pos, $width);
        }
        else
        {
            for($a=0; $a<$this->three_dimensional_height_px; $a++)
            {
                imageline($this->image,
                          $x_pos + $width,                   $this->bottom_of_bars - $a + $this->v_adjust,
                          $x_pos + $width + $thickness_3d,   $this->bottom_of_bars - $thickness_3d - $a + $this->v_adjust,
                          $this->color_3d);
            }
        }
    }

    function draw_3D_col_bar_gradient($bottom, $top, $x_pos, $width)
    {
        $total_height = floor($bottom - $top);
        $num_gradiations = $total_height;
        if($num_gradiations == 0) $num_gradiations=1;
        $gradient_steps_px = floor($total_height / $num_gradiations);

        $red   = $orig_red   = $this->color_3d_rgb[0];
        $green = $orig_green = $this->color_3d_rgb[1];
        $blue  = $orig_blue  = $this->color_3d_rgb[2];

        $softening_factor = $this->softening_factor;
        $gradient_color_step_red = $this->compute_gradient_step($red, $num_gradiations, $softening_factor);
        $gradient_color_step_green = $this->compute_gradient_step($green, $num_gradiations, $softening_factor);
        $gradient_color_step_blue = $this->compute_gradient_step($blue, $num_gradiations, $softening_factor);



        $red -= $gradient_color_step_red * $num_gradiations;
        $green -= $gradient_color_step_green * $num_gradiations;
        $blue -= $gradient_color_step_blue * $num_gradiations;

        for($a=0; $a<$num_gradiations; $a++)
        {

            $this->apply_gradient_step($red, $green, $blue,
                                       $orig_red, $orig_green, $orig_blue,
                                       $gradient_color_step_red, $gradient_color_step_green, $gradient_color_step_blue);
            $this->set_3d_color($red,$green,$blue);

            if(!isset($gradient_bottom) || $gradient_bottom==0) $gradient_bottom = $bottom;
            $gradient_top = $gradient_bottom - $gradient_steps_px;

            $thickness_3d = $this->three_dimensional_thickness;

            for($b=$gradient_top; $b<=$gradient_bottom; $b++)
            {
                imageline($this->image,
                          $x_pos + $width,                   $b + $this->v_adjust,
                          $x_pos + $width + $thickness_3d,   $b + $this->v_adjust - $thickness_3d,
                          $this->color_3d);

            }
            $gradient_bottom = $gradient_top;
        }
    }
    //*************************
    //END OF COLUMN BAR METHODS
    //*************************


    //************************
    //START: BAR GRAPH METHODS
    //************************
    function draw_bar($x_pos, $data, $label)
    {
        $data_text = $data;

        if($data < $this->minimum_data_point)
        {
            $data = 1;
        }
        else
        {
            $data -= $this->minimum_data_point;
        }


        if($this->data_initialized == FALSE)
        {
            die("Please initialize data set first through init_dataset() before attempting to draw a data point");
        }

        $bottom = $this->bottom_of_bars + $this->v_adjust;
        $width = $this->bar_width;

        //convert data to bar pixels using pixels per point
        $height = $data * $this->pixels_per_point;

        //If three dimensional, height should be subtracted by the 3d bar thickness
        if($this->three_dimensional)
        {
            $height -= $this->three_dimensional_thickness;
            if($height < 0) $height=0; //make sure no negative value gets stored in height
        }

        //convert height info to usable top coordinate for rendering the bar
        //image_label_height + (bar_height - $height)
        $top = $this->image_label_height + ($this->bar_height - $height);

        if($this->three_dimensional)
        {
            $this->three_dimensional_height_px = $height;
            $this->draw_3D_col_bar($x_pos, $top, $width);
        }

        imagefilledrectangle($this->image,
                             $x_pos,          $top,
                             $x_pos + $width, $bottom,
                             $this->color);

        $this->legend_colors[] = $this->color;



        if($this->enable_gradient)
        {
            $this->draw_col_bar_gradient($bottom, $top, $x_pos, $width);
        }


        if($this->write_label)
        {
            $this->choose_label_color('LABEL GRAY');
            imagestring($this->image,
                        $this->label_font_size,
                        $x_pos,
                        $this->label_y_coord,
                        $label, $this->label_color);
        }

        if($this->write_data_text)
        {
            $y_adjust = 14;
            if($this->three_dimensional)
            {
                $y_adjust+=$this->three_dimensional_thickness;
                $x_pos+=$this->three_dimensional_thickness;
            }

            //Decide if formatted_data_text should have a decimal portion or not.
            // If the raw data text has no decimal portion, do not display any.
            // If the raw data text has a decimal portion, show up to two decimal places only.
            if(ceil($data_text) == $data_text)
            {
                $formatted_data_text = number_format($data_text,0);
            }
            else
            {
                $formatted_data_text = number_format($data_text,2);
            }

            $this->choose_label_color('LABEL GRAY');
            imagestring($this->image,
                        $this->data_text_font_size,
                        $x_pos,
                        $top-$y_adjust,
                        $formatted_data_text, $this->label_color);
        }
    }

    function draw_bar_gradient($bottom, $top, $x_pos, $width)
    {
        $total_height = floor($bottom - $top);
        $num_gradiations = $total_height;
        if($num_gradiations == 0) $num_gradiations=1;
        $gradient_steps_px = floor($total_height / $num_gradiations);

        $red   = $orig_red   = $this->color_rgb[0];
        $green = $orig_green = $this->color_rgb[1];
        $blue  = $orig_blue  = $this->color_rgb[2];

        $softening_factor = $this->softening_factor;
        $gradient_color_step_red = $this->compute_gradient_step($red, $num_gradiations, $softening_factor);
        $gradient_color_step_green = $this->compute_gradient_step($green, $num_gradiations, $softening_factor);
        $gradient_color_step_blue = $this->compute_gradient_step($blue, $num_gradiations, $softening_factor);

        $red -= $gradient_color_step_red * $num_gradiations;
        $green -= $gradient_color_step_green * $num_gradiations;
        $blue -= $gradient_color_step_blue * $num_gradiations;

        for($a=0; $a<$num_gradiations; $a++)
        {
            $this->apply_gradient_step($red, $green, $blue,
                                       $orig_red, $orig_green, $orig_blue,
                                       $gradient_color_step_red, $gradient_color_step_green, $gradient_color_step_blue);
            $this->set_color($red,$green,$blue);

            if($gradient_bottom==0) $gradient_bottom = $bottom;
            $gradient_top = $gradient_bottom - $gradient_steps_px;

            imagefilledrectangle($this->image,
                                 $x_pos,          $gradient_top,
                                 $x_pos + $width, $gradient_bottom,
                                 $this->color);

            $gradient_bottom = $gradient_top;
        }
    }

    function draw_3D_bar($x_pos, $top, $width)
    {
        $thickness_3d = $this->three_dimensional_thickness;

        imagefilledrectangle($this->image,
                             $x_pos + $thickness_3d,
                             $top - $thickness_3d,
                             $x_pos + $width + $thickness_3d,
                             $this->bottom_of_bars - $thickness_3d + $this->v_adjust,
                             $this->color_3d);

        for($a=0; $a<$this->bar_width; $a++)
        {
            imageline($this->image,
                      $x_pos + $a,
                      $top,
                      $x_pos + $thickness_3d +$a,
                      $top - $thickness_3d,
                      $this->color_3d);
        }

        if($this->enable_gradient)
        {
            $this->draw_3D_col_bar_gradient($this->bottom_of_bars, $top, $x_pos, $width);
        }
        else
        {
            for($a=0; $a<$this->three_dimensional_height_px; $a++)
            {
                imageline($this->image,
                          $x_pos + $width,                   $this->bottom_of_bars - $a + $this->v_adjust,
                          $x_pos + $width + $thickness_3d,   $this->bottom_of_bars - $thickness_3d - $a + $this->v_adjust,
                          $this->color_3d);
            }
        }
    }

    function draw_3D_bar_gradient($bottom, $top, $x_pos, $width)
    {
        $total_height = floor($bottom - $top);
        $num_gradiations = $total_height;
        if($num_gradiations == 0) $num_gradiations=1;
        $gradient_steps_px = floor($total_height / $num_gradiations);

        $red   = $orig_red   = $this->color_3d_rgb[0];
        $green = $orig_green = $this->color_3d_rgb[1];
        $blue  = $orig_blue  = $this->color_3d_rgb[2];

        $softening_factor = $this->softening_factor;
        $gradient_color_step_red = $this->compute_gradient_step($red, $num_gradiations, $softening_factor);
        $gradient_color_step_green = $this->compute_gradient_step($green, $num_gradiations, $softening_factor);
        $gradient_color_step_blue = $this->compute_gradient_step($blue, $num_gradiations, $softening_factor);



        $red -= $gradient_color_step_red * $num_gradiations;
        $green -= $gradient_color_step_green * $num_gradiations;
        $blue -= $gradient_color_step_blue * $num_gradiations;

        for($a=0; $a<$num_gradiations; $a++)
        {

            $this->apply_gradient_step($red, $green, $blue,
                                       $orig_red, $orig_green, $orig_blue,
                                       $gradient_color_step_red, $gradient_color_step_green, $gradient_color_step_blue);
            $this->set_3d_color($red,$green,$blue);

            if($gradient_bottom==0) $gradient_bottom = $bottom;
            $gradient_top = $gradient_bottom - $gradient_steps_px;

            $thickness_3d = $this->three_dimensional_thickness;

            for($b=$gradient_top; $b<=$gradient_bottom; $b++)
            {
                imageline($this->image,
                          $x_pos + $width,                   $b + $this->v_adjust,
                          $x_pos + $width + $thickness_3d,   $b + $this->v_adjust - $thickness_3d,
                          $this->color_3d);

            }
            $gradient_bottom = $gradient_top;
        }
    }
    //************************
    //END OF BAR GRAPH METHODS
    //************************

    function draw_chart_lines($color=null, $h_coords=null, $v_coords=null)
    {
        if($color==null)
        {
            $color = 'YELLOW';
        }

        $this->choose_chartline_color($color);
        $color = $this->chartline_color;

        if(!is_array($h_coords) || !is_array($v_coords))
        {
            $h_coords[0] = $this->label_space_y;
            $h_coords[1] = $this->height - $this->lower_portion_height - $this->label_space_x;
            $h_coords[2] = $this->width - $this->right_margin;
            $h_coords[3] = $this->height - $this->lower_portion_height - $this->label_space_x;

            $v_coords[0] = $this->label_space_y;
            $v_coords[1] = $this->image_label_height;
            $v_coords[2] = $this->label_space_y;
            $v_coords[3] = $this->height - $this->lower_portion_height - $this->label_space_x;;
        }

        imageline ($this->image,
                   $h_coords[0],
                   $h_coords[1],
                   $h_coords[2],
                   $h_coords[3],
                   $color); //horizontal

        imageline ($this->image,
                   $v_coords[0],
                   $v_coords[1],
                   $v_coords[2],
                   $v_coords[3],
                   $color); //vertical

        $this->chartline_h_coords = array($h_coords[0],
                                           $h_coords[1],
                                           $h_coords[2],
                                           $h_coords[3]);

        $this->chartline_v_coords = array($v_coords[0],
                                           $v_coords[1],
                                           $v_coords[2],
                                           $v_coords[3]);
    }

    function draw_default_y_axis()
    {
        $x_pos = $this->chartline_h_coords[0];
        $y_top = $this->chartline_v_coords[1];
        $y_bottom = $this->chartline_v_coords[3];

        $line_height = $y_bottom - $y_top;

        $arrPoint['100'] = $this->data_highest;
        $arrPoint['75']  = $this->data_highest * .75;
        $arrPoint['50']  = $this->data_highest * .50;
        $arrPoint['25']  = $this->data_highest * .25;
        $arrPoint['0']   = $this->data_highest * 0;

        $arrPointsYCoord = array('100'=> $y_bottom - ($line_height),
                                 '75'=> $y_bottom - ($line_height * .75),
                                 '50'=> $y_bottom - ($line_height * .5),
                                 '25'=> $y_bottom - ($line_height * .25),
                                  '0'=> $y_bottom);

        foreach($arrPointsYCoord as $point=>$y_pos)
        {

            if($this->data_highest < 1000)
            {
                $point_label = number_format($arrPoint[$point],2);
            }
            else
            {
                $point_label = number_format($arrPoint[$point],0);
            }

            if(strlen($point_label) == 1) $cur_x_pos = $x_pos - 12;
            else $cur_x_pos = $x_pos - (strlen($point_label) * 10);

            if($this->label_color == '')
            {
                $this->choose_label_color('LABEL GRAY');
            }

            imagestring($this->image,
                        $this->label_font_size,
                        $cur_x_pos,
                        $y_pos-7,
                        $point_label,
                        $this->label_color);

            if($point != 0)
            {
                $this->choose_chartline_color('LIGHT GRAY');
                $x1 = $x_pos - 5;
                $x2 = $this->width - $this->right_margin;
                imageline ($this->image,
                           $x1,
                           $y_pos,
                           $x2,
                           $y_pos,
                           $this->chartline_color); //horizontal
            }
        }
    }

    function draw_y_axis($y_labels, $max_value, $min_value=0)
    {
        $x_pos = $this->chartline_h_coords[0];
        $y_top = $this->chartline_v_coords[1];
        $y_bottom = $this->chartline_v_coords[3];

        $line_height = $y_bottom - $y_top;

        $this->minimum_data_point = $min_value;
        $total_points_to_render = $max_value - $min_value;
        $this->pixels_per_point = $this->bar_height / $total_points_to_render;

        $num_labels = count($y_labels);
        $y_step = 1 / ($num_labels - 1);


        $y_adjust=1;
        foreach($y_labels as $label)
        {
            $arrPointsYCoord[$label] = $y_bottom - ($line_height * $y_adjust);
            $y_adjust -= $y_step;
        }


        $cntr=0;
        foreach($arrPointsYCoord as $label=>$y_pos)
        {
            if(strlen($label) == 1) $cur_x_pos = $x_pos - 12;
            else $cur_x_pos = $x_pos - (strlen($label) * 10);

            if($this->label_color == '')
            {
                $this->choose_label_color('LABEL GRAY');
            }

            imagestring($this->image,
                        $this->label_font_size,
                        $cur_x_pos,
                        $y_pos-7,
                        $label,
                        $this->label_color);

            $cntr++;
            if($cntr < $num_labels)
            {
                $this->choose_chartline_color('LIGHT GRAY');
                $x1 = $x_pos - 5;
                $x2 = $this->width - $this->right_margin;
                imageline ($this->image,
                           $x1,
                           $y_pos,
                           $x2,
                           $y_pos,
                           $this->chartline_color); //horizontal
            }
        }
    }

    function draw_footer()
    {
        $x1 = 0;
        $x2 = $this->width;
        $y1 = $this->height - $this->footer_space_height + $this->footer_top_margin;
        $y2 = $this->height;

        imagefilledrectangle($this->image,
                             $x1, $y1,
                             $x2, $y2,
                             $this->footer_box_color);

        imagettftext($this->image,
                     $this->footer_label_font_size,
                     0,
                     $x1 + $this->footer_label_left_offset,
                     $y1 + $this->footer_label_top_offset,
                     $this->footer_label_color,
                     $this->font_directory . $this->footer_label_font,
                     $this->footer_text);

    }

    function draw_legend($arr_labels)
    {
        if(is_array($arr_labels))
        {
            $this->legend_labels = $arr_labels;
        }
        else
        {
            die("Invalid legend set, cannot create legend.");
        }


        //Draw the legend box

        $x1 = $this->legend_left_offset - 10;
        $x2 = $this->width - 10;
        $y1 = $this->height - $this->lower_portion_height + $this->legend_top_margin - 10;

        $y2 = $y1;
        for($a=0; $a<$this->data_count; $a++)
        {
            $y2 += $this->legend_item_height;
        }

        $y2 += 10;


        imagefilledrectangle($this->image,
                             $x1, $y1,
                             $x2, $y2,
                             $this->legend_box_color);

        //Draw the legend items
        $top = $this->height - $this->lower_portion_height + $this->legend_top_margin;
        foreach($this->legend_colors as $key=>$color)
        {
            $bottom = $top + ($this->legend_item_height - 5);
            $x1 = $this->legend_left_offset;
            $x2 = $this->legend_left_offset + ($this->legend_item_height - 5);

            //small box, filled with the current color
            imagefilledrectangle($this->image,
                                 $x1, $top,
                                 $x2, $bottom,
                                 $color);

            //text according to label
            $label = $arr_labels[$key];
            imagestring($this->image,
                        $this->label_font_size,
                        $x2 + 10,
                        $top+2,
                        $label,
                        $this->legend_label_color);

            $top += $this->legend_item_height;
        }
    }

    function draw_image_label($image_label, $subtitle='')
    {
        $x1=0;
        $y1=0;
        $x2=$this->width;
        $y2=$this->image_label_height - $this->image_label_bottom_margin;

        imagefilledrectangle($this->image,
                             $x1, $y1,
                             $x2, $y2,
                             $this->image_label_box_color);

        imagettftext($this->image,
                     $this->image_label_main_font_size,
                     0,
                     $x1 + 20,
                     $y1 + $this->image_label_main_font_size + 20,
                     $this->image_label_text_color,
                     $this->font_directory . $this->image_label_font,
                     $image_label);

        if($subtitle == '')
        {
            //No subtitle specified, nothing to do
        }
        else
        {
            $space = imagefontheight($this->image_label_main_font_size) + 10;

            if(is_array($subtitle))
            {
                $vertical_offset_cntr=20;
                foreach($subtitle as $subtitle_line)
                {
                    imagestring($this->image,
                                $this->image_label_subtitle_font_size,
                                $x1 + 20,
                                $y1 + $space + $vertical_offset_cntr,
                                $subtitle_line,
                                $this->image_label_subtitle_color);

                    $vertical_offset_cntr+=20;
                }
            }
            else
            {
                imagestring($this->image,
                            $this->image_label_subtitle_font_size,
                            $x1 + 20,
                            $y1 + $space + 20,
                            $subtitle,
                            $this->image_label_subtitle_color);
            }
        }
    }

    function draw_auto_column_bar($filename, $dataset, $datalabels=null, $title=null, $subtitle=null, $x_labels=null, $y_labels=null, $max_value=null, $min_value=null)
    {
        $this->init_dataset($dataset, $subtitle);
        $this->draw_image_label($title, $subtitle);
        $this->draw_chart_lines();
        if(is_array($y_labels))
        {
            if($max_value == null || $max_value == $min_value)
            {
                die('Error: You must specify max_value in order to use custom y-axis labels, and make sure that the max_value is not equal to the
                        min_value (if min_value was specified). Although note required, it is also a good idea to specify the min_value.');
            }

            if($min_value == null)
            {
                $min_value = 0;
            }

            $this->draw_y_axis($y_labels, $max_value, $min_value);
        }
        else
        {
            $this->draw_default_y_axis();
        }

        $x_pos = $this->bar_left_offset + $this->label_space_y;
        $x_adjust = $this->bar_width + $this->bar_space;
        if($this->three_dimensional) $x_adjust += $this->three_dimensional_thickness;

        $color_count = count($this->color_set_2d);

        $color_cntr=0;
        for($a=0; $a<$this->data_count; $a++)
        {
            $this->choose_color($this->color_set_2d[$color_cntr]);

            if($this->three_dimensional)
            {
                if(isset($this->color_set_3d[$color_cntr]))
                {
                    $this->choose_3d_color($this->color_set_3d[$color_cntr]);
                }
                else
                {
                    //No 3d color counterpart specified, so make one automatically - darker shade of existing color
                    $red = $this->color_constants[$this->color_set_2d[$color_cntr]][0];
                    $green = $this->color_constants[$this->color_set_2d[$color_cntr]][1];
                    $blue = $this->color_constants[$this->color_set_2d[$color_cntr]][2];
                    $this->derive_3d_color($red, $green, $blue);
                }
            }

            $this->draw_col_bar($x_pos, $this->arr_data_point[$a], $x_labels[$a]);
            $x_pos += $x_adjust;

            $color_cntr++;
            if($color_cntr == $color_count)
            {
                $color_cntr = 0;
            }
        }

        if(is_array($datalabels) && $this->legend_enabled)
        {
            $this->draw_legend($datalabels);
        }

        if($this->footer_enabled)
        {
            $this->draw_footer();
        }

        imagepng($this->image, $filename);
        imagedestroy($this->image);
    }

    function draw_auto_bar_graph($filename, $dataset, $datalabels=null, $title=null, $subtitle=null, $x_labels=null, $y_labels=null, $max_value=null, $min_value=null)
    {
        $this->init_dataset_bar($dataset, $subtitle);
        $this->draw_image_label($title, $subtitle);
        $this->draw_chart_lines();
        if(is_array($y_labels))
        {
            $this->draw_y_axis($y_labels, $max_value, $min_value);
        }
        else
        {
            $this->draw_default_y_axis();
        }

        $x_pos = $this->bar_left_offset + $this->label_space_y;
        $x_adjust = $this->bar_width + $this->bar_space;
        if($this->three_dimensional) $x_adjust += $this->three_dimensional_thickness;

        $color_count = count($this->color_set_2d);

        $color_cntr=0;
        for($a=0; $a<$this->data_count; $a++)
        {
            $this->choose_color($this->color_set_2d[$color_cntr]);

            if($this->three_dimensional)
            {
                if(isset($this->color_set_3d[$color_cntr]))
                {
                    $this->choose_3d_color($this->color_set_3d[$color_cntr]);
                }
                else
                {
                    //No 3d color counterpart specified, so make one automatically - darker shade of existing color
                    $red = $this->color_constants[$this->color_set_2d[$color_cntr]][0];
                    $green = $this->color_constants[$this->color_set_2d[$color_cntr]][1];
                    $blue = $this->color_constants[$this->color_set_2d[$color_cntr]][2];
                    $this->derive_3d_color($red, $green, $blue);
                }
            }

            $this->draw_bar($x_pos, $this->arr_data_point[$a], $x_labels[$a]);
            $x_pos += $x_adjust;

            $color_cntr++;
            if($color_cntr == $color_count)
            {
                $color_cntr = 0;
            }
        }

        if(is_array($datalabels) && $this->legend_enabled)
        {
            $this->draw_legend($datalabels);
        }

        if($this->footer_enabled)
        {
            $this->draw_footer();
        }

        imagepng($this->image, $filename);
        imagedestroy($this->image);
    }

    function draw_auto_pie_chart($filename, $dataset, $datalabels=null, $title=null, $subtitle=null)
    {

        $this->init_dataset_pie($dataset, $subtitle);
        $this->draw_image_label($title,$subtitle);


        $total = 0;
        foreach($dataset as $data_point)
        {
            $total += $data_point;
        }

        if($total != $this->pie_total_degrees) //converting data points to their respective degrees
        {
            foreach($dataset as $key=>$data_point)
            {
                $dataset[$key] =  ($data_point / $total) * $this->pie_total_degrees;
                if($dataset[$key] < 2) $dataset[$key] = 2; //without this, imagefilledarc goes crazy for values less than 1; 2 is chosen because it looks better (more visible)
            }
        }

        $slice = array();
        $accumulator = 0;
        foreach($dataset as $data_point)
        {
            $slice[] = $data_point + $accumulator;
            $accumulator += $data_point;
        }

        $pie_width = $this->pie_width;
        $pie_height = $this->pie_height;
        $pie_center_x = $this->pie_center_x;
        $pie_center_y = $this->pie_center_y;

        if($this->three_dimensional)
        {
            for ($i = $pie_center_y+$this->three_dimensional_thickness; $i > $pie_center_y; $i--)
            {
                $color_cntr=0;
                for($a=0; $a<count($dataset); $a++)
                {
                    //Set color for the slice's 3D portion
                    if(isset($this->color_set_3d[$color_cntr]))
                    {
                        $this->choose_3d_color($this->color_set_3d[$color_cntr]);
                    }
                    else
                    {
                        //No 3d color counterpart specified, so make one automatically - darker shade of existing color
                        $red = $this->color_constants[$this->color_set_2d[$color_cntr]][0];
                        $green = $this->color_constants[$this->color_set_2d[$color_cntr]][1];
                        $blue = $this->color_constants[$this->color_set_2d[$color_cntr]][2];
                        $this->derive_3d_color($red, $green, $blue);
                    }

                    if($a==0)
                    {
                        imagefilledarc($this->image, $pie_center_x, $i, $pie_width, $pie_height, 0, $slice[$a], $this->color_3d, IMG_ARC_PIE);
                        if($this->enable_gradient)
                        {
                            //Nothing for the 3D portion as of now.
                        }
                    }
                    else
                    {
                        $prev = $a-1;
                        imagefilledarc($this->image, $pie_center_x, $i, $pie_width, $pie_height, $slice[$prev], $slice[$a] , $this->color_3d, IMG_ARC_PIE);
                        if($this->enable_gradient)
                        {
                            //Nothing for the 3D portion as of now.
                        }
                    }
                    $color_cntr++;
                }
            }
        }

        $color_cntr=0;
        for($a=0; $a<count($dataset); $a++)
        {
            $this->choose_color($this->color_set_2d[$color_cntr]);
            $this->legend_colors[] = $this->color;

            if($a==0)
            {
                imagefilledarc($this->image, $pie_center_x, $pie_center_y, $pie_width, $pie_height, 0, $slice[$a], $this->color, IMG_ARC_PIE);
                if($this->enable_gradient)
                {
                    $num_gradiations = ($pie_height + $pie_width) / $this->pie_gradient_limiter;
                    $gradient_steps_h = $pie_height / $num_gradiations;
                    $gradient_steps_w = $pie_width / $num_gradiations;

                    $red   = $orig_red   = $this->color_rgb[0];
                    $green = $orig_green = $this->color_rgb[1];
                    $blue  = $orig_blue  = $this->color_rgb[2];

                    $softening_factor = $this->softening_factor;
                    $gradient_color_step_red = $this->compute_gradient_step($red, $num_gradiations, $softening_factor);
                    $gradient_color_step_green = $this->compute_gradient_step($green, $num_gradiations, $softening_factor);
                    $gradient_color_step_blue = $this->compute_gradient_step($blue, $num_gradiations, $softening_factor);

                    $red -= $gradient_color_step_red * $num_gradiations;
                    $green -= $gradient_color_step_green * $num_gradiations;
                    $blue -= $gradient_color_step_blue * $num_gradiations;

                    $gradiation_h = 0;
                    $gradiation_w = 0;
                    for($b=0; $b<$num_gradiations; $b++)
                    {
                        $this->apply_gradient_step($red, $green, $blue,
                                                   $orig_red, $orig_green, $orig_blue,
                                                   $gradient_color_step_red, $gradient_color_step_green, $gradient_color_step_blue);

                        $this->set_color($red,$green,$blue);

                        imagefilledarc($this->image, $pie_center_x, $pie_center_y, $pie_width - $gradiation_w, $pie_height - $gradiation_h, 0, $slice[$a] , $this->color, IMG_ARC_PIE);

                        $gradiation_h += $gradient_steps_h;
                        $gradiation_w += $gradient_steps_w;
                    }
                }
            }
            else
            {
                $prev = $a-1;
                imagefilledarc($this->image, $pie_center_x, $pie_center_y, $pie_width, $pie_height, $slice[$prev], $slice[$a] , $this->color, IMG_ARC_PIE);

                if($this->enable_gradient)
                {
                    $num_gradiations = ($pie_height + $pie_width) / $this->pie_gradient_limiter;
                    $gradient_steps_h = $pie_height / $num_gradiations;
                    $gradient_steps_w = $pie_width / $num_gradiations;

                    $red   = $orig_red   = $this->color_rgb[0];
                    $green = $orig_green = $this->color_rgb[1];
                    $blue  = $orig_blue  = $this->color_rgb[2];

                    $softening_factor = $this->softening_factor;
                    $gradient_color_step_red = $this->compute_gradient_step($red, $num_gradiations, $softening_factor);
                    $gradient_color_step_green = $this->compute_gradient_step($green, $num_gradiations, $softening_factor);
                    $gradient_color_step_blue = $this->compute_gradient_step($blue, $num_gradiations, $softening_factor);

                    $red -= $gradient_color_step_red * $num_gradiations;
                    $green -= $gradient_color_step_green * $num_gradiations;
                    $blue -= $gradient_color_step_blue * $num_gradiations;

                    $gradiation_h = 0;
                    $gradiation_w = 0;
                    for($b=0; $b<$num_gradiations; $b++)
                    {
                        $this->apply_gradient_step($red, $green, $blue,
                                                   $orig_red, $orig_green, $orig_blue,
                                                   $gradient_color_step_red, $gradient_color_step_green, $gradient_color_step_blue);

                        $this->set_color($red,$green,$blue);

                        imagefilledarc($this->image, $pie_center_x, $pie_center_y, $pie_width - $gradiation_w, $pie_height - $gradiation_h, $slice[$prev], $slice[$a] , $this->color, IMG_ARC_PIE);

                        $gradiation_h += $gradient_steps_h;
                        $gradiation_w += $gradient_steps_w;
                    }
                }
            }

            $color_cntr++;
        }

        if(is_array($datalabels) && $this->legend_enabled)
        {
            $this->draw_legend($datalabels);
        }

        if($this->footer_enabled)
        {
            $this->draw_footer();
        }

        imagepng($this->image, $filename);
        imagedestroy($this->image);
    }
}