<!--Vista de "imprimir horario" desde todos los usuarios. Será la vista de imprimir el horario-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gimnasio Lavanda</title>
    <!--Enlaces a los estilos:-->
        <link rel="stylesheet" type="text/css" href="assets/css/estilos.css">
</head>
<body>
    <div class="impriH4">
        <h2> Horario Lavanda </h2>
    </div>
    <div class="impri">
        <table>
            <thead class="impri">
                <tr>
                    <th class="impri">Hora</th>
                    <?php foreach ($days as $dd) :?>
                        <th class="impri"><?php echo $dd["dia"]?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>  
                <!--Si no hay usuarios en la base de datos con lo establecido a buscar, se avisará al usuario.-->
            <?php foreach ($data["tramos"] as $t) : ?>
                <tr>
                    <!--Le meto la función substring para que no muestre los segundos-->
                    <td class="impri"><?php echo substr($t["hora_inicio"], 0, -3)." - ".substr($t["hora_fin"], 0, -3)?></td>
                    <!--Recorro los 3 arrays para que me imprima el nombre de la actividad en el día de la semana correspondiente-->
                    <?php foreach ($days as $d) :?>
                        <td class="impri">

                            <?php if($t[$d["id"]]){
                                    foreach ($activities as $a) : 
                                        if($a["id"]==$t[$d["id"]]["actividad_id"]){ 
                                            echo $a["nombre"];
                                        }
                                    endforeach; ?> 
                            <?php } ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</body>
</html>

