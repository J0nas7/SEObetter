<?
if (isset($_POST['Register'])) {
  if ($this->User->create_login($_POST['userMail'])) {
    $successmsg = "Din e-mail er oprettet. Vi sender en e-mail med et kodeord.";
  } else {
    $errormsg = "E-mail adressen er ugyldig eller bruges allerede. Prøv igen.";
  }
}
?>

<div class="text-container error" style="display: <?=(isset($errormsg) ? 'block' : 'none')?>;">
  <?=$errormsg;?>
</div>
<div class="text-container success" style="display: <?=(isset($successmsg) ? 'block' : 'none')?>;">
  <?=$successmsg;?>
</div>
<div class="input-container">
  <input type="text" name="userMail" placeholder="E-mail" required="required" />
</div>
<input type="submit" name="Register" value="Opret bruger" />
<div class="text-container">
  <span class="Link" id="login-link" onclick="window.location.href='/login';">Har du allerede en bruger? Log ind her</span>
  <span></span>
</div>
