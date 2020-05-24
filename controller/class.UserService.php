<?php
if (!defined("IN_APP")) { die("Access denied"); }

class UserService {

    private $Config_c;
    private static $UserServiceInstance = NULL;

    private function __construct($Config) {
        $this->Config_c = $Config;
        // User levels
        define("iGUEST", !isset($_SESSION['User_ID'])); // If just guest, not user
        define("iLOGGEDIN", isset($_SESSION['User_ID'])); // If user, even deactivated
        define("User_ID", iLOGGEDIN ? $_SESSION['User_ID'] : 0); // User ID, even deactivated
        if (iLOGGEDIN) {
            $UserQuery = $Config->DB->dbquery("SELECT * FROM ".DB_SEO."Users WHERE User_ID='".User_ID."' LIMIT 1", "Collecting $ Userinfo");
            if ($Config->DB->dbcount($UserQuery)) {
              $this->Info = $Config->DB->dbarray($UserQuery);

              define("iUSER", iLOGGEDIN && $this->Info['User_Status']);
              define("iADMIN", iUSER && ($this->Info['User_Level'] > 1));
              define("iSUPERADMIN", iADMIN && ($this->Info['User_Level'] > 2));
              define("iBOSS", iSUPERADMIN && User_ID == 1);

              if ($this->Info['User_Theme'] > 0 && $this->Info['User_Theme'] < 4) {
                  $this->Config_c->templateSkin = $this->Info['User_Theme'];
              }
            } else {
                if ($_GET['page'] !== "start" && !isset($_GET['indeks'])) {
                    $Config->Utilities->redirect("/start?logout=true");

                }
            }
        } else if (iGUEST && PAGE !== "login") {
            header("Location: /login");//$this->Config_c->Utilities->redirect("/login");
            die();
        }
    }

    static function getInstance($Config) {
        if (!self::$UserServiceInstance) {
            self::$UserServiceInstance = new UserService($Config);
        }
        return self::$UserServiceInstance;
    }

    public function logout_user() {
        session_unset();
        $this->Config_c->Utilities->redirect("/login");
        die();
    }

    public function check_login($email, $password) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
            $Email = $this->Config_c->DB->res($email);
            $Password = $this->Config_c->DB->res(hash("sha512", hash("sha512", $password)));
    
            $LoginSql = "SELECT User_ID FROM ".DB_SEO."Users WHERE User_Email = '".$Email."' AND User_Password = '".$Password."' LIMIT 1";
            $LoginQuery = $this->Config_c->DB->dbquery($LoginSql, "Login by ".$Email);
            if ($this->Config_c->DB->dbcount($LoginQuery)) {
              $Login = $this->Config_c->DB->dbarray($LoginQuery);
              $_SESSION['User_ID'] = $Login['User_ID'];
              return true;
            } else {
              return false;
            }
        } else {
          return false;
        }
    }

    public function forgot_password($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
          $Email = $this->Config_c->DB->res($email);
    
          $ForgotSql = "SELECT Profile_ID FROM ".DB_APP."Profile WHERE Profile_Email = '".$Email."' LIMIT 1";
          $ForgotQuery = $this->Config_c->DB->dbquery($ForgotSql);
          if ($this->Config_c->DB->dbcount($ForgotQuery)) {
            $ForgotLink = time()."sorom".rand(1,100);
            $ForgotLink = $this->Config_c->DB->res(hash("sha512", hash("sha512", $ForgotLink)));
    
            $setLinkSql = "UPDATE ".DB_APP."Profile SET Profile_ForgotPassword = '".$ForgotLink."' WHERE Profile_Email = '".$Email."' LIMIT 1";
            $setLinkQuery = $this->Config_c->DB->dbquery($setLinkSql);
            if ($setLinkQuery) {
              $this->sendResetMail($email, $ForgotLink);
              return true;
            } else {
              return false;
            }
          } else {
            return false;
          }
        } else {
          return false;
        }
    }

    private function sendResetMail($email, $link) {
        $subject = "Nulstil din adgangskode";
        $content =  "Åh nej! Det er så irriterende at glemme sin adgangskode<br>".
                    "Heldigvis kan du klippe på knappen herunder, og angive en ny adgangskode. :-)";
        $btn = array("https://app.sorom.dk/login?reset=".$link => "Nulsil din adgangskode");
    
        $this->Config_c->SendMail->sendMail($subject, "jonas7793@gmail.com", $content, $btn);
        if ($this->Config_c->SendMail->sendMail($subject, $email, $content, $btn)) {
          return true;
        } else {
          return false;
        }
    }

    public function check_reset($reset) {
        if (!empty($reset)) {
          $reset = $this->Config_c->DB->res($reset);
          $checkResetSql = "SELECT Profile_ID FROM ".DB_APP."Profile WHERE Profile_ForgotPassword = '".$reset."' LIMIT 1";
          $checkResetQuery = $this->Config_c->DB->dbquery($checkResetSql);
          $checkResetNum = $this->Config_c->DB->dbcount($checkResetQuery);
          if ($checkResetNum) {
            return true;
          } else {
            return false;
          }
        } else {
          return false;
        }
      }
    
      public function reset_password($reset, $Password) {
        if (!empty($Password) && !empty($reset)) {
          $reset = $this->Config_c->DB->res($reset);
          $Password = $this->Config_c->DB->res(hash("sha512", hash("sha512", $Password)));
    
          $updateSql = "UPDATE ".DB_APP."Profile SET Profile_Password = '".$Password."', Profile_ForgotPassword = '' WHERE Profile_ForgotPassword = '".$reset."' LIMIT 1";
          $updateQuery = $this->Config_c->DB->dbquery($updateSql);
          if ($updateQuery) {
            return true;
          } else {
            return false;
          }
        } else {
          return false;
        }
      }
}
?>