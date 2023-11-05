$(document).ready(function(){

    $('#nacionalidad').select2();
    $('#departamento').select2();
    $('#ciudad').select2();

    // FUNCION PARA RECARGAR LA LISTA DE DEPARTAMENTOS Y CIUDADES POR MEDIO DE AJAX O FETCH
    function listaOrigenDepartamento() {
        let valorNacionalidad = $('#nacionalidad').val();
        let divDepartamento = $('#departamento');
        let divCiudad = $('#ciudad');

        // Realizar una consulta fetch para mostrar los departamentos
        fetch(`vistasRegistroClientes/selectDepartamento.php?valorNa=${valorNacionalidad}`)
            .then(res => res.text())
            .then(datos => {
                divDepartamento.html(datos);

                // Si el valor de nacionalidad no es igual a 43, que cargue la opcion "No requerido"
                if (valorNacionalidad != 43) {
                    fetch(`vistasRegistroClientes/selectCiudad.php?valorDe=0`)
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
    });

    // Funcion para mostrar la lista de las ciudades segun el departamento esto lo hacemos por medio de FETCH

    function listaOrigenCiudad() {
        let valorDepartamento = $('#departamento').val();
        let divCiudad = $('#ciudad');

        // Realiza una única llamada a la función fetch para cargar las ciudades
        fetch(`vistasRegistroClientes/selectCiudad.php?valorDe=${valorDepartamento}`) // realizar consulta fetch
            .then(res => res.text())
            .then(datos => divCiudad.html(datos))
            .catch();
    }

    listaOrigenCiudad(); // ejecutar la funcion

    $('#departamento').change(function () { // evento change para saber cuando hay un cambio en el select
        listaOrigenCiudad();
    });

});