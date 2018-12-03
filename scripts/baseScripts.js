
var template;
$(document).ready(function() {


  $('body').on('click', '.medForSpecEditForm input[name=delete]', function() {
    deleteRow('.medForSpecEditForm.template', 'appendTo', $(this).closest('.medForSpecEditForm'), 'input[name=medCount]');
  });

  $('body').on('click', '#moeStack input[name=delete]', function() {
    deleteRow('#moeTamplate', 'moeStack', $(this).closest('.moerow'), 'input[name=moeCount]');
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

function getTemplatePrepared(templateSelector) {
  var tamplateInstance = $(templateSelector).clone();
  tamplateInstance.removeClass('template');
  tamplateInstance.removeClass('hidden');
  tamplateInstance.find("input[type=hidden], input[type=text], select").each(function() {
    if ($(this).attr('type') !== 'hidden')
      $(this).val("");
  });
  return tamplateInstance;
}

function addRow(templateSelector, toAddID, counterSelector = '', zeroValueSelector = '') {
  var newRow = getTemplatePrepared(templateSelector);
  var cntInput;
  var count;

  if (counterSelector != '') {
    cntInput = $(counterSelector);
    count = parseInt(cntInput.val());
  }

  if (zeroValueSelector != '')
    newRow.find(zeroValueSelector).val(0);

  if (counterSelector != '') {
    cntInput.val(count + 1);
  }
  newRow.appendTo("#" + toAddID);
  recalculatePrefixes(toAddID, templateSelector);
}

function deleteRow(templateSelector, toAddID, row, counterSelector = '') {
  if (row.length > 0) {
    row.remove();
    if (counterSelector != '') {
      var cntInput = $(counterSelector);
      var count = parseInt(cntInput.val());
      cntInput.val(count - 1);
    }
    recalculatePrefixes(toAddID, templateSelector);
  }
}

function recalculatePrefixes(toAddID, templateSelector) {
  var template = getTemplatePrepared(templateSelector);
  var rows = $('#' + toAddID + ' > *');
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

function ConfirmDel(Url)
{
  var res = confirm("Jste si jistí?");
  if (res == true)
  {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("GET", Url, true); // true for asynchronous
    xmlHttp.send(null);
  }
}

function LogOut()
{
  var xmlHttp = new XMLHttpRequest();
  var currentLocation = window.location.href;
  xmlHttp.open("GET", currentLocation + "?logout", true);
  xmlHttp.send(null);
  location.reload();
}