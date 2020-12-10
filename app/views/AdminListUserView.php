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
            <?php if(isset($error) && $error === "count0"){ ?>
                <div class="alert alert-danger" style="margin-top:5px;"> 
                    No existe ningún usuario en nuestra base de datos con los parámetros de busqueda indicados.<br/> 
                </div>
                
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
                    <td class='<?php if ($d["estado"]=='0'){echo "inactivo";}else{echo "activo";} ?>'>
                        <?php 
                            //Si está activo, se mostrará un icono.
                            if ($d["estado"]=='1'){
                                echo "Activo";
                            }else{
                                echo "Inactivo";
                            }
                        ?>
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
                            <a href="?controller=adminUser&action=editUser&id=<?= $d['id'] ?>" class="listUser"><i class="fas fa-user-edit"></i>Editar </a>
                            <a href="?controller=adminUser&action=deleteUser&id=<?= $d['id'] ?>" class="listUser"><i class="fas fa-user-slash"></i>Eliminar</a>

                        <?php } ?>
                        
                    </td>
                </tr>
            <?php endforeach;} ?>
            </tbody>
        </table>
    </div>
</div>
