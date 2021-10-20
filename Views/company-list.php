<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Listado de Empresas</h2>
            <table class="table bg-light-alpha">
                <thead>
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
                    ?>
                        <tr>
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
                    ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>