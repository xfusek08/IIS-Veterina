<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/OwnerBrowseViewModel.php");

  $actVM = SessionControl::pageInitRoutine("OwnerBrowseViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <link rel="stylesheet" type="text/css" href="Styles/browStyles.css">
  </head>
  <body>
    <?php include 'menu.php';?>
    <div class="content">
      <h1>Seznam majitelů</h1>
      <form action="" method="get">
        <input type="text" value="" placeHolder="Vyhledat..." name="search">
        <input type="submit" name="searchButton" class="searchButton">
      </form>
      <table>
        <thead>
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
            <td><?= $owner->Adress ?></td>
            <td><?= $owner->Telefon ?></td>
            <td><?= $owner->Sex ?></td>
            <td><?= $owner->IsActive ?></td>
          </tr>
        <?php } ?>
        <tr><th class="table_add table_select" colspan="6">Přidat vlastníka</th></tr>
        </tbody>
      </table>
      </div>
  </body>
</html>
