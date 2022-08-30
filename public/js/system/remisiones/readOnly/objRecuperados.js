const no_remision_obj = document.getElementById('no_remision_objetosRecuperados'),
    no_ficha_obj = document.getElementById('no_ficha_objetosRecuperados'),
    pathImagesObj = pathFilesRemisiones + `${no_ficha_obj.value}/ObjRecuperados/`,
    imageObjRecu = document.getElementById('obj-recuperados-image').style.display = 'block';

const getObjetosRecuperados = () => {

    var myFormData = new FormData();

    myFormData.append('no_remision', no_remision_obj.value);
    myFormData.append('no_ficha', no_ficha_obj.value);

    fetch(base_url + 'getObjetosRecuperados', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {

        // console.log('Only view')
        // console.log(data)

        const rowsTableArmas = data.armas;
        for (let i = 0; i < rowsTableArmas.length; i++) {
            let formData = {
                tipoArma: rowsTableArmas[i].Tipo_Arma,
                cantidadArmas: rowsTableArmas[i].Cantidad,
                descripcionArmas: rowsTableArmas[i].Descripcion_Arma
            }
            insertNewRowArma(formData, 'view');
        }

        const rowsTableDrogas = data.drogas;
        for (let i = 0; i < rowsTableDrogas.length; i++) {
            let formData = {
                tipoDroga: rowsTableDrogas[i].Tipo_Droga,
                cantidadDroga: rowsTableDrogas[i].Cantidad,
                unidadDroga: rowsTableDrogas[i].Unidad,
                descripcionDroga: rowsTableDrogas[i].Descripcion_Droga
            }
            insertNewRowDroga(formData, 'view');
        }

        const rowsTableObjetos = data.objetos;
        for (let i = 0; i < rowsTableObjetos.length; i++) {
            let formData = {
                descripcionOtros: rowsTableObjetos[i].Descripcion_Objeto
            }
            insertNewRowOtro(formData, 'view');
        }
        /* se añade la funcion para leer los vehiculos recuperados de la base de datos, solo para leer*/
        const rowsTableVehiculos = data.vehiculos;
        for (let i = 0; i < rowsTableVehiculos.length; i++) {
            let formData = {
                Tipo_Situacion_0: rowsTableVehiculos[i].Tipo_Situacion == 0 ? true:false,
                Tipo_Vehiculo: rowsTableVehiculos[i].Tipo_Vehiculo,
                Placa_Vehiculo: rowsTableVehiculos[i].Placa_Vehiculo,
                Marca: rowsTableVehiculos[i].Marca,
                Submarca: rowsTableVehiculos[i].Submarca,
                Modelo: rowsTableVehiculos[i].Modelo,
                Color: rowsTableVehiculos[i].Color,
                Senia_Particular: rowsTableVehiculos[i].Senia_Particular,
                No_Serie: rowsTableVehiculos[i].No_Serie,
                Procedencia_Vehiculo: rowsTableVehiculos[i].Procedencia_Vehiculo,
                Observacion_Vehiculo: rowsTableVehiculos[i].Observacion_Vehiculo,
            }
            
            insertNewRowVehiculo(formData, 'view');
        }


        // const rowsTableVehiculo = data.vehiculos;

        // if (rowsTableVehiculo.length > 0) {

        //     if (rowsTableVehiculo)

        //         for (let i = 0; i < rowsTableVehiculo.length; i++) {
        //         let formData = {
        //             OBJ_Tipo_Vehiculo: rowsTableVehiculo[i].Tipo_Vehiculo,
        //             OBJ_Placa_Vehiculo: rowsTableVehiculo[i].Placa_Vehiculo,
        //             OBJ_Marca: rowsTableVehiculo[i].Marca,
        //             OBJ_Modelo: rowsTableVehiculo[i].Modelo,
        //             OBJ_Year: rowsTableVehiculo[i].Year,
        //             OBJ_Color: rowsTableVehiculo[i].Color,
        //             OBJ_Senia_Particular: rowsTableVehiculo[i].Senia_Particular,
        //             OBJ_No_Serie: rowsTableVehiculo[i].No_Serie,
        //             OBJ_Observacion_Vehiculo: rowsTableVehiculo[i].Observacion_Vehiculo,
        //             OBJ_Fecha_Asegurado: rowsTableVehiculo[i].Fecha_Asegurado,
        //             OBJ_Hora_Asegurado: rowsTableVehiculo[i].Hora_Asegurado,
        //             OBJ_Hora_Arribo: rowsTableVehiculo[i].Hora_Arribo_Central,
        //             Colonia_objetos: rowsTableVehiculo[i].Colonia,
        //             Calle_1_objetos: rowsTableVehiculo[i].Calle_1,
        //             Calle_2_objetos: rowsTableVehiculo[i].Calle_2,
        //             cordY_objetos: rowsTableVehiculo[i].Coordenada_Y,
        //             cordX_objetos: rowsTableVehiculo[i].Coordenada_X,
        //             CP_objetos: rowsTableVehiculo[i].CP,
        //             Tipo_Situacion: rowsTableVehiculo[i].Tipo_Situacion,
        //             Forma_Aseguramiento: rowsTableVehiculo[i].Forma_Aseguramiento,
        //             No_Int: rowsTableVehiculo[i].No_Int,
        //             No_Ext: rowsTableVehiculo[i].No_Ext
        //         }
        //         insertNewRowVehiculo(formData, formData, 'view');
        //     }

        // }

        toDataUrl(pathImagesObj + data.image.Path_Objetos, function(myBase64) {
            createElementObjRecuperados(myBase64);
        });

    })
}