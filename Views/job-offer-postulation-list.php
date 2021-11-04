<?php
use Utils\CustomSessionHandler as CustomSessionhandler;

$sessionHandler = new CustomSessionhandler();
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
        <div class="col-8">
            <h2>Listado de Postulaciones</h2>
                </div>
                <div class="container">
                    <div class="row">
                         <div class="col-sm">
                              <label for="">Empresa:</label>
                              <p><?php $postulationsHistory['']?></p>
                         </div>
                         <div class="col-sm">
                              <label for="">Posición:</label>
                              <p><?php foreach ($jobPositionsList as $jobPosition) {
                                        if ($jobPosition['jobPositionId'] == $jobOffer->getJobPositionId()) {
                                             echo $jobPosition['description'];
                                        }
                                   } ?></p>
                         </div>
                         <div class="col-sm">
                              <label for="">Descripción:</label>
                              <p><?php echo $jobOffer->getTitle(); ?></p>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-sm">
                              <label for="">Fecha de Creación:</label>
                              <p><?php echo $jobOffer->getCreatedAt(); ?></p>
                         </div>
                         <div class="col-sm">
                              <label for="">Fecha de Expiración:</label>
                              <p><?php echo $jobOffer->getExpirationDate(); ?></p>
                         </div>
                         <div class="col-sm">
                              <label for="">Salario:</label>
                              <p><?php echo $jobOffer->getSalary(); ?></p>
                         </div>
                    </div>
               </div>
            <div class="table-container overflow-auto">
                <table class="table bg-light-alpha">
                    <thead class='thead-dark'>
                        <?php if ($sessionHandler->isAdmin()) {
                        ?>
                            <th>ID</th>
                        <?php
                        }
                        ?>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($companiesList as $company) {
                            if ($company->getStatus() == true) {
                        ?>
                                <tr>
                                    <?php if ($sessionHandler->isAdmin()) {
                                    ?>
                                        <td><?php echo $company->getCompanyId() ?></td>
                                    <?php
                                    }
                                    ?>
                                    <td><?php echo $company->getName() ?></td>
                                    <td><?php echo $company->getEmail() ?></td>
                                    <td><?php echo $company->getPhone() ?></td>
                                    <td>
                                        <a href="<?php echo FRONT_ROOT ?>Company/ShowDetails/<?php echo $company->getCompanyId(); ?>" class="btn btn-primary">Detalles</a>
                                        <?php if ($sessionHandler->isAdmin()) {
                                        ?>
                                            <a href="<?php echo FRONT_ROOT ?>Company/ShowModifyView/<?php echo $company->getCompanyId(); ?>" class="btn btn-primary">Modificar</a>
                                            <a href="<?php echo FRONT_ROOT ?>Company/RemoveCompany/<?php echo $company->getCompanyId(); ?>" class="btn btn-danger">Eliminar</a>
                                    </td>
                                <?php
                                        }
                                ?>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
    </section>
    <div class='list-nav'>
    <?php
    if ($sessionHandler->isStudent()) {
    ?>
        <a class="btn btn-secondary go-back" href="<?php echo FRONT_ROOT ?>Student/ShowDashboard">Regresar</a>
    <?php
    } else if ($sessionHandler->isAdmin()) {
    ?>
        <a class="btn btn-secondary go-back mr-2" href="<?php echo FRONT_ROOT ?>Admin/ShowDashboard">Regresar</a>
        <a class="btn btn-success" href="<?php echo FRONT_ROOT ?>Company/ShowAddView">Agregar</a>
    <?php
    }
    ?>
    </div>
</main>