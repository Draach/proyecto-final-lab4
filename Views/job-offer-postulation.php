<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Postulacion</h2>
               <div>
                   <?php echo var_dump($jobOffer); ?>
               </div>
               <form action="<?php echo FRONT_ROOT ?>JobPostulation/Add" method="post" enctype = "multipart/form-data" class="bg-light-alpha p-5">
               <input type="hidden" name="jobOfferId" value="<?php echo $jobOffer->getJobOfferId(); ?>">
               <input type="hidden" name="studentId" value="<?php echo $_SESSION['loggedUser']->getStudentId(); ?>">
                    <div class="row">
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Comentario</label>
                                   <input type="text" name="comment" value="" class="form-control">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">CV</label>
                                   <input type="file" name="cvarchive" value="" class="form-control">
                              </div>
                        </div>
                    </div>
                    <a class="btn btn-secondary" href="<?php echo FRONT_ROOT ?>Student/ShowDashboard">Regresar</a>
                    <button type="submit" class="btn btn-dark">Postularse</button>
               </form>
          </div>
     </section>
</main>