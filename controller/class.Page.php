<?php
class Page {
    private $Config_c;
    private static $PageInstance = NULL;
    public $PAGE_LEVEL;

    private function __construct($Config) {
      $this->Config_c = $Config;
    }

    static function getInstance($Config) {
        if (!self::$PageInstance) {
          self::$PageInstance = new Page($Config);
        }
        return self::$PageInstance;
    }

    public function checkPage($page, $load = true) {
      if (!empty($page)) {
        if (file_exists(BASEDIR."pages/".$page."/index.php")) {
          if ($load) {
            $this->PAGE_LEVEL = "pages/".$page."/";
            return BASEDIR."pages/".$page."/index.php";
         } else {
           return "Exists";
         }
        } else if (file_exists(BASEDIR."pages/".$page.".php")) {
          if ($load) {
            $this->PAGE_LEVEL = "pages/";
            return BASEDIR."pages/".$page.".php";
          } else {
            return "Exists";
          }
        } else {
          $this->NotificationsArray[] = array("Type" => "Warning", "Message" => "Siden er ikke tilgængelig: Kunne ikke findes");
          return false;
        }
      } else {
        $this->NotificationsArray[] = array("Type" => "Warning", "Message" => "Siden er ikke tilgængelig: Tom forespørgsel");
        $this->Utilities->redirect($this->Utilities->LinkGiveString('page', 'websites'));
        return false;
      }
    }

    public function LoadModel($Name) {
      $filename = MODEL."class.".$Name.".php";
      if (file_exists($filename)) {
        include $filename;
      } else {
        die("Model doesn't exist");
      }
    }
    
    public function LoadPlugin($Name) {
      $filename = PLUGINS.$Name."/loader.php";
      if (file_exists($filename)) {
        include $filename;
      } else {
        // TODO
      }
    }
}
?>