//convertir color hexadecimal a rgb con opacidad
const convertHexToRGBA = (hexCode, opacity) => {
    opacity = (opacity >= 0.0 && opacity <= 1.0) ? opacity : 1.0;

    let hex = hexCode.replace('#', '');

    if (hex.length === 3) {
        hex = `${hex[0]}${hex[0]}${hex[1]}${hex[1]}${hex[2]}${hex[2]}`;
    }

    const r = parseInt(hex.substring(0, 2), 16);
    const g = parseInt(hex.substring(2, 4), 16);
    const b = parseInt(hex.substring(4, 6), 16);

    return `rgba(${r},${g},${b},${opacity})`;
};

/**---------------MIS COLORES (para mantener un perfil)----------------------- */
const mis_colores = [
    // '#e57373',
    '#f06292',
    // '#ba68c8',
    '#9575cd',
    // '#7986cb',
    '#64b5f6',
    // '#4fc3f7',
    '#4dd0e1',
    // '#4db6ac',
    '#81c784',
    // '#aed581',
    '#dce775',
    // '#66bb6a',
    '#9ccc65',
    // '#d4e157',
    '#fff176',
    // '#ffd54f',
    '#ffb74d',
    // '#ff8a65',
    '#a1887f',
    // '#e0e0e0',
    '#90a4ae'
];
//------------------------VARIABLES DE CANVAS Y CHARTS---------------------------
let ctx1 = document.getElementById('id_grafica_1').getContext('2d');
let ctx2 = document.getElementById('id_grafica_2').getContext('2d');
let ctx3 = document.getElementById('id_grafica_3').getContext('2d');
let chart1 = new Chart(ctx1, {});
let chart2 = new Chart(ctx2, {});
let chart3 = new Chart(ctx3, {});
//------------------------GENERACIÓN DE GRÁFICAS---------------------------

const mostrarGrafica = (results) => {
    let mis_labels = [];
    let backColors = [];
    let borderColors = [];
    let miData = [];
    let totalInsp = 0;

    chart1.destroy() //se destruye el anterior canvas para poner el nuevo
    results.forEach((element, index) => {
        mis_labels.push(element.Zona_Sector);
        miData.push(element.Num_Inspecciones);
        backColors.push(convertHexToRGBA(mis_colores[(index % mis_colores.length)], 0.3));
        borderColors.push(convertHexToRGBA(mis_colores[(index % mis_colores.length)], 1.0));
        totalInsp += parseInt(element.Num_Inspecciones);
    });
    document.getElementById('id_total_grafica').innerHTML = totalInsp;

    if (results.length > 0) {
        document.getElementById('id_sin_results_grafica').classList.add('mi_hide')
        chart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: mis_labels,
                datasets: [{
                    label: ['Total registros'],
                    data: miData,
                    backgroundColor: backColors,
                    borderColor: borderColors,
                    borderWidth: 1
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
    } else {
        document.getElementById('id_sin_results_grafica').classList.remove('mi_hide')
    }

}

const mostrarGrafica2 = (results) => {
    let mis_labels = [];
    let backColors = [];
    let borderColors = [];
    let miData = [];

    chart2.destroy() //se destruye el anterior canvas para poner el nuevo
    results.forEach((element, index) => {
        mis_labels.push(element.Zona_Sector);
        miData.push(element.Num_Inspecciones);
        backColors.push(convertHexToRGBA(mis_colores[(index % mis_colores.length)], 0.3));
        borderColors.push(convertHexToRGBA(mis_colores[(index % mis_colores.length)], 1.0));
    });

    if (results.length > 0) {
        chart2 = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: mis_labels,
                datasets: [{
                    // label: ['# of Votes'],
                    data: miData,
                    backgroundColor: backColors,
                    borderColor: borderColors,
                    borderWidth: 1
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
    }
}
const mostrarGrafica3 = (numPersonas, numVehiculos) => {

    chart3.destroy() //se destruye el anterior canvas para poner el nuevo

    chart3 = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: ["Total personas", "Total vehículos"],
            datasets: [{
                label: ['#'],
                data: [numPersonas, numVehiculos],
                backgroundColor: [convertHexToRGBA(mis_colores[2], 0.3), convertHexToRGBA(mis_colores[0], 0.3)],
                borderColor: [convertHexToRGBA(mis_colores[2], 1.0), convertHexToRGBA(mis_colores[0], 1.0)],
                borderWidth: 1
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

}

const getDataNumInspPorZonas = () => {
    let formAux = new FormData();
    formAux.append('cadena', document.getElementById('id_search').value);
    fetch(base_url_js + 'Inspecciones/getNumInspPorZonas', {
            method: 'POST',
            body: formAux
        })
        .then(resp => resp.json())
        .then(data => {
            mostrarGrafica(data.por_zonas);
            mostrarGrafica2(data.por_zonas);
            mostrarGrafica3(data.total_personas, data.total_vehiculos);
        })
        .catch(err => console.log(err))

}

const checarCadenaForGrafica = (event) => {
    if ((search.value == "") || (event.keyCode == '13')) {
        getDataNumInspPorZonas();
    }
}

window.onload = function() {
    $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    });

    getDataNumInspPorZonas();
    search_button.addEventListener('click', getDataNumInspPorZonas);
    document.getElementById('id_search').addEventListener('change', checarCadenaForGrafica);
    document.getElementById('id_search').addEventListener('keyup', checarCadenaForGrafica);
};