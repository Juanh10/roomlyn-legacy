$(document).ready(function(){

    $('.btnIconoMenu').click(function(){

        $('.menuLateral').toggleClass('activoMenu');
        $('body').toggleClass('activoBackground');
    
    });
    
    
    $(document).click(function(event) {
    
        let menuLateral = $(".menuLateral");
        let btnMenuFijo = $('.btnIconoMenu');
      
        if (!$(event.target).closest(menuLateral).length && !$(event.target).closest(btnMenuFijo).length) {
            menuLateral.removeClass ('activoMenu');
            $('body').removeClass('activoBackground');
        }
    });

 //* AGREGAR Y QUITAR CLASES A LOS ENLACES DEL MENU DEL MENU LATERAL FIJO

 var urlActual = window.location.href; // OBTENER LA URL ACTUAL

 $('.enlaceMenu').each(function() { // RECORRER TODAS LAS URL DEL MENU
   let href = $(this).attr('href'); // GUARDAR EL ATRIBUTO HREF DE LOS MENU

   if (urlActual.endsWith(href)) { // COMPARAR EL ATRIBUTO HREF CON LA URL ACTUAL
     $(this).addClass('activo'); // SI LA URL ACTUAL ES IGUAL AL HREF ME AGREGA LA CLASE ACTIVO
     return false; // ME RETORNA EL VALOR CUADNO ENCUENTRE EL ENLACE
   }
 });

  //* AGREGAR Y QUITAR CLASES A LOS ENLACES DEL MENU LATERAL


 $('.enlaceMenu2').each(function() { // RECORRER TODAS LAS URL DEL MENU
  let href2 = $(this).attr('href'); // GUARDAR EL ATRIBUTO HREF DE LOS MENU

  if (urlActual.endsWith(href2)) { // COMPARAR EL ATRIBUTO HREF CON LA URL ACTUAL
    $(this).addClass('activo'); // SI LA URL ACTUAL ES IGUAL AL HREF ME AGREGA LA CLASE ACTIVO
    return false; // ME RETORNA EL VALOR CUADNO ENCUENTRE EL ENLACE
  }
});

});

$(document).ready(function(){

  //* PARTE DE MOSTRAR DATOS PARA ACTUALIZAR EN LA TABLA DE USUARIOS

  $('.editBtn').click(function(){

    $tr = $(this).closest('tr'); // Seleccionar el elemento tr mas cercano

    let datos = $tr.children('td').map(function(){ // me recorre todos los elementos de la etiqueta td
      return $(this).text(); // me retorna todos los valores de la etiqueta hijo del td
    });

    $('#id_actual').val(datos[0]); // al id en la cual es un input toma el valor del dato
    $('#primerNombreUsuario').val(datos[1]);
    $('#segundoNombreUsuario').val(datos[2]);
    $('#primerApellidoUsuario').val(datos[3]);
    $('#segundoApellidoUsuario').val(datos[4]);
    $('#documentoUsuario').val(datos[5]);
    $('#telefonoUsuario').val(datos[6]);
    $('#emailUsuario').val(datos[7]);
    $('#usuario').val(datos[9]);
    $('#contraseña').val(datos[10]);

  });

  //* ALERTA DE VERIFICACION PARA ELIMINAR UN DATO (DESHABILITAR)

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


//* SECCION DE HABITACIONES

// Apartado de tipo de habitaciones y habitaciones

let serviciosBtn = $('#serviciosBtn');
let tipoHabitacionesBtn = $('#tipoHabitacionesBtn');
let habitacionesBtn = $('#habitacionesBtn');
let servicios = $('#servicios');
let tipoHabitaciones = $('#tipoHabitaciones');
let habitaciones = $('#habitaciones');

function esconderSeccionHabitaciones(){ // crear funcion para ocultar contenido
  tipoHabitaciones.hide(); // ocultar elementos
  habitaciones.hide();
  servicios.hide();
}

tipoHabitacionesBtn.click(function(){
  esconderSeccionHabitaciones();
  tipoHabitaciones.load('../vistasAdmin/habitaciones/tipoHabitaciones.php'); // cargar elemento 
  tipoHabitaciones.show();// mostrar elemento
});

habitacionesBtn.click(function(){
  esconderSeccionHabitaciones();
  habitaciones.load('../vistasAdmin/habitaciones/habitacionesReg.php');
  habitaciones.show();
});

serviciosBtn.click(function(){
  esconderSeccionHabitaciones();
  habitaciones.load('../vistasAdmin/habitaciones/servicios.php');
  habitaciones.show();
});

//* MOSTRAR DATOS DE LA TABLA DE SERVICIOS

$('.editServiciosBtn').click(function(){

  $tr = $(this).closest('tr'); // Seleccionar el elemento tr mas cercano

  let datos = $tr.children('td').map(function(){ // me recorre todos los elementos de la etiqueta td
    return $(this).text(); // me retorna todos los valores de la etiqueta hijo del td
  });

  $('#id_actualServicio').val(datos[0]); // al id en la cual es un input toma el valor del dato
  $('#servicioAct').val(datos[1]);

});

});