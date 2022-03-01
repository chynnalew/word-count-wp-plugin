<?php

/*
  Plugin Name: Word Count 
  Description: Count the words in a post
  Version: 1.0
  Author: Chynna
*/

class WordCountAndTimePlugin {
  function __construct(){
    add_action('admin_menu', array($this, 'adminPage'));
  }

  function adminPage() {
    add_options_page("Word Count Settings", 'Word Count', 'manage_options', 'word-count-settings-page', array($this, 'html'));
  }
  
  function html() { ?>
    <div class='wrap'>
      <h1> Word Count Settings </h1>
    </div>
  <?php }

}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();


