<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Estado Académico</h2>
            <table class="table bg-light-alpha">
                <thead>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>DNI</th>
                    <th>Legajo</th>
                    <th>Género</th>
                    <th>Nacimiento</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $student->getFirstName() ?></td>
                        <td><?php echo $student->getLastName() ?></td>
                        <td><?php echo $student->getDni(); ?></td>
                        <td><?php echo $student->getFileNumber(); ?></td>
                        <td><?php echo $student->getGender(); ?></td>
                        <td><?php echo $student->getBirthDate(); ?></td>
                        <td><?php echo $student->getEmail(); ?></td>
                        <td><?php echo $student->getPhoneNumber(); ?></td>
                    </tr>
                    </tr>
                </tbody>
            </table>
            <a class="btn btn-secondary mt-0" href="<?php echo FRONT_ROOT ?>Student/ShowDashboard">Regresar</a>
        </div>
    </section>
</main>