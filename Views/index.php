<div class='login'>
  <div class='login-box'>
    <div class='login-left-card shadow'>
      <img src='<?php echo FRONT_ROOT ?>Views/img/utnmdp-vert.png'>
    </div>
    <div class='login-right-card shadow'>
    <form action="<?php echo FRONT_ROOT ?>Auth/Login" method="post">
        <p>Login</p>
        <input type='text' class="form-control" name='email' placeholder="Your Email" formControlName="email">
        <hr>
        <input type='password' class="form-control" placeholder="Your Password" formControlName="password">
        <hr>
        <button type='submit'>Login</button>
        <a href='#'>Forgot your password?</a>    
        <?php
        if($message != ""){
             echo $message;
        }
        ?>
      </form>
    </div>
  </div>
</div>
