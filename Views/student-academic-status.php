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
                        <td><?php echo $_SESSION['loggedUser']['firstName'] ?></td>
                        <td><?php echo $_SESSION['loggedUser']['lastName'] ?></td>
                        <td><?php echo $_SESSION['loggedUser']['dni'] ?></td>
                        <td><?php echo $_SESSION['loggedUser']['fileNumber'] ?></td>
                        <td><?php echo $_SESSION['loggedUser']['gender'] ?></td>
                        <td><?php echo $_SESSION['loggedUser']['birthDate'] ?></td>
                        <td><?php echo $_SESSION['loggedUser']['email'] ?></td>
                        <td><?php echo $_SESSION['loggedUser']['phoneNumber'] ?></td>
                    </tr>
                    </tr>
                </tbody>
            </table>
            <a class="btn btn-secondary mt-0" href="<?php echo FRONT_ROOT ?>Student/ShowDashboard">Regresar</a>
        </div>
    </section>
</main>