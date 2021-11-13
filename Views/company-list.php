<?php

use Utils\CustomSessionHandler as CustomSessionhandler;
$modalOption;

$sessionHandler = new CustomSessionhandler();
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container text-white">
            <form action="<?php echo FRONT_ROOT ?>Company/GetByName" method="post" class="form-row">
                <div class="col-8">
                    <h2 class="text-white">Listado de Empresas</h2>
                </div>
                <div class="col">
                    <input class="form-control mr-sm-2" type="search" name="name" placeholder="Buscar por nombre..." aria-label="Search">
                </div>
                <div class="col">
                    <button class="btn btn-outline-success border-yellow my-2 my-sm-0" type="submit">Buscar</button>
                </div>
            </form>
            <?php if (isset($message)) {
                echo "<div class='alert alert-warning' role='alert'>$message</div>";
            } ?>
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
                                        <a href="<?php echo FRONT_ROOT ?>Company/ShowDetails/<?php echo $company->getCompanyId(); ?>" class="btn btn-yellow shadow">Detalles</a>
                                        <?php if ($sessionHandler->isAdmin()) {
                                        ?>
                                            <a href="<?php echo FRONT_ROOT ?>Company/ShowModifyView/<?php echo $company->getCompanyId(); ?>" class="btn btn-yellow shadow">Modificar</a>
                                            <button type="button" class="btn btn-danger shadow" data-id="<?php echo $company->getCompanyId(); ?>" onclick="confirm(this);">
                                                Eliminar
                                            </button>
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
            <a class="btn btn-yellow" href="<?php echo FRONT_ROOT ?>Company/ShowAddView">Agregar</a>
        <?php
        }
        ?>
    </div>
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
                <p>Estás seguro de que deseas eliminar esta compañia?</p>
                <form method="POST" action="<?php echo FRONT_ROOT ?>Company/RemoveCompany/" id="form-confirm">
                    <input type="hidden" name="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Atras</button>
                <button type="submit" form="form-confirm" class="btn btn-primary">Eliminar</button>
            </div>
        </div>
    </div>
</div>