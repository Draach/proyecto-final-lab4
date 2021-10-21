<div class='login'>
  <div class='login-box'>
    <div class='login-left-card shadow'>
      <img src='<?php echo FRONT_ROOT ?>Views/img/utnmdp-vert.png'>
    </div>
    <div class='login-right-card shadow'>
      <form action="<?php echo FRONT_ROOT ?>Auth/StudentLogin" method="post">
        <p>Login</p>
        <input type='text' class="form-control" name='email' placeholder="Your Email" formControlName="email">
        <hr>        
        <button type='submit'>Login</button>
        <a class="btn btn-secondary mt-0" href="<?php echo FRONT_ROOT ?>">Regresar</a>
        <a href='#'>Forgot your password?</a>       
        <?php
        if ($message != "") {
          echo $message;
        }
        ?>
      </form>
    </div>
  </div>
</div>