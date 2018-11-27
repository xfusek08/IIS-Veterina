<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/MedicamentBrowseViewModel.php");

  $actVM = SessionControl::pageInitRoutine("MedicamentBrowseViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <link rel="stylesheet" type="text/css" href="Styles/browStyles.css">
  </head>
  <body>
  <?php include 'menu.php';?>
    <div class="content">
    <h1>Seznam léků</h1>
      <form action="" method="get">
        <input type="text" value="" placeHolder="Vyhledat..." name="search">
        <input type="submit" name="searchButton" class="searchButton">
      </form>
      <table>
        <thead>
          <th>Název</th>
          <th>Typ</th>
          <th>Cena</th>
          <th>Výrobce</th>
        </thead>
        <tbody>
          <?php foreach($actVM->Medicaments as $medicament) { ?>
            <tr class="table_select" onclick="changePage(<?= $medicament->Pk ?>, 'ownerDetail.view.php')">
              <td><?= $medicament->Name ?></td>
              <td><?= $medicament->Type ?></td>
              <td><?= $medicament->Price ?></td>
              <td><?= $medicament->Company ?></td>
            </tr>
          <?php } ?>
          <tr><th class="table_add table_select" colspan="4">Přidat lék</th></tr>
        </tbody>
      </table>
    </div>
  </body>
</html>
