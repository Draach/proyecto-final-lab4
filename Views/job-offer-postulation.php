<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container text-white">
               <h2 class="mb-4">Postulacion</h2>
               <div class="container">
                    <div class="row">
                         <div class="col-sm">
                              <label for="">Empresa:</label>
                              <p><?php 
                              echo $jobOffer->getCompany()->getName();
                                    ?></p>
                         </div>
                         <div class="col-sm">
                              <label for="">Posición:</label>
                              <p><?php echo $jobOffer->getJobPosition()->getDescription(); ?></p>
                         </div>
                         <div class="col-sm">
                              <label for="">Descripción:</label>
                              <p><?php echo $jobOffer->getTitle(); ?></p>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-sm">
                              <label for="">Fecha de Creación:</label>
                              <p><?php echo $jobOffer->getCreatedAt(); ?></p>
                         </div>
                         <div class="col-sm">
                              <label for="">Fecha de Expiración:</label>
                              <p><?php echo $jobOffer->getExpirationDate(); ?></p>
                         </div>
                         <div class="col-sm">
                              <label for="">Salario:</label>
                              <p><?php echo $jobOffer->getSalary(); ?></p>
                         </div>
                    </div>
               </div>
               <form action="<?php echo FRONT_ROOT ?>JobPostulation/Add" method="post" enctype="multipart/form-data" class="bg-light-alpha p-5">
                    <input type="hidden" name="jobOfferId" value="<?php echo $jobOffer->getJobOfferId(); ?>">
                    <input type="hidden" name="studentId" value="<?php echo $_SESSION['loggedUser']->getStudentId(); ?>">
                    <div class="row">
                         <div class="col-lg">
                              <div class="form-group">
                                   <label for="">Comentario</label>
                                   <textarea name="comment" value="" class="form-control" rows="6"></textarea>
                              </div>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Currículum <sub>(Formato PDF)</sub></label>
                                   <input type="file" name="cvarchive" value="" class="form-control">
                              </div>
                         </div>
                    </div>
                    <a class="btn btn-secondary" href="<?php echo FRONT_ROOT ?>Student/ShowDashboard">Regresar</a>
                    <button type="submit" class="btn btn-yellow">Postularse</button>
               </form>
          </div>
     </section>
</main>