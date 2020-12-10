<!--Vista de "olvidé mi contraseña"-->
<div class="passwordForg">	
    <div class="container">	
      <p><h2 class="h2Passw"> "Olvidé mi contraseña"</h2></p>
    </div>
    <div class="container">
      <form  action="index.php?controller=password&action=recuperate" method="POST" class="form">
        <div class="datos">
          <label for="password">Email:
          <!--sececho se coloca primero la variable del form por si existe, que recuerde en la casilla el nombre del form y no de la cookie (en caso de que exista).-->
            <input type="email" name="emailUser" class="form-control contra" <?php rememberValue($_POST["emailUser"],$_POST["emailUser"])?>/>            
          </label>
          <br>
          <br>
          <label><input type="submit" value="Recuperar mi contraseña" name="submit" class="btn btn-primary" /></label>
          <label><button type="button" class="btn btn-secondary recuperarContra" onclick="location.href='index.php?controller=index&action=index'">Volver a "Login de usuario"</button></label>  
        </div>
        <br/>
        <div>
          <?php 
            if (isset($_GET["sendMail"]) && $_GET["sendMail"]){

            ?>

              <div class="alert alert-success" style="margin-top:5px;"> 
                La nueva contraseña se ha enviado correctamente.
                <br/> 
                Para no poner la contraseña del gmail utilizado para enviar las contraseñas olvidadas, se ha utilizado un servicio de email falso
                cuya url es: <a href="https://ethereal.email/create">https://ethereal.email/create</a>. El usuario y contraseña de este servicio está en la documentación.
              </div>

            <?php

            }else if(isset($_GET["error"]) && $_GET["error"]=="campo"){
              echo '<div class="alert alert-danger" style="margin-top:5px;"> El email introducino no figura en nuestra base de datos.<br/> </div>';

            }else if(isset($_GET["error"]) && $_GET["error"]=="unexpected"){
              echo '<div class="alert alert-danger" style="margin-top:5px;"> Se ha producido un error inesperado.<br/> </div>';

            }
          ?> 
        </div>
      </form>
    </div>
</div>