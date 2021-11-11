<?php
echo var_dump($studentsList);
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
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
                        <td><?php echo $jobOffer->getJobOfferId(); ?></td>
                        <td><?php echo $jobOffer->getTitle(); ?></td>
                        <td><?php echo $company->getName(); ?></td>
                        <td><?php echo $jobOffer->getJobPositionId(); ?></td>
                        <td><?php echo $jobOffer->getSalary(); ?></td>
                        <td></td>
                    </tbody>
                    <thead class='thead-dark'>
                        <th>ID Postulación</th>
                        <th>ID Estudiante</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Comentario</th>
                        <th>Currículum Vitae</th>
                    </thead>
                    <tbody>
                        <?php foreach ($postulationsHistory as $postulation) { ?>
                            <tr>
                                <td><?php echo $postulation['idjob_postulations']; ?></td>
                                <td><?php echo $postulation['studentId']; ?></td>
                                <?php foreach($studentsList as $student) {
                                    if($student['studentId'] == $postulation['studentId']) { ?>
                                        <td><?php echo $student['firstName']; ?></td>
                                        <td><?php echo $student['lastName']; ?></td>
                                    <?php }
                                } ?>                                
                                <td><?php echo $postulation['comment']; ?></td>
                                <td><a href="<?php echo FRONT_ROOT ?>Uploads/<?php echo $postulation['cvarchive']; ?>" target="_blank"><?php echo $postulation['cvarchive']; ?></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <a class="btn btn-secondary mt-0" href="<?php echo FRONT_ROOT ?>JobOffer/ShowListView">Regresar</a>
        </div>
    </section>
</main>