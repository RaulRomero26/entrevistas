<div class="container">

    <div class="paragraph-title d-flex justify-content-between mt-5 mb-4">
        <h5>Fichas</h5>
        <div>
            <a href="" class="btn btn-opacity">Nueva ficha</a>
        </div>
    </div>

    <!--<div class="row">
        <div class="col-12 div_mark my-4 shadow d-flex justify-content-around align-items-center ">
            <div class="row text-center w-100">
                <a href="" class="col-3">
                    <div class="remision_banner">
                        <p class="title">Pendientes</p>
                        <p class="subtitle">10 remisiones </p>
                    </div>
                </a>
                <a href="" class="col-3">
                    <div class="remision_banner">
                        <p class="title">Finalizadas</p>
                        <p class="subtitle">10 remisiones </p>
                    </div>
                </a>
                <a href="" class="col-3">
                    <div class="remision_banner">
                        <p class="title">Activas</p>
                        <p class="subtitle">10 remisiones </p>
                    </div>
                </a>
                <a href="" class="col-3">
                    <div class="">
                        <p class="title">Canceladas</p>
                        <p class="subtitle">10 remisiones </p>
                    </div>
                </a>
            </div>
        </div>
    </div> -->

    <!--<div class="row filters mt-4">
        <div class="col-md-3 d-flex justify-content-center">
            <div class="justify-content-center align-items-center mr-5">
                <a href="" data-toggle="modal" data-target="#filtros_1">
                    <i class="material-icons ssc md-30 " id="filtro_1" data-toggle="modal" data-placement="bottom" title="Filtros">filter_alt</i>
                    <span class="ml-2">Filtros</span>
                </a>
            </div>
            <div class="justify-content-center align-items-center dropdown">
                <a href="" id="dropdownMenuButton" data-toggle="dropdown">

                    <i class="material-icons md-30 ssc" id="filtro_2" data-toggle="modal" data-placement="bottom" title="Columnas" data-target="#filtros_2">table_chart</i>

                    <span class="ml-2">Columnas</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                            Columna 2
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                            Columna 2
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                            Columna 3
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 d-flex justify-content-around align-items-center">
            <div class="input-group input-group-sm">
                <input type="search" name="busqueda" value="" id="busqueda" class="form-control py-2 border-right-0 border" placeholder="Buscar" required="required" aria-describedby="button-addon2" onkeypress="return soloNumeros(event)" />
                <span class="input-group-append">
                    <div id="search" class="input-group-text bg-transparent"><i class="material-icons md-18 ssc search" id="filtro">search</i></div>
                </span>
            </div>
        </div>
        <div class="col-md-2 d-flex align-items-center">
            <div class="label-select">
                <input type="hidden" name="category" value="">
                <button type="submit" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p class="mr-5">Etiqueta</p>
            </div>
        </div>
        <div class="col-md-3 d-flex justify-content-around align-items-center">
            <p>320 resultados</p>
            <button class="btn btn-primary">
                <i class="far fa-file-excel"></i>
            </button>
            <button class="btn btn-primary">
                <i class="far fa-file-pdf"></i>
            </button>
        </div>
    </div>
