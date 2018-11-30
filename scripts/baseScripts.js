function changePage(spk, url)
{
  $(location).attr('href', url +"?pk=" + spk);
}

function changeToNewAni(owner, url)
{
  $(location).attr('href', url +"?pk=0" + "&ownerpk=" + owner);
}

function swapTables(toSwap, amount)
{
  var choose;
  var buttons;
  var n = 1;
  while(n <= amount)
  {
    choose = document.getElementById("chosen_detail_" + n);
    if(choose != null)
    {
      if(toSwap == n)
      {
        choose.style.visibility = "visible";
        choose.style.display = "block";
      }
      else
      {
        choose.style.visibility = "hidden";
        choose.style.display = "none";
      }
    }
    buttons = document.getElementsByClassName("to_swap");
    if(buttons != null)
    {
      if(toSwap == n)
        buttons[n - 1].style.backgroundColor = "rgb(77, 226, 226)";
      else
        buttons[n - 1].style.backgroundColor = "rgba(172, 172, 172, 0.11)";
    }
    n++;
  }
}

function addRow(res)
  {
    var template = $('#MedForSpecEditFormTemp');
    var newRow = template.clone();
    newRow.find("input[type=hiden], input[type=text], select").each(function(i,box)
    {
      if(box.attr('name') == "mfs_spepk")
        box.attr('name', res + "mfs_spepk")
      else if(box.attr('name') == "mfs_recommended_dosis")
        box.attr('name', res + "mfs_recommended_dosis")
      else if(box.attr('name') == "mfs_effective_against")
        box.attr('name', res + "mfs_effective_against")
      else if(box.attr('name') == "mfs_pk")
      {
        box.attr('name', res + "mfs_pk")
        box.attr('value', 0)
      }
    },    
    newRow.appendTo("#appendTo");
  }