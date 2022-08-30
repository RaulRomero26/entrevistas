const remision = document.getElementById('no_remision_principales');

const getTabsValidados = ()=>{

    let myFormData = new FormData();
    myFormData.append('remision', remision.value);

    fetch(base_url + 'getTabsValidados',{
        method: 'POST',
        body: myFormData
    })
    .then(res=>res.json())
    .then(data=>{
        const bit = data.data.tabs_validados.Reverse;
        for(let i=0; i<bit.length;i++){
            if(bit[i] === '1'){
                document.getElementById('check-tab-'+i).style.display= 'block';
            }
        }
    })
}