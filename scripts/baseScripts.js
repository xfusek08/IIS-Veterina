function changePage(spk, url)
{
  $(location).attr('href', url +"?pk=" + spk);
}

function swapTables(toSwap)
{
  console.log(toSwap);
}

function ageLoad(totalAge)
{
  var today = new Date();
  var yy = parseInt(today.getFullYear());
  var mm = parseInt(today.getMonth()+1);

  var y = parseInt(totalAge.substring(6, 10));
  var m = parseInt(totalAge.substring(2, 5));

  var month = mm - m;
  if(month < 0)
    y++;

  var res = yy - y;

  var age = document.getElementById("ani_age");
  age.innerHTML = " (Věk:" + res + ")";
}