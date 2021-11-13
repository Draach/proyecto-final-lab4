<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container text-white">
            <?php if ($jobPostulationsList == null) { ?>
                <div class="alert alert-warning" role="alert">
                    <h2 class="py-10 pl-5">Aún no te has postulado a ninguna oferta!</h2>
                </div>
            <?php } else { ?>
                <h2 class="mb-4">Historial de Postulaciones de <?php echo $jobPostulationsList[0]->getStudent()->getFirstName() . " " . $jobPostulationsList[0]->getStudent()->getLastName(); ?></h2>
                <div class="table-container overflow-auto">
                    <table class="table bg-light-alpha">
                        <thead class='thead-dark'>
                            <th>Empresa</th>
                            <th>Puesto</th>
                            <th>Carrera</th>
                            <th>Comentario</th>
                            <th>Estado</th>
                        </thead>
                        <tbody>
                            <?php foreach ($jobPostulationsList as $jobPostulation) { ?>
                                <tr>
                                    <td><?php echo $jobPostulation->getJobOffer()->getCompany()->getName(); ?></td>
                                    <td><?php echo $jobPostulation->getJobOffer()->getJobPosition()->getDescription(); ?></td>
                                    <td><?php echo $jobPostulation->getJobOffer()->getJobPosition()->getCareer()->getDescription() ?></td>
                                    <td><?php echo $jobPostulation->getComment(); ?></td>
                                    <td><?php
                                        if ($jobPostulation->getActive() == 1) {
                                            echo "<p class='badge badge-warning'>Activa</p>";
                                        } else {
                                            echo "<p class='badge badge-secondary'>Inactiva</p>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
            <a class="btn btn-secondary mt-0" href="<?php echo FRONT_ROOT ?>Student/ShowDashboard">Regresar</a>
        </div>
    </section>
</main>