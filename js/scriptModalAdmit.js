$(document).ready(function(){

    // Script para enviar por medio de FETCH el id seleccionado en un select para hacer una funcion en especifico

    let tipoHabEdit = $('#tipoHabEdit');
    let addSelectEdit = $('#addSelect');
    let valorPredeterminado = tipoHabEdit.find('option:selected').val();
    
    tipoHabEdit.on('change', function () {

        let seleccion = tipoHabEdit.val();
    
        if (seleccion !== valorPredeterminado) {

            tipoHabEdit.find('option:selected').removeAttr('selected'); // deseleccionar la opcion predeterminado
        }

        fetch(`../vistasAdmin/editTipoCama.php?idselect=${seleccion}`)
            .then(res => res.text())
            .then(datos => addSelectEdit.html(datos))
            .catch();
    });
    

});