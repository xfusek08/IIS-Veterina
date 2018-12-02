<?php
  require_once("viewModels/TreatmentOnAnimalViewModel.php");

  ini_set("default_charset", "utf-8");

  function BuildTreatmentsOnAnimalView(TreatmentOnAnimalViewModel $actVM) {
    if ($actVM == null || !is_a($actVM, "TreatmentOnAnimalViewModel"))
      return;
?>
<div class="treatmentView">
  <h2><?= $actVM->Caption ?>-<?= $actVM->State ?></h2>
  <div class="prognosis">Prognóza</div>
  <textarea readonly><?= $actVM->Prognosis ?></textarea>
  <div class="flex">
    <div class="flexPart">
      <p>Spjatá vyšetření</p>
      <table>
        <thead>
          <th>Datum</th>
          <th>Typ</th>
          <th>Hodina</th>
          <th>Proběhlo</th>
        </thead>
        <tbody>
          <?php foreach ($actVM->Examinations as $actExam) { ?>
            <tr class="table_select" onclick="changePage(<?= $actExam->ExaPk ?>, 'examinationDetail.view.php')">
              <td><a href="?pk=<?= $actExam->Pk ?>"><?= $actExam->Date ?></td>
              <td><?= $actExam->Type ?></td>
              <td><?= $actExam->Hour ?></td>
              <td><?= $actExam->Ocurred ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="flexPart">
    <p>Diagnózy</p>
      <table>
        <thead>
          <th>Datum</th>
          <th>Průběžná diagnóza</th>
        </thead>
        <tbody>
          <?php foreach ($actVM->Examinations as $actExam) { ?>
            <tr class="table_select" onclick="changePage(<?= $actExam->ExaPk ?>, 'examinationDetail.view.php')">
            <?php if ($actExam->Ocurred == 'A') { ?>
              <td><a href="?pk=<?= $actExam->Pk ?>"><?= $actExam->Date ?></td>
              <td class="smallPad"><textarea readonly><?= $actExam->Diagnosis ?></textarea></td>
            </tr>
            <?php } ?>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="flexPart">
      <p>Předepsané léky</p>
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
</div>
<?php
}