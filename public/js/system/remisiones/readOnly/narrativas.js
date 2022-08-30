const narrativaPeticionario = document.getElementById('narrativaPeticionario'),
    narrativaElementos = document.getElementById('narrativaElementos'),
    narrativaDetenido = document.getElementById('narrativaDetenido'),
    extractoIPH = document.getElementById('extractoIPH'),
    no_remision_narrativas = document.getElementById('no_remision_narrativas'),
    no_ficha_narrativas = document.getElementById('no_ficha_narrativas'),
    cdiFolioJC = document.getElementById('cdiFolioJC'),
    pathFileIPH = pathFilesRemisiones+`${no_ficha_narrativas.value}/IPH/${no_remision_narrativas.value}/`;

const getNarrativas = ()=>{ 
    var myFormData  =  new FormData()
    myFormData.append('no_remision', no_remision_narrativas.value);
    myFormData.append('no_ficha', no_ficha_narrativas.value);

    fetch(base_url + 'getNarrativas', {
        method: 'POST',
        body: myFormData
    })

    .then (res => res.json())

    .then( data => {
        
        narrativaPeticionario.innerText = (data.peticionario.Narrativa_Hechos === undefined || data.peticionario.Narrativa_Hechos === null ) ? 'NA' : data.peticionario.Narrativa_Hechos.toUpperCase();
        narrativaElementos.innerText = (data.elemento.Narrativa_Hechos === undefined || data.elemento.Narrativa_Hechos === null) ? 'NA' : data.elemento.Narrativa_Hechos.toUpperCase();
        narrativaDetenido.innerText = (data.detenido.Narrativa_Hechos === undefined || data.detenido.Narrativa_Hechos === null) ? 'NA' : data.detenido.Narrativa_Hechos.toUpperCase();
        extractoIPH.innerText = (data.iph.Extracto_IPH === undefined || data.iph.Extracto_IPH === null) ? 'NA' : data.iph.Extracto_IPH.toUpperCase();
        cdiFolioJC.innerText = (data.iph.CDI === undefined || data.iph.CDI === null) ? 'NA' : data.iph.CDI.toUpperCase();

        if(data.iph.Path_IPH != null){
            document.getElementById('viewPDFIPH').innerHTML = `
                <embed src="${pathFileIPH+data.iph.Path_IPH}" width="100%" height="400"  type="application/pdf">
            `;
        }

    })
}