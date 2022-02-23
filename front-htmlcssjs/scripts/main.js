$(document).ready(function(){  
  getAllUsers();

  $('form#users-form').submit(function(e){
    e.preventDefault();

    let data = {};

    for(let i=0;i< e.target.length;i++){
      data[e.target[i].id] = e.target[i].value;
    }

    if(data.id){
      updateUser(data);
    }else {
      addUser(data);
    }
    toggleModal();
  });

  $('button#b-search').click(function(){
    let name = $('input#search').val();
    $('input#search').val('');
    getUserByName(name);
  });
  $('button#open-modal').click(function(){
    toggleModal();
    resetForm();
  });
  $('button#close-modal').click(function(){
    toggleModal();
    resetForm();
  });
  $('button#b-submit').click(function(){
    $('form#users-form').submit();
  });

  $('input#cep').inputmask({"mask": "99999-999"});
});
