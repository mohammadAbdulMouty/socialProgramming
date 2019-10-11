$(function(){
    $('.album-photos li img').on('click',function(){
        $('.img-overlay img').attr('src',$(this).attr('src'));
        $('.img-overlay').show();
    })
    $('.close-overlay').on('click',function(){
        $('.img-overlay').hide();
    })
});