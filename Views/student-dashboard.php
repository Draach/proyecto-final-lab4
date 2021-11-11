<?php 
use Utils\CustomSessionHandler as CustomSessionHandler;

$sessionHandler = new CustomSessionHandler();
?>
<main class='py-5'>
    <section class='dashboard py-5'>
        <div class='option-card btn-yellow border-rounded shadow'>
            <a href="<?php echo FRONT_ROOT ?>Student/AcademicStatus">
                Estado Académico
            </a>
        </div>
        <div class='option-card btn-yellow border-rounded shadow'>
            <a class="nav-link" href="<?php echo FRONT_ROOT ?>Company/ShowListView">
                Listado de Empresas
            </a>
        </div>
        <div class='option-card btn-yellow border-rounded shadow'>
            <a href="<?php echo FRONT_ROOT ?>JobOffer/ShowListView">
                Listado de Propuestas
            </a>
        </div>
        <div class='option-card btn-yellow border-rounded shadow'>
            <a href='<?php echo FRONT_ROOT ?>JobPostulation/ShowPostulationsHistory?studentId=<?php echo $this->sessionHandler->getStudentId();?>'>
                Historial de Aplicaciones
            </a>
        </div>
        <div class='option-card btn-yellow border-rounded shadow'>
            <a href="<?php echo FRONT_ROOT ?>Auth/Logout">
                Salir
            </a>
        </div>

    </section>
</main>