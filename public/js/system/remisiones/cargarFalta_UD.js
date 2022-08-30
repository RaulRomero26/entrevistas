const remitido_1 = document.getElementById("Remitido"),
    select_1 = document.getElementById('delito_1'),
    div_delito_1 = document.getElementById('div_delito_1'),
    letrero_1 = document.getElementById('letrero_1');

var ruta_1 = document.getElementById('div_ruta_1')
var unidad_1 = document.getElementById('div_unidad_1')
var negocio_1 = document.getElementById('div_negocio_1')

remitido_1.addEventListener('change', ()=>{
    getDataRemitidoA(remitido_1.value);
});

const getDataRemitidoA = (instancia)=>{

    console.log('ins', instancia)

    let id_uh = '';
    if( instancia.includes('M.P.'))
        id_uh = 'Falta_Delito_Tipo2'
    else if( instancia.includes('JUEZ') )
        id_uh = 'Falta_Delito_Tipo1'

    console.log(id_uh)

    if( id_uh !== ''  ) document.getElementById(id_uh).checked = true ;

    let formData = new FormData();

    formData.append('instancia', instancia);

    fetch(base_url + 'getDelito',{
        method: 'POST',
        body: formData
    })
    .then(res=>res.json())
    .then(data=>{
        if(data.length > 0){
            letrero_1.style.display = 'none';
            select_1.innerHTML = '';
            data.forEach(element => {
                select_1.innerHTML +=`
                    <option value="${element.Descripcion}">${element.Descripcion}</option>
                `;
            });
        }else{
            select_1.innerHTML = '';
            letrero_1.style.display = 'block';
            letrero_1.innerText = 'Por favor verifica tu consulta, posiblemente la instancia ingresada no sea valida.';
        }
    })
}

select_1.addEventListener('change', ()=>{
    switch(select_1.value){
        case 'ROBO A TRANSPORTE PÚBLICO':
            ruta_1.style.display = 'block'
            unidad_1.style.display = 'block'
            negocio_1.style.display = 'none'
        break;
        case 'ROBO A COMERCIO':
            negocio_1.style.display = 'block'
            ruta_1.style.display = 'none'
            unidad_1.style.display = 'none'
        break;
    }
})