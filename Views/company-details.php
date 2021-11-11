<?php

use Utils\CustomSessionHandler as CustomSessionhandler;

$sessionHandler = new CustomSessionhandler();
?>
<div class='details'>
  <div class='details-card shadow'>
    <div class='details-header-card'>
      <!--
      <?php if ($sessionHandler->isAdmin()) {
      ?>
        <a href="<?php echo FRONT_ROOT ?>Company/ShowModifyView/<?php echo $company->getCompanyId(); ?>">Modificar</a>
        <a href="<?php echo FRONT_ROOT ?>Company/RemoveCompany/<?php echo $company->getCompanyId(); ?>">Eliminar</a>

      <?php
      }
      ?>
      -->
      <h1><?php echo $company->getName(); ?></h1>
      <hr>
    </div>
    <div class='details-content-card'>
      <div class='content-left'>
        <img src='<?php echo FRONT_ROOT ?>Views/img/placeholder.png'>
      </div>
      <div class='content-right'>
        <ul className="ul-education fa-ul" style="list-style:none">
          <li>
            <p className="item-desc">
              Correo: <?php echo $company->getEmail(); ?>
            </p>
          </li>
          <li>
            <p className="item-desc">
              Teléfono: <?php echo $company->getPhone(); ?>
            </p>
          </li>
          <li>
            <p className="item-desc">
              Dirección: <?php echo $company->getAddress(); ?>
            </p>
          </li>
          <li>
            <p className="item-desc">
              Cuit: <?php echo $company->getCuit(); ?>
            </p>
          </li>
          <li>
            <p className="item-desc">
              Sitio Web: <a href="<?php echo $company->getWebsite(); ?>"><?php echo $company->getWebsite(); ?></a>
            </p>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <a class="btn btn-secondary my-2" href="<?php echo FRONT_ROOT ?>Company/ShowListView">Regresar</a>
</div>