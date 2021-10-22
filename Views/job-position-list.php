    <main class="py-5">
        <section id="listado" class="mb-5">
            <div class="container">
                <h2 class="mb-4">Listado de Propuestas Laborales</h2>
                <table class="table bg-light-alpha">
                    <thead>
                        <th>ID</th>
                        <th>Carrera</th>
                        <th>Descripción</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($jobPositionsList as $jobPosition) {
                        ?>
                            <tr>
                                <td><?php echo $jobPosition['jobPositionId'] ?></td>
                                <td><?php
                                    foreach ($careersList as $career) {
                                        if ($jobPosition['careerId'] == $career['careerId']) {
                                            echo $career['description'];
                                            break;
                                        }
                                    }
                                    ?></td>
                                <td><?php echo $jobPosition['description'] ?></td>
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