$(document).ready(function () {

  $('.btnIconoMenu').click(function () {

    $('.menuLateral').toggleClass('activoMenu');
    $('body').toggleClass('activoBackground');

  });

  let enlacePrincipal = $('.enlacePrincipal');

  enlacePrincipal.click(function() {
    $('.flecha').toggleClass('flechaActivo');// agregar clase
  
    let height = 0;
    let menu = this.nextElementSibling; // seleccionar al hermano adyacente del elemento con la clase enlacePrincipal

    if(menu.clientHeight == 0){
      height = menu.scrollHeight;
    }

    menu.style.height = `${height}px`;

  });
  


  $(document).click(function (event) {

    let menuLateral = $(".menuLateral");
    let btnMenuFijo = $('.btnIconoMenu');

    if (!$(event.target).closest(menuLateral).length && !$(event.target).closest(btnMenuFijo).length) {
      menuLateral.removeClass('activoMenu');
      $('body').removeClass('activoBackground');
    }
  });

  //* AGREGAR Y QUITAR CLASES A LOS ENLACES DEL MENU LATERAL FIJO

  let urlActual = window.location.href; // OBTENER LA URL ACTUAL

  $('.enlaceMenu').each(function () { // RECORRER TODAS LAS URL DEL MENU
    let href = $(this).attr('href'); // GUARDAR EL ATRIBUTO HREF DE LOS MENU

    if (urlActual.endsWith(href)) { // COMPARAR EL ATRIBUTO HREF CON LA URL ACTUAL
      $(this).addClass('activo'); // SI LA URL ACTUAL ES IGUAL AL HREF ME AGREGA LA CLASE ACTIVO
      return false; // ME RETORNA EL VALOR CUADNO ENCUENTRE EL ENLACE
    }
  });


  //* Agregar clase activo al menu desplegable del submenu
  $('.enlaceMenuSecund').each(function(){ 
    let href = $(this).attr('href');
    let submenu = $('.menuDesplegable');

    if(urlActual.endsWith(href)){
      submenu.addClass('activo');
      return false;
    }
  });

  //* AGREGAR Y QUITAR CLASES A LOS ENLACES DEL MENU LATERAL


  $('.enlaceMenu2').each(function () { // RECORRER TODAS LAS URL DEL MENU
    let href2 = $(this).attr('href'); // GUARDAR EL ATRIBUTO HREF DE LOS MENU

    if (urlActual.endsWith(href2)) { // COMPARAR EL ATRIBUTO HREF CON LA URL ACTUAL
      $(this).addClass('activo'); // SI LA URL ACTUAL ES IGUAL AL HREF ME AGREGA LA CLASE ACTIVO
      return false; // ME RETORNA EL VALOR CUADNO ENCUENTRE EL ENLACE
    }
  });

});

$(document).ready(function(){

  //! Alertas de verificacion

  $('.formularioEliminar').submit(function(e) {
    e.preventDefault(); // sirve para parar lo que esta haciendo el navegador
    Swal.fire({
        title: '¿Estas seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Deshabilitar'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit(); // sirve para enivar los datos del formulario
        }
    });
});

  //* Mostrar datos de usuarios para editar

  $('.botonEditar').click(function(e){
    let tr = e.target.parentElement.parentElement.parentElement; // seleccionar al tr
    let td = [...tr.children]; // convertir en arreglo

    let datos = td.map(function(element){ // recorre los td
      return $(element).text(); // combierte los elementos del td en texto
    })

    let nombreSeparados = datos[1].split(" "); // separa el nombre y lo convierte en un arreglo
    
    $('#id_usuario').val(datos[0]);
    $('#pNombre').val(nombreSeparados[0]);
    $('#sNombre').val(nombreSeparados[1]);
    $('#pApellido').val(nombreSeparados[2]);
    $('#sApellido').val(nombreSeparados[3]);
    $('#documento').val(datos[2]);
    $('#telefono').val(datos[3]);
    $('#email').val(datos[4]);
    $('#usuario').val(datos[6]);
    $('#contraseñaUsuario').val(datos[7]);
    

  })

});