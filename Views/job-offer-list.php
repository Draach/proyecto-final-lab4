<?php

use Models\JobOffer;
use Utils\CustomSessionHandler as CustomSessionhandler;

$sessionHandler = new CustomSessionhandler();
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container-fluid">
            <form action="<?php echo FRONT_ROOT ?>JobOffer/GetByJobPositionDesc" method="post" class="form-row">
                <div class="col-8">
                    <h2>Listado de Propuestas Laborales</h2>
                </div>
                <div class="col">
                    <input class="form-control mr-sm-2" type="search" name="jobPositionDesc" placeholder="Buscar por puesto..." aria-label="Search">
                </div>
                <div class="col">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </div>
            </form>
            <?php if (isset($message)) {
                echo $message;
            } ?>
            <div class="table-container overflow-auto">
                <table class="table bg-light-alpha">
                    <thead>
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
                                    <td><?php echo $jobOffer->getTitle(); ?></td>
                                    <td><?php echo $jobOffer->getCreatedAt(); ?></td>
                                    <td><?php echo $jobOffer->getExpirationDate(); ?></td>
                                    <td><?php echo $jobOffer->getSalary(); ?></td>
                                    <td><?php
                                        foreach ($companiesList as $company) {
                                            if ($company->getCompanyId() == $jobOffer->getCompanyId()) {
                                                echo $company->getName();
                                            }
                                        }
                                        ?></td>
                                    <td><?php foreach ($jobPositionsList as $jobPosition) {
                                            if ($jobPosition['jobPositionId'] == $jobOffer->getJobPositionId()) {
                                                echo $jobPosition['description'];
                                            }
                                        }
                                        ?></td>
                                    <td>
                                        <?php
                                        foreach ($jobPositionsList as $jobPosition) {
                                            if ($jobPosition['jobPositionId'] == $jobOffer->getJobPositionId()) {
                                                foreach ($careersList as $career) {
                                                    if ($career['careerId'] == $jobPosition['careerId']) {
                                                        echo $career['description'];
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </td>
                                    <?php if ($sessionHandler->isAdmin() == true) { ?>
                                        <td><a class="btn btn-primary" href="<?php echo FRONT_ROOT ?>JobOffer/ShowJobOfferPostulations/<?php echo $jobOffer->getJobOfferId(); ?>">Ver Postulaciones</a></td>
                                        <td><a class="btn btn-primary" href="<?php echo FRONT_ROOT ?>JobOffer/ShowModifyView/<?php echo $jobOffer->getJobOfferId(); ?>">Modificar</a></td>
                                        <td><a class="btn btn-danger" href="<?php echo FRONT_ROOT ?>JobOffer/Delete/<?php echo $jobOffer->getJobOfferId(); ?>" onclick="return confirm('Estas seguro de que quieres eliminar esta propuesta laboral?');">Eliminar</a></td>
                                        <?php }
                                    if ($sessionHandler->isStudent() == true) {
                                        if ($postulatedJobOfferId != $jobOffer->getJobOfferId() && $postulatedJobOfferId == -1) { ?>
                                            <td><a class="btn btn-primary" href="<?php echo FRONT_ROOT ?>JobPostulation/ShowPostulationView/<?php echo $jobOffer->getJobOfferId(); ?>" onclick="return confirm('Desea aplicar para la propuesta <?php echo $jobOffer->getTitle(); ?>?');">Aplicar</a></td>
                                        <?php
                                        }
                                        if ($postulatedJobOfferId != $jobOffer->getJobOfferId() && $postulatedJobOfferId != -1) { ?>
                                        <td><a class="btn btn-secondary disabled" href="<?php echo FRONT_ROOT ?>JobPostulation/ShowPostulationView/<?php echo $jobOffer->getJobOfferId(); ?>">Aplicar</a></td>                                            
                                        <?php
                                        }
                                        if ($postulatedJobOfferId == $jobOffer->getJobOfferId()) { ?>
                                            <td><a class="btn btn-danger" href="<?php echo FRONT_ROOT ?>JobPostulation/Remove?jobOfferId=<?php echo $jobOffer->getJobOfferId(); ?>&studentId=<?php echo $sessionHandler->getStudentId(); ?>" onclick="return confirm('Estas a punto de remover tu aplicación. Estás seguro de que deseas hacer esto?');">Remover Aplicación</a></td>
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