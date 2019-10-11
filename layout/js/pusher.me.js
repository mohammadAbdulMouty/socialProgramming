$(function(){
    // Enable pusher logging - don't include this in production
     Pusher.logToConsole = true;
 
     var pusher = new Pusher('22fb4c1174b8f33a27d4', {
       encrypted: true
     });
     var channel = pusher.subscribe('my-channel');
     idOn = $('.friend-name.active').data('fid');
     channel.bind('my-event', function(data) {
       idOn =0;
         var to = data.to;
      
         var from =data.from;
        
         idOn = $('.friend-name.active').data('frid');
        
         var idlogin = $('.chat-display').data('idlogin');
         console.log(idlogin);
         $('.noMessage').hide();
         $('.new-message-input').val('');
         console.log(data.message);
         if(from == idlogin){
             console.log('hi');
             $('.message-content-append').append('<div class="content-message"><img src="data/uploads/images/default.jpg" class="img-message-user"><span class="span-you"></span><div class="alert alert-success alert-you">'+data.message+'</div></div>');
             $('.message-content-all').animate({
                 scrollTop:$(".message-content-append")[0].scrollHeight+999999999,
             })
             
         }else if(to == idlogin){
            console.log('hi');
             $('.message-content-append[data-fid='+from+']').append('<div class="content-message content-not-you"><div class="alert alert-info alert-not-you">'+data.message+'</div><img src="data/uploads/images/default.jpg" class="img-message-user"><span class="span-not-you"></span></div><!--end div.content-message-->');
             $('.message-content-all').animate({
                 scrollTop:$(".message-content-append")[0].scrollHeight,
             })
         
       }
     });
 //     var count = channel.members.count;
 //     console.log(count)
 // channel.bind("pusher:subscription_succeeded", function (members) {
 //     $(members).each(function(member) {
         
 //         addMember(member);
 //       });
 //  });
 //  channel.bind("pusher:member_added", function(member){
 //     addMember(member);
 //   });
   
 //   channel.bind("pusher:member_removed", function(member){
 //     removeMember(member)
 //   });
 //   function addMember(member){
     
 //   } 
 //   function removeMember (member) { 
 //     console.log("bye"); 
 //   }
 
 
   });