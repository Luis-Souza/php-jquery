let dataUsersInMemoryLocal;
let uri = 'http://localhost:3000';

// save data in memory local
function setDataUsersInMemoryLocal(data){
  if(!dataUsersInMemoryLocal){
    dataUsersInMemoryLocal = data;
  }else {
    data.forEach(el => {
      let exists = getDataUsersInMemoryExists(el.id);
      if(!exists){
        dataUsersInMemoryLocal = [el, ...dataUsersInMemoryLocal];
      }
    });
  }
}

//verify if element exists in memory, in case true return el.
function getDataUsersInMemoryExists(id){
  return dataUsersInMemoryLocal.find(res => res.id === id);
}

// request all users in bd
function getAllUsers() {
  $.ajax({
    method: "GET",
    url: uri+"/users",
    accept: "*/*",
    contenType: 'Application/json'
  })
  .done(function( result, msg ) {
    if(result.data){
      povTable(result.data);
    }
  })
  .then(function(result){
    if(result.data){
      setDataUsersInMemoryLocal(result.data);
    }
  });
}

// request new user
function addUser(formData){
  if(!formData){
    return;
  }

  $.ajax({
    method: "POST",
    url: uri+"/create",
    accept: "*/*",
    contenType: 'Application/json',
    data: { 
      "name": formData.name, "last_name": formData.last_name, 
      "birth_date": formData.birth_date,
      "email": formData.email, "address": {
        "public_place": formData.public_place, "complement": formData.complement,
        "city": formData.city, "state": formData.state, "number": formData.number,
        "district": formData.district, "cep": formData.cep
      }
    }
  })
  .done(function( result, status ) {
    alert(result.message)
  })
  .fail(function(result,status){
    alert(status);
  })
  .then(function(result,status){
    getAllUsers();
  });
}

// request users by name
function getUserByName(name){
  if(!name){
    alert("Informe um nome de usuário valido!");
    return;
  }

  $.ajax({
    method: "GET",
    accept: "*/*",
    url: uri+"/search/" + name,
  }).done(function(result, status) {
    if(result.data){
      povTable(result.data);
    }else{
      alert(result['message']);
    }
  })
  .then(function(result,status){
    if(result.data){
      alert(result['message']);
      setDataUsersInMemoryLocal(result.data);
    }
  });

}

// request delete user
function deleteUserId(id){
  if(!id){
    return;
  }

  $.ajax({
    method: "DELETE",
    url: uri+"/delete/" + id,
    accept: '*/*'
  }).done(function(result, status){
    getAllUsers();
    alert(status);
  }).fail(function(result, status){
    alert(status);
  });
}

// request update user
function updateUser(formData){
  if(!formData){
    return;
  }

  $.ajax({
    method: "PATCH",
    url: uri+"/update",
    accept: "*/*",
    data: { 
      "id": formData._id,"name": formData.name, "last_name": formData.last_name, 
      "birth_date": formData.birth_date,
      "email": formData.email, "address": {
        "public_place": formData.public_place, "complement": formData.complement,
        "city": formData.city, "state": formData.state, "number": formData.number,
        "district": formData.district, "cep": formData.cep
      }
    }
  })
  .done(function( result, msg ) {
    alert(result['message']);
    getAllUsers();
  })
  .fail((result, status)=>{
    alert(result['message']??status);
  });
}

// prepare table with data of the users
function povTable(data){  
  if(!data){
    return;
  }

  let tbody = $('tbody#tbody').empty(); //clean tbody

  data.map(item => {                                  //generated <tr> with data
    let content = document.createElement('tr');
    content.innerHTML += ` <th>  ${item.id}  </th>
        <td> ${item.name} </td>
        <td> ${item.last_name} </td>
        <td> ${item.email} </td>
        <td> ${item.birth_date} </td>
        <td>
          <a id="${item.id}">excluir</a>
          <a id="${item.id}">editar</a>
        </td>
    `;
    tbody.append(content);
  });

  $('a').click(function(e){       //add functions of the delete and update
    if(e.target.innerText === "excluir"){
      deleteUserId(e.target.id);
    }else if(e.target.innerText === "editar"){
      handleEdit(e.target.id);
    }
  });
}

// prepare update form
function openModalEdition(dataForm){
  if(!dataForm){
    return;
  }
  //generated input[_id] hidden to update action

  let form = $('form#users-form')[0];
  let identFieldEdit = document.createElement('input');

  $(identFieldEdit).attr("id","id");
  $(identFieldEdit).attr("type","hidden");

  form.append(identFieldEdit);

  
  for(let i=0;i < form.length;i++){     //pass values to form
    let inputId = form[i].id;
    if(dataForm[inputId]){
      form[inputId].value = dataForm[inputId];
    }else{
      form[inputId].value = dataForm.address[inputId];
    }
  }

  toggleModal();
}

//action to open modal and set data for update
function handleEdit(id){
  let user = getDataUsersInMemoryExists(id);

  if(!user){return;}

  openModalEdition(user);
}

function resetForm(){
  let form = $('form#users-form')[0];

  for(let i=0;i < form.length;i++){
    form[i].value = '';
  }
}