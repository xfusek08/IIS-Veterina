<?php
  require_once("viewModels/ExaminationsOnAnimalViewModel.php");

  ini_set("default_charset", "utf-8");

  function BuildExaminationsOnAnimalView(ExaminationsOnAnimalViewModel $actVM) {
    if ($actVM == null || !is_a($actVM, "ExaminationsOnAnimalViewModel"))
      return;
?>
<div class="examinationView">
  <h2>Vyšetření</h2>
  <table>
    <thead>
      <th>Datum</th>
      <th>Hodina</th>
      <th>Typ</th>
      <th>Trvání (min)</th>
      <th>Cena</th>
      <th>Proběhlo</th>
    </thead>
    <tbody>
      <?php foreach ($actVM->$Examinations as $Examination) { ?>
        <tr class="table_select">
          <td><?= $Examination->Date ?></td>
          <td><?= $Examination->Hour ?></td>
          <td><?= $Examination->Type ?></td>
          <td><?= $Examination->Duration ?></td>
          <td><?= $Examination->Price ?></td>
          <td><?= $Examination->Occured ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<?php
}