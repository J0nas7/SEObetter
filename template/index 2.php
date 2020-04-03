<!DOCTYPE html>
<html lang="da">
<head>
    <title>Time Tracking Tool | Applesign</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="cache-control" content="no-cache">
    <?php
    $this->Template->TemplateLoadStylesheet("https://fonts.googleapis.com/css?family=Asap&display=swap", "-t");
    $this->Template->TemplateLoadStylesheet("template.min.css", "template");
    $this->Template->TemplateLoadJavaScript(TEMPLATE_URL."js/template.js");
    ?>
</head>
<body>
    <div class="Bodycover with-bg"></div>
    <div class="topbar">
        <div class="topbar-center">
            <a class="logo" href="<?=APP_URL;?>/?ref=logo"></a>
            <span class="applesign">Applesign</span>
            <span class="menuTrigger">
                <span class="hamburger" id="one"></span>
                <span class="hamburger" id="two"></span>
                <span class="hamburger" id="three"></span>
                <span class="x" id="one"></span>
                <span class="x" id="two"></span>
            </span>
            <ul class="topmenu">
                <li><a href="<?=APP_URL;?>/?ref=tm">Workspaces</a></li>
                <li><a href="<?=APP_URL;?>/projects?ref=tm">Projects</a></li>
                <li><a href="<?=APP_URL;?>/todolists?ref=tm">Todolists</a></li>
            </ul>
        </div>
    </div>
    <div class="pageWrapper">
        <?=$this->getPage(PAGE);?>
        <div class="clrBth"></div>
    </div>

    <?php
    $playerStatus = "stop";
    ?>
    <div class="bottombar <?=$playerStatus;?> <?=(isset($this->FooterbarType) ? $this->FooterbarType : "");?>">
        <?php if (isset($this->FooterbarMsg)) { ?>
            <span class="FooterMsg"><?=$this->FooterbarMsg;?></span>
        <?php } else { ?>
            <script type="text/javascript">var playerStatus = "<?=$playerStatus;?>", playerTimer = 0;</script>
            <div class="player <?=$playerStatus;?>">
                <span class="ctrlBtn <?=$playerStatus;?>"></span>
                <span class="ctrlBtn2 stop"></span>
                <span class="curTask"></span>
                <span class="pauseTask">PAUSE</span>
                <span class="counter">
                    <span>H</span>
                    <strong class="H">00</strong>
                    <span>:M</span>
                    <strong class="M">00</strong>
                    <span>:S</span>
                    <strong class="S">00</strong>
                </span>
            </div>
        <?php } ?>
    </div>
    <footerjs style="display: none;">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script type="text/javascript">
        <?=$this->Template->TemplateLoadStylesheets;?>
        </script>
        <?=$this->Template->PerformFooterJS;?>
    </footerjs>
</body>
</html>