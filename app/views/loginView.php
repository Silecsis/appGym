<!--Vista del login-->
  <div class="centrar">	
    <div class="container text-center cuerpo">	
      <p><h2> Login de usuario:</h2></p>
    </div>
    <div class="text-center">
          <?php 
            if (isset($_GET["message"])){
              if ($_GET["message"]=="registrer"){
                 echo '<div class="alert alert-success" style="margin-top:5px;"> Se ha registrado correctamente.<br/> </div>';
              }
            }
          ?> 
    </div>
    <div class="container">
      <form  action="index.php?controller=index&action=login" method="POST" class="form">
        <div class="datos">
          <label for="name">Usuario:
            <!--sececho se coloca primero la variable del form por si existe, que recuerde en la casilla el nombre del form y no de la cookie (en caso de que exista).-->
            <input type="text" name="usuario" class="form-control usuario" value="<?php sececho($_GET["userName"],$_COOKIE["usuario"])?>"/> 
          </label>
          <br/>
          <label for="password">Contraseña:
            <input type="password" name="password" class="form-control contra" value="<?php sececho($_COOKIE["password"])?>"/>            
          </label>
            <li class="login">
              <!--Este php pondrá checkeado en el input si marcamos la casilla.-->
                <label><input type="checkbox" class="recordar" name="recordar" <?php if(isset($_COOKIE['recordar'])){echo " checked";} ?>> Recordar usuario y contraseña</label>
            </li>
            <li class="login">
              <!--Este php pondrá checkeado en el input si marcamos la casilla.-->
                <label><input type="checkbox" class="mantenerSesion" name="mantenerSesion" <?php if(isset($_COOKIE['mantenerSesion'])){echo " checked";} ?>> Mantener sesión abierta</label>
            </li>
        </div>
        <div class="text-center">
          <br>
          <label><button type="button" class="btn btn-secondary recuperarContra" onclick="location.href='index.php?controller=password&action=forgoted'">Olvidé mi contraseña</button></label> 
          <?php 
            if (isset($_GET["error"])){
              if ($_GET["error"]=="authRequired"){
                 echo '<div class="alert alert-danger" style="margin-top:5px;"> Debes estar logueado para acceder a este sitio.<br/> </div>';
                }else if($_GET["error"]=="notFound"){
                  echo '<div class="alert alert-danger" style="margin-top:5px;"> Tu nombre de usuario (email )y/o contraseña no se encuentra en nuestra base de datos.<br/> </div>';
                }else if($_GET["error"]=="empty"){
                  echo '<div class="alert alert-danger" style="margin-top:5px;"> No puedes dejar los campos de email y/o contraseña vacíos.<br/> </div>';
                }else if($_GET["error"]=="deactivated"){
                  echo '<div class="alert alert-danger" style="margin-top:5px;"> Tienes el usuario desactivado. Comunícate con algún administrador.<br/> </div>';
                }
            }

          ?> 
          <br>
          <input type="submit" value="Entrar" name="submit" class="btn btn-primary" />
          <button type="button" class="btn btn-primary" onclick="location.href='index.php?controller=user&action=registrer'">Registrarme</button>
        </div>
      </form>
    </div>
  </div>