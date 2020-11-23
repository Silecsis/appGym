    <header>
        <h1>Gimnasio Lavanda</h1>

        <!--Si no estamos logueados, no podremos cerrar sesión, por lo que no aparecerá la sesión.-->
        <?php
        //---------------------------AQUI METER INCLUDE CON NAVVV!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            if(isset($_SESSION['logueado'])){
        ?>
            <a href="index.php?controller=index&action=logout">Cerrar Sesión</a>            
        <?php
            }
        ?>
    </header>