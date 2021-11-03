<?php

use Models\JobOffer;
use Utils\CustomSessionHandler as CustomSessionhandler;

$sessionHandler = new CustomSessionhandler();
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <form action="<?php echo FRONT_ROOT ?>JobOffer/GetByJobPositionDesc" method="post" class="form-row">
            <div class="col-8">
                    <h2>Listado de Propuestas Laborales</h2>
                </div>
                <div class="col">
                    <input class="form-control mr-sm-2" type="search" name="jobPositionDesc" placeholder="Search" aria-label="Search">
                </div>
                <div class="col">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </div>
            </form>
            <?php if (isset($message)) {
                echo $message;
            } ?>
            <table class="table bg-light-alpha">
                <thead>
                    <th>Descripción</th>
                    <th>Creación</th>
                    <th>Expiración</th>
                    <th>Salario</th>
                    <th>Empresa</th>
                    <th>Puesto</th>
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
                                <?php if ($sessionHandler->isAdmin() == true) { ?>
                                    <td><a class="btn btn-secondary" href="<?php echo FRONT_ROOT ?>JobOffer/Delete/<?php echo $jobOffer->getJobOfferId(); ?>">Eliminar</a></td>
                                    <td><a class="btn btn-secondary" href="<?php echo FRONT_ROOT ?>JobOffer/ShowModifyView/<?php echo $jobOffer->getJobOfferId(); ?>">Modificar</a></td>
                                    <?php }
                                if ($sessionHandler->isStudent() == true) {
                                    if ($isPostulated != $jobOffer->getJobOfferId()) { ?>
                                        <td><a class="btn btn-primary" href="<?php echo FRONT_ROOT ?>JobPostulation/ShowPostulationView/<?php echo $jobOffer->getJobOfferId(); ?>">Postularse</a></td>
                                    <?php
                                    }
                                    if ($isPostulated == $jobOffer->getJobOfferId()) { ?>
                                        <td><a class="btn btn-danger" href="<?php echo FRONT_ROOT ?>JobPostulation/Remove?jobOfferId=<?php echo $jobOffer->getJobOfferId(); ?>&studentId=<?php echo $sessionHandler->getLoggedStudentId(); ?>">Despostularse</a></td>
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