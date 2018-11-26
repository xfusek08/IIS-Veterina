function changePage(spk, url)
{
  $(location).attr('href', url +"?pk=" + spk);
}