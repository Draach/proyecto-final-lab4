<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">
                Eliminar Admin
            </h2>
            <form action="<?php echo FRONT_ROOT ?>Admin/RemoveAdmin" method="get" class="bg-light-alpha p-5">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">ID Admin</label>
                            <input type="number" name="id" value="" class="form-control">
                        </div>
                        <a class="btn btn-secondary ml-auto" href="<?php echo FRONT_ROOT ?>Admin/ShowDashboard">Regresar</a>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>