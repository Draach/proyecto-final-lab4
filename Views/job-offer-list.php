<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Listado de Propuestas Laborales</h2>
            <table class="table bg-light-alpha">
                <thead>
                    <th>Titulo</th>
                    <th>Creación</th>
                    <th>Expiración</th>
                    <th>Salario</th>
                    <th>Empresa</th>
                    <th>Puesto</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($jobOffersList as $jobOffer) {
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
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
            if ($_SESSION['loggedUser']['role'] == "student") {
            ?>
                <a class="btn btn-secondary" href="<?php echo FRONT_ROOT ?>Student/ShowDashboard">Regresar</a>
            <?php
            } else if ($_SESSION['loggedUser']['role'] == "admin") {
            ?>
                <a class="btn btn-secondary" href="<?php echo FRONT_ROOT ?>Admin/ShowDashboard">Regresar</a>
            <?php
            }
            ?>
        </div>
    </section>
</main>