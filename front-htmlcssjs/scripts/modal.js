function toggleModal(){
  if(!$('div.modal').hasClass('show')){
    $('div.modal').addClass('show');
    $('div.modal').show();
  }else {
    $('div.modal').removeClass('show');
    $('div.modal').toggle();
  }
}