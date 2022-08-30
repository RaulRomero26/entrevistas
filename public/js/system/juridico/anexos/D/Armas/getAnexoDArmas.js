// let Ubicacion_Arma = document.getElementById('Ubicacion_Arma')
// let Calibre = document.getElementById('Calibre')
// let Color = document.getElementById('Color')
// let Matricula = document.getElementById('Matricula')
// let Num_Serie = document.getElementById('Num_Serie')
// let Observaciones = document.getElementById('Observaciones')
// let Destino = document.getElementById('Destino')
// let Nombre_A = document.getElementById('Nombre_A')
// let Ap_Paterno_A = document.getElementById('Ap_Paterno_A')
// let Ap_Materno_A = document.getElementById('Ap_Materno_A')
//     //--------------------Testigos-----------------------------
// let Nombre_TA_0 = document.getElementById('Nombre_TA_0')
// let Ap_Paterno_TA_0 = document.getElementById('Ap_Paterno_TA_0')
// let Ap_Materno_TA_0 = document.getElementById('Ap_Materno_TA_0')
// let Nombre_TA_1 = document.getElementById('Nombre_TA_1')
// let Ap_Paterno_TA_1 = document.getElementById('Ap_Paterno_TA_1')
//let Ap_Materno_TA_1 = document.getElementById('Ap_Materno_TA_1')
//     //--------------------Primer respondiente-----------------------------
// let Nombre_PRA = document.getElementById('Nombre_PRA')
// let Ap_Paterno_PRA = document.getElementById('Ap_Paterno_PRA')
// let Ap_Materno_PRA = document.getElementById('Ap_Materno_PRA')
// let InstitucionA = document.getElementById('InstitucionA')
// let CargoA = document.getElementById('CargoA')

let Id_Puesta = document.getElementById('Id_Puesta')
let Id_Inventario_Arma = document.getElementById('Id_Inventario_Arma')
const getData = () => {
    let myFormData = new FormData();
    myFormData.append('Id_Puesta', Id_Puesta.value)
    myFormData.append('Id_Inventario_Arma', Id_Inventario_Arma.value)

    fetch(base_url_js + 'Juridico/getInfoAnexoDArmas', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {

        // console.log(data)
        if (data.resp_case === 'success') {
            // console.log(data)
            if (data.apartados.estatus != '1')
                document.getElementById('id_edit_button_panel').classList.remove('mi_hide')

            const { apartados } = data
            const { general, primer_respondiente, testigos } = apartados

            Aportacion.checked = (general.Aportacion === '0') ? false : true;
            Ubicacion_Arma.value = general.Ubicacion_Arma
            Calibre.value = general.Calibre
            Color.value = general.Color
            Matricula.value = general.Matricula
            Num_Serie.value = general.Num_Serie
            Observaciones.value = general.Observaciones
            Destino.value = general.Destino

            Nombre_A.value = general.Nombre_A
            Ap_Paterno_A.value = general.Ap_Paterno_A
            Ap_Materno_A.value = general.Ap_Materno_A

            if (testigos != null) {
                document.getElementById('testigo_1').checked = true;
                document.getElementById('div_testigos').style.display = 'block'
                Nombre_TA_0.value = testigos[0].Nombre_TA
                Ap_Paterno_TA_0.value = testigos[0].Ap_Paterno_TA
                Ap_Materno_TA_0.value = testigos[0].Ap_Materno_TA
                Nombre_TA_1.value = testigos[1].Nombre_TA
                Ap_Paterno_TA_1.value = testigos[1].Ap_Paterno_TA
                Ap_Materno_TA_1.value = testigos[1].Ap_Materno_TA
            }

            if (primer_respondiente != null) {
                document.getElementById('arma_0').checked = true;
                document.getElementById('div_respondientes_Armas').style.display = 'block'
                Nombre_PRA.value = primer_respondiente.Nombre_PR
                Ap_Paterno_PRA.value = primer_respondiente.Ap_Paterno_PR
                Ap_Materno_PRA.value = primer_respondiente.Ap_Materno_PR
                InstitucionA.value = primer_respondiente.Institucion
                CargoA.value = primer_respondiente.Cargo
            }

            document.getElementsByName('Inspeccion').forEach(element => {
                if (element.value === general.Inspeccion) {
                    element.checked = true;
                }
            })

            document.getElementsByName('Tipo_Arma').forEach(element => {
                if (element.value === general.Tipo_Arma) {
                    element.checked = true;
                }
            })



        } else {
            console.log('Error en la consulta')
        }
    })
}