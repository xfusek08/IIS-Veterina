<?php
  require_once("viewModels/TreatmentOnAnimalViewModel.php");

  ini_set("default_charset", "utf-8");

  function BuildTreatmentsOnAnimalView(TreatmentOnAnimalViewModel $actVM) {
    if ($actVM == null || !is_a($actVM, "TreatmentOnAnimalViewModel"))
      return;
?>
<div class="treatmentView">
<<<<<<< HEAD
  <h2><?= $actVM->Caption ?>-<?= $actVM->State ?></h2>
  <div>
    <div class="left">
      <div class="prognosis">Prognóza</div>
      <textarea readonly><?= $actVM->Prognosis ?></textarea>
      <p>Předepsané léky</p>
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
    </div>
    <div class="right">
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
  </div>
=======
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
          <td><a href="?pk=<?= $actExam->ExaPk ?>"><?= $actExam->Date ?></td>
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
>>>>>>> a39730d087d4c2724ab0ab3866b255d11e8fd788
</div>
<?php
}