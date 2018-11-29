<?php
  require_once("viewModels/TreatmentOnAnimalViewModel.php");

  ini_set("default_charset", "utf-8");

  function BuildTreatmentsOnAnimalView(TreatmentOnAnimalViewModel $actVM) {
    if ($actVM == null || !is_a($actVM, "TreatmentOnAnimalViewModel"))
      return;
?>
<div class="treatmentView">
  <span><?= $actVM->Caption ?> </span>
  <span><?= $actVM->State ?></span>
  <div>Prognóza</div>
  <textarea readonly><?= $actVM->Prognosis ?></textarea>
  <div>Předepsané léky</div>
  <table>
    <thead>
      <th>Název</th>
      <th>Délka užívání</th>
      <th>Dávkování</th>
    </thead>
    <tbody>
      <?php foreach ($actVM->Medicaments as $actMed) { ?>
        <tr>
          <td><a href="?pk=<?= $actMed->MedPk ?>"><?= $actMed->Name ?></a></td>
          <td><?= $actMed->UsageTime ?></td>
          <td><?= $actMed->Dosage ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <div>Spjatá vyšetření</div>
  <table>
    <thead>
      <th>Datum</th>
      <th>Typ</th>
      <th>Hodina</th>
      <th>Proběhlo</th>
    </thead>
    <tbody>
      <?php foreach ($actVM->Examinations as $actExam) { ?>
        <tr>
          <td><a href="?pk=<?= $actExam->Pk ?>"><?= $actExam->Date ?></td>
          <td><?= $actExam->Type ?></td>
          <td><?= $actExam->Hour ?></td>
          <td><?= $actExam->Ocurred ?></td>
        </tr>
        <?php if ($actExam->Ocurred == 'A') { ?>
        <tr>
          <td>Průběžná diagnóza:</td>
          <td colspan="3">
            <textarea readonly><?= $actExam->Diagnosis ?></textarea>
          </td>
        </tr>
        <?php } ?>
      <?php } ?>
    </tbody>
  </table>
</div>
<?php
}