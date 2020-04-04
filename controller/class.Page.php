<?php
class Page {
    private static $PageInstance = NULL;

    private function __construct() {
        
    }

    static function getInstance() {
        if (!self::$PageInstance) {
          self::$PageInstance = new Page();
        }
        return self::$PageInstance;
    }

    private function getPage($page, $load = true) {
      if (!empty($page)) {
        if (file_exists(BASEDIR."pages/".$page."/index.php")) {
          if ($load) {
            $this->PAGE_LEVEL = "pages/".$page."/";
            require_once BASEDIR."pages/".$page."/index.php";
         }
        } else if (file_exists(BASEDIR."pages/".$page.".php")) {
          if ($load) {
            $this->PAGE_LEVEL = "pages/";
            require_once BASEDIR."pages/".$page.".php";
          }
        } else {
          $this->NotificationsArray[] = array("Type" => "Warning", "Message" => "Siden er ikke tilgængelig: Kunne ikke findes");
        }
        } else {
          $this->NotificationsArray[] = array("Type" => "Warning", "Message" => "Siden er ikke tilgængelig: Tom forespørgsel");
          $this->Utilities->redirect($this->Utilities->LinkGiveString('page', 'websites'));
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