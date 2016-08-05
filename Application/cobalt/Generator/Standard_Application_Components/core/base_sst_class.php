<?php
class base_sst
{
    var $control_delay  = 0; //controls delay between form controls, in milliseconds
    var $misc_delay     = 0; //controls delay for misc actions that usually require shorter delays than control_delay
    var $char_delay     = 0;  //controls delay in typing each character
    var $scroll_padding = 50;  //pixels to scroll down after focusing on a control (so that controls won't end up at the very bottom)
    var $script         = '';
    var $search_mode    = 'id';

    function __construct()
    {
        $this->preset();
    }

    function preset($preset_value='default')
    {
        strtolower($preset_value);
        switch($preset_value)
        {
            case 'default':
                            $this->control_delay = 350;
                            $this->misc_delay    = 150;
                            $this->char_delay    = 30;
                            break;
            case 'fast':
                            $this->control_delay = 175;
                            $this->misc_delay    = 75;
                            $this->char_delay    = 15;
                            break;
            case 'instant':
                            $this->control_delay = 1;
                            $this->misc_delay    = 1;
                            $this->char_delay    = 1;
                            break;
        }

        return $this;
    }

    function begin()
    {
        $control_delay = $this->control_delay;
        $misc_delay    = $this->misc_delay;
        $char_delay    = $this->char_delay;

        $js_code  = "\r\n";
        $js_code .= "<script>\r\n";
        $js_code .= $this->on_load();
        $js_code .= "\r\n";
        $js_code .= "execOnLoad(\r\n";
        $js_code .= "    function()\r\n";
        $js_code .= "    {\r\n";
        $js_code .= "        control_delay = $control_delay;\r\n";
        $js_code .= "        misc_delay = $misc_delay;\r\n";
        $js_code .= "        char_delay = $char_delay;\r\n";
        $js_code .= "        delay_total = 1000;\r\n";
        $js_code .= "        var sst_events = [];\r\n";

        $this->script .= $js_code;
        return $this;
    }

    function click($clickable)
    {
        if($this->search_mode == 'id')
        {
            $command = 'getElementById';
            $js_var  = 'a';
        }
        elseif($this->search_mode == 'name')
        {
            $command = 'getElementsByName';
            $js_var  = 'a[0]';
        }

        $js_code  = '';
        $js_code .= "        sst_events.push(window.setTimeout(function(){ try{a = document.$command('$clickable'); $js_var.focus(); $js_var.scrollIntoView(false); } catch(e) {terminateEvents(sst_events, e);} }, delay_total));\r\n";
        $js_code .= "        delay_total += misc_delay;\r\n";
        $js_code .= "        sst_events.push(window.setTimeout(function(){ try{a = document.$command('$clickable'); $js_var.click(); } catch(e) {terminateEvents(sst_events, e);} }, delay_total));\r\n";
        $js_code .= "        delay_total += misc_delay;\r\n";

        $this->script .= $js_code;
        return $this;
    }

    function end()
    {
        $js_code  = "    });\r\n";
        $js_code .= "</script>\r\n";

        $this->script .= $js_code;
        return $this;
    }

    function focus($element)
    {
        $js_code  = '';
        $js_code .= "        sst_events.push(window.setTimeout(function(){ try{a = document.getElementById('$element'); a.focus(); a.scrollIntoView(false) } catch(e) {terminateEvents(sst_events, e);} }, delay_total));\r\n";
        $js_code .= "        delay_total += control_delay;\r\n";

        $this->script .= $js_code;
        return $this;
    }

    function on_load()
    {
        //We can't properly indent the contents of $js_code because the indentation will remain in the output; the indentation will have to
        //be how we want the output to be indented.
        $js_code =<<<EOD
function execOnLoad(sst_function)
{
    /*
    This makes sure existing onload functions defined by the page will be triggered before the SST onload is done.
    Without this, the SST onload will replace the page's existing onload function, and SST will not be dealing with
    the exact same state as normal users
    */

    var existing_onload = window.onload;
    if(typeof window.onload == 'function')
    {
        window.onload = function()
        {
            if(existing_onload)
            {
                existing_onload();
            }
            sst_function();
        }
    }
    else
    {
        window.onload = sst_function;
    }
}

function terminateEvents(sst_events, e)
{
    /*
    This will clear all events setup by setTimeout. This is to prevent
    future events from triggering following an error.
    */

    for (var i = 0; i < sst_events.length; i++)
    {
        clearTimeout(sst_events[i]);
    }


    alert("SST Test has failed! Message: " + e.name + " - " + e.message);
    console.log(e);

    /*
    FIXME: This should also send AJAX request to clear all SST Sessions through "SESSION['sst'] = array();"
    */
}

EOD;
        return $js_code;
    }

