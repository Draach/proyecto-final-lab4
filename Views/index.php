<?php
if(isset($_SESSION["loggedUser"])){
  if ($_SESSION["loggedUser"]['role'] == "admin") {
    require_once(VIEWS_PATH . "admin-dashboard.php");
  } else if ($_SESSION["loggedUser"]["role"] == "student") {
    require_once(VIEWS_PATH . "student-dashboard.php");
  } 
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
          <input type='text' class="form-control" name='email' placeholder="Your email here..." formControlName="email">
          <hr>
          <input type='password' name='password' value='' placeholder="Admin password here..." class="form-control" formControlName="password">
          <hr>
          <button type='submit'>Login</button>
          <a href='#'>Olvidé mi contraseña.</a>
          <?php
          if ($message != "") {
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