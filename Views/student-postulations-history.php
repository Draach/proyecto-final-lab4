<?php

use Utils\CustomSessionHandler as CustomSessionHandler;

$sessionHandler = new CustomSessionHandler();
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Historial de Postulaciones de <?php echo $this->sessionHandler->getLoggedUserName(); ?></h2>
            <div class="table-container overflow-auto">
                <table class="table bg-light-alpha">
                    <thead class='thead-dark'>

                        <th>Empresa</th>
                        <th>Puesto</th>
                        <th>Comentario</th>
                        <th>Estado</th>
                    </thead>
                    <tbody>
                        <?php foreach ($jobPostulationsList as $jobPostulation) { ?>
                            <tr>
                                <td><?php foreach ($jobOffersList as $jobOffer) {
                                        if ($jobOffer->getJobOfferId() == $jobPostulation->getJobOfferId()) {
                                            foreach ($companiesList as $company) {
                                                if ($company->getCompanyId() == $jobOffer->getCompanyId()) {
                                                    echo $company->getName();
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?php foreach ($jobOffersList as $jobOffer) {
                                        if ($jobOffer->getJobOfferId() == $jobPostulation->getJobOfferId()) {
                                            foreach ($jobPositionsList as $jobPosition) {
                                                if ($jobPosition['jobPositionId'] == $jobOffer->getJobPositionId()) {
                                                    echo $jobPosition['description'];
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?php echo $jobPostulation->getComment(); ?></td>
                                <td><?php
                                    if ($jobPostulation->getActive() == 1) {
                                        echo "<p class='text-primary'>Activa</p>";
                                    } else {
                                        echo "<p class='text-danger'>Inactiva</p>";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <a class="btn btn-secondary mt-0" href="<?php echo FRONT_ROOT ?>Student/ShowDashboard">Regresar</a>
        </div>
    </section>
</main>