    function select($element, $value_to_select)
    {
        $js_code  = '';
        $js_code .= "        sst_events.push(window.setTimeout(function(){ try{a = document.getElementById('$element'); a.focus(); a.scrollIntoView(false); window.scrollBy(0," . $this->scroll_padding . "); a.value = '$value_to_select'; } catch(e) {terminateEvents(sst_events, e);} }, delay_total));\r\n";
        $js_code .= "        delay_total += control_delay;\r\n";

        $this->script .= $js_code;
        return $this;
    }

    function type($element, $string, $auto_scroll=FALSE)
    {
        //FIXME: $auto_scroll not yet implemented.

        $js_code = '';

        //This just resets value to empty.
        $js_code .= "        sst_events.push(window.setTimeout(function(){ try{a = document.getElementById('$element'); a.focus(); a.scrollIntoView(false); window.scrollBy(0," . $this->scroll_padding . "); a.scrollTop = a.scrollHeight; a.scrollLeft = a.scrollLeftMax;} catch(e) {terminateEvents(sst_events, e);} }, delay_total));\r\n";
        $js_code .= "        delay_total += misc_delay;\r\n";
        $js_code .= "        sst_events.push(window.setTimeout(function(){ try{a = document.getElementById('$element'); a.select();} catch(e) {terminateEvents(sst_events, e);} }, delay_total));\r\n";
        $js_code .= "        delay_total += misc_delay;\r\n";
        $js_code .= "        sst_events.push(window.setTimeout(function(){ try{a = document.getElementById('$element'); a.value = '';} catch(e) {terminateEvents(sst_events, e);} }, delay_total));\r\n";
        $js_code .= "        delay_total += misc_delay;\r\n";

        $length = strlen($string);

        for($a=0; $a<$length; ++$a)
        {
            $value = $string[$a];

            //Deal with newlines, otherwise they eff up the JS code
            if($value == "\r" OR $value == "\n")
            {
                $value = '\n';
            }

            //FIXME: focus, scrollIntoView and scrollBy does not need to be in the loop, they should only be called once, outside the loop.
            //scrollLeft and scrollTop should remain here.
            $js_code .= "        sst_events.push(window.setTimeout(function(){ try{a = document.getElementById('$element'); a.focus(); a.scrollIntoView(false); window.scrollBy(0," . $this->scroll_padding . "); a.value += '$value'; a.scrollTop = a.scrollHeight; a.scrollLeft = a.scrollLeftMax; } catch(e) {terminateEvents(sst_events, e);} }, delay_total));\r\n";
            $js_code .= "        delay_total += char_delay;\r\n";

        }

        $js_code .= "        delay_total += control_delay;\r\n";

        $this->script .= $js_code;
        return $this;
    }

    function tick($element)
    {
        $js_code  = '';
        $js_code .= "        sst_events.push(window.setTimeout(function(){ try{a = document.getElementById('$element'); a.scrollIntoView(false); window.scrollBy(0," . $this->scroll_padding . ");} catch(e) {terminateEvents(sst_events, e);} }, delay_total));\r\n";
        $js_code .= "        delay_total += misc_delay;\r\n";
        $js_code .= "        sst_events.push(window.setTimeout(function(){ try{a = document.getElementById('$element'); a.focus(); a.checked = true; } catch(e) {terminateEvents(sst_events, e);} }, delay_total));\r\n";
        $js_code .= "        delay_total += control_delay;\r\n";

        $this->script .= $js_code;
        return $this;
    }


    //FIXME: should this be separate from $this->end?
    function end_task()
    {
        array_shift($_SESSION['sst']['tasks']);
        return $this;
    }

    function search_by_id()
    {
        $this->search_mode = 'id';
        return $this;
    }

    function search_by_name()
    {
        $this->search_mode = 'name';
        return $this;
    }

    function auto_test()
    {
        //Only subclasses can use this; this requires access to a data dictionary file.
        $this->begin();
        foreach($this->fields as $field=>$data)
        {
            switch($data['control_type'])
            {
                case 'textbox' :
                case 'textarea' :
                                $this->type($field, 'Auto Test text');
                                break;
                case 'drop-down list' :
                                $this->select($field, '1');
                                break;
                case 'radio buttons' :
                                $this->tick($field . '[0]');
                                break;
            }
        }
        $this->focus('btn_submit');
        $this->click('btn_cancel');
        $this->end();

        return $this;
    }
}