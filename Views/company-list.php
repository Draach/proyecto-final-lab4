<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <form action="<?php echo FRONT_ROOT ?>Company/GetByName" method="post" class="form-row">
                <div class="col-8">
                    <h2>Listado de Empresas</h2>
                </div>
                <div class="col">
                    <input class="form-control mr-sm-2" type="search" name="name" placeholder="Search" aria-label="Search">
                </div>
                <div class="col">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </div>
            </form>
            <div class="table-container overflow-auto">
                <table class="table bg-light-alpha">
                    <thead class='thead-dark'>
                        <?php if ($_SESSION["loggedUser"]["role"] == "admin") {
                        ?>
                            <th>ID</th>
                        <?php
                        }
                        ?>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($companiesList as $company) {
                            if ($company->getStatus() == true) {
                        ?>
                                <tr>
                                    <?php if ($_SESSION["loggedUser"]["role"] == "admin") {
                                    ?>
                                        <td><?php echo $company->getCompanyId() ?></td>
                                    <?php
                                    }
                                    ?>
                                    <td><?php echo $company->getName() ?></td>
                                    <td><?php echo $company->getEmail() ?></td>
                                    <td><?php echo $company->getPhone() ?></td>
                                    <td><a href="<?php echo FRONT_ROOT ?>Company/ShowDetails/<?php echo $company->getCompanyId(); ?>" class="btn btn-primary">Ver Detalles</a></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
    </section>
    <?php
    if ($_SESSION['loggedUser']['role'] == "student") {
    ?>
        <a class="btn btn-secondary go-back" href="<?php echo FRONT_ROOT ?>Student/ShowDashboard">Regresar</a>
    <?php
    } else if ($_SESSION['loggedUser']['role'] == "admin") {
    ?>
        <a class="btn btn-secondary go-back" href="<?php echo FRONT_ROOT ?>Admin/ShowDashboard">Regresar</a>
    <?php
    }
    ?>
</main>