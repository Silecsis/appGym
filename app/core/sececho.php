<?php
/**
 * Para recordar campos.
 * 
 */


    /**
     * Si strList está indefinida o no continuene ningun elemento definido,
     * devuelve el primero que esté definido.
     * Sino, devuelve null.
     *
     * @param [type] ...$strList Lista (que puede ser indefinido con el "&") de posibles textos.
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
     *
     * @param [*] $postValue
     * @param [*] $originalValue
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

    /**
     * Recuerda el valor selecciona del botón desplegable.
     *
     * @param string $valueSelect el valor guardado.
     * @param string $valueOption el valor de la opción
     * @return void
     */
    function rememberValueSelect(&$valueSelect, $valueOption, &$valueOriginal)
    {
        if(isset($valueSelect) && $valueSelect===$valueOption){
            echo "selected";
        }else if(isset($valueOriginal) && $valueOriginal===$valueOption){
            echo "selected";
        }
    }

    /**
     * Recuerda el valor si es una variable que no sea boton
     *
     * @param string $postValue el valor guardado.
     * @param string $originalValue el valor de la opción
     * @return void
     */
    function rememberValueNotBT(&$postValue,&$originalValue)
    {
        $value="";

        if(isset($postValue)){
            $value=$postValue;
        }else if(isset($originalValue)){
            $value=$originalValue;
        }

        echo "$value";
    }

    
?>