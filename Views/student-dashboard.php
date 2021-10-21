<?php

if ($_SESSION["loggedUser"]['role'] != "student") {
    require_once(VIEWS_PATH . "index.php");
} else {
?>
    <main class='py-5'>
        <section class='dashboard py-5'>
            <div class='option-card border border-dark'>
                <a href="<?php echo FRONT_ROOT ?>Student/AcademicStatus">
                    Consultar Estado Académico
                </a>
            </div>
            <div class='option-card border border-dark'>
                <a class="nav-link" href="<?php echo FRONT_ROOT ?>Company/List">
                    Consultar Listado de Empresas
                </a>
            </div>
            <div class='option-card border border-dark'>
                <a href='#'>
                    Consultar Listado de Propuestas
                </a>
            </div>
            <div class='option-card border border-dark'>
                <a href='#'>
                    Consultar Historial de Aplicaciones
                </a>
            </div>
            <div class='option-card border border-dark'>
                <a href="<?php echo FRONT_ROOT ?>Auth/Logout">
                    Salir
                </a>
            </div>

        </section>
    </main>
<?php
}
?>