<!--Vista de "editar usuario" desde el admin.
        Es la vista del formulario de editar el usario desde la lista de usuarios y
        es la vista de "nuevo usuario".-->

<div class="formAdminEU">
    <div class="container cuerpo text-center">
        <?php if(isset($_GET["id"])){ ?>	
            <p><h2>Editar usuario con id <?php echo $_GET["id"]?></h2></p>
        <?php }else{ ?>
            <p><h2>Crear nuevo usuario</h2></p>
        <?php } ?>
    </div>
    <div class="container formContainer">
        <!--Se recarga a sí misma.-->
        <form action="" method="POST" enctype="multipart/form-data" class="formAdminEdit">
            <div class="text-center">
                <?php 
                    if (isset($_GET["success"]) && $_GET["success"]){
                        echo '<div class="alert alert-success" style="margin-top:5px;"> La edición ha sido realizada correctamente. </div>';
                        
                    }else if(isset($_GET["message"]) && $_GET["message"]=="created"){
                        echo '<div class="alert alert-success" style="margin-top:5px;"> El usuario se ha creado correctamente. </div>';
                    }
                ?> 
            </div>
            <label for="nif">Nif
                <input type="text" name="nif" class="form-control"  <?php rememberValue($_POST["nif"],$user->nif) ?>/> 
                <?php echo mostrar_error($errors, "nif"); ?>  
            </label>
            <br>
            <label for="nombre">Nombre
                <input type="text" name="nombre" class="form-control" <?php rememberValue($_POST["nombre"],$user->nombre) ?> /> 
                <?php echo mostrar_error($errors, "nombre"); ?>  
            </label>
            <br/>
            <label for="apellidos"> Apellidos
                <input type="text" name="apellidos" class="form-control" <?php rememberValue($_POST["apellidos"],$user->apellidos) ?> /> 
                <?php echo mostrar_error($errors, "apellidos"); ?>  
            </label>
            <br/>
            <label for="email"> Email
                <input type="email" name="email" class="form-control" <?php rememberValue($_POST["email"],$user->email) ?> /> 
                <?php echo mostrar_error($errors, "email"); ?>  
            </label>

            <br/>
            <label for="telefono"> Teléfono
                <input type="text" name="telefono" class="form-control" <?php rememberValue($_POST["telefono"],$user->telefono) ?> /> 
                <?php echo mostrar_error($errors, "telefono"); ?>  
            </label>
            <br>
            <label for="direccion"> Dirección
                <input type="text" name="direccion" class="form-control" <?php rememberValue($_POST["direccion"],$user->direccion) ?> /> 
                <?php echo mostrar_error($errors, "direccion"); ?>  
            </label>
            <br>
            <label class="blu">Estado
                <select name="estado" class="form-control" <?php  ?>>
                    <option value="1" <?php rememberValueSelect($_POST["estado"],"1",$user->estado) ?>>Activo</option>
                    <option value="0" <?php rememberValueSelect($_POST["estado"],"0",$user->estado) ?>>Inactivo</option>
                </select>
            </label>
            <br/>
            <br/>
            <label for="imagen">Imagen
                <!--Si estamos editando-->
                <?php if(isset($_GET["id"])){?>
                    <input type="text" name="imagenHidden" class="form-control" hidden <?php rememberValue($_POST["imagenHidden"],$user->imagen) ?>/> 
                    <img  class="avatar" src="assets/img/avatarsUsers/<?php sececho($_POST["imagenHidden"],$user->imagen) ?>">
                    <br/>
                    <p>··Para cambiar imagen:</p>
                <?php } ?>

                <input type="file" name="imagen" class="form-control" <?php rememberValue($_POST["imagen"],$user->imagen) ?>/> 
                <?php echo mostrar_error($errors, "imagen"); ?>                         
            </label>
            <br>
            <label class="blu">Rol
                <select name="rol" class="form-control">
                    <option value="1" <?php rememberValueSelect($_POST["rol"],"1",$user->rol_id) ?>>Administrador</option>
                    <option value="2" <?php rememberValueSelect($_POST["rol"],"2",$user->rol_id) ?>>Socio</option>
                </select>
            </label>

            <?php if(!isset($_GET["id"])){?>
                <br/>
                    <h2 class="recordatorio">Recordatorio: <br>Password será el NIF del usuario.</h2> 
            <?php } ?>

            <div class=" text-right">
                <?php if(isset($_GET["id"])){ ?>	
                    <button type="button" class="btn btn-secondary" onclick="location.href='index.php?controller=adminUser&action=listUser&pagina=1&rxp=10'">Volver a "Listar usuario"</button>
                    <input type="submit" name="submit" value="Editar usuario"  class="btn btn-primary"/> 
                <?php }else{ ?>
                    <input type="submit" name="submit" value="Crear usuario"  class="btn btn-primary"/> 
                <?php } ?>   
            </div>   
        </form>
    </div>
</div>