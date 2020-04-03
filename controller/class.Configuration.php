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

        private function __construct() {
            define("TEMPLATE", "template/");

            $this->Page = Page::getInstance();
            $this->Template = Template::getInstance($this);

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