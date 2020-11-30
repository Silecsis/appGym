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
        <!--MODIFICAR ENVIO DE DATOS-->
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
            <label for="apellido1"> Primer apellido:
                <input type="text" name="apellido1" class="form-control" <?php rememberValue($_POST["apellido1"],$user->apellido1) ?> /> 
                <?php echo mostrar_error($errors, "apellido1"); ?>  
            </label>
            <br/>
            <label for="apellido2"> Segundo apellido:
                <input type="text" name="apellido2" class="form-control" <?php rememberValue($_POST["apellido2"],$user->apellido2) ?>/> 
                <?php echo mostrar_error($errors, "apellido2"); ?>  
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
            
            <?php if(!isset($_SESSION["usuario"])){?>
                <br/>
                <label for="login">Login:
                    <input type="text" name="login" class="form-control" <?php rememberValue($_POST["login"],$user->login) ?> /> 
                    <?php echo mostrar_error($errors, "login"); ?>    
                </label>
            <?php } ?>
           
            <!--Si existe el user-->
            <?php if(isset($_SESSION["usuario"])){?>
                <br/>
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
                <label for="passwordMod">Password:              
                    <input type="password" name="passwordMod" class="form-control" <?php rememberValue($_POST["passwordMod"],$_POST["passwordMod"]) ?>/>
                    <?php echo mostrar_error($errors, "passwordMod"); ?>                  
                </label>
            <?php } ?>

            <br/>
            <label for="email">Correo:
                <input type="email" name="email" class="form-control" <?php rememberValue($_POST["email"],$user->email) ?> /> 
                <?php echo mostrar_error($errors, "email"); ?>                      
            </label>
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
            <input type="submit" value="Editar" name="submit" class="btn btn-success" />
        </form>
    </div>
</div>
