<?php
/**
 * Si strList está indefinida o no continuene ningun elemento definido,
 * devuelve el primero que esté definido.
 * Sino, devuelve null.
 *
 * @param [type] $strList Lista (que puede ser indefinido con el "&") de
 * posibles textos.
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
     * Imprime el atributo value con un valor que depende de los parámetros postvalue y originalvalue.
     * Si ninguno de los dos está especificado, el valor es vacio. 
     * 
     * Si se especifica postvalue, el valor es el que tiene postvalue.
     * Si se especifica originalvalue y no se especifica postvalue, el valor es originalvalue.
     * 
     * (&--> puede ser indeefinido)
     * @param [*] $postValue form
     * @return void
     */
    function rememberValue(&$postValue,&$originalValue)
    {
        $value="";

        if(isset($postValue)){
            $value=$postValue;
        }else if(isset($originalValue)){
            $value=$originalValue;
        }

        echo "value='$value'";
    }

    
?>