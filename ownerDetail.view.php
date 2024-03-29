<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/OwnerDetailViewModel.php");
  require_once('menu.php');

  unset($_GET['edit']);
  $actVM = SessionControl::pageInitRoutine("OwnerDetailViewModel");
  if ($actVM->Pk == 0)
    SessionControl::navigate('ownerBrowse.view.php');
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <link rel="stylesheet" type="text/css" href="Styles/detailStyles.css">
    <script src="scripts/jQuery.js"></script>
    <script src="scripts/baseScripts.js"></script>
  </head>
  <body>
    <?php BuildMenu(SessionControl::isAdmin()) ?>
    <div class="preContent">
      <div class="content">
        <div class="page_buttons">
          <input type="submit" action="" name="submit_del" value="Smazat" class="swap_button" 
          onclick="ConfirmDel('ownerDetail.view.php?pk=<?= $actVM->Pk ?>&delete')">
          <input type="submit" name="submit_edi" value="Upravit" class="swap_button"
          onclick="changePage(<?= $actVM->Pk ?>, 'ownerEdit.view.php')">
        </div>
        <h1>Detail majitele</h1>
        <div class="owner_detail">
          <h3>Jméno: <?= $actVM->Name ?></h3>
          <p>Adresa: <?= $actVM->Address ?></p>
          <p>Pohlaví: <?= $actVM->Sex ?></p>
          <p>Telefonní číslo: <?= $actVM->Number ?></p>
        <div>
          <div class="animalView">
            <h3>Registrovaná zvířata:</h3>
            <table>
              <thead>
                <th>Jméno</th>
                <th>Druh</th>
                <th>Pohlaví</th>
                <th>Počet aktivních léčeb</th>
                <th>Termín posledního/plánovaného vyšetření</th>
              </thead>
              <tbody>
              <?php foreach ($actVM->Animals as $actAnimal) { ?>
                <tr class="table_select" onclick="changePage(<?= $actAnimal->Pk ?>, 'animalDetail.view.php')">
                  <td><?= $actAnimal->AnimalName ?></td>
                  <td><?= $actAnimal->Species ?></td>
                  <td><?= $actAnimal->Sex ?></td>
                  <td><?= $actAnimal->TreatmentNumber ?></td>
                  <td><?= $actAnimal->LatestExamination ?></td>
                </tr>
              <?php } ?>
              <tr onclick="changeToNewAni(<?= $actVM->Pk ?> , 'animalEdit.view.php')" ><th class="table_add table_select" colspan="5">Přidat zvíře</th></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>