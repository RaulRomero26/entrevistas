window.onload = function() {

    let online = window.navigator.onLine;
    if (!online) {
        offlineMapsPrincipal();
    }
}


// Si pulsamos tecla en un Input
$("input").keydown(function(e) {
    // Capturamos qué telca ha sido
    var keyCode = e.which;
    // Si la tecla es el Intro/Enter
    if (keyCode == 13) {
        // Evitamos que se ejecute eventos
        event.preventDefault();
        // Devolvemos falso
        return false;
    }
});

$(".form-control").keypress(function(key) {
    if (
        key.charCode === 180 || //´
        key.charCode === 225 || //á
        key.charCode === 193 || //Á
        key.charCode === 233 || //é
        key.charCode === 201 || //É
        key.charCode === 237 || //í
        key.charCode === 205 || //Í
        key.charCode === 243 || //ó
        key.charCode === 211 || //Ó
        key.charCode === 250 || //ú
        key.charCode === 218 //Ú
    ) {
        return false;
    }
});

const quitandoAcento = (letra) => {
    const acentos = { 'á': 'a', 'é': 'e', 'í': 'i', 'ó': 'o', 'ú': 'u', 'Á': 'A', 'É': 'E', 'Í': 'I', 'Ó': 'O', 'Ú': 'U' };
    return cadena.split('').map(letra => acentos[letra] || letra).join('').toString();
}

var btn = document.getElementById('btm_p')

document.getElementById('ext_1').style.visibility = 'visible'
if (document.getElementById('ext_2') != null) {
    document.getElementById('ext_2').style.visibility = 'visible'
}

$('input[name=dp_ocultar_mostrar]').click(function() {
    if (this.value == 0) {
        document.getElementById('ext_1').style.visibility = 'hidden'
        document.getElementById('ext_2').style.visibility = 'hidden'
        btn.style.marginTop = '500px'


    } else {
        document.getElementById('ext_1').style.visibility = 'visible'
        document.getElementById('ext_2').style.visibility = 'visible'
    }
});


$('#fileIPH').change(function(e) {

    var fileName = $(this).val().split("\\").pop();
    console.log(fileName);
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

const zonaSector = (show, hide) => {
    document.getElementById(show).style.display = 'block';
    document.getElementById(hide).style.display = 'none';
    document.getElementById(show).disabled = true;
    document.getElementById(hide).disabled = false;
}

/*solo números*/
function soloNumeros(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    // Patron de entrada, en este caso solo acepta numeros
    patron = /[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

function ventanaSecundaria(URL) {
    window.open(URL, '_blank', "width=500,height=500,scrollbars=YES,centerscreen")
}