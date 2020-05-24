<?
if ($_GET['reset']) { $reset = $this->DB->res($_GET['reset']); }

if ($_POST['Reset']) {
  $_GET['reset'] = $reset = $this->DB->res($_POST['Reset']);
  if ($this->User->reset_password($reset, $_POST['userPassword'])) {
    $successmsg = "Din adgangskode er nu opdateret!<br>Klik herunder for at logge ind.";
  } else {
    $errormsg = "Adgangskoden blev ikke opdateret. Prøv igen.";
  }
}

if ($reset) {
  if ($errormsg || $successmsg) {
  ?>
  <div class="text-container error" style="display: <?=($errormsg ? 'block' : 'none')?>;">
    <?=$errormsg;?>
  </div>
  <div class="text-container success" style="display: <?=($successmsg ? 'block' : 'none')?>;">
    <?=$successmsg;?>
  </div>
  <?
  } else if ($this->User->check_reset($reset)) {
  ?>
  <div class="input-container">
    <input type="password" class="pwd" name="userPassword" placeholder="Ny adgangskode" required="required" />
    <span class="togglePassword"></span>
  </div>
  <input type="submit" value="Gem ny adgangskode" />
  <input type="hidden" name="Reset" value="<?=$reset;?>" />
  <?
  } else {
    $errormsg2 = "Den angivede resetnøgle findes ikke. Prøv igen.";
  }
  ?>
  <div class="text-container">
    <span class="Link" id="login-link" onclick="window.location.href='/login';">Kommet i tanke om adgangskoden? Log ind her</span>
    <span></span>
  </div>
<?
} else {
  $errormsg2 = "Linket er ugyldigt. Prøv igen.";
}
?>
<div class="text-container error" style="display: <?=($errormsg2 ? 'block' : 'none')?>;">
  <?=$errormsg2;?>
</div>
