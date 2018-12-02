<?php
  require_once("viewModels/TreatmentOnAnimalViewModel.php");

  ini_set("default_charset", "utf-8");

  function BuildTreatmentsOnAnimalView(TreatmentOnAnimalViewModel $actVM) {
    if ($actVM == null || !is_a($actVM, "TreatmentOnAnimalViewModel"))
      return;
?>
<div class="treatmentView">
  <h2><?= $actVM->Caption ?>-<?= $actVM->State ?></h2>
  <h3>Prognóza</h3>
  <textarea readonly><?= $actVM->Prognosis ?></textarea>
  <div>
    <h3>Spjatá vyšetření</h3>
    <table>
      <thead>
        <th>Datum</th>
        <th>Typ</th>
        <th>Hodina</th>
        <th>Proběhlo</th>
        <th>Diagnóza</th>
      </thead>
      <tbody>
        <?php foreach ($actVM->Examinations as $actExam) { ?>
          <tr class="table_select" onclick="changePage(<?= $actExam->ExaPk ?>, 'examinationDetail.view.php')">
            <td><a href="?pk=<?= $actExam->Pk ?>"><?= $actExam->Date ?></td>
            <td><?= $actExam->Type ?></td>
            <td><?= $actExam->Hour ?></td>
            <td><?= $actExam->Ocurred ?></td>
            <td class="smallPad"><textarea readonly><?= $actExam->Diagnosis ?></textarea></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <div>
    <h3>Předepsané léky</h3>
    <table>
      <thead>
        <th>Název</th>
        <th>Délka užívání</th>
        <th>Dávkování</th>
      </thead>
      <tbody>
        <?php foreach ($actVM->Medicaments as $actMed) { ?>
          <tr class="table_select" onclick="changePage(<?= $actMed->MedPk ?>, 'medicamentDetail.view.php')">
            <td><a href="?pk=<?= $actMed->MedPk ?>"><?= $actMed->Name ?></a></td>
            <td><?= $actMed->UsageTime ?></td>
            <td><?= $actMed->Dosage ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?php
}