<?php
/**
 * @package add_text
 * @version 1.0.0
 */
/*
Plugin Name: addText
Description:  
Author: PaulinaP
Version: 1.0.0
Author URI: 
*/

function add_text_after_content($content){
    if(!is_front_page()){
        $after_content = '<p class="test-dodany">See You! </p>';
        printf($after_content);
    
    }
}

add_filter('the_content','add_text_after_content');
