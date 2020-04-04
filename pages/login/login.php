<?
if (isset($_POST['Login'])) {
  if ($this->User->check_login($_POST['userMail'], $_POST['userPassword'])) {
    $success = $this->Utilities->redirect("/");
  } else {
    $errormsg = "Log ind mislykkede. Prøv igen.";
  }
}
?>
<div class="text-container error" style="display: <?=(isset($errormsg) ? 'block' : 'none')?>;">
  <?=(isset($errormsg) ? $errormsg : "");?>
</div>
<div class="input-container">
  <input type="text" name="userMail" placeholder="E-mail" required="required" />
  <input type="password" class="pwd" name="userPassword" placeholder="******" required="required" />
  <span class="togglePassword"></span>
</div>
<input type="submit" name="Login" value="Log ind" />
<div class="text-container">
  <span class="Link" id="forgot-password-link" onclick="window.location.href='/login?forgot';">Har du glemt din adgangskode?</span>
  <span class="Link" id="register-user-link" onclick="window.location.href='/login?register';">Tilmeld dig gratis</span>
</div>