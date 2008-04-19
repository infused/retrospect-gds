<?php
  
  # this class expects a valid adodb database connection called $db
  # and that a valid config.php file has been required
  class Upgrader {
    
    var $languages = array(
      'en_US' => 'English',
      'es_ES' => 'Spanish',
      'de_DE' => 'German',
      'nl_NL' => 'Dutch',
      'fr_FR' => 'French',
      'pl_PL' => 'Polish',
      'pt_BR' => 'Portuguese',
      'no_NB' => 'Norwegian',
      'he_IL' => 'Hebrew',
      'sv_SE' => 'Swedish'
    );
    
    var $options = array(
      'default_lang' => 'en_US',
      'allow_lang_change' => '1',
      'default_page' => 'surnames',
      'translate_dates' => '1',
      'debug' => '0',
      'meta_copyright' => '',
      'meta_keywords' => 'Genealogy,Family History',
      'date_format' => '1',
      'sort_children' => '0',
      'sort_marriages' => '0',
      'sort_events' => '0',
      'allow_comments' => '1',
      'gallery_plugin' => '0',
      'published_gedcom' => ''
    );
    
    
    function upgrade_languages() {
      $upgrades = false;
      foreach ($this->languages as $lang_code => $lang_name) {
        if (!$this->_language_exists($lang_code)) {
          $this->_add_language($lang_code);
          $upgrades = true;
        }
      }
      if (!$upgrades) echo 'No language updates were necessary.<br />';
    }
    
    function upgrade_options() {
      $upgrades = false;
      foreach($this->options as $opt_key => $opt_val) {
        if (!$this->_option_exists($opt_key)) {
          $this->_add_option($opt_key);
          $upgrades = true;
        }
      }
      if (!$upgrades) echo 'No option updates were necessary.<br />';
    }

    function _language_exists($lang_code) {
      global $db, $g_db_prefix;
      $sql = "SELECT COUNT(*) FROM {$g_db_prefix}language WHERE lang_code='{$lang_code}'";
      if ($db->GetOne($sql) > 0) return true;
      else return false;
    } 
    
    function _option_exists($opt_key) {
      global $db, $g_db_prefix;
      $sql = "SELECT COUNT(*) FROM {$g_db_prefix}options WHERE opt_key='{$opt_key}'";
      if ($db->GetOne($sql) > 0) return true;
      else return false;
    }
    
    function _add_language($lang_code) {
      global $db, $g_db_prefix;
      $sql = "INSERT INTO {$g_db_prefix}language ";
      $sql .= "VALUES ('', '{$lang_code}', 'utf-8', '{$this->languages[$lang_code]}')";
      if ($db->Execute($sql))
        echo "&bull; Added new language configuration for {$this->languages[$lang_code]}<br/>";
      else 
        echo "&bull; Error adding language configuration for {$this->languages[$lang_code]}<br/>";
    }
    
    function _add_option($opt_key) {
      global $db, $g_db_prefix;
      $sql = "INSERT INTO {$g_db_prefix}options ";
      $sql .= "VALUES ('', '{$opt_key}', '{$this->options[$opt_key]}')";
      if ($db->Execute($sql))
        echo "&bull; Added '{$opt_key}' configuration option<br/>";
      else 
        echo "&bull; Error adding '{$opt_key}' configuration option<br/>";
    }
    
  }
?>