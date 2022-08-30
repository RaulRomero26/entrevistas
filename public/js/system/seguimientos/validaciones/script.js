//Solo letras y espacios en blanco
function letrasyEspacios(e) 
{
    tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla == 8) 
    {
        return true;
    }

    if (tecla == 94) 
    {
    	return false;
    }

    // Patron de entrada, en este caso solo acepta numeros y letras
    patron = /[ñA-Za-z^\s]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

function soloNumeros(e) 
{
    tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla == 8) 
    {
        return true;
    }

    // Patron de entrada, en este caso solo acepta numeros
    patron = /[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

function soloLetras(e) 
{
    tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla == 8) 
    {
        return true;
    }

    if (tecla == 94) 
    {
    	return false;
    }

    // Patron de entrada, en este caso solo acepta letras (con la ñ)
    patron = /[ñA-Za-z]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

//Solo letras, numeros y espacios en blanco
function letrasNumerosyEspacios(e) 
{
    tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla == 8) 
    {
        return true;
    }

    if (tecla == 94) 
    {
    	return false;
    }

    // Patron de entrada, en este caso solo acepta numeros y letras
    //patron = /[ñA-Za-z0-9^\s^#]/;   //Permite #
    patron = /[ñA-Za-z0-9^\s^_./]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

//Con letras y numeros sin espacios en blanco
function letrasyNumeros(e) 
{
    tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla == 8) 
    {
        return true;
    }

    if (tecla == 94) 
    {
    	return false;
    }

    // Patron de entrada, en este caso solo acepta numeros y letras
    patron = /[ñA-Za-z0-9^\p{Zs}]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}