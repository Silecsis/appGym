<div class="formEdit">
    <?php require 'controllers/ValidationFormController.php'; ?>

    <div class="container cuerpo text-center">	
        <p><h2> Datos de usuario:</h2></p>
        <?php echo validez($errors); ?>
        <?php if (isset($_POST["submit"]) && (count($errors) == 0)) { valoresfrm(); } ?>
    </div>
    <div class="container">
        <!--MODIFICAR ENVIO DE DATOS-->
        <form  action="index.php?controller=home&action=edit" method="POST" enctype="multipart/form-data">

        <label for="nif">Nif:
            <input type="text" name="nif" class="form-control"  <?php rememberCamp("nif") ?>/> 
            <?php echo mostrar_error($errors, "nif"); ?>    
        </label>
        <br>
        <label for="nombre">Nombre:
            <input type="text" name="nombre" class="form-control" <?php rememberCamp("nombre") ?> /> 
            <?php echo mostrar_error($errors, "nombre"); ?>    
        </label>
        <br/>
        <label for="apellido1"> Primer apellido:
            <input type="text" name="apellido1" class="form-control" <?php rememberCamp("apellido1") ?> /> 
            <?php echo mostrar_error($errors, "apellido1"); ?>  
        </label>
        <br/>
        <label for="apellido2"> Segundo apellido:
            <input type="text" name="apellido2" class="form-control" <?php rememberCamp("apellido2") ?> /> 
            <?php echo mostrar_error($errors, "apellido2"); ?>  
        </label>
        <br/>
        <label for="imagen">Imagen:
            <input type="file" name="imagen" class="form-control" <?php rememberCamp("imagen") ?>/> 
            <?php echo mostrar_error($errors, "imagen"); ?>                         
        </label>
        <br/>

        <br/>
        <label for="login">Login:
            <input type="text" name="login" class="form-control" <?php rememberCamp("login") ?> /> 
            <?php echo mostrar_error($errors, "login"); ?>    
        </label>
        <br/>
        
        <label for="password">Password:
            <input type="password" name="password" class="form-control" <?php rememberCamp("password") ?> />
            <?php echo mostrar_error($errors, "password"); ?>                  
        </label>
        <br/>
        <label for="email">Correo:
            <input type="email" name="email" class="form-control" <?php rememberCamp("email") ?> /> 
            <?php echo mostrar_error($errors, "email"); ?>                      
        </label>
        <br/>

        <label for="telefono">Teléfono:
            <input type="text" name="telefono" class="form-control" <?php rememberCamp("telefono") ?>/> 
            <?php echo mostrar_error($errors, "telefono"); ?>                         
        </label>
        <br/>

        <label for="direccion">Dirección:
            <input type="text" name="direccion" class="form-control" <?php rememberCamp("direccion") ?>/> 
            <?php echo mostrar_error($errors, "direccion"); ?>                       
        </label>
        <br/>

        <!-- <label for="role">Rol:
            <select name="role" class="form-control">
            <option value="0" <//?php if(isset($_POST["role"])){ if($_POST["role"]==0){ echo "selected='selected'"; }} ?> >Normal</option>
            <option value="1" <//?php if(isset($_POST["role"])){ if($_POST["role"]==1){ echo "selected='selected'"; }} ?> >Administrador</option>
            </select>
            <//?php echo mostrar_error($errors, "role"); ?>                    
        </label>
        <br/>            -->

        
        <input type="submit" value="Enviar" name="submit" class="btn btn-success" />
        <?php 
        // echo ($_SESSION['usuario']["login"]);
        //  require_once MODELS_FOLDER."UserModel.php";
        //  $userModel=new UserModel();

        //  $user=$userModel->getDatabase($_SESSION['usuario']["login"]);
     
             //echo ($user["data"]->nif);
        ?>

    </div>
</div>
