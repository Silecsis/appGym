<!--Vista de "listar tramos" desde admin.
        Es la vista que carga los tramos de la BBDD.
        Además, tendrá el campo de búsqueda.-->

<div class="listUser">
    <div class="identificar text-center">
        <h4> Tramos </h4>
    </div>
    <div class="buscarListUser">
        <fieldset class="scheduler-border">
            <legend  class="scheduler-border">
                <h2 class="blu">Apartado de búsqueda</h2>
            </legend>

            <form action="" method="GET" >
                <!--Daba fallos el action, por eso lo he metido con estos botones.-->
                <input type="hidden" name="controller" value="adminTramos"/>
                <input type="hidden" name="action" value="listTramos"/>
                <input type="hidden" name="pagina" value="<?php echo $_GET["pagina"] ?>"/>
                <input type="hidden" name="rxp" value="<?php echo $_GET["rxp"] ?>"/>

                <label class="blu">Día: 
                    <select name="dia" class="blu" <?php  ?>>
                        <option value="" <?php rememberValueSelect($_GET["dia"],"",$vacio) ?>>Todos</option>
                        <!--Recorremos la base de datos de dias para poner las opciones-->
                        <?php foreach ($days as $dd) :?>
                            <option value="<?php echo $dd["id"]?>" <?php rememberValueSelect($_GET["dia"],$dd["id"],$vacio) ?>> <?php echo $dd["dia"] ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="blu">Hora y minutos de inicio: 
                    <input name="hora_inicio" type="text" class="blu" <?php rememberValue($_GET["hora_inicio"],$vacio) ?>/>
                </label>
                <label class="blu">Hora y minutos de fin: 
                    <input name="hora_fin" type="text" class="blu" <?php rememberValue($_GET["hora_fin"],$vacio) ?>/>
                </label>
                <label class="blu">Actividad: 
                    <input name="actividad_id" type="text" class="blu" <?php rememberValue($_GET["actividad_id"],$vacio) ?>/>
                </label>
                <br>
                <input type="submit" name="submit" value="Buscar"  class="btn btn-primary"/>
            </form>
        </fieldset>
    </div>
    <div class="tablaListUser">
        <div class="input-group">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                    <!--Para ir a la página anterior, le restamos 1 a la pagina recibida por el get-->
                        <a class="page-link pag" href="index.php?controller=adminTramos&action=listTramos&pagina=<?php $pagAct=$_GET["pagina"]; if($pagAct>1){$pagAct=$pagAct-1;}else{$pagAct==1;}echo $pagAct."&rxp=".$_GET["rxp"].$url;?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Anterior</span>
                        </a>
                    </li>

                    <?php for ($i=1;$i<=$paginas;$i++): ?>
                    <li class="page-item">
                        <a class="page-link pag <?php if($_GET["pagina"]==$i){ echo "page-item-selected";}?>" href="index.php?controller=adminTramos&action=listTramos&pagina=<?php echo $i."&rxp=".$_GET["rxp"].$url?>"><?php echo $i ?></a></li>
                    <?php endfor ?>

                    <li class="page-item">
                        <a class="page-link pag" href="index.php?controller=adminTramos&action=listTramos&pagina=<?php $pagAct=$_GET["pagina"]; if($pagAct<$paginas){$pagAct=$pagAct+1;}else{$pagAct==$paginas;}echo $pagAct."&rxp=".$_GET["rxp"].$url;?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Siguiente</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle eleccionPag"
                        type="button" id="dropdownMenu1" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    <?php if(isset($_GET["rxp"])){ echo $_GET["rxp"];}else{ echo PAGE_SIZE;}?> registros x pág
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <a class="dropdown-item" href="index.php?controller=adminTramos&action=listTramos&pagina=1&rxp=2<?php echo $url ?>" >2 registros</a>
                    <a class="dropdown-item" href="index.php?controller=adminTramos&action=listTramos&pagina=1&rxp=6<?php echo $url ?>">6 registros</a>
                    <a class="dropdown-item" href="index.php?controller=adminTramos&action=listTramos&pagina=1&rxp=8<?php echo $url ?>">8 registros</a>
                    <a class="dropdown-item" href="index.php?controller=adminTramos&action=listTramos&pagina=1&rxp=10<?php echo $url ?>">10 registros</a>
                </div>
            </div>
            <?php if($_SESSION["usuario"]["rol_id"]==1){ ?>
                <div>
                    <a href="?controller=adminTramos&action=createTramos" class="btn btn-nuev " role="button"><i class="fas fa-plus-square fe"> Nuevo tramo</i></a>
                </div>
            <?php } ?>

        </div>
        <table id="tablePreview" class="table table-striped table-sm table-hover table-bordered tabalListUser">
            <thead class="listUser">
                <tr>
                    <th>ID</th>
                    <th>Día</th>
                    <th>Hora de inicio</th>
                    <th>Hora de fin</th>
                    <th>Actividad</th>
                    <th>Fecha de alta</th>
                    <th>Fecha de baja</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>  
                <!--Si no hay usuarios en la base de datos con lo establecido a buscar, se avisará al usuario.-->
            <?php if(isset($data["count"]) && $data["count"] == "0"){ ?>
                <tr>
                    <td colspan="12" class="errorTable">
                       No existe ningún tramo con los parámetros de busqueda indicados en nuestra base de datos . 
                    </td>
                </tr>
                <?php }else{ foreach ($data["tramos"] as $t) : ?>
                <tr>
                    <td><?= $t["id"]?></td>
                    <td>
                        <?php foreach ($days as $d) :
                                if($t["dia"]==$d["id"]){
                                    echo $d["dia"];
                                }
                            endforeach;
                        ?>
                    </td>
                    <td><?= $t["hora_inicio"] ?></td>
                    <td><?= $t["hora_fin"] ?></td>
                    <td>
                        <?php foreach ($activities as $a) :
                                if($t["actividad_id"]==$a["id"]){
                                    echo $a["nombre"];
                                }
                            endforeach;
                        ?>
                    </td>
                    <td><?= $t["fecha_alta"] ?></td>
                    <td><?php if($t["fecha_baja"]==null){echo "No hay fecha de baja";}?></td>
                    <td>
                        <a href="?controller=adminTramos&action=editTramos&id=<?= $t['id']."&rxp=".$_GET["rxp"] ?>" class="listUser"><i class="fas fa-edit"></i>Editar </a>
                        <a href="?controller=adminTramos&action=deleteTramos&id=<?= $t['id']."&rxp=".$_GET["rxp"].$url.'&pagina='.$_GET['pagina'] ?>" class="listUser"><i class="far fa-trash-alt"></i>Eliminar</a>
                    </td>
                </tr>
            <?php endforeach;} ?>
            </tbody>
        </table>
    </div>
</div>