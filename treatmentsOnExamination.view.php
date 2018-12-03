<?php
  ini_set("default_charset", "utf-8");

  require_once("viewModels/TreatmentOnExaminationViewModel.php");

  function BuildTreatmentsOnExaminationView(TreatmentOnExaminationViewModel $actVM) {
    if ($actVM == null || !is_a($actVM, "TreatmentOnExaminationViewModel"))
      return;
?>
<div class="treatmentView">
  <h2><?= $actVM->Caption ?>-<?= $actVM->State ?></h2>
  <h3>Průběžná diagnóza</h3>
  <textarea readonly><?= $actVM->OngoingDiagnosis ?></textarea>
  <h3>Prognóza</h3>
  <textarea readonly><?= $actVM->Prognosis ?></textarea>
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
<?php
}