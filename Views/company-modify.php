<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container text-white">
               <h2 class="mb-4">Modificar Empresa</h2>
               <form action="<?php echo FRONT_ROOT ?>Company/Modify" method="post" class="bg-light-alpha p-5">
                    <div class="row">
                         <input type="hidden" name="id" value="<?php echo $company->getCompanyId(); ?>">
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Nombre</label>
                                   <input type="text" name="companyName" value="<?php echo $company->getName(); ?>" class="form-control">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Email</label>
                                   <input type="email" name="email" value="<?php echo $company->getEmail(); ?>" class="form-control">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Teléfono</label>
                                   <input type="text" name="phone" value="<?php echo $company->getPhone(); ?>" class="form-control">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Dirección</label>
                                   <input type="text" name="address" value="<?php echo $company->getAddress(); ?>" class="form-control">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Cuit</label>
                                   <input type="text" name="cuit" value="<?php echo $company->getCuit(); ?>" class="form-control">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Website</label>
                                   <input type="text" name="website" value="<?php echo $company->getWebsite(); ?>" class="form-control">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Founded</label>
                                   <input type="date" name="founded" value="<?php echo $company->getFounded(); ?>" class="form-control">
                              </div>
                         </div>
                    </div>
                    <a class="btn btn-secondary ml-auto" href="<?php echo FRONT_ROOT ?>Company/ShowListView">Regresar</a>
                    <button type="submit" class="btn btn-yellow">Modificar</button>
               </form>
          </div>
     </section>
</main>