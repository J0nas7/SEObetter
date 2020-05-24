<?php
    if (!defined("IN_APP")) { die("Access denied"); }
    require_once "controller/class.Page.php";
    require_once "controller/class.Database.php";
    require_once "controller/class.Template.php";
    require_once "controller/class.UserService.php";

    class Configuration {
        private static $ConfInstance = NULL;

        public $Page;
        public $DB;
        public $Template;

        public $SiteName = "SEObetter";
        public $SiteSlogan = "See You Better!";
        public $templateSkin = 1;

        private function __construct() {
            // Locate Basedir.php and set the BASEDIR path
            $folder_level = ""; $i = 0;
            while (!file_exists($folder_level."Basedir.html")) {
                $folder_level .= "../"; $i++;
                if ($i == 7) { die("Basedir.html file not found"); }
            }

            // GLOBAL CONSTANT VARIABLES
            define("BASEDIR", $folder_level);
            define("PAGE", (isset($_GET['page']) ? $_GET['page'] : "start"));
            define("APP_URL", ($_SERVER['HTTP_HOST'] == "localhost:8443" ? "/" : "http://app.seobetter.dk/"));
            define("TEMPLATE_URL", APP_URL."template/");
            define("TEMPLATE", "template/");

            // GET INSTANCES OF OTHER CONTROLLERS
            $this->DB = DatabaseConfig::getInstance();
            $this->Template = Template::getInstance($this);
            $this->UserService = UserService::getInstance($this);
            $this->Page = Page::getInstance($this);

            require_once TEMPLATE."index.php";
            $this->getPage(PAGE);
            require_once TEMPLATE."elements/footer.php";
        }

        private function getPage($page, $load = true) {
            $checkPage = $this->Page->checkPage($page, $load);
            if (isset($checkPage) && $checkPage && $checkPage !== "Exists") {
                require_once $checkPage;
            }
        }

        static function getInstance() {
            if (!self::$ConfInstance) {
            self::$ConfInstance = new Configuration();
            }
            return self::$ConfInstance;
        }
    }
?>