function changePage(spk, url)
{
  $(location).attr('href', url +"?pk=" + spk);
}

function changeToNew(spk, owner, url)
{
  $(location).attr('href', url +"?pk=" + spk + "&" + owner);
}

function swapTables(toSwap, amount)
{
  var choose;
  var n = 1;
  while(n <= amount)
  {
    choose = document.getElementById("chosen_detail_" + n);
    if(toSwap == n)
      choose.style.visibility = "visible";
    else
      choose.style.visibility = "hidden";
    n++;
  }
}