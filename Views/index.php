<?php
if ($_SESSION["loggedUser"]['role'] == "admin") {
  require_once(VIEWS_PATH . "admin-dashboard.php");
} else if ($_SESSION["loggedUser"]["role"] == "student") {
  require_once(VIEWS_PATH . "student-dashboard.php");
} else {
?>
  <div class='login'>
    <div class='login-box'>
      <div class='login-left-card shadow'>
        <img src='<?php echo FRONT_ROOT ?>Views/img/utnmdp-vert.png'>
      </div>
      <div class="login-right-card shadow">
        <div>
          <h2 class='text-center pt-4'><a href="<?php echo FRONT_ROOT ?>Home/AdminLogin">Administrador</a></h2>
        </div>
        <div>
          <h2 class='text-center pt-4'><a href="<?php echo FRONT_ROOT ?>Home/StudentLogin">Estudiante</a></h2>
        </div>
      </div>
    </div>
  </div>
<?php
}
?>