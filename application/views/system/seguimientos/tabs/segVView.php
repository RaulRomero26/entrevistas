<div class="container mt-5 mb-3">
    <div class="row mt-5">
        <div class="col-6 col-lg-auto mr-lg-auto my-2 my-lg-auto  d-flex justify-content-center">
            <!-- Button trigger modal -->
                <button type="button" class="btn btn-filtro" data-toggle="dropdown" id="id_filtros2">
                    <i class="material-icons md-30 v-a-middle" >filter_alt</i><br>
                    <span class="v-a-middle" >Filtros</span>
                </button>
            <!--Dropdown filter content-->
                <div class="dropdown-menu" aria-labelledby="id_filtros2">
                    <a class="dropdown-item <?= ($data['filtroActual2']==1)?'active':'';?>" href="<?= base_url;?>Seguimientos/index/?filtro2=1">Vista general</a>
                    <div class="dropdown-divider"></div>
                        <a class="dropdown-item <?= ($data['filtroActual2']==11)?'active':'';?>" href="#" class="btn btn-filtro" data-toggle="modal" data-target="#filtro_rangos_2">
                        <span class="v-a-middle" >Por rango de fechas</span>
                        </a>
                </div>
        </div>

        <div class="col-6 col-lg-auto mr-lg-auto my-2 my-lg-auto d-flex justify-content-center">
            <!-- Button trigger modal -->
                <button type="button" class="btn btn-filtro" data-toggle="dropdown" id="columnas_filtro2">
                    <i class="material-icons md-30 v-a-middle" >table_chart</i>
                    <span class="v-a-middle" >Columnas</span>
                </button>
            <!--Dropdown filter content-->
                <div id="id_dropdownColumns2" class="dropdown-menu" aria-labelledby="columnas_filtro2">
                            <?= $data['dropdownColumns2'];?>
                </div>
        </div>
                

        <div class="col-12 col-lg-auto mr-lg-auto my-2 my-lg-auto  d-flex justify-content-center">
            <?php $cadena2 = (isset($data['cadena2'])) ? $data['cadena2'] : ""; ?>
                <div class="input-group">
                    <input id="id_search2" type="search" name="busqueda2" value="<?= $cadena2; ?>" id="busqueda2" class="form-control py-2 border-right-0 border" placeholder="Buscar" required="required" aria-describedby="button-addon2" onkeyup="return checarCadena2(event)" onchange="return checarCadena2(event)">
                    <span class="input-group-append">
                    <div id="search_button2" class="input-group-text bg-transparent"><i class="material-icons md-18 ssc search" id="filtro2">search</i></div>
                                        </span>
                </div>
        </div>


        <div class="col-6 col-lg-auto mr-lg-auto my-auto  d-flex justify-content-center" id="id_total_rows2">
            Total registros: <?= (isset($data['total_rows2']))?$data['total_rows2']:"null";?>
        </div>
        <div class="col-6 col-lg-auto mr-lg-auto my-2 my-lg-auto d-flex justify-content-center">
            <div id="buttonsExport">
                <?php 
                    $cadenaExport2 = (isset($data['cadena2'])) ? ("&cadena2=" . $data['cadena2']) : "";
                    $filtroActual2 = "&filtroActual2=".$data['filtroActual2'];
                ?>

                <a id="id_link_excel2" href="<?= base_url ?>Seguimientos/exportarInfoSV/?tipo_export2=<?= "EXCEL" . $cadenaExport2; ?>" class="btn" data-toggle="tooltip" data-placement="bottom" title="Exportar a Excel">
                    <i class="material-icons ssc md-36">description</i>
                </a>
                <a id="id_link_pdf2" href="<?= base_url ?>Seguimientos/exportarInfoSV/?tipo_export2=<?= "PDF" . $cadenaExport2; ?>" target="_blank" class="btn" data-toggle="tooltip" data-placement="bottom" title="Exportar a PDF">
                    <i class="material-icons ssc md-36">picture_as_pdf</i>
                </a>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center mt-3">
        <div class="col-auto">
            <span>Filtro: </span>
            <div class="chip">
                <span class="v-a-middle" >
                    <?php
                        if (isset($_SESSION['userdata']->rango_inicio_sv))
                        {
                            $r_inicio = $_SESSION['userdata']->rango_inicio_sv;
                            $r_fin = $_SESSION['userdata']->rango_fin_sv;
                            echo (isset($data['filtroNombre2']))?$data['filtroNombre2']." | Rangos de (".$r_inicio.") a (".$r_fin.")":"Vista general #2";  
                        }
                        else
                        {
                            echo (isset($data['filtroNombre2']))?$data['filtroNombre2']:"Vista general #3";
                        }
                                            
                    ?>
                </span>
            </div>            
        </div>
        <?php
            if (isset($_SESSION['userdata']->rango_inicio_sv)) {
        ?>
        <a class="btn btn-opacity" href="<?= base_url;?>Seguimientos/removeRangosFechasSesionSV/?filtroActual2=<?= $data['filtroActual2'];?>">mostrar todo</a>
        <?php
            }
        ?>
    </div>  
</div>

<!-- Tabla con la información -->
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-auto">
            <table class="table table-responsive mt-2">
                <thead class="thead-myTable text-center">
                    <tr id="id_header2">
                        
                        <?= $data['infoTable2']['header'];?>
                    </tr>
                </thead>
                <tbody id="id_tbody2">
                    <?php
                    //se imprime todos los registros tabulados de la consulta
                    echo $data['infoTable2']['body'];
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--Despliegue de Links de Pagination-->
<div class="container mt-3 mb-5">
    <div class="row d-flex justify-content-center">
        <div class="col-auto">
            <nav aria-label="Page navigation example ">
                <ul id="id_pagination2" class="pagination">
                    <?php
                    echo $data['links2'];
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Modals content-->
<div class="modal fade" id="filtro_rangos_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title-width" id="exampleModalLabel">Filtrar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="material-icons">close</i>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="form_rangos2" class="row filter-content mb-3" method="post" action="<?= base_url;?>Seguimientos/index/?filtro2=<?= $data['filtroActual2']?>">
                        <div class="col-3">
                            <h6>Rango de folios</h6>
                        </div>
                        <div class="col-9">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group input-group-sm">
                                        <input type="date" class="form-control" id="id_date_21" name="rango_inicio_sv" aria-describedby="fecha_filtro_1" required>
                                        <small id="fecha_filtro_21" class="form-text text-muted">Fecha inicio</small>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group input-group-sm">
                                        <input type="date" class="form-control" id="id_date_22" name="rango_fin_sv" aria-describedby="fecha_filtro_2" required>
                                        <small id="fecha_filtro_22" class="form-text text-muted">Fecha fin</small>
                                    </div>
                                </div>
                            </div>       
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>
                <button type="button" class="btn btn-primary" onclick="return aplicarRangos2()">Aplicar</button>
            </div>
        </div>
    </div>
</div>

<!--Input de filtro para Fetch busqueda por cadena-->
<input id="filtroActual2" type="hidden" value="<?= $data['filtroActual2']?>">



