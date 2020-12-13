<!--Vista de "listar usuario" desde el admin.
        Es la vista que carga todos los usuarios de la BBDD.
        Además, tendrá el campo de búsqueda.-->

<div class="listUser">
    <div class="buscarListUser">
        <fieldset class="scheduler-border">
            <legend  class="scheduler-border">
                <h2 class="blu">Apartado de búsqueda</h2>
            </legend>

            <form action="" method="GET" >
                <!--Daba fallos el action, por eso lo he metido con estos botones.-->
                <input type="hidden" name="controller" value="adminUser"/>
                <input type="hidden" name="action" value="listUser"/>
                <input type="hidden" name="pagina" value="<?php echo $_GET["pagina"] ?>"/>
                <input type="hidden" name="rxp" value="<?php echo $_GET["rxp"] ?>"/>

                <label class="blu">NIF: 
                    <input name="nif" type="text" class="blu" <?php rememberValue($_GET["nif"],$vacio) ?>/>
                </label>
                <label class="blu">Nombre: 
                    <input name="nombre" type="text" class="blu" <?php rememberValue($_GET["nombre"],$vacio) ?>/>
                </label>
                <label class="blu">Apellidos: 
                    <input name="apellidos" type="text" class="blu" <?php rememberValue($_GET["apellidos"],$vacio) ?>/>
                </label>
                <label class="blu">Email: 
                    <input name="email" type="text" class="blu" <?php rememberValue($_GET["email"],$vacio) ?>/>
                </label>
                <br>
                <label class="blu">Telefono: 
                    <input name="telefono" type="text" class="blu" <?php rememberValue($_GET["telefono"],$vacio) ?>/>
                </label>
                <label class="blu">Dirección: 
                    <input name="direccion" type="text" class="blu" <?php rememberValue($_GET["direccion"],$vacio) ?>/>
                </label>
                <label class="blu">Estado: 
                    <select name="estado" class="blu" <?php  ?>>
                        <option value="" <?php rememberValueSelect($_GET["estado"],"",$vacio) ?>>Todos</option>
                        <option value="1" <?php rememberValueSelect($_GET["estado"],"1",$vacio) ?>>Activo</option>
                        <option value="0" <?php rememberValueSelect($_GET["estado"],"0",$vacio) ?>>Inactivo</option>
                    </select>
                </label>
                <label class="blu">Rol: 
                    <select name="rol" class="blu">
                        <option value="" <?php rememberValueSelect($_GET["rol"],"",$vacio) ?>>Todos</option>
                        <option value="1" <?php rememberValueSelect($_GET["rol"],"1",$vacio) ?>>Administrador</option>
                        <option value="2" <?php rememberValueSelect($_GET["rol"],"2",$vacio) ?>>Socio</option>
                    </select>
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
                        <a class="page-link pag" href="index.php?controller=adminUser&action=listUser&pagina=<?php $pagAct=$_GET["pagina"]; if($pagAct>1){$pagAct=$pagAct-1;}else{$pagAct==1;}echo $pagAct."&rxp=".$_GET["rxp"].$url;?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Anterior</span>
                        </a>
                    </li>

                    <?php for ($i=1;$i<=$paginas;$i++): ?>
                    <li class="page-item">
                        <a class="page-link pag <?php if($_GET["pagina"]==$i){ echo "page-item-selected";}?>" href="index.php?controller=adminUser&action=listUser&pagina=<?php echo $i."&rxp=".$_GET["rxp"].$url?>"><?php echo $i ?></a></li>
                    <?php endfor ?>

                    <li class="page-item">
                        <a class="page-link pag" href="index.php?controller=adminUser&action=listUser&pagina=<?php $pagAct=$_GET["pagina"]; if($pagAct<$paginas){$pagAct=$pagAct+1;}else{$pagAct==$paginas;}echo $pagAct."&rxp=".$_GET["rxp"].$url;?>" aria-label="Next">
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
                    <a class="dropdown-item" href="index.php?controller=adminUser&action=listUser&pagina=1&rxp=2<?php echo $url ?>" >2 registros</a>
                    <a class="dropdown-item" href="index.php?controller=adminUser&action=listUser&pagina=1&rxp=6<?php echo $url ?>">6 registros</a>
                    <a class="dropdown-item" href="index.php?controller=adminUser&action=listUser&pagina=1&rxp=8<?php echo $url ?>">8 registros</a>
                    <a class="dropdown-item" href="index.php?controller=adminUser&action=listUser&pagina=1&rxp=10<?php echo $url ?>">10 registros</a>
                </div>
            </div>
            
            <div>
                <a href="index.php?controller=adminUser&action=createUser" class="btn btn-nuev " role="button"><i class="fas fa-plus-square fe"> Nuevo usuario</i></a>
            </div>

        </div>
        <table id="tablePreview" class="table table-striped table-sm table-hover table-bordered tabalListUser">
            <thead class="listUser">
                <tr>
                    <th>ID</th>
                    <th>NIF</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Telefono</th>
                    <th>Dirección</th>
                    <th>Estado</th>
                    <th>Img</th>
                    <th>Rol</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>  
                <!--Si no hay usuarios en la base de datos con lo establecido a buscar, se avisará al usuario.-->
            <?php if(isset($data["count"]) && $data["count"] == "0"){ ?>
                <tr>
                    <td colspan="12" class="errorTable">
                       No existe ningún usuario con los parámetros de busqueda indicados en nuestra base de datos . 
                    </td>
                </tr>
            <?php }else{ foreach ($data["users"] as $d) : ?>
                <tr>
                    <td><?= $d["id"]?></td>
                    <td><?= $d["nif"] ?></td>
                    <td><?= $d["nombre"] ?></td>
                    <td><?= $d["apellidos"] ?></td>
                    <td><?= $d["email"] ?></td>
                    <td><?= $d["password"] ?></td>
                    <td><?= $d["telefono"] ?></td>
                    <td><?= $d["direccion"] ?></td>
                    <td class='<?php if ($d["estado"]=='0'){echo "inactivo";}else{echo "activo";} ?>'><!--Este es para el estilo-->

                        <!--Se pondrá un botón para desactivar o activar en caso de que no sea el propio usuario logueado-->
                        <?php if($d['id'] != $_SESSION['usuario']["id"]){  if ($d["estado"]=='1'){ ?>
                            <button type="button" class="btn btn-secondary activate" onclick="location.href='?controller=adminUser&action=changeStatusUser&id=<?= $d['id'].'&estadoACambiar=0'.$url.'&pagina='.$_GET['pagina'] ?>'">Desactivar</button>
                        <?php }else{ ?>
                                <button type="button" class="btn btn-secondary activate" onclick="location.href='?controller=adminUser&action=changeStatusUser&id=<?= $d['id'].'&estadoACambiar=1'.$url.'&pagina='.$_GET['pagina'] ?>'">Activar</button>
                        <?php }} ?>
                    </td>
                    <td><img  class="avatar" src="assets/img/avatarsUsers/<?= $d["imagen"] ?>"></td>
                    <td>
                        <?php 
                            //Es un usuario, aparece el icono de usuario. Sino, el de admin.
                            if ($d["rol_id"]=='2'){
                                echo "<i class='fas fa-user'></i>";
                            }else{
                                echo "<i class='fas fa-user-tie'></i>";
                            }
                        ?>
                    </td>
                    <td>
                        <?php if($d['id'] != $_SESSION['usuario']["id"]){?>
                            <a href="?controller=adminUser&action=editUser&id=<?= $d['id']."&rxp=".$_GET["rxp"] ?>" class="listUser"><i class="fas fa-user-edit"></i>Editar </a>
                            <a href="?controller=adminUser&action=deleteUser&id=<?= $d['id']."&rxp=".$_GET["rxp"].$url.'&pagina='.$_GET['pagina'] ?>" class="listUser"><i class="fas fa-user-slash"></i>Eliminar</a>

                        <?php } ?>
                        
                    </td>
                </tr>
            <?php endforeach;} ?>
            </tbody>
        </table>
    </div>
</div>
