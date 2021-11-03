<?php

use Utils\CustomSessionHandler as CustomSessionHandler;

$sessionHandler = new CustomSessionHandler();
?>
<main class="admin-dashboard">
    <div class="admin-dashboard-content">
        <h1>Bienvenido <?php echo $this->sessionHandler->getLoggedUserName(); ?></h1>
    </div>
</main>