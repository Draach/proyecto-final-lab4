<?php
use Utils\CustomSessionHandler as CustomSessionHandler;

$sessionHandler = new CustomSessionHandler();
?>
<main class="admin-dashboard">
    <div class="admin-dashboard-content text-yellow">
        <h1>Bienvenido <?php echo $this->sessionHandler->getEmail(); ?> </h1>
    </div>
</main>