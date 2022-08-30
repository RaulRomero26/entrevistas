<?php
$id_Inteligencia    = (isset($_GET['id_Inteligencia'])) ? $_GET['id_Inteligencia'] : '0';
?>
<input type="hidden" name="id_Inteligencia" id="id_Inteligencia" value=<?= $id_Inteligencia ?>>

<div class="container">
    <div class="paragraph-title d-flex justify-content-between mt-5 mb-4">
        <h5><a href="<?= base_url; ?>InteligenciaOperativa">Inteligencia Operativa</a><span> / Ver</span></h5>
    </div>

    <div class="row mt-5">
        <div class="form-group col-lg-4 text-center">
            <label for="zona" class="label-form">Nombre del elemento responsable:</label>
            <span class="valor-campo" id="Nombre_Elemento_R"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-4 text-center">
            <label for="zona" class="label-form">Responsable de turno:</label>
            <span class="valor-campo" id="Responsable_Turno"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-4 text-center">
            <label for="zona" class="label-form">Origen del evento:</label>
            <span class="valor-campo" id="Origen_Evento"></span>
            <span class="span_error" id="zona_error"></span>
        </div>

        <div class="form-group col-lg-4 text-center mt-3">
            <label for="zona" class="label-form">Fecha del turno:</label>
            <span class="valor-campo" id="Fecha_Turno"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-4 text-center mt-3">
            <label for="zona" class="label-form">Turno:</label>
            <span class="valor-campo" id="Turno"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-4 text-center mt-3">
            <label for="zona" class="label-form">Semana:</label>
            <span class="valor-campo" id="Semana"></span>
            <span class="span_error" id="zona_error"></span>
        </div>

        <div class="form-group col-lg-4 text-center mt-3">
            <label for="zona" class="label-form">Folio DERI:</label>
            <span class="valor-campo" id="Folio_Deri"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-4 text-center mt-3">
            <label for="zona" class="label-form">Fecha del evento:</label>
            <span class="valor-campo" id="Fecha_Evento"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-4 text-center mt-3">
            <label for="zona" class="label-form">Hora del reporte:</label>
            <span class="valor-campo" id="Hora_Reporte"></span>
            <span class="span_error" id="zona_error"></span>
        </div>

        <div class="form-group col-lg-3 text-center mt-3">
            <label for="zona" class="label-form">Motivo:</label>
            <span class="valor-campo" id="Motivo"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-3 text-center mt-3">
            <label for="zona" class="label-form">Caracteristicas del evento:</label>
            <span class="valor-campo" id="Caracteristicas_Robo"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-3 text-center mt-3">
            <label for="zona" class="label-form">Violencia:</label>
            <span class="valor-campo" id="Violencia"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-3 text-center mt-3">
            <label for="zona" class="label-form">Tipo de violencia:</label>
            <span class="valor-campo" id="Tipo_Violencia"></span>
            <span class="span_error" id="zona_error"></span>
        </div>

        <div class="col-12 text-center mt-5">
            <p class="form_title">Ubicación: </p>
        </div>

        <div class="form-group col-lg-6 text-center mt-3">
            <label for="zona" class="label-form">Colonia:</label>
            <span class="valor-campo" id="Colonia"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-6 text-center mt-3">
            <label for="zona" class="label-form">Calle:</label>
            <span class="valor-campo" id="Calle"></span>
            <span class="span_error" id="zona_error"></span>
        </div>

        <div class="form-group col-lg-3 text-center mt-3">
            <label for="zona" class="label-form">Núm. de Interior:</label>
            <span class="valor-campo" id="noInterior"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-3 text-center mt-3">
            <label for="zona" class="label-form">Núm. de Exterior:</label>
            <span class="valor-campo" id="noExterior"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-3 text-center mt-3">
            <label for="zona" class="label-form">Coordenada Y:</label>
            <span class="valor-campo" id="cordY"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-3 text-center mt-3">
            <label for="zona" class="label-form">Coordenada X:</label>
            <span class="valor-campo" id="cordX"></span>
            <span class="span_error" id="zona_error"></span>
        </div>

        <div class="form-group col-lg-6 text-center mt-3">
            <label for="zona" class="label-form">Municipio:</label>
            <span class="valor-campo" id="Municipio"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-6 text-center mt-3">
            <label for="zona" class="label-form">Código Postal:</label>
            <span class="valor-campo" id="CP"></span>
            <span class="span_error" id="zona_error"></span>
        </div>

        <div class="form-group col-lg-6 text-center mt-5">
            <label for="zona" class="label-form">Zona del evento:</label>
            <span class="valor-campo" id="Zona_Evento"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-6 text-center mt-5">
            <label for="zona" class="label-form">Vector:</label>
            <span class="valor-campo" id="Vector"></span>
            <span class="span_error" id="zona_error"></span>
        </div>


        <div class="col-lg-12">
            <table class="table table-bordered" id="camarasIO">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Ubicación de la cámara respecto al evento</th>
                        <th scope="col">¿La cámara funciona?</th>
                        <th scope="col">Tipo</th>
                    </tr>
                </thead>
                <tbody class="text-uppercase">
                </tbody>
            </table>
        </div>

        <div class="form-group col-lg-6 text-center mt-5">
            <label for="zona" class="label-form">Unidad del primer respondiente:</label>
            <span class="valor-campo" id="Unidad_Primer_R"></span>
            <span class="span_error" id="zona_error"></span>
        </div>

        <div class="form-group col-lg-6 text-center mt-5">
            <label for="zona" class="label-form">Información del primer respondiente:</label>
            <span class="valor-campo" id="Informacion_Primer_R"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-6 text-center mt-5">
            <label for="zona" class="label-form">Acciones:</label>
            <span class="valor-campo" id="Acciones"></span>
            <span class="span_error" id="zona_error"></span>
        </div>



        <div class="form-group col-lg-6 text-center mt-5">
            <label for="zona" class="label-form">¿Se identificarón responsables?</label>
            <span class="valor-campo" id="Identificacion_Responsables"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-6 text-center mt-5">
            <label for="zona" class="label-form">¿Detención por información de I.O?</label>
            <span class="valor-campo" id="Detencion_Por_Info_Io"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-6 text-center mt-5">
            <label for="zona" class="label-form">Elementos que realizan la detención:</label>
            <span class="valor-campo" id="Elementos_Realizan_D"></span>
            <span class="span_error" id="zona_error"></span>
        </div>

        <div class="form-group col-lg-6 text-center mt-5">
            <label for="zona" class="label-form">Fecha de detención:</label>
            <span class="valor-campo" id="Fecha_Detencion"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-6 text-center mt-5">
            <label for="zona" class="label-form">Compañía:</label>
            <span class="valor-campo" id="Compania"></span>
            <span class="span_error" id="zona_error"></span>
        </div>

        <div class="col-12 text-center mt-5">
            <p class="form_title">Zona de aseguramiento: </p>
        </div>

        <div class="form-group col-lg-6 text-center mt-3">
            <label for="zona" class="label-form">Colonia:</label>
            <span class="valor-campo" id="Colonia_1"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-6 text-center mt-3">
            <label for="zona" class="label-form">Calle:</label>
            <span class="valor-campo" id="Calle_1"></span>
            <span class="span_error" id="zona_error"></span>
        </div>

        <div class="form-group col-lg-3 text-center mt-3">
            <label for="zona" class="label-form">Núm. de Interior:</label>
            <span class="valor-campo" id="noInterior_1"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-3 text-center mt-3">
            <label for="zona" class="label-form">Núm. de Exterior:</label>
            <span class="valor-campo" id="noExterior_1"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-3 text-center mt-3">
            <label for="zona" class="label-form">Coordenada Y:</label>
            <span class="valor-campo" id="cordY_1"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-3 text-center mt-3">
            <label for="zona" class="label-form">Coordenada X:</label>
            <span class="valor-campo" id="cordX_1"></span>
            <span class="span_error" id="zona_error"></span>
        </div>

        <div class="form-group col-lg-6 text-center mt-3">
            <label for="zona" class="label-form">Municipio:</label>
            <span class="valor-campo" id="Municipio_1"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <div class="form-group col-lg-6 text-center mt-3">
            <label for="zona" class="label-form">Código Postal:</label>
            <span class="valor-campo" id="CP_1"></span>
            <span class="span_error" id="zona_error"></span>
        </div>

        <div class="form-group col-lg-12" id="viewPDFIPH">
        </div>

        <div class="col-12" id="RenderPDF"></div>

        <div class="col-12 text-center mt-5">
            <p class="form_title">Vehículos relacionados: </p>
        </div>

        <table class="table mb-5 table-bordered" id="seguimientoVehiculosPer">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Color</th>
                    <th scope="col">Identificación de placa</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Uso del vehículo</th>
                    <th scope="col">Involucrado/Robado</th>
                    <th scope="col">Características del vehículo</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody class="text-uppercase">
            </tbody>
        </table>
    </div>
</div>