<?php function BuildMenu($isAdmin) {?>
  <div class="menu">
    <ul class="menu_table">
      <li class="menu_choice"><a href="animalBrowse.view.php">Zvířata</a></li>
      <li class="menu_choice"><a href="ownerBrowse.view.php">Majitelé</a></li>
      <li class="menu_choice"><a href="medicamentBrowse.view.php">Léky</a></li>    
      <?php if($isAdmin) { ?>
        <li class="menu_choice"><a href="employeeBrowse.view.php">Zaměstnanci</a></li>
      <?php } ?>
      <li class="menu_choice"><a href="optionsDetail.view.php">Nastavení</a></li>
    </ul>
  </div>
<?php } ?>