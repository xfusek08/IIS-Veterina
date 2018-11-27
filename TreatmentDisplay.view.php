<?php
  ini_set("default_charset", "utf-8");

  function BuildTreatmentViewDiv(TreatmentDisplayViewModel $actVM) {
    if ($actVM == null || !is_a($actVM, "TreatmentDisplayViewModel"))
      return;
?>
<div class="treatmentView">
  <h1><?= $actVM->Treatment->getColumnStringValue('tre_caption') . ' - ' . $actVM->Treatment->getColumnStringValue('tre_state_text'); ?></h1>
  <h2>Prognóza</h2><hr/>
  <textarea readonly><?= $actVM->Treatment->getColumnStringValue('tre_prognosis') ?></textarea>
  <h2>Předepsané léky</h2><hr/>
  <table>
    <thead>
      <th>Název</th>
      <th>Délka užívání</th>
      <th>Dávkování</th>
    </thead>
    <tbody>
      <?php while(($actEnt = $actVM->MedicamentsBrowser->getNext()) != null) { ?>
      <tr>
        <td><a href="?pk=<?= $actEnt->getColumnStringValue('medicament_pk') ?>">
          <?= $actEnt->getColumnStringValue('med_name') ?>
        </a></td>
        <td><?= $actEnt->getColumnStringValue('mot_usage_time') ?></td>
        <td><?= $actEnt->getColumnStringValue('mot_dosage') ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <h2>Spjatá vyšetření</h2><hr/>
  <div style="margin-left: 30px; margin-right: 30px;">
    <?php while(($actEnt = $actVM->ExaminationsBrowser->getNext()) != null) { ?>
      <div class="examination">
        <div class="header">
          <?= $actEnt->getColumnStringValue('exa_begin_date_time') ?>
          <?= $actEnt->getColumnStringValue('exa_text') ?>
          <?php
            $occured = $actEnt->getColumnByName('exa_occurred')->getValue();
            if ($actEnt->getColumnByName('exa_begin_date_time')->getValue() > strtotime('00:00:00'))
              echo ($occured) ? "proběhlo" : "plánované";
            else
              echo ($occured) ? "proběhlo" : "neproběhlo";
          ?>
        </div>
        <textarea readonly><?= $actEnt->getColumnStringValue('toe_ongoing_diagnosis') ?></textarea>
      </div>
      <hr/>
    <?php } ?>
  </div>
</div>
<?php
}