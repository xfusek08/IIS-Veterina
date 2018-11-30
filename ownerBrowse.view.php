<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/OwnerBrowseViewModel.php");
  require_once('menu.php');

  $actVM = SessionControl::pageInitRoutine("OwnerBrowseViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <link rel="stylesheet" type="text/css" href="Styles/browStyles.css">
    <script src="scripts/jQuery.js"></script>
    <script src="scripts/baseScripts.js"></script>
  </head>
  <body>
    <?php BuildMenu(SessionControl::isAdmin()) ?>
    <div class="preContent">
      <div class="content">
        <h1>Seznam majitelů</h1>
        <form action="" method="get">
          <input type="text" value="<?= $actVM->SearchString ?>" placeHolder="Vyhledat..." name="search">
          <input value="Vyhledat" type="submit" name="searchButton" class="searchButton">
        </form>
        <table>
          <thead class="bor_bot">
            <th>Jméno</th>
            <th>Příjmení</th>
            <th>Adresa</th>
            <th>Telefon</th>
            <th>Pohlaví</th>
            <th>Stav</th>
          </thead>
          <tbody>
          <?php foreach($actVM->Owners as $owner) { ?>
            <tr class="table_select" onclick="changePage(<?= $owner->Pk ?>, 'ownerDetail.view.php')">
              <td><?= $owner->Name ?></td>
              <td><?= $owner->Surname ?></td>
              <td><?= $owner->Address ?></td>
              <td><?= $owner->Telephone ?></td>
              <td><?= $owner->Sex ?></td>
              <td><?= $owner->IsActive ?></td>
            </tr>
          <?php } ?>
          <tr onclick="changePage(0, 'ownerEdit.view.php')"><th class="table_add table_select" colspan="6">Přidat majitele</th></tr>
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
