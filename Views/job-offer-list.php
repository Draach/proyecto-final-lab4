<?php

use Models\JobOffer;
use Utils\CustomSessionHandler as CustomSessionhandler;

$sessionHandler = new CustomSessionhandler();
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container-fluid text-white">
            <form action="<?php echo FRONT_ROOT ?>JobOffer/GetByJobPositionDesc" method="post" class="form-row">
                <div class="col-8">
                    <h2>Listado de Propuestas Laborales</h2>
                </div>
                <div class="col">
                    <input class="form-control mr-sm-2" type="search" name="jobPositionDesc" placeholder="Buscar por puesto..." aria-label="Search">
                </div>
                <div class="col">
                    <button class="btn btn-outline-success border-yellow my-2 my-sm-0" type="submit">Buscar</button>
                </div>
            </form>
            <?php if (isset($message)) {
                echo "<div class='alert alert-warning' role='alert'>
                $message
                </div>";
            } ?>
            <div class="table-container overflow-auto">
                <table class="table bg-light-alpha">
                    <thead>
                        <?php if ($sessionHandler->isAdmin()) {
                        ?>
                            <th>ID</th>
                        <?php
                        }
                        ?>
                        <th>Descripción</th>
                        <th>Creación</th>
                        <th>Expiración</th>
                        <th>Salario</th>
                        <th>Empresa</th>
                        <th>Puesto</th>
                        <th>Carrera</th>
                        <th>Acciones</th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($jobOffersList as $jobOffer) {
                            if ($jobOffer->getActive() == true) {
                        ?>
                                <tr>
                                    <?php if ($sessionHandler->isAdmin()) {
                                    ?>
                                        <td><?php echo $jobOffer->getJobOfferId() ?></td>
                                    <?php
                                    }
                                    ?>
                                    <td><?php echo $jobOffer->getTitle(); ?></td>
                                    <td><?php echo $jobOffer->getCreatedAt(); ?></td>
                                    <td><?php echo $jobOffer->getExpirationDate(); ?></td>
                                    <td><?php echo $jobOffer->getSalary(); ?></td>
                                    <td><?php
                                        echo $jobOffer->getCompany()->getName();
                                        ?></td>
                                    <td><?php
                                        echo $jobOffer->getJobPosition()->getDescription();
                                        ?></td>
                                    <td>
                                        <?php
                                        echo $jobOffer->getJobPosition()->getCareer()->getDescription();
                                        ?>
                                    </td>
                                    <?php if ($sessionHandler->isAdmin() == true) { ?>
                                        <td><a class="btn btn-yellow shadow" href="<?php echo FRONT_ROOT ?>JobOffer/ShowJobOfferPostulations/<?php echo $jobOffer->getJobOfferId(); ?>">Ver Postulaciones</a></td>
                                        <td><a class="btn btn-yellow shadow" href="<?php echo FRONT_ROOT ?>JobOffer/ShowModifyView/<?php echo $jobOffer->getJobOfferId(); ?>">Modificar</a></td>
                                        <td><button type="button" class="btn btn-danger shadow" data-id="<?php echo $jobOffer->getJobOfferId(); ?>" data-action="<?php echo FRONT_ROOT ?>JobOffer/Delete/" data-message="Está seguro de querer eliminar esta propuesta laboral?" onclick="confirm(this);">
                                                Eliminar
                                            </button></td>
                                        <?php }
                                    if ($sessionHandler->isStudent() == true) {
                                        if ($postulatedJobOfferId != $jobOffer->getJobOfferId() && $postulatedJobOfferId == -1) { ?>
                                            <!--
                                                Link para aplicar en caso de que el modal no funcione
                                                <td><a class="btn btn-yellow shadow" href="<?php echo FRONT_ROOT ?>JobPostulation/ShowPostulationView/<?php echo $jobOffer->getJobOfferId(); ?>" onclick="return confirm('Desea aplicar para el puesto <?php echo $jobOffer->getJobPosition()->getDescription(); ?>?');">Aplicar</a></td>
                                            -->
                                            <td><button type="button" class="btn btn-yellow shadow" data-id="<?php echo $jobOffer->getJobOfferId(); ?>" data-position="<?php echo $jobOffer->getJobPosition()->getDescription(); ?>" data-action="<?php echo FRONT_ROOT ?>JobPostulation/ShowPostulationView/" data-message="Está a punto de aplicar para el puesto:" onclick="confirm(this);">
                                                    Aplicar
                                                </button></td>
                                        <?php
                                        }
                                        if ($postulatedJobOfferId != $jobOffer->getJobOfferId() && $postulatedJobOfferId != -1) { ?>
                                            <td><a class="btn btn-secondary disabled" href="<?php echo FRONT_ROOT ?>JobPostulation/ShowPostulationView/<?php echo $jobOffer->getJobOfferId(); ?>">Aplicar</a></td>
                                        <?php
                                        }
                                        if ($postulatedJobOfferId == $jobOffer->getJobOfferId()) { ?>
                                            <td><a class="btn btn-danger shadow" href="<?php echo FRONT_ROOT ?>JobPostulation/Remove?jobOfferId=<?php echo $jobOffer->getJobOfferId(); ?>&studentId=<?php echo $sessionHandler->getStudentId(); ?>" onclick="return confirm('Estas a punto de remover tu aplicación. Estás seguro de que deseas hacer esto?');">Remover Aplicación</a></td>
                                    <?php
                                        }
                                    } ?>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
            if ($sessionHandler->isStudent()) {
            ?>
                <a class="btn btn-secondary" href="<?php echo FRONT_ROOT ?>Student/ShowDashboard">Regresar</a>
            <?php
            } else if ($sessionHandler->isAdmin()) {
            ?>
                <a class="btn btn-secondary" href="<?php echo FRONT_ROOT ?>Admin/ShowDashboard">Regresar</a>
            <?php
            }
            ?>
        </div>
    </section>
</main>


<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="confirmMessage"></p>
                <form method="POST" action="" id="form-confirm">
                    <input type="hidden" name="id">
                </form>                
                <p id="position"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Atras</button>
                <button type="submit" form="form-confirm" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </div>
</div>

