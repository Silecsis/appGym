<!--Vista de "listar actividades dirigidas" desde el admin.
        Es la vista que carga todas las actividades de la BBDD.
        Además, tendrá el campo de búsqueda.-->

<div class="listUser">
    <div class="identificar text-center">
        <h4> Actividades </h4>
    </div>
    <div class="buscarListAct">
        <fieldset class="scheduler-border">
            <legend  class="scheduler-border">
                <h2 class="blu">Apartado de búsqueda</h2>
            </legend>

            <form action="" method="GET" >
                <!--Daba fallos el action, por eso lo he metido con estos botones.-->
                <input type="hidden" name="controller" value="adminActivities"/>
                <input type="hidden" name="action" value="listActivities"/>
                <input type="hidden" name="pagina" value="<?php echo $_GET["pagina"] ?>"/>
                <input type="hidden" name="rxp" value="<?php echo $_GET["rxp"] ?>"/>

                <label class="blu">Nombre: 
                    <input name="nombre" type="text" class="blu" <?php rememberValue($_GET["nombre"],$vacio) ?>/>
                </label>

                <label class="blu">Descripción: 
                    <input name="descripcion" type="text" class="blu" <?php rememberValue($_GET["descripcion"],$vacio) ?>/>
                </label>

                <label class="blu">Aforo: 
                    <input name="aforo" type="text" class="blu" <?php rememberValue($_GET["aforo"],$vacio) ?>/>
                </label>
                <br>
                <input type="submit" name="submit" value="Buscar"  class="btn btn-primary"/>
            </form>
        </fieldset>
    </div> 
    <div class="tablaListActivities">

        <div class="input-group activity">            
            <nav aria-label="Page navigation example" class="pagAct">
                <ul class="pagination">
                    <li class="page-item">
                    <!--Para ir a la página anterior, le restamos 1 a la pagina recibida por el get-->
                        <a class="page-link pag" href="index.php?controller=adminActivities&action=listActivities&pagina=<?php $pagAct=$_GET["pagina"]; if($pagAct>1){$pagAct=$pagAct-1;}else{$pagAct==1;}echo $pagAct."&rxp=".$_GET["rxp"].$url;?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Anterior</span>
                        </a>
                    </li>

                    <?php for ($i=1;$i<=$paginas;$i++): ?>
                    <li class="page-item">
                        <a class="page-link pag <?php if($_GET["pagina"]==$i){ echo "page-item-selected";}?>" href="index.php?controller=adminActivities&action=listActivities&pagina=<?php echo $i."&rxp=".$_GET["rxp"].$url?>"><?php echo $i ?></a></li>
                    <?php endfor ?>

                    <li class="page-item">
                        <a class="page-link pag" href="index.php?controller=adminActivities&action=listActivities&pagina=<?php $pagAct=$_GET["pagina"]; if($pagAct<$paginas){$pagAct=$pagAct+1;}else{$pagAct==$paginas;}echo $pagAct."&rxp=".$_GET["rxp"].$url;?>" aria-label="Next">
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
                    <a class="dropdown-item" href="index.php?controller=adminActivities&action=listActivities&pagina=1&rxp=2<?php echo $url ?>" >2 registros</a>
                    <a class="dropdown-item" href="index.php?controller=adminActivities&action=listActivities&pagina=1&rxp=6<?php echo $url ?>">6 registros</a>
                    <a class="dropdown-item" href="index.php?controller=adminActivities&action=listActivities&pagina=1&rxp=8<?php echo $url ?>">8 registros</a>
                    <a class="dropdown-item" href="index.php?controller=adminActivities&action=listActivities&pagina=1&rxp=10<?php echo $url ?>">10 registros</a>
                </div>
            </div>
            <div>
                <a href="index.php?controller=adminActivities&action=createActivities" class="btn btn-nuev btn-nuevAct " role="button"><i class="fas fa-plus-square fe"> Nueva actividad</i></a>
            </div>
        </div>

        <table id="tablePreview" class="table table-striped table-sm table-hover table-bordered tablaListActivities">
            <thead class="listUser">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Aforo</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>  
                <!--Si no hay usuarios en la base de datos con lo establecido a buscar, se avisará al usuario.-->
            <?php if(isset($data["count"]) && $data["count"] == "0"){ ?>
                <tr>
                    <td colspan="12" class="errorTable">
                       No existe ninguna actividad con los parámetros de busqueda indicados en nuestra base de datos . 
                    </td>
                </tr>
            <?php }else{ foreach ($data["activities"] as $d) : ?>
                <tr>
                    <td><?= $d["id"]?></td>
                    <td><?= $d["nombre"] ?></td>
                    <td><?= $d["descripcion"] ?></td>
                    <td><?= $d["aforo"] ?></td>
                    <td>
                        <?php if($_SESSION['usuario']["rol_id"]==1){?>
                            <a href="?controller=adminActivities&action=editActivities&id=<?= $d['id']."&rxp=".$_GET["rxp"] ?>" class="listUser"><i class="fas fa-edit"></i>Editar </a>
                            <a href="?controller=adminActivities&action=deleteActivities&id=<?= $d['id']."&rxp=".$_GET["rxp"].$url.'&pagina='.$_GET['pagina'] ?>" class="listUser"><i class="far fa-trash-alt"></i>Eliminar</a>
                        <?php } ?>
                        
                    </td>
                </tr>
            <?php endforeach;} ?>
            </tbody>
        </table>
    </div>
</div>