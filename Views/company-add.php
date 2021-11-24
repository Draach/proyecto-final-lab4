<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container text-white">
               <h2 class="mb-4">Agregar Empresa</h2>
               <form action="<?php echo FRONT_ROOT ?>Company/Add" method="post" class="bg-light-alpha p-5">
                    <div class="row">
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Nombre</label>
                                   <input type="text" name="name" value="" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Email</label>
                                   <input type="email" name="email" value="" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Teléfono</label>
                                   <input type="text" name="phone" value="" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Dirección</label>
                                   <input type="text" name="address" value="" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Cuit</label>
                                   <input type="text" name="cuit" value="<?php if (isset($dni)) {
                                                                                echo $dni;
                                                                           } ?>" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Sitio Web</label>
                                   <input type="text" name="website" value="" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Fundación</label>
                                   <input type="date" name="founded" value="" class="form-control" required>
                              </div>
                         </div>
                    </div>
                    <a class="btn btn-secondary" href="<?php echo FRONT_ROOT ?>Admin/ShowDashboard">Regresar</a>
                    <button type="submit" class="btn btn-yellow">Agregar</button>
               </form>
          </div>
     </section>
</main>