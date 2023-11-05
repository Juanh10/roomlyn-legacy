$(document).ready(function() {
    $('#onload').fadeOut(); //TODO Desaparece el elemento
    $('.cabecera').show(); //TODO Muestra el elemento
    
    
    let menu = $('.navegacion ul');
    let icono = $('.icono');

    $(".menuRespon").click(function(){
        menu.toggleClass('mostrar');
        icono.toggleClass('iconoActivo');
    });

    $('#nacionalidad').select2();
    $('#departamento').select2();
    $('#ciudad').select2();

    // FUNCION PARA RECARGAR LA LISTA DE DEPARTAMENTOS Y CIUDADES POR MEDIO DE AJAX O FETCH
    function listaOrigenDepartamento() {
        let valorNacionalidad = $('#nacionalidad').val();
        let valorCliente = $('#idCliente').val();
        let divDepartamento = $('#departamento');
        let divCiudad = $('#ciudad');

        // Realizar una consulta fetch para mostrar los departamentos
        fetch(`selectDepartamento2.php?valorNa=${valorNacionalidad}&vCliente=${valorCliente}`)
            .then(res => res.text())
            .then(datos => {
                divDepartamento.html(datos);

                // Si el valor de nacionalidad no es igual a 43, que cargue la opcion "No requerido"
                if (valorNacionalidad != 43) {
                    fetch(`selectCiudad2.php?valorDe=0&vCliente=${valorCliente}`)
                        .then(resCiudad => resCiudad.text())
                        .then(datosCiudad => divCiudad.html(datosCiudad))
                        .catch();
                }
            })
            .catch();
    }

    listaOrigenDepartamento(); // Ejecutar la funcion

    $('#nacionalidad').change(function () { // evento change para saber cuando hay un cambio en el select
        listaOrigenDepartamento();
        listaOrigenCiudad(); // ejecutar la funcion
    });

    // Funcion para mostrar la lista de las ciudades segun el departamento esto lo hacemos por medio de FETCH

    function listaOrigenCiudad() {
        let valorDepartamento = $('#departamento').val();
        let divCiudad = $('#ciudad');
        let valorCliente = $('#idCliente').val();

        // Realiza una única llamada a la función fetch para cargar las ciudades
        fetch(`selectCiudad2.php?valorDe=${valorDepartamento}&vCliente=${valorCliente}`) // realizar consulta fetch
            .then(res => res.text())
            .then(datos => divCiudad.html(datos))
            .catch();
    }

    listaOrigenCiudad(); // ejecutar la funcion

    $('#departamento').change(function () { // evento change para saber cuando hay un cambio en el select
        listaOrigenCiudad();
    });

  
});
  