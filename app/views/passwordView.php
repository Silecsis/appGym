
<div class="passwordForg">	
    <div class="container">	
      <p><h2 class="h2Passw"> "Olvidé mi contraseña"</h2></p>
    </div>
    <div class="container">
      <form  action="index.php?controller=password&action=recuperate" method="POST" class="form">
        <div class="datos">
          <label for="name">Login de usuario:
            <!--sececho se coloca primero la variable del form por si existe, que recuerde en la casilla el nombre del form y no de la cookie (en caso de que exista).-->
            <input type="text" name="loginUser" class="form-control usuario" <?php rememberValue($_POST["loginUser"],$_POST["loginUser"])?>/> 
          </label>
          <br/>
          <label for="password">Email:
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
            if (isset($_GET["password"])){
                echo '<div class="alert alert-success" style="margin-top:5px;"> La nueva contraseña es ' . $_GET["password"] . '.<br/> </div>';
            }else if(isset($_GET["error"]) && $_GET["error"]=="campo"){
              echo '<div class="alert alert-danger" style="margin-top:5px;"> El login/email introducino no figura en nuestra base de datos.<br/> </div>';
            }else if(isset($_GET["error"]) && $_GET["error"]=="unexpected"){

            }
          ?> 
        </div>
      </form>
    </div>
</div>