<?php
if (!defined("IN_APP")) { die("Access denied"); }
if (isset($_SESSION['Profile_ID'])) { $this->Utilities->redirect("/"); }

/*$this->Template->TemplateLoadJavascript(TEMPLATE_URL."js/jQuery_min.3.3.1.js");
$this->Template->TemplateLoadJavascript($this->PAGE_LEVEL."login.js");
$this->Template->TemplateLoadStylesheet($this->PAGE_LEVEL."login.css");*/
?>
<html lang="da">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Log på | Velkommen til Applesign</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="cache-control" content="no-cache">
    <link rel="stylesheet" media="screen" href="<?=TEMPLATE_URL;?>css/template.min.css?t=<?=time();?>" />
</head>
<body class="Loginpage">
  <div class="Loginform">
    <form action="" method="post" class="Loginform">
      <div class="logo-container">
        <span class="logo-span">
          <img src="/applesign/template/img/topbar-logo.png" />
        </span>
      </div>
      <?
      if (isset($_GET['register'])) {
        require_once "register.php";
      } else if (isset($_GET['forgot'])) {
        require_once "forgot.php";
      } else if (isset($_GET['reset'])) {
        require_once "reset.php";
      } else {
        require_once "login.php";
      }
      ?>
      <div class="footer">
        
      </div>
    </form>
  </div>
  <footerjs style="display: none;">
    <script type="text/javascript" src="<?=TEMPLATE_URL;?>js/jQuery_min.3.3.1.js"></script>
    <script type="text/javascript">
      <?=$this->Template->TemplateLoadStylesheets;?>
    </script>
    <?=$this->Template->PerformFooterJS;?>
  </footerjs>
</body>
</html>
