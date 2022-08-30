const selectEvento = document.getElementById('tipo_evento'),
    detenidos      = document.getElementsByName('detenidos'),
    marca          = document.getElementById('marca'),
    tipo           = document.getElementById('tipo'),
    year           = document.getElementById('anio'),
    placas         = document.getElementById('placas'),
    color          = document.getElementById('color'),
    cuantos        = document.getElementById('cuantos'),
    ficha          = document.getElementById('ficha'),
    remisiones     = document.getElementById('remisiones'),
    ficha_error    = document.getElementById('ficha_error'),
    situacion      = document.getElementsByName('situacion');
    ;

selectEvento.addEventListener('change', ()=>{
    if(selectEvento.value === 'ROBO DE VEHÍCULO'){
        document.getElementById('content_observaciones').style.display = 'block'
    }else{
        document.getElementById('content_observaciones').style.display = 'none';
        marca.value = '';
        tipo.value = '';
        year.value = '';
        placas.value = '';
        color.value = '';
    }
})

situacion.forEach(elem=>{
    elem.addEventListener('change',()=>{
        if(elem.value === 'Frustrado'){
            modo_fuga.value = 'DETENIDO';
        }else{
            modo_fuga.value = 'CON RUMBO DESCONOCIDO';
        }
    })
})

detenidos.forEach(detenido=>{
    detenido.addEventListener('change', ()=>{
        if(detenido.value === 'Si'){
            document.getElementById('detenidos_content').style.display = 'block'
        }else{
            document.getElementById('detenidos_content').style.display = 'none';
            cuantos.value = '';
            ficha.value = '';
            remisiones.value = '';
        }
    })
})

folio.addEventListener('change', async()=>{
    let result = await existFolio(folio.value);
    if(result){
        if(window.confirm('El folio ya exite, ¿Desea editarlo?')){
            window.location = base_url_js+'EventosDelictivos/editarRegistro/'+folio.value
        }else{
            folio.classList.add('is-invalid');
            folio_no_error.innerText = 'Folio existente';
        }
    }else{
        folio.classList.remove('is-invalid');
        folio.classList.add('is-valid');
        folio_no_error.innerText = '';
    }
})

ficha.addEventListener('change', async()=>{
    const result = await getFicha(ficha.value);
    if(result.length>0){
        ficha.classList.remove('is-invalid'); ficha.classList.add('is-valid'); ficha_error.innerText = '';
        cuantos.value = result.length;
        remisiones.value = '';
        document.getElementById('responsables_table').getElementsByTagName('tbody')[0].innerHTML = '';
        result.forEach((rem, i)=>{
            (result[i+1] === undefined) ? remisiones.value += rem.No_Remision : remisiones.value += rem.No_Remision+', ';

            let formData = {
                no_remision_table : rem.No_Remision,
                nombre_table : rem.fullname.toUpperCase(),
                edad_table : rem.Edad,
                sexo_table : (rem.Genero.toUpperCase() === 'H') ? 'HOMBRE' : 'MUJER'
            }

            insertNewRowResponsable(formData);
        })
    }else{
        ficha.classList.remove('is-valid'); ficha.classList.add('is-invalid'); ficha_error.innerText = 'No existe ficha';
        cuantos.value = '';
        remisiones.value = '';
        document.getElementById('responsables_table').getElementsByTagName('tbody')[0].innerHTML = '';
    }
})

remisiones.addEventListener('keypress',async(e)=>{

    if (e.key === 'Enter' && remisiones.value !== '') {

        const values = remisiones.value.split(',');
        let band = true;
        
        values.forEach(value=>{
            if(isNaN(value)) band = false;
        })

        if(band){
            remisiones.classList.remove('is-invalid');
            document.getElementById('remisiones_error').innerText = '';
            const remisionesData = await getRemisiones(remisiones.value);
            let errors = '';
            document.getElementById('responsables_table').getElementsByTagName('tbody')[0].innerHTML = '';
            remisionesData.forEach(remision=>{
                if(remision.status && remision.data !== false){
                    let formData = {
                        no_remision_table : remision.remision,
                        nombre_table : remision.data.fullname.toUpperCase(),
                        edad_table : remision.data.Edad,
                        sexo_table : (remision.data.Genero.toUpperCase() === 'H') ? 'HOMBRE' : 'MUJER'
                    }
        
                    insertNewRowResponsable(formData);
                }else{
                    errors += `Remisión: ${remision.remision} no se encontró. \n`;
                }
            })

            //(errors != '') ? document.getElementById('remisiones_error').innerText = errors : document.getElementById('remisiones_error').innerText = '';
            document.getElementById('remisiones_error').innerText = (errors != '') ? errors : '';
        }else{
            remisiones.classList.add('is-invalid');
            document.getElementById('remisiones_error').innerText = 'Lo sentimos, algún folio ingresado no es valido.';
        }
    }
})


const getFicha = async(ficha)=>{
    let myFormData = new FormData();

    myFormData.append('ficha', ficha);

    let response = await fetch(base_url_js+'EventosDelictivos/existFicha',{
        method: 'POST',
        body: myFormData
    });

    let data = await response.json();

    return data;
}

const getRemisiones = async(remisiones)=>{
    let myFormData = new FormData();

    myFormData.append('remisiones', remisiones);

    let response = await fetch(base_url_js+'EventosDelictivos/existRemisiones',{
        method: 'POST',
        body: myFormData
    });

    let data = await response.json();

    return data;
}

const existFolio = async(folio)=>{
    let myFormData = new FormData();

    myFormData.append('id_evento', folio);

    let response = await fetch(base_url_js+'EventosDelictivos/existFolio',{
        method: 'POST',
        body: myFormData
    });

    let data = await response.json();

    return data;
}