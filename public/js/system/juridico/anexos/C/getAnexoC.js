/*
let fecha = document.getElementById('fecha')
let hora = document.getElementById('hora')

let tipo = document.getElementById('tipo')
let Procedencia = document.getElementById('Procedencia')
let Uso = document.getElementById('Uso')
let Situacion = document.getElementById('Situacion')

let Marca = document.getElementById('Marca')
let Submarca = document.getElementById('Submarca')
let Modelo = document.getElementById('Modelo')
let Color = document.getElementById('Color')
let Placa = document.getElementById('Placa')
let Num_Serie = document.getElementById('Num_Serie')
let Observaciones = document.getElementById('Observaciones')
let Destino = document.getElementById('Destino')
let Nombre_PR = document.getElementById('Nombre_PR')
let Ap_Paterno_PR = document.getElementById('Ap_Paterno_PR')
let Ap_Materno_PR = document.getElementById('Ap_Materno_PR')
let Institucion = document.getElementById('Institucion')
let Cargo = document.getElementById('Cargo')
let Nombre_PR_1 = document.getElementById('Nombre_PR_1')
let Ap_Paterno_PR_1 = document.getElementById('Ap_Paterno_PR_1')
let Ap_Materno_PR_1 = document.getElementById('Ap_Materno_PR_1')
let Institucion_1 = document.getElementById('Institucion_1')
let Cargo_1 = document.getElementById('Cargo_1')

let data = document.getElementById('anexoCForm')

//labels para mostrar de error
let fecha_error = document.getElementById('fecha_error')
let hora_error = document.getElementById('hora_error')
let Marca_error = document.getElementById('Marca_error')
let Submarca_error = document.getElementById('Submarca_error')
let Modelo_error = document.getElementById('Modelo_error')
let Color_error = document.getElementById('Color_error')
let Placa_error = document.getElementById('Placa_error')
let Num_Serie_error = document.getElementById('Num_Serie_error')
let Observaciones_error = document.getElementById('Observaciones_error')
let Destino_error = document.getElementById('Destino_error')

let Nombre_PR_error = document.getElementById('Nombre_PR_error')
let Ap_Paterno_PR_error = document.getElementById('Ap_Paterno_PR_error')
let Ap_Materno_PR_error = document.getElementById('Ap_Materno_PR_error')
let Institucion_error = document.getElementById('Institucion_error')
let Cargo_error = document.getElementById('Cargo_error')
let Nombre_PR_1_error = document.getElementById('Nombre_PR_1_error')
let Ap_Paterno_PR_1_error = document.getElementById('Ap_Paterno_PR_1_error')
let Ap_Materno_PR_1_error = document.getElementById('Ap_Materno_PR_1_error')
let Institucion_1_error = document.getElementById('Institucion_1_error')
let Cargo_1_error = document.getElementById('Cargo_1_error')
let button = document.getElementById('btn_anexoC')
*/

let Id_Puesta = document.getElementById('Id_Puesta')
let Id_Inspeccion_Vehiculo = document.getElementById('Id_Inspeccion_Vehiculo')
const getData = () => {
    let myFormData = new FormData();
    myFormData.append('Id_Puesta', Id_Puesta.value)
    myFormData.append('Id_Inspeccion_Vehiculo', Id_Inspeccion_Vehiculo.value)

    fetch(base_url_js + 'Juridico/getInfoAnexoC', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {
        // console.log(data)
        if (data.resp_case === 'success') {

            if (data.apartados.estatus != '1')
                document.getElementById('id_edit_button_panel').classList.remove('mi_hide')
            const { apartados } = data
            const { general, primer_respondiente, segundo_respondiente } = apartados
            //console.log(general)
            const auxFechaHora = general.Fecha_Hora.split(" ")
            fecha.value = auxFechaHora[0]
            hora.value = auxFechaHora[1]

            tipo.value = general.Tipo
            Procedencia.value = general.Procedencia
            Uso.value = general.Uso
            Situacion.value = general.Situacion

            Marca.value = general.Marca
            Submarca.value = general.Submarca
            Modelo.value = general.Modelo
            Color.value = general.Color
            Placa.value = general.Placa
            Num_Serie.value = general.Num_Serie

            Observaciones.value = general.Observaciones
            Destino.value = general.Destino;
            (general.Objetos_Encontrados != '1') ? document.getElementById('Objetos_Encontrados_0').cheked = true: document.getElementById('Objetos_Encontrados_1').checked = true;
            //console.log(primer_respondiente)

            if (primer_respondiente != null && primer_respondiente.Nombre_PR != '') {
                document.getElementById('pr_0').checked = true;
                document.getElementById('div_respondientes').style.display = 'block'
                Institucion.style.display = 'block'

                Nombre_PR.value = primer_respondiente.Nombre_PR
                Ap_Paterno_PR.value = primer_respondiente.Ap_Paterno_PR
                Ap_Materno_PR.value = primer_respondiente.Ap_Materno_PR
                Institucion.value = primer_respondiente.Institucion
                Cargo.value = primer_respondiente.Cargo

                if (segundo_respondiente != null) {
                    Nombre_PR_1.value = segundo_respondiente.Nombre_PR
                    Ap_Paterno_PR_1.value = segundo_respondiente.Ap_Paterno_PR
                    Ap_Materno_PR_1.value = segundo_respondiente.Ap_Materno_PR
                    Institucion_1.value = segundo_respondiente.Institucion
                    Cargo_1.value = segundo_respondiente.Cargo
                }
            }
        } else {
            console.log('Error en la consulta')
        }
    })
}