-->
    <div class="row filters mt-5 mb-5 text-center">
        <div class="col-md-3  col-sm-6 d-flex justify-content-center align-items-center pointer mt-4" >
            <i class="material-icons md-30 ssc" data-toggle="modal" data-target="#filtros_1">filter_alt</i>
            <span class="mr-3" data-toggle="modal" data-target="#filtros_1">Filtros</span>

            <i class="material-icons md-30 ssc " id="dropdownMenuButton" id="dropdownMenuButton" data-toggle="dropdown">table_chart</i>
            <span class="ml-2" id="dropdownMenuButton" data-toggle="dropdown">Columnas</span>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Columna 2
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Columna 2
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Columna 3
                    </label>
                </div>
            </div>
        </div>



        <div class="col-md-4 col-sm-12  d-flex justify-content-center align-items-center mt-4">
            <div class="input-group input-group-sm">
                <input type="search" name="busqueda" value="" id="busqueda" class="form-control py-2 border-right-0 border" placeholder="Buscar" required="required" aria-describedby="button-addon2" onkeypress="return soloNumeros(event)" />
                <span class="input-group-append">
                    <div id="search" class="input-group-text bg-transparent"><i class="material-icons md-18 ssc search" id="filtro">search</i></div>
                </span>
            </div>
        </div>

        <div class="col-md-2 col-sm-12 d-flex justify-content-center align-items-center mt-4">
            <div class="label-select">
                <input type="hidden" name="category" value="">
                <button type="submit" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p class="mr-5">Etiqueta</p>
            </div>
        </div>


        <div class="col-md-3  col-sm-12 d-flex justify-content-around align-items-center ml-n1 mt-4">
            <p>320 resultados</p>
            <i class="material-icons ssc md-30  pointer" data-toggle="tooltip" data-placement="bottom" title="Exportar a Excel">description</i>
            <i class="material-icons ssc md-30 ml-3 pointer" data-toggle="tooltip" data-placement="bottom" title="Exportar a PDF">picture_as_pdf</i>
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-12">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <th scope="row">4</th>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <th scope="row">5</th>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <th scope="row">6</th>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">7</th>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">8</th>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">9</th>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">10</th>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>

    <nav aria-label="Page navigation example ">
        <ul class="pagination justify-content-center mb-5">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Anterior</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Siguiente</a>
            </li>
        </ul>
    </nav>


    <!-- Modal Filtros-->
    <div class="modal fade" id="filtros_1" tabindex="-1" aria-labelledby="filtros_1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="filtros_1">Filtros</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mt-3">
                            <div class="col-4">
                                <span class="modal-span">Por autoridad</span>
                            </div>

                            <div class="col-8">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="autoridad_1">
                                    <label class="custom-control-label" for="autoridad_1">Autoridad 1</label>
                                </div>

                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="autoridad_2">
                                    <label class="custom-control-label" for="autoridad_2">Autoridad 2</label>
                                </div>

                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="autoridad_3">
                                    <label class="custom-control-label" for="autoridad_3">Autoridad 3</label>
                                </div>

                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="autoridad_4">
                                    <label class="custom-control-label" for="autoridad_4">Autoridad 4</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="autoridad_5">
                                    <label class="custom-control-label" for="autoridad_5">Autoridad 5</label>
                                </div>

                            </div>

                            <div class="col-12 mt-4 mb-4">
                                <div class="dropdown-divider"></div>
                            </div>

                            <div class="col-4">
                                <span class="modal-span">Por estatus</span>
                            </div>

                            <div class="col-8">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="estatus_1">
                                    <label class="custom-control-label" for="estatus_1">Estatus 1</label>
                                </div>

                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="estatus_2">
                                    <label class="custom-control-label" for="estatus_2">Estatus 2</label>
                                </div>

                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="estatus_3">
                                    <label class="custom-control-label" for="estatus_3">Estatus 3</label>
                                </div>

                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="estatus_4">
                                    <label class="custom-control-label" for="estatus_4">Estatus 4</label>
                                </div>
                            </div>


                            <div class="col-12 mt-4 mb-4">
                                <div class="dropdown-divider"></div>
                            </div>

                            <div class="col-4">
                                <span class="modal-span">Por rango de folios</span>
                            </div>

                            <div class="col-4">
                                <div class="form-group input-group-sm">
                                    <input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    <small id="emailHelp" class="form-text text-muted">Inicio</small>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group input-group-sm">
                                    <input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?= date("Y-m-d") ?>">
                                    <small id="emailHelp" class="form-text text-muted">Fin</small>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="mx-auto"><button type="button" class="btn btn-ssc btn_1 btn-sm">Aplicar</button></div>
                </div>
            </div>
        </div>
    </div>

    <div id="content_popovers">


    </div>





</div>