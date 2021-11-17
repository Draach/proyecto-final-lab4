<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container text-white justify-content-center">
            <h2 class="mb-4">Registrarse</h2>
            <div class="card">
                <form action="<?php echo FRONT_ROOT ?>Auth/Register" method="post" class="bg-light-alpha p-5">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" name="dni" value="" placeholder="DNI o CUIT" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="email" name="email" value="" placeholder="Correo electrónico" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="password" name="password" value="" placeholder="Contraseña" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="password" name="passwordConfirm" value="" placeholder="Confirmar contraseña" class="form-control" required>
                            </div>
                        </div>
                    </div>                         
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="" style="color: black !important;">¿Eres un estudiante o una organización?</label>
                                <select name="roleId" class="form-control">
                                    <?php foreach ($rolesList as $role) { ?>
                                        <option value="<?php echo ucfirst($role->getRoleId()); ?>"><?php echo ucfirst($role->getName()); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>                                  
                    <a class="btn btn-secondary shadow" href="<?php echo FRONT_ROOT ?>Home/Index">Regresar</a>
                    <button type="submit" class="btn btn-yellow shadow">Regístrate</button>
                    <?php
                    if (isset($message)) {                        
                        echo "<p class='text-danger pt-5'>$message</p>";
                    }
                    ?>
                </form>
            </div>
        </div>
    </section>
</main>