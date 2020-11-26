<?php
/**
 * Si str está definida, hace un echo del valor str.
 * Sino, hace un echo del default.
 *
 * @param [type] $str Recibe un String (que puede ser indefinido con el "&").
 * @param [type] $default Valor que queremos mostrar si no está definido. 
 * @return void
 */
    function sececho(&...$strList) {
        $result=null;
        foreach($strList as $str){
            //Se queda con el primero que encuentra, por ello el orden es importante.
            if(isset($str)){
                $result=$str;
            break;
            }
        }
        echo $result;
    }


    /**
     * Si existe el campo del form, se recuerda.
     *
     * @param [*] $campo form
     * @return void
     */
    function rememberCamp($campo)
    {
        if(isset($_POST["$campo"])){
            echo "value='{$_POST["$campo"]}'";
        }
    }

    
?>