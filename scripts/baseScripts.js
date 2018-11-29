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
  var buttons;
  var n = 1;
  while(n <= amount)
  {
    choose = document.getElementById("chosen_detail_" + n);
<<<<<<< HEAD
    if(choose != null)
    {
      if(toSwap == n)
        choose.style.visibility = "visible";
      else
        choose.style.visibility = "hidden";
    }
    buttons = document.getElementsByClassName("to_swap");
    if(buttons != null)
    {
      if(toSwap == n)
        buttons[n - 1].style.backgroundColor = "rgb(77, 226, 226)";
      else
        buttons[n - 1].style.backgroundColor = "rgba(172, 172, 172, 0.11)";
    }
=======
    if(toSwap == n)
      choose.style.display = "block";
    else
      choose.style.display = "none";
>>>>>>> a39730d087d4c2724ab0ab3866b255d11e8fd788
    n++;
  }
}