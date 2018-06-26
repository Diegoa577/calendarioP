$(function(){
  var l = new Login();
})


class Login {
  constructor() {
    this.submitEvent()
  }

  submitEvent(){
    $('form').submit((event)=>{
      event.preventDefault()
      this.sendForm()
    })
  }

  sendForm(){
    var user = $('#login-form').find('#user').val();
    var password = $('#login-form').find('#password').val();
    var datos = {"user": user,"password":password};
    // let form_data = new FormData();
    // form_data.append('username', $('#user').val())
    // form_data.append('password', $('#password').val())
    $.ajax({
      url: '../server/check_login.php',
      cache: false,
      data: datos,
      type: 'POST',
      success: function(php_response){
        var respuesta = JSON.parse(php_response);
        if (respuesta[0]=="OK") {
          console.log("ok");
          if (respuesta[1] == 'concedido') {
            console.log("bien");
            window.location.href = 'main.html';
          }else {
            console.log("error");
            alert('Usuario y contraseña incorrectos, inténtelo de nuevo');
          }


        }else{
          console.log("mal");
          alert(php_response.conexion);
        }
      },
      error: function(){
        alert("error en la comunicación con el servidor");
      }
    })
  }
}
