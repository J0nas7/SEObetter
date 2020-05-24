<?
if (isset($_POST['Forgot'])) {
  if ($this->User->forgot_password($_POST['userMail'])) {
    $successmsg = "Vi har sendt en e-mail med et link.<br>Med den kan du nulstille din adgangskode inden midnat.";
  } else {
    $errormsg = "E-mail adressen er ugyldig eller ikke i brug. Prøv igen.";
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
<input type="submit" name="Forgot" value="Få en ny adgangskode" />
<div class="text-container">
  <span class="Link" id="login-link" onclick="window.location.href='/login';">Kommet i tanke om adgangskoden? Log ind her</span>
  <span></span>
</div>
