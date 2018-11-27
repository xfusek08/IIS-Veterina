function changePage(spk, url)
{
  $(location).attr('href', url +"?pk=" + spk);
}

function swapTables(toSwap)
{
  console.log(toSwap);
}