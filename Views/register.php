<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container text-white">
            <h2 class="mb-4">Registrarse</h2>
            <div class="card">
            <form action="<?php echo FRONT_ROOT ?>Auth/Register" method="post" class="bg-light-alpha p-5">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="text" name="dni" value="" placeholder="Número de Documento" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="email" name="email" value="" placeholder="Correo electrónico" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="password" name="password" value="" placeholder="Contraseña" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="password" name="passwordConfirm" value="" placeholder="Contraseña" class="form-control" required>
                        </div>
                    </div>
                </div>
                <a class="btn btn-secondary" href="<?php echo FRONT_ROOT ?>Home/Index">Regresar</a>
                <button type="submit" class="btn btn-yellow">Regístrate</button>
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
            </form>
            </div>
        </div>
    </section>
</main>