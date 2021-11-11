<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Modificar Propuesta</h2>
               <form action="<?php echo FRONT_ROOT ?>jobOffer/Modify" method="post" class="bg-light-alpha p-5">
                    <div class="row">
                         <input type="hidden" name="jobOfferId" value="<?php echo $jobOffer->getJobOfferId(); ?>">
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Title</label>
                                   <input type="text" name="title" value="<?php echo $jobOffer->getTitle(); ?>" class="form-control">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Fecha de creacion</label>
                                   <input type="text" name="createdAt" value="<?php echo $jobOffer->getCreatedAt(); ?>" class="form-control" readonly>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Fecha de expiracion</label>
                                   <input type="text" name="expirationDate" value="<?php echo $jobOffer->getExpirationDate(); ?>" class="form-control">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Salario</label>
                                   <input type="number" name="salary" value="<?php echo $jobOffer->getSalary(); ?>" class="form-control">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Empresa</label>
                                   <input type="text" name="salary" value="<?php echo $jobOffer->getCompany()->getName(); ?>" class="form-control" readonly>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Puesto</label>
                                   <input type="text" name="salary" value="<?php echo $jobOffer->getJobPosition()->getDescription(); ?>" class="form-control" readonly>
                              </div>
                         </div>
                    </div>
                    <a class="btn btn-secondary ml-auto" href="<?php echo FRONT_ROOT ?>JobOffer/ShowListView">Regresar</a>
                    <button type="submit" class="btn btn-primary">Modificar</button>
               </form>
          </div>
     </section>
</main>