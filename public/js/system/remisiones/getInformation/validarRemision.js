const buttons = document.getElementsByClassName('btn-tab-getIndex'),
    remision = document.getElementById('no_remision_principales');

buttons.forEach(element => {
    element.addEventListener('click', ()=>{
        let myFormData  = new FormData();
        const idMessage = element.getAttribute('message'),
            message = document.getElementById(idMessage);

        myFormData.append('num_tab', element.getAttribute('data-id'));
        myFormData.append('remision', remision.value);

        fetch(base_url + 'updateValidarTab',{
            method: 'POST',
            body: myFormData
        })
        .then(res=>res.json())
        .then(data=>{
            if(data.status){
                message.innerHTML = '<div class="alert alert-success text-center" role="alert">Tab validado con éxito.</div>'
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });
                getTabsGuardados();
            }else{
                message.innerHTML = '<div class="alert alert-danger text-center" role="alert">Lo sentimos ocurrio un error.</div>'
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });
            }
        })
    })
});

const idButtonTab = [
    {
        "tab":0,
        "id": 'btn_principal',
        "message": 'span-message-0' 
    },
    {
        "tab":1,
        "id": 'btn_peticionario',
        "message": 'span-message-1' 
    },
    {
        "tab":2,
        "id": 'btn_ubicacionH',
        "message": 'span-message-2' 
    },
    {
        "tab":3,
        "id": 'btn_elementos',
        "message": 'span-message-3' 
    },
    {
        "tab":4,
        "id": 'btn_objRecuperados',
        "message": 'span-message-4' 
    },
    {
        "tab":5,
        "id": 'btn_capturaFyH',
        "message": 'span-message-5' 
    },
    {
        "tab":6,
        "id": 'btn_ubicacionD',
        "message": 'span-message-6' 
    },
    {
        "tab":7,
        "id": 'btn_senasParticulares',
        "message": 'span-message-7' 
    },
    {
        "tab":8,
        "id": 'btn_entrevista',
        "message": 'span-message-8' 
    },
    {
        "tab":9,
        "id": 'btn_mediaF',
        "message": 'span-message-9' 
    },
    {
        "tab":10,
        "id": 'btn_narrativas',
        "message": 'span-message-10' 
    }
];

const getTabValidado = async(tab)=>{
    let myFormData = new FormData();
    myFormData.append('remision', remision.value);

    let response = await fetch(base_url + 'getTabsGuardados',{
        method: 'POST',
        body: myFormData
    });
    let data = await response.json();
    //console.log(data);
    const tabs_validados = data.tabs.tabs_validados.Reverse.split('');
    const tabs_guardados = data.data.tabs_guardados.Reverse.split('');
    let band = true;

    const level = parseInt(tabs_validados[tab])+parseInt(tabs_guardados[tab]);

    if(level === 2 && data.validacionRol != 'Admin'){
        band = false;
    }
    
    getTabsGuardados();
    
    return band;
}

const getTabsGuardados = ()=>{

    let myFormData = new FormData();
    myFormData.append('remision', remision.value);

    fetch(base_url + 'getTabsGuardados',{
        method: 'POST',
        body: myFormData
    })
    .then(res=>res.json())
    .then(data=>{

        const tabsGuardados = data.data.tabs_guardados.Reverse.split(''),
            tabsValidados = data.tabs.tabs_validados.Reverse.split(''),
            rol = data.validacionRol;

        if(tabsGuardados[0] === '1' && tabsGuardados[1] === '1' && tabsGuardados[2] === '1' && tabsGuardados[3] === '1'){
            if(rol === 'Admin' || rol === 'Validacion'){
                buttons.forEach(element => {
                    element.style.display = 'block'
                });
            }
        }

        tabsValidados.forEach((element, i) => {
            if(element === '1'){
                document.getElementById(`btn-tab-getIndex-${i}`).style.display = 'none';
                if(rol != 'Admin'){
                    if(document.getElementById(idButtonTab[i].id) != null){
                        document.getElementById(idButtonTab[i].id).style.display = 'none';
                    }
                    document.getElementById(idButtonTab[i].message).style.display = 'block';
                }
            }
        });
        

        tabsGuardados.forEach((element,i) => {
            const level = parseInt(element)+parseInt(tabsValidados[i]);
            drawCheckSaveValidateTab(level, i);
        });
    })
}

const drawCheckSaveValidateTab = (type, tab)=>{

    let div = document.getElementById(`check-tab-${tab}`);

    if(type === 2){
        div.innerHTML = `
            <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z"/>
                <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z"/>
            </svg>
        `;
    }else{
        if(type === 1){
            div.innerHTML = `
                <svg data-toggle="popover" data-content="Tab guardado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                </svg>
            `;
        }
    }
}