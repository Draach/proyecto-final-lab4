<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Eliminar Empresa</h2>
               <form action="<?php echo FRONT_ROOT ?>Company/RemoveCompany" method="post" class="bg-light-alpha p-5">
                    <div class="row">
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">ID Empresa</label>
                                   <input type="number" name="id" value="" class="form-control">
                              </div>
                              <a class="btn btn-secondary ml-auto" href="<?php echo FRONT_ROOT ?>Admin/ShowDashboard">Regresar</a>
                              <button type="submit" class="btn btn-dark">Eliminar</button>
                         </div>
                    </div>
               </form>
          </div>
     </section>
</main>