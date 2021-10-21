<?php

if ($_SESSION["loggedUser"]['role'] != "admin" && $_SESSION["loggedUser"]["role"] != "student") {
    require_once(VIEWS_PATH . "index.php");
} else {
    if ($_SESSION["loggedUser"]["role"] == "admin") {
        require_once(VIEWS_PATH . "nav.php");
    }
?>
    <main class="py-5">
        <section id="listado" class="mb-5">
            <div class="container">
                <h2 class="mb-4">Listado de Empresas</h2>
                <table class="table bg-light-alpha">
                    <thead>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Cuit</th>
                        <th>Sitio Web</th>
                        <th>Fundación</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($companiesList as $company) {
                            if ($company->getStatus() == true) {
                        ?>
                                <tr>
                                    <td><?php echo $company->getCompanyId() ?></td>
                                    <td><?php echo $company->getName() ?></td>
                                    <td><?php echo $company->getEmail() ?></td>
                                    <td><?php echo $company->getPhone() ?></td>
                                    <td><?php echo $company->getAddress() ?></td>
                                    <td><?php echo $company->getCuit() ?></td>
                                    <td><?php echo $company->getWebsite() ?></td>
                                    <td><?php echo $company->getFounded() ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                        </tr>
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
<?php
}
?>