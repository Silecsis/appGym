<!--Vista de "editar usuario"  estando logueado y de "registro."-->

<div class="formEdit">
    <div class="container cuerpo text-center">	
        <p><h2> Datos de usuario:</h2></p>
        <?php
            if(isset($errors) && count($errors) == 0){
                echo '<div class="alert alert-success" style="margin-top:5px;"> Formulario validado correctamente!! :)</div>'; 
            }  
        ?>
        <!-- <//?php if (isset($_POST["submit"]) && (count($errors) == 0)) { valoresfrm(); } ?> -->
    </div>
    <div class="container formContainer">
        <!--Se recarga a sí misma.-->
        <form action="" method="POST" enctype="multipart/form-data" class="formEdit">
        
            <label for="nif">Nif:
                <input type="text" name="nif" class="form-control"  <?php rememberValue($_POST["nif"],$user->nif) ?>/> 
                <?php echo mostrar_error($errors, "nif"); ?>    
            </label>
            <br>
            <label for="nombre">Nombre:
                <input type="text" name="nombre" class="form-control" <?php rememberValue($_POST["nombre"],$user->nombre) ?> /> 
                <?php echo mostrar_error($errors, "nombre"); ?>    
            </label>
            <br/>
            <label for="apellidos"> Apellidos:
                <input type="text" name="apellidos" class="form-control" <?php rememberValue($_POST["apellidos"],$user->apellidos) ?> /> 
                <?php echo mostrar_error($errors, "apellidos"); ?>  
            </label>
            
            <br/>
            <!--Si existe el user-->
            <?php if(isset($_SESSION["usuario"])){?>
                <br/> 
                <label for="password">Para cambiar la contraseña rellene con su contraseña actual:
                <input type="password" name="password" class="form-control" <?php rememberValue($_POST["password"],$_POST["password"]) ?> />
                <?php echo mostrar_error($errors, "password"); ?> 
                </label> 
                <br/>

                <label for="passwordMod">Ahora rellene con la nueva contraseña:              
                    <input type="password" name="passwordMod" class="form-control" <?php rememberValue($_POST["passwordMod"],$_POST["passwordMod"]) ?>/>
                    <?php echo mostrar_error($errors, "passwordMod"); ?>                  
                </label>
            <br/>
            <?php }else{ ?>
                <br/>
                <label for="email">Correo:
                    <input type="email" name="email" class="form-control" <?php rememberValue($_POST["email"],$user->email) ?> /> 
                    <?php echo mostrar_error($errors, "email"); ?>                      
                </label>

                <br/>
                <label for="passwordMod">Password:              
                    <input type="password" name="passwordMod" class="form-control" <?php rememberValue($_POST["passwordMod"],$_POST["passwordMod"]) ?>/>
                    <?php echo mostrar_error($errors, "passwordMod"); ?>                  
                </label>
            <?php } ?>
            <br/>
            <label for="telefono">Teléfono:
                <input type="text" name="telefono" class="form-control" <?php rememberValue($_POST["telefono"],$user->telefono) ?>/> 
                <?php echo mostrar_error($errors, "telefono"); ?>                         
            </label>
            <br/>

            <label for="direccion">Dirección:
                <input type="text" name="direccion" class="form-control" <?php rememberValue($_POST["direccion"],$user->direccion) ?>/> 
                <?php echo mostrar_error($errors, "direccion"); ?>                       
            </label>
            <br/>
            <br/>
            <label for="imagen">Imagen:
                <!--Si existe el user-->
                <?php if(isset($_SESSION["usuario"])){?>
                    <img  class="avatar" src="assets/img/avatarsUsers/<?php echo ($_SESSION["usuario"]["img"])?>">
                    <br/>
                    <p>··Para cambiar imagen:</p>
                <?php } ?>

                <input type="file" name="imagen" class="form-control" <?php rememberValue($_POST["imagen"],$user->imagen) ?>/> 
                <?php echo mostrar_error($errors, "imagen"); ?>                         
            </label>
            <div class="text-right">
            <br/>
            <?php if(isset($_SESSION["usuario"])){?>
                <input type="submit" value="Editar perfil" name="submit" class="btn btn-primary" />
            <?php }else{?>
                <input type="submit" value="Registrarme" name="submit" class="btn btn-primary"/>
                <label><button type="button" class="btn btn-secondary recuperarContra" onclick="location.href='index.php?controller=index&action=index'">Volver a "Login de usuario"</button></label>  
            <?php }?>
            </div>
        </form>
    </div>
</div>
