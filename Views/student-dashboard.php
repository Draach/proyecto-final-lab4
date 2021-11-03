<?php 
use Utils\CustomSessionHandler as CustomSessionHandler;

$sessionHandler = new CustomSessionHandler();
?>
<main class='py-5'>
    <section class='dashboard py-5'>
        <div class='option-card border border-dark'>
            <a href="<?php echo FRONT_ROOT ?>Student/AcademicStatus">
                Consultar Estado Académico
            </a>
        </div>
        <div class='option-card border border-dark'>
            <a class="nav-link" href="<?php echo FRONT_ROOT ?>Company/ShowListView">
                Consultar Listado de Empresas
            </a>
        </div>
        <div class='option-card border border-dark'>
            <a href="<?php echo FRONT_ROOT ?>JobOffer/ShowListView">
                Consultar Listado de Propuestas
            </a>
        </div>
        <div class='option-card border border-dark'>
            <a href='<?php echo FRONT_ROOT ?>JobPostulation/ShowPostulationsHistory?studentId=<?php echo $this->sessionHandler->getLoggedStudentId();?>'>
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