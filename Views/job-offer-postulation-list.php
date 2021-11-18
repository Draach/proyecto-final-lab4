<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container text-white">
            <?php if ($postulationsHistory == null) { ?>
                <div class="alert alert-warning" role="alert">
                    No se han encontrado postulaciones para esta oferta de trabajo.
                </div>
            <?php } else { ?>
                <h2 class="mb-4">Historial de Postulaciones</h2>
                <div class="table-container overflow-auto">
                    <table class="table bg-light-alpha">
                        <thead class='thead-dark'>
                            <th>ID Propuesta</th>
                            <th>Descripción</th>
                            <th>Empresa</th>
                            <th>Puesto</th>
                            <th>Salario</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <td><?php echo $postulationsHistory[0]->getJobOffer()->getJobOfferId(); ?></td>
                            <td><?php echo $postulationsHistory[0]->getJobOffer()->getTitle(); ?></td>
                            <td><?php echo $postulationsHistory[0]->getJobOffer()->getCompany()->getName(); ?></td>
                            <td><?php echo $postulationsHistory[0]->getJobOffer()->getJobPosition()->getDescription(); ?></td>
                            <td><?php echo $postulationsHistory[0]->getJobOffer()->getSalary(); ?></td>
                            <td></td>
                        </tbody>
                    </table>
                    <table class="table bg-light-alpha">
                        <thead class='thead-dark'>
                            <th>ID Postulación</th>
                            <th>ID Estudiante</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Comentario</th>
                            <th>Acciones</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php foreach ($postulationsHistory as $postulation) { ?>
                                <tr>
                                    <td><?php echo $postulation->getPostulationId(); ?></td>
                                    <td><?php echo $postulation->getStudent()->getStudentId(); ?></td>
                                    <td><?php echo $postulation->getStudent()->getFirstName(); ?></td>
                                    <td><?php echo $postulation->getStudent()->getLastName(); ?></td>                                    
                                    <td><?php echo $postulation->getComment(); ?></td>
                                    <td><a href="<?php echo FRONT_ROOT ?>Uploads/<?php echo $postulation->getCVarchive(); ?>" target="_blank" class="btn btn-yellow">Ver CV</a></td>
                                    <td><a href="<?php echo FRONT_ROOT ?>JobPostulation/Remove?jobOfferId=<?php echo $postulationsHistory[0]->getJobOffer()->getJobOfferId(); ?>&studentId=<?php echo $postulation->getStudent()->getStudentId(); ?>&email=<?php echo $postulation->getStudent()->getEmail(); ?>" class="btn btn-warning">Anular</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
                <a class="btn btn-secondary mt-0" href="<?php echo FRONT_ROOT ?>JobOffer/ShowListView">Regresar</a>
            </div>
    </section>
</main>