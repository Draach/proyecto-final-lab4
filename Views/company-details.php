<div class='details'>
  <div class='details-card shadow'>
    <div class='details-header-card'>
      <?php if ($_SESSION["loggedUser"]["role"] == "admin") {
      ?>
        <form>
          <button type="button">Delete</button>
        </form>
      <?php
      }
      ?>
      <h1><?php echo $company->getName(); ?></h1>
      <hr>
    </div>
    <div class='details-content-card'>
      <div class='content-left'>
        <img src='<?php echo FRONT_ROOT ?>Views/img/placeholder.png'>
      </div>
      <div class='content-right'>
        <ul className="ul-education fa-ul">
          <li>
            <p className="item-desc">
              <?php echo $company->getEmail(); ?>
            </p>
          </li>
          <li>
            <p className="item-desc">
              <?php echo $company->getPhone(); ?>
            </p>
          </li>
          <li>
            <p className="item-desc">
              <?php echo $company->getAddress(); ?>
            </p>
          </li>
          <li>
            <p className="item-desc">
              <?php echo $company->getCuit(); ?>
            </p>
          </li>
          <li>
            <p className="item-desc">
              <?php echo $company->getWebsite(); ?>
            </p>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <a class="btn btn-secondary my-2" href="<?php echo FRONT_ROOT ?>Company/ShowListView">Regresar</a>
</div>