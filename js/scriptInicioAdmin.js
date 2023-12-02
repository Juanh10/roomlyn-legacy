$(document).ready(function () {

    // Obtener mes actual para el select
    var fechaActual = new Date();
    var mesActual = fechaActual.getMonth() + 1;
    $("#mesHab").val(mesActual.toString());

    // OBTENER VALOR DEL SELECT
    enviarSelect();
    $('#mesHab').change(function () {
        enviarSelect();
    });

    // Declara una variable para almacenar el gráfico
    var graficoChart;

    function enviarSelect() {
        // Obtener el valor y el texto seleccionado del elemento select
        let select = $('#mesHab').val();
        let selectext = $('#mesHab option:selected').text();

        // Comparación para saber si ya existe un gráfico existente para destruirlo
        if (graficoChart) {
            graficoChart.destroy();
        }

        // Enviar la consulta AJAX
        fetch('../../procesos/filtrosInicio/filtroSelect.php?select=' + select)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error de red: ${response.status}`);
                }
                return response.json();
            })
            // ...

            .then(data => {
                // Procesar los datos recibidos
                let datosPorHabitacion = {};

                data.forEach(entry => {
                    const habitacionId = entry.id_habitacion;
                    if (!(habitacionId in datosPorHabitacion)) {
                        datosPorHabitacion[habitacionId] = {
                            cantidad_reservas: 0,
                            numero_habitacion: entry.nHabitacion  // Agregar el número de habitación
                        };
                    }
                    datosPorHabitacion[habitacionId].cantidad_reservas += entry.cantidad_reservas;
                });

                // Ordenar el array de datos en orden descendente por cantidad de reservas
                const datosOrdenados = Object.values(datosPorHabitacion).sort((a, b) => b.cantidad_reservas - a.cantidad_reservas);

                // Configuracion del grafico utilizando Chart.js
                let ctx = document.getElementById('myChart').getContext('2d');
                graficoChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: datosOrdenados.map(habitacion => `Habitación ${habitacion.numero_habitacion}`),
                        datasets: [{
                            label: `Reservas para el mes de ${selectext}`,
                            data: datosOrdenados.map(habitacion => habitacion.cantidad_reservas),
                            backgroundColor: 'rgba(196, 172, 159, 0.2)',
                            borderColor: 'rgba(196, 172, 159, 1)',
                            borderWidth: 1,
                            fill: false
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error al obtener datos del servidor:', error));
    }

});