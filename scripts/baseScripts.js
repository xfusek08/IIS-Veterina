function changePage(spk, url)
{
  $(location).attr('href', url +"?pk=" + spk);
}

function swapTables(toSwap)
{
  var choose = document.getElementById("chosen_detail");
  if(toSwap == 1)
    choose.innerHTML("$actVM->LoadTreatmentsHTML();");
  else
    choose.innerHTML("$actVM->LoadMedicamentsHTML();");
}