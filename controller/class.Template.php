<?php
if (!defined("IN_APP")) { die("Access denied"); }

class Template {

  private $Config_c;
  private static $TemplateInstance = NULL;
  public $TemplateLoadStylesheets;
  public $PerformFooterJS;

  private function __construct($Config) {
    $this->Config_c = $Config;

    $templateSkins = array(1 => "light", "dark");
    $theTemplateSkin = $templateSkins[$this->Config_c->templateSkin];
    $this->Config_c->templateSkin = $theTemplateSkin;
  }

  static function getInstance($Config) {
        if (!self::$TemplateInstance) {
            self::$TemplateInstance = new Template($Config);
        }
        return self::$TemplateInstance;
    }

  function PageH($Text) {
    $this->PerformFooterJS .= '
      <script type="text/javascript">
        $(".pageWrapper .pageHeader:first-child").html("'.$Text.'");
      </script>
    ';
  }

  function TemplateLoadStylesheet($Href, $relativeTo = "") {
    if ($relativeTo == "template") { $Href = "/".TEMPLATE."css/".$Href; }
    if ($relativeTo !== "-t") { $Href .= "?t=".time(); }
    $this->TemplateLoadStylesheets .= '
      var link = $("<link />",{
        rel: "stylesheet",
        type: "text/css",
        href: "'.$Href.'"
      });
      $("head").append(link);
    ';
  }

  function TemplateLoadJavaScript($Src) {
    $this->PerformFooterJS .= ' <script type="text/javascript" src="'.$Src.'?t='.time().'"></script>';
  }

}
?>