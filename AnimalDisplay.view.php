<?php
  ini_set("default_charset", "utf-8");

  function BuildAnimalViewDiv(TreatmentDisplayViewModel $actVM) {
    if ($actVM == null || !is_a($actVM, "TreatmentAnimalViewModel"))
      return;
?>

<div class="animalView">
  <table>
    <thead>
      <th>Jméno</th>
      <th>Druh</th>
      <th>Pohlaví</th>
      <th>Termín vyšetření</th>
      <th>Počet aktivních léčeb</th>
    </thead>
    <tbody>
    <tr style="color: gray"><th class="table_part" colspan="4">S plánovaným vyšetřením</th><th class="table_part">Naplánované vyšetření</th><th class="table_part"></tr>
    <?php foreach ($actVM->AnimalsPlanned as $actAnimal) { ?>
      <tr class="table_select" onclick="changePage(<?= $actAnimal->Pk ?>, 'animalDetail.view.php')">
        <td><?= $actAnimal->AnimalName ?></td>
        <td><?= $actAnimal->Species ?></td>
        <td><?= $actAnimal->Sex ?></td>
        <td><?= $actAnimal->LatestExamination ?></td>
        <td><?= $actAnimal->TreatmentNumber ?></td>
      </tr>
    <?php } ?>
    <tr style="color: gray"><th class="table_part" colspan="4">Bez plánovaného vyšetření</th><th class="table_part">Poslední vyšetření</th><th class="table_part"></tr>
    <?php foreach ($actVM->AnimalsNotPlanned as $actAnimal ) { ?>
      <tr class="table_select" onclick="changePage(<?= $actAnimal->Pk ?>, 'animalDetail.view.php')">
        <td><?= $actAnimal->AnimalName ?></td>
        <td><?= $actAnimal->Species ?></td>
        <td><?= $actAnimal->Sex ?></td>
        <td><?= $actAnimal->LatestExamination ?></td>
        <td><?= $actAnimal->TreatmentNumber ?></td>
      </tr>
      <tr><th class="table_add table_select" colspan="5">Přidat zvíře</th></tr>
    <?php } ?>
    </tbody>
  </table>
</div>
<?php
}