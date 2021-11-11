<?php

use Utils\CustomSessionHandler as CustomSessionhandler;

$sessionHandler = new CustomSessionhandler();
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container text-white">
            <div class="col-8">
                <h2>Listado de Usuarios</h2>
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
                        <th>Email</th>                       
                        <th>Rol</th>
                        <th>ID Estudiante</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($usersList as $user) {
                            if ($user->getActive() == true) {
                        ?>
                                <tr>
                                    <?php if ($sessionHandler->isAdmin()) {
                                    ?>
                                        <td><?php echo $user->getUserId() ?></td>
                                    <?php
                                    }
                                    ?>                                    
                                    <td><?php echo $user->getEmail() ?></td>
                                    <td><?php echo ucfirst($user->getRoleName()); ?></td>
                                    <td><?php echo $user->getStudentId() ?></td>
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
            <a class="btn btn-yellow" href="<?php echo FRONT_ROOT ?>Admin/ShowAddView">Agregar</a>
        <?php
        }
        ?>
    </div>
</main>