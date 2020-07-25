<?php
  class Locales {
    public $lang;
    public $results = array();

    private $fallbackLocale = 'en_US';
    private $supportedLocale = array(
      'en_US',
      'fr_FR'
    );
    private $correspondingLocale = array(
      'en' => 'en_US',
      'fr' => 'fr_FR'
    );

    // Constructeur
    public function __construct() {
      if (isset($_GET['lang'])) {
        // the locale can be changed through the query-string
        $this->results['src'] = 'query-string';
        $requestLang = filter_input(INPUT_GET, 'lang', FILTER_SANITIZE_STRING);
        $this->lang = $this->findLocale($requestLang);
      } elseif (isset($_COOKIE['lang'])) {
        // if the cookie is present instead, let's just keep it
        $this->results['src'] = 'cookie';
        $requestLang = filter_input(INPUT_COOKIE, 'lang', FILTER_SANITIZE_STRING);
        $this->lang = $this->findLocale($requestLang);
      } elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        // default: look for the languages the browser says the user accepts
        $this->results['src'] = 'browser languages';
        $requestLangs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        array_walk($requestLangs, function (&$lang) { $lang = strtr(strtok($lang, ';'), ['-' => '_']); });
        foreach ($requestLangs as $browserLang) {
          if ($this->valid($browserLang)) {
            $this->lang = $this->findLocale($browserLang);
            break;
          }
        }
        if (!isset($this->lang)) $this->lang = $this->findLocale('');
      }

      setcookie('lang', $this->lang, $options = ['samesite' => 'Lax']); //it's stored in a cookie so it can be reused

      // here we define the global system locale given the found language
      $results = putenv("LANG=".$this->lang);
      if (!$results) $this->results['putenv'] = 'putenv failed';
    
      // this might be useful for date functions (LC_TIME) or money formatting (LC_MONETARY), for instance
      $results = setlocale(LC_ALL, $this->lang);
      if (!$results) $this->results['setlocale'] = 'setlocale failed: locale function is not available on this platform, or the given local does not exist in this environment';

      // this will make Gettext look for <directory>/<lang>/LC_MESSAGES/main.mo
      $results = bindtextdomain('main', __DIR__);
      $this->results['bindtextdomain'] = 'new text domain is set to "'.$results.'"';
    
      // indicates in what encoding the file should be read
      $results = bind_textdomain_codeset('main', 'UTF-8');
      $this->results['bind_textdomain_codeset'] = 'new text domain codeset is set to "'.$results.'"';
    
      // here we indicate the default domain the gettext() calls will respond to
      $results = textdomain('main');
      $this->results['textdomain'] = 'current message domain is set to "'.$results.'"';
    }

    // Destructeur
    public function __destruct() { }

    /**
     * Verifies if the given $locale is supported in the project
     * @param string $locale
     * @return bool
     */
    private function valid($locale) {
      return in_array($locale, $this->supportedLocale) || isset($this->correspondingLocale[$locale]);
    }

    /**
     * Verifies if the given $locale is supported and return
     * the corresponding locale in the project, en_US if not
     * @param string $locale
     * @return string
     */
    function findLocale($locale) {
      if (in_array($locale, $this->supportedLocale)) return $locale;
      if (isset($this->correspondingLocale[$locale])) return $this->correspondingLocale[$locale];
      //setting the source/default locale, for informational purposes
      return $this->fallbackLocale;
    }
  }
  
  $LocalesClass = new Locales();
  print_r($LocalesClass->results);
?>