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
    add_action('admin_init', array($this, 'settings'));
    add_filter('the_content', array($this, 'ifWrap'));
  }

  //function to filter the content only if any of the setting check boxes are checked
  function ifWrap($content){
    if((is_main_query() AND is_single()) AND (get_option('wcp_word_count', '1') OR get_option('wcp_character_count', '1') OR get_option('wcp_read_time', '1'))) {
      return $this->createHTML($content);
    } else {
      $content;
    }
  }
  //function to add stats to content if conditions of ifWrap are met
  function createHTML(){
    return $content . "TEST TEST TEST!!!";
  }

  function settings() {
    add_settings_section('wcp_first_section', null, null, 'word-count-settings-page',);

    // location setting
    add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => array($this, 'sanitizeLocation'), 'default' => '0'));
    // headline text
    add_settings_field('wcp_headline', 'Headline Text', array($this, 'headlineHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics'));
    // Word count
    add_settings_field('wcp_word_count', 'Word Count', array($this, 'wordCountHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_word_count', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
    // Character count
    add_settings_field('wcp_character_count', 'Character Count', array($this, 'characterCountHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_character_count', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
    // Read time
    add_settings_field('wcp_read_time', 'Read Time', array($this, 'readTimeHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_read_time', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
  }

  function locationHTML() { ?>
    <select name="wcp_location">
      <option value="0" <?php selected(get_option('wcp_location'), '0') ?> >Beginning of post</option>
      <option value="1" <?php selected(get_option('wcp_location'), '1') ?>>End of Post</option>
    </select>
  <?php }
  // function to compare input to possible options. if option is valid, save input, else, default to last input and display error
  function sanitizeLocation($input) {
    if ($input != '0' AND $input != '1') {
      add_settings_error('wcp_location', 'WCP_LOCATION_ERROR', 'Display location must be beginning or end');
      return get_option('wcp_location');
    } else {
      return $input;
    }
  }

  function headlineHTML() { ?>
    <input type="text" name='wcp_headline' value="<?php echo esc_attr(get_option('wcp_headline'))?>">
  <?php }

  function wordCountHTML() { ?>
    <input type="checkbox" name='wcp_word_count' value="1" <?php checked(get_option('wcp_word_count'),"1")?>>
  <?php }

  function characterCountHTML() { ?>
    <input type="checkbox" name='wcp_character_count' value="1" <?php checked(get_option('wcp_character_count'), '1')?>>
  <?php }

  function readTimeHTML() { ?>
    <input type="checkbox" name='wcp_read_time' value='1' <?php checked(get_option('wcp_read_time'), '1')?>>
  <?php }

  function adminPage() {
    add_options_page("Word Count Settings", 'Word Count', 'manage_options', 'word-count-settings-page', array($this, 'html'));
  }
  
  function html() { ?>
    <div class='wrap'>
      <h1> Word Count Settings </h1>
      <form action="options.php" method="post">
        <?php
          settings_fields('wordcountplugin');
          do_settings_sections('word-count-settings-page');
          submit_button();
        ?>
      </form>
    </div>
  <?php }

}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();


