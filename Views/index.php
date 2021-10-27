<?php

use Utils\CustomSessionHandler as CustomSessionhandler;

$sessionHandler = new CustomSessionhandler();
if ($sessionHandler->isAdmin()) {
  require_once(VIEWS_PATH . "nav.php");
  require_once(VIEWS_PATH . "admin-dashboard.php");
} else if ($sessionHandler->isStudent()) {
  require_once(VIEWS_PATH . "student-dashboard.php");
} else {
?>
  <div class='login'>
    <div class='login-box'>
      <div class='login-left-card shadow'>
        <img src='<?php echo FRONT_ROOT ?>Views/img/utnmdp-vert.png'>
      </div>
      <div class='login-right-card shadow'>
        <form action="<?php echo FRONT_ROOT ?>Auth/Login" method="post">
          <p>Login</p>
          <input type='text' class="form-control" name='email' placeholder="Email here..." formControlName="email">
          <hr>
          <input type='password' name='password' value='' placeholder="Password here..." class="form-control" formControlName="password">
          <hr>
          <button type='submit'>Login</button>
          <div id="formFooter">
            <a class="underlineHover" href="#">Olvidé mi contraseña.</a>
          </div>
          <?php
          if (isset($message)) {
            echo $message;
          }
          ?>
        </form>
      </div>
    </div>
  </div>
<?php
}
?>