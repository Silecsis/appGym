  <!--Aquí se mostrará el menú una vez logueado. Común en todas las vistas.
    Tiene diferencias si es admin o si es socio-->  
    <header>
        <h1>Gimnasio Lavanda</h1>

        <!--Si no estamos logueados, no podremos cerrar sesión, por lo que no aparecerá la sesión.-->
        <?php if(isset($_SESSION['logueado'])){ ?>
            <div class="navHeader"> 
                <div class="input-group">
                    <nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
                    <!--Enlace para ir a home-->
                        <a class="navbar-brand" href="index.php?controller=home&action=index"><i class="fa fa-home" aria-hidden="true">Home</i></a>
                        <button class="navbar-toggler mr" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333-1"
                            aria-controls="navbarSupportedContent-333-1" aria-expanded="false" aria-label="Toggle navigation">
                                <span><i class="fas fa-arrow-alt-circle-down peque"></i></span>
                        </button>
                    
                        <div class="collapse navbar-collapse" id="navbarSupportedContent-333-1">
                            <ul class="navbar-nav nav-flex-icons">
                                <li class="nav-item">
                                    <!--Mensajes-->
                                    <a class="nav-link waves-effect waves-light navColor" href="index.php?controller=home&action=messages">Mensajes</a>
                                </li>

                                <?php if($_SESSION['usuario']["rol_id"]==1){?>
                                    <li class="nav-item">
                                        <!--Usuarios-->
                                        <a class="nav-link waves-effect waves-light navColor" href="index.php?controller=adminUser&action=listUser&pagina=1&rxp=10">Usuarios</a>
                                    </li>
                                    <li class="nav-item">
                                        <!--Actividades dirigidas-->
                                        <a class="nav-link waves-effect waves-light navColor" href="index.php?controller=adminActivities&action=listActivities&pagina=1&rxp=10">Actividades</a>
                                </li>
                                <?php }?>

                                
                                
                                <li class="nav-item">
                               
                                </li>
                                

                                <li class="nav-item dropdown">
                                
                                </li>
                            </ul>
                        </div>
                    </nav>  

                    <nav class="ml-auto navbar navbar-expand-lg navbar-dark default-color">
                    <a class="navbar-brand" href="index.php?controller=home&action=index"></a>
                        <button class="navbar-toggler mr navColor" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333-2"
                            aria-controls="navbarSupportedContent-333-2" aria-expanded="false" aria-label="Toggle navigation">
                                <span><i class="fa" aria-hidden="true">Usuario</i><i class="fas fa-arrow-alt-circle-down peque"></i></span>
                        </button>
                    
                        <div class="collapse navbar-collapse text-right" id="navbarSupportedContent-333-2">
                            <ul class="navbar-nav ml-auto nav-flex-icons">
                                <li class="nav-item">
                                <!--Nombre user-->    
                                    <p class="horaIni" id="hora"><?php echo $_SESSION['usuario']["nombre"];?></p>
                                </li>
                                <li class="nav-item">
                                <!--Hora entrada-->
                                    <p class="horaIni" id="hora"><?php echo $_SESSION['usuario']["hora_login"];?></p>
                                </li>
                               
                                <li class="nav-item">
                                <!--Tipo user-->
                                    <a class="nav-link waves-effect waves-light navColor">
                                        <?php 
                                        //Es un usuario, aparece el icono de usuario. Sino, el de admin.
                                            if ($_SESSION['usuario']["rol_id"]=='2'){
                                                echo "<i class='fas fa-user'></i>";
                                            }else{
                                                echo "<i class='fas fa-user-tie'></i>";
                                            }
                                        ?>
                                    </a>
                                </li>

                                <li class="nav-item dropdown">
                                <!--Usuario-->
                                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                        <img  class="avatar" src="assets/img/avatarsUsers/<?php echo ($_SESSION["usuario"]["img"])?>">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-default"
                                    aria-labelledby="navbarDropdownMenuLink-333">
                                        <a class="dropdown-item sesion" href="index.php?controller=user&action=edit">Editar perfil</a>
                                        <a class="dropdown-item sesion" href="index.php?controller=index&action=logout">Cerrar Sesión</a> 
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>        
        <?php } ?>
    </header>