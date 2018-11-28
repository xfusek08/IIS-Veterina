<?php
  ini_set("default_charset", "utf-8");

  function BuildExaminationViewDiv(ExaminationDisplayViewModel $actVM) {
    if ($actVM == null || !is_a($actVM, "ExaminationDisplayViewModel"))
      return;
?>
<div class="examinationView">
  <h2>Vyšetření</h2>
  <table>
    <thead>
      <th>Typ</th>
      <th>Zadal</th>
      <th>Datum</th>
      <th>Trvání</th>
      <th>Cena</th>
      <th>Přidružená léčba</th>
    </thead>
    <tbody>
      <?php foreach ($actVM->$Examinations as $Examination) { ?>
        <tr class="table_select">
          <td><?= $Examination->Type ?></td>
          <td><?= $Examination->Employee ?></td>
          <td><?= $Examination->Date ?></td>
          <td><?= $Examination->Duration ?></td>
          <td><?= $Examination->Report ?></td>
          <td><?= $Examination->Medicament ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<?php
}