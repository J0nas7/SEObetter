<?php
    if (!defined("IN_APP")) { die("Access denied"); }
    require_once "controller/class.Page.php";
    //require_once "controller/class.Database.php";
    require_once "controller/class.Template.php";

    class Configuration {
        private static $ConfInstance = NULL;

        public $Page;
        public $DB;
        public $Template;

        public $SiteName = "SEObetter";
        public $SiteSlogan = "See You Better!";
        public $templateSkin = 1;

        private function __construct() {
            define("TEMPLATE", "template/");

            $this->Page = Page::getInstance($this);
            $this->Template = Template::getInstance($this);

            // Locate Basedir.php and set the BASEDIR path
            $folder_level = ""; $i = 0;
            while (!file_exists($folder_level."Basedir.html")) {
                $folder_level .= "../"; $i++;
                if ($i == 7) { die("Basedir.html file not found"); }
            }

            // GLOBAL VARIABLES
            define("BASEDIR", $folder_level);
            define("PAGE", (isset($_GET['page']) ? $_GET['page'] : "workspace"));

            require_once TEMPLATE."index.php";
        }

        static function getInstance() {
            if (!self::$ConfInstance) {
            self::$ConfInstance = new Configuration();
            }
            return self::$ConfInstance;
        }
    }
?>