/*
let Descripcion_PL = document.getElementById('Descripcion_PL')
let Descripcion_Apoyo = document.getElementById('Descripcion_Apoyo')
let Motivo_Ingreso = document.getElementById('Motivo_Ingreso')
let Nombre_PER_0 = document.getElementById('Nombre_PER_0')
let Ap_Paterno_PER_0 = document.getElementById('Ap_Paterno_PER_0')
let Ap_Materno_PER_0 = document.getElementById('Ap_Materno_PER_0')
let Institucion_0 = document.getElementById('Institucion_0')
let Cargo_0 = document.getElementById('Cargo_0')
let Nombre_PER_1 = document.getElementById('Nombre_PER_1')
let Ap_Paterno_PER_1 = document.getElementById('Ap_Paterno_PER_1')
let Ap_Materno_PER_1 = document.getElementById('Ap_Materno_PER_1')
let Institucion_1 = document.getElementById('Institucion_1')
let Cargo_1 = document.getElementById('Cargo_1')
let tabla = document.getElementById('elementos_intervencion')
let Observaciones = document.getElementById('Observaciones')
let Fecha = document.getElementById('Fecha')
let Hora = document.getElementById('Hora')
*/

let Id_Puesta = document.getElementById('Id_Puesta')
let Id_Entrega_Recepcion_Lugar = document.getElementById('Id_Entrega_Recepcion_Lugar')
const getData = () => {
    let myFormData = new FormData();
    myFormData.append('Id_Puesta', Id_Puesta.value)
    myFormData.append('Id_Entrega_Recepcion_Lugar', Id_Entrega_Recepcion_Lugar.value)

    fetch(base_url_js + 'Juridico/getInfoAnexoF', {
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
            const { general, persona_entrega, persona_recibe, personal_intervencion } = apartados

            Descripcion_PL.value = general.Descripcion_PL

            if (general.Descripcion_Apoyo != '') {
                document.getElementById('div_Descripcion_Apoyo').style.display = 'block'
                document.getElementById('autoridad_1').checked = true
                Descripcion_Apoyo.value = general.Descripcion_Apoyo
            }

            if (general.Motivo_Ingreso != '' && personal_intervencion.length > 0) {
                document.getElementById('id_Motivo').style.display = 'block'
                document.getElementById('persona_1').checked = true
                document.getElementById('btn-add-personal').disabled = true;
                Motivo_Ingreso.value = general.Motivo_Ingreso

                for (let i = 0; i < personal_intervencion.length; i++) {
                    let formData = {
                        Nombre_PLI: personal_intervencion[i].Nombre_PLI,
                        Ap_Paterno_PLI: personal_intervencion[i].Ap_Paterno_PLI,
                        Ap_Materno_PLI: personal_intervencion[i].Ap_Materno_PLI,
                        Cargo: personal_intervencion[i].Cargo,
                        Institucion: personal_intervencion[i].Institucion
                    }
                    insertNewRowPersonal(formData);
                }

            }

            const button_row = document.getElementById('elementos_intervencion').getElementsByClassName('action_row')
            activateButtonRow(button_row, true)

            Nombre_PER_0.value = persona_entrega.Nombre_PER
            Ap_Paterno_PER_0.value = persona_entrega.Ap_Paterno_PER
            Ap_Materno_PER_0.value = persona_entrega.Ap_Materno_PER
            Institucion_0.value = persona_entrega.Institucion
            Cargo_0.value = persona_entrega.Cargo
            Nombre_PER_1.value = persona_recibe.Nombre_PER
            Ap_Paterno_PER_1.value = persona_recibe.Ap_Paterno_PER
            Ap_Materno_PER_1.value = persona_recibe.Ap_Materno_PER
            Institucion_1.value = persona_recibe.Institucion
            Cargo_1.value = persona_recibe.Cargo
            Observaciones.value = general.Observaciones_Entrega_Recibe

            const aux_fecha_hora = general.Fecha_Hora_Recepcion.split(' ')
            Fecha.value = aux_fecha_hora[0]
            Hora.value = aux_fecha_hora[1]

        } else {
            console.log('Error en la consulta')
        }
    })
}

let activateButtonRow = (arg, value) => {
    for (let i = 0; i < arg.length; i++) {
        arg[i].disabled = value
    }
}