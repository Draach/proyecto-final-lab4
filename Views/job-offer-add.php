<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container text-white">
            <h2 class="mb-4">Agregar Propuesta Laboral</h2>
            <form action="<?php echo FRONT_ROOT ?>JobOffer/Add" method="post" class="bg-light-alpha p-5">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Puesto</label>
                            <select name="jobPositionId" class="form-control">
                                <?php foreach ($jobPositionsList as $jobPosition) { ?>
                                    <option value="<?php echo $jobPosition['jobPositionId']; ?>"><?php echo $jobPosition['description']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Empresa</label>
                            <select name="companyId" class="form-control">
                                <?php foreach ($companiesList as $company) { ?>
                                    <option value="<?php echo $company->getCompanyId(); ?>"><?php echo $company->getName(); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Descripción<sub>(45 Caracteres)</sub></label>
                            <input type="text" name="title" value="" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Salario</label>
                            <input type="number" min="0" name="salary" value="" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Creación</label>
                            <input type="date" name="createdAt" value="<?php echo date('Y-m-d') ?>" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Fecha de Expiración</label>
                            <input type="date" name="expirationDate" value="" class="form-control" required="required">
                        </div>
                    </div>
                </div>
                <a class="btn btn-secondary" href="<?php echo FRONT_ROOT ?>Admin/ShowDashboard">Regresar</a>
                <button type="submit" class="btn btn-yellow">Agregar</button>
            </form>
        </div>
    </section>
</main>