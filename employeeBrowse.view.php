<?php
  ini_set("default_charset", "utf-8");

  require_once("lib/SessionControl.php");
  require_once("viewModels/EmployeeBrowseViewModel.php");

  $actVM = SessionControl::pageInitRoutine("EmployeeBrowseViewModel");
?>

<html lang="cz">
  <head>
    <?php require_once("baseHeader.php");?>
    <link rel="stylesheet" type="text/css" href="Styles/browStyles.css">
  </head>
  <body>
    <?php include 'menu.php';?>
    <div class="content">
      <h1>Seznam zaměstnanců</h1>
      <form action="" method="get">
        <input type="text" value="<?= $actVM->SearchString ?>" placeHolder="Vyhledat..." name="search">
        <input value="Vyhledat" type="submit" name="searchButton" class="searchButton">
      </form>
      <table>
        <thead class="bor_bot">
          <th>Jméno</th>
          <th>Příjmení</th>
          <th>Adresa</th>
          <th>Telefon</th>
          <th>Pohlaví</th>
          <th>Pozice</th>
        </thead>
        <tbody>
        <?php foreach($actVM->Employees as $employee) { ?>
          <tr class="table_select" onclick="changePage(<?= $employee->Pk ?>, 'employeeDetail.view.php')">
            <td><?= $employee->Name ?></td>
            <td><?= $employee->Surname ?></td>
            <td><?= $employee->Address ?></td>
            <td><?= $employee->Telephone ?></td>
            <td><?= $employee->Sex ?></td>
            <td><?= $employee->Position ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </body>
</html>
