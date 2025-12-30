<?php

/**
 * 
 * 
 * @param string $label_text The text to display in the label
 * @param string $field_name The field name of the form input this label relates to
 * (assumes you've set the form input id to the specified field name).
 * @return string
 */
function get_label($label_text, $field_name)
{
    $label  = "<label for=\"$field_name\"";
    $label .= (form_error($field_name)) ? ' class="formError"' : '';
    $label .= ">" . $label_text . ":";
    $label .= (form_error($field_name)) ? " " . form_error($field_name) : '';
    $label .= "</label>\n";
    
    return $label;
}

// End of file: MY_Form_helper.php
// Location: ./system/application/helpers/MY_Form_helper.php 