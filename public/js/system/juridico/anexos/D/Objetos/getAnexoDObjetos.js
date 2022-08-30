/*
let Ubicacion_Objeto = document.getElementById('Ubicacion_Objeto')
let Destino = document.getElementById('Destino')
let Descripcion_Objeto = document.getElementById('Descripcion_Objeto')
let Nombre_A = document.getElementById('Nombre_A')
let Ap_Paterno_A = document.getElementById('Ap_Paterno_A')
let Ap_Materno_A = document.getElementById('Ap_Materno_A')
    //--------------------Testigos-----------------------------
let Nombre_TO_0 = document.getElementById('Nombre_TO_0')
let Ap_Paterno_TO_0 = document.getElementById('Ap_Paterno_TO_0')
let Ap_Materno_TO_0 = document.getElementById('Ap_Materno_TO_0')
let Nombre_TO_1 = document.getElementById('Nombre_TO_1')
let Ap_Paterno_TO_1 = document.getElementById('Ap_Paterno_TO_1')
let Ap_Materno_TO_1 = document.getElementById('Ap_Materno_TO_1')
    //--------------------Primer respondiente-----------------------------
let Nombre_PR = document.getElementById('Nombre_PR')
let Ap_Paterno_PR = document.getElementById('Ap_Paterno_PR')
let Ap_Materno_PR = document.getElementById('Ap_Materno_PR')
let Institucion = document.getElementById('Institucion')
let Cargo = document.getElementById('Cargo')
*/

let Id_Puesta = document.getElementById('Id_Puesta')
let Id_Inventario_Objetos = document.getElementById('Id_Inventario_Objetos')
const getData = () => {
    let myFormData = new FormData();
    myFormData.append('Id_Puesta', Id_Puesta.value)
    myFormData.append('Id_Inventario_Objetos', Id_Inventario_Objetos.value)

    fetch(base_url_js + 'Juridico/getInfoAnexoDObjetos', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {

        console.log(data)
        if (data.resp_case === 'success') {

            if (data.apartados.estatus != '1')
                document.getElementById('id_edit_button_panel').classList.remove('mi_hide')

            const { apartados } = data
            const { general, primer_respondiente, testigos } = apartados

            document.getElementsByName('Apariencia').forEach(element => {

                if (general.Apariencia === 'Narcótico' || general.Apariencia === 'Hidrocarburo' || general.Apariencia === 'Numerario') {
                    element.checked = (element.value === general.Apariencia) ? true : false;
                    document.getElementById('div_otro').style.display = 'none'
                } else {
                    element.checked = (element.value === 'Otro') ? true : false;
                    document.getElementById('div_otro').style.display = 'block'
                    otro_objeto.value = general.Apariencia
                }
            })

            Aportacion.checked = (general.Aportacion === '0') ? false : true;

            document.getElementsByName('Inspeccion').forEach(element => {
                if (element.value === general.Inspeccion) {
                    element.checked = true;
                }
            })

            Ubicacion_Objeto.value = general.Ubicacion_Objeto
            Destino.value = general.Destino
            Descripcion_Objeto.value = general.Descripcion_Objeto
            Nombre_A.value = general.Nombre_A
            Ap_Paterno_A.value = general.Ap_Paterno_A
            Ap_Materno_A.value = general.Ap_Materno_A

            if (testigos != null) {
                document.getElementById('testigo_1').checked = true;
                document.getElementById('div_testigos').style.display = 'block'
                Nombre_TO_0.value = testigos[0].Nombre_TO
                Ap_Paterno_TO_0.value = testigos[0].Ap_Paterno_TO
                Ap_Materno_TO_0.value = testigos[0].Ap_Materno_TO
                Nombre_TO_1.value = testigos[1].Nombre_TO
                Ap_Paterno_TO_1.value = testigos[1].Ap_Paterno_TO
                Ap_Materno_TO_1.value = testigos[1].Ap_Materno_TO
            }

            if (primer_respondiente != null) {
                document.getElementById('respondiente_0').checked = true;
                document.getElementById('div_respondiente').style.display = 'block'
                Nombre_PR.value = primer_respondiente.Nombre_PR
                Ap_Paterno_PR.value = primer_respondiente.Ap_Paterno_PR
                Ap_Materno_PR.value = primer_respondiente.Ap_Materno_PR
                Institucion.value = primer_respondiente.Institucion
                Cargo.value = primer_respondiente.Cargo
            }
        } else {
            console.log('Error en la consulta')
        }
    })
}