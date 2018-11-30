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

function addRow() {
  var template = $('#MedForSpecEditFormTemp');
  var newRow = template.clone();
  var cntInput = $('input[name="medCount"]');
  var count = parseInt(cntInput.val());
  newRow.find("input[type=hidden], input[type=text], select").each(function() {
    var name = $(this).attr('name');
    console.log();
    if ($(this).attr('type') !== 'hidden')
      $(this).val("");
    if (name == 'mfs_pk')
      $(this).val(0);
    $(this).attr('name', count + '_' +name);
  });
  cntInput.val(count + 1);
  newRow.appendTo("#appendTo");
}