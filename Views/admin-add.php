<?php 

 if($_SESSION["loggedUser"]['role'] != "admin"){
     require_once(VIEWS_PATH."index.php");
 } else {
     require_once(VIEWS_PATH."nav.php");
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Agregar Admin</h2>
            <form action="<?php echo FRONT_ROOT ?>Admin/Add" method="post" class="bg-light-alpha p-5">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Nombre</label>
                            <input type="text" name="firstName" value="" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Apellido</label>
                            <input type="text" name="lastName" value="" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">DNI</label>
                            <input type="text" name="dni" value="" class="form-control">
                        </div>
                    </div>                                        
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="male">Hombre</option>
                                <option value="female">Mujer</option>
                                <option value="non-binary">No Binarie</option>
                                <option value="no-say" selected="selected">Prefiero no decirlo</option>
                                <option value="none">Ninguna de las anteriores</option>                            
                            </select>                            
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Fecha de Nacimiento</label>
                            <input type="date" name="birthDate" value="" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="email" value="" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" value="" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Teléfono</label>
                            <input type="text" name="phoneNumber" value="" class="form-control">
                        </div>
                    </div>                    
                </div>
                <a class="btn btn-secondary" href="<?php echo FRONT_ROOT ?>Admin/ShowDashboard">Regresar</a>
                <button type="submit" class="btn btn-dark">Agregar</button>
            </form>
        </div>
    </section>
</main>
<?php
 }
 ?>