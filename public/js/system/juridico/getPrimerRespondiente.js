const getPrimerRespondiente = (value, elements)=>{
    const content = document.getElementById(elements.find(key => key.key === 'content').value);
    if(value.length != 0){
        let myFormData = new FormData;
    
        myFormData.append('input-search-element', value);
    
        fetch(base_url_js + 'BuscarPolicia', {
            method: 'POST',
            body: myFormData
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            document.getElementById(elements.find(key => key.key === 'button').value).innerText = 'Buscar';
            document.getElementById(elements.find(key => key.key === 'button').value).removeAttribute('disabled');
            if(elements.some(key => key.key === 'nombre'))      document.getElementById(elements.find(key => key.key === 'nombre').value).value      = '';
            if(elements.some(key => key.key === 'paterno'))     document.getElementById(elements.find(key => key.key === 'paterno').value).value     = '';
            if(elements.some(key => key.key === 'materno'))     document.getElementById(elements.find(key => key.key === 'materno').value).value     = '';
            if(elements.some(key => key.key === 'cargo'))       document.getElementById(elements.find(key => key.key === 'cargo').value).value       = '';
            if(elements.some(key => key.key === 'adscripcion')) document.getElementById(elements.find(key => key.key === 'adscripcion').value).value = '';
            if(elements.some(key => key.key === 'control'))     document.getElementById(elements.find(key => key.key === 'control').value).value     = '';
            if(!data.status){
                content.innerHTML = `
                    <div class="col-lg-12 text-center">
                        <span class="span_error">${data.error_message}</span>
                    </div>
                `;
            }else{
                localStorage.setItem('inputsDom', JSON.stringify(elements));
                
                if((data.res).length > 1){
                    let aux = '',
                        elements = [];
                    aux = `
                        <div class="col-lg-12 text-center">
                            <label class="label-form mt-2">Se encontraron varios registros con esas especificaciones. Seleccione el correcto.</label>
                        </div>
                    `;
    
                    data.res.forEach((element,i)=>{
                        if(i<=4){
                            elements.push(element);
                            aux += `<div class="list-group-item list-group-item-action py-1" onclick="drawElementInForm(${i})">${decode_utf8(element.Paterno)} ${decode_utf8(element.Materno)} ${decode_utf8(element.Nombre)}</div>`;
                        }
                    });
    
                    content.innerHTML = aux;
                    localStorage.setItem('elements', JSON.stringify(elements));
                }else{
                    content.innerHTML = ``;
    
                    drawElementInForm(data.res[0]);
    
                }
            }
        })
    }else{
        content.innerHTML = `
            <div class="col-lg-12 text-center">
                <span class="span_error">Campo requerido</span>
            </div>
        `;
    }
}

const drawElementInForm = (element)=>{

    let cargo = '';
    const elements = JSON.parse(localStorage.getItem('inputsDom'));
    
    (typeof(element) != 'object') ? {Nombre, Paterno, Materno, TipoEmpleado, AdscripCom, No_ControlMunicipio} = JSON.parse(localStorage.getItem('elements'))[element] : {Nombre, Paterno, Materno, TipoEmpleado, AdscripCom, No_ControlMunicipio} = element;
    
    switch (TipoEmpleado) {
        case 'M':
            cargo = 'MUNICIPAL'
        break;
        case 'P':
            cargo = 'POLICIA'
        break;
        case 'V':
            cargo = 'VIALIDAD'
        break;
    }
    
    if(Nombre               != '' && elements.some(key => key.key === 'nombre'))      document.getElementById(elements.find(key => key.key === 'nombre').value).value      = decode_utf8(Nombre);
    if(Paterno              != '' && elements.some(key => key.key === 'paterno'))     document.getElementById(elements.find(key => key.key === 'paterno').value).value     = decode_utf8(Paterno);
    if(Materno              != '' && elements.some(key => key.key === 'materno'))     document.getElementById(elements.find(key => key.key === 'materno').value).value     = decode_utf8(Materno);
    if(TipoEmpleado         != '' && elements.some(key => key.key === 'cargo'))       document.getElementById(elements.find(key => key.key === 'cargo').value).value       = cargo;
    if(AdscripCom           != '' && elements.some(key => key.key === 'adscripcion')) document.getElementById(elements.find(key => key.key === 'adscripcion').value).value = AdscripCom;
    if(No_ControlMunicipio  != '' && elements.some(key => key.key === 'control'))     document.getElementById(elements.find(key => key.key === 'control').value).value     = No_ControlMunicipio;
    if(elements.some(key => key.key === 'fullname'))     document.getElementById(elements.find(key => key.key === 'fullname').value).value     = decode_utf8(Nombre)+' '+decode_utf8(Paterno)+' '+decode_utf8(Materno);
    
    document.getElementById(elements.find(key => key.key === 'content').value).innerHTML = '';
    document.getElementById(elements.find(key => key.key === 'search').value).value = '';
    localStorage.removeItem('inputsDom')
    localStorage.removeItem('elements')
}

const decode_utf8 = (s) =>{
    return decodeURIComponent(escape(s));
}





