$(function(){
    $('body').on('click','.btnAddFriend',function(){
        xml = new XMLHttpRequest();
        var idprofile = $(this).data('id');
        console.log(idprofile);
        xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status == 200){
               $('.add-friend').html(xml.responseText);
            }
        
        }
        xml.open('POST','friends-ajax.php?idProfile='+idprofile+'');
        xml.send();
    })
});