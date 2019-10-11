$(function(){
  $('.adminlogoutbtn').on('click',function(){
    xml = new XMLHttpRequest();
    xml.open('POST','logoutadmin.php');
    xml.send();
  })
  $('html').on('click','.btn-admin-okg',function(){
      idgroup = $(this).data('gid');
      xml = new XMLHttpRequest();
      xml.onreadystatechange  = function(){
        if(xml.readyState == 4 && xml.status == 200){
            $('.container-new-group-admin').html(xml.responseText);
        }
      }
      xml.open('POST','ajaxgroupok.php?status=1&idg='+idgroup);
      xml.send();
  })
  $('html').on('click','.btn-admin-deleteg',function(){
    idgroup = $(this).data('gid');
    xml = new XMLHttpRequest();
    xml.onreadystatechange  = function(){
      if(xml.readyState == 4 && xml.status == 200){
          $('.container-new-group-admin').html(xml.responseText);
      }
    }
    xml.open('POST','ajaxgroupok.php?status=2&idg='+idgroup);
    xml.send();
  })
})