function changePage(spk, url)
{
  $(location).attr('href', url +"?pk=" + spk);
}

function swapTables(toSwap)
{
  var choose;
  if(toSwap == 1)
  {
    choose = document.getElementById("chosen_detail_1");
    choose.style.visibility = "visible";
    choose = document.getElementById("chosen_detail_2");
    choose.style.visibility = "hidden";
  }
  else
  {
    choose = document.getElementById("chosen_detail_2");
    choose.style.visibility = "visible";
    choose = document.getElementById("chosen_detail_1");
    choose.style.visibility = "hidden";
  }
}