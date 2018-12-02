
var template;
$(document).ready(function() {
  template = $('.medForSpecEditForm.template').clone();
  template.removeClass('template');
  template.find("input[type=hidden], input[type=text], select").each(function() {
    if ($(this).attr('type') !== 'hidden')
      $(this).val("");
  });

  $('body').on('click', '.medForSpecEditForm input[name=delete]', function() {
    deleteRow($(this).closest('.medForSpecEditForm'));
  });

});

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
  var newRow = template.clone();
  var cntInput = $('input[name="medCount"]');
  var count = parseInt(cntInput.val());
  newRow.find("input[name=mfs_pk]").val(0);
  cntInput.val(count + 1);
  newRow.appendTo("#appendTo");
  recalculatePrefixes();
}

function deleteRow(row) {
  if (row.length > 0) {
    row.remove();
    var cntInput = $('input[name="medCount"]');
    var count = parseInt(cntInput.val());
    cntInput.val(count - 1);
    recalculatePrefixes();
  }
}

function recalculatePrefixes() {
  var rows = $("#appendTo tr")
  var cnt = 0;
  rows.each(function() {
    var inputList = template.find('input[type=hidden], input[type=text], select');
    var inputIndex = 0;
    $(this).find("input[type=hidden], input[type=text], select").each(function() {
      var name = '';
      if (cnt > 0)
        name = cnt + '_';
      name += inputList.eq(inputIndex).attr('name');
      $(this).attr('name', name);
      inputIndex++;
    });
    cnt++;
  });
}
