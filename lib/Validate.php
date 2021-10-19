<?php

class Validate { 

    public function v_str($campo){

        $sr = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s\']+$/";
        if(preg_match($sr, $campo)){
            return true;
        }else{
            return false;
        }
    }
    

    public function v_int($campo){

        $sr = "/^[0-9]+$/";
        if(preg_match($sr, $campo)){
            return true;
        }else{
            return false;
        }
    }


    public function v_strInt($campo){

        $sr = "/^[0-9a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s\']+$/";
        if(preg_match($sr, $campo)){
            return true;
        }else{
            return false;
        }
    }

    public function v_fecha($campo){

        $sr = "/^[0-2][0-9]|3[0-1](\/|-)(0[1-9]|1[0-2])\2(\d{4})+$/";
        if(preg_match($sr, $campo)){
            return true;
        }else{
            return false;
        }
    }

    public function v_img($campo){

        $ext = explode(".", $campo);
        $ext = end($ext);
        if($ext == 'jpg' or $ext =='png' or $ext =='jfif' or $ext =='jpeg' or $ext == 'JPG'or $ext =='PNG' or $ext =='JFIF' or $ext =='JPEG'){
            return true;
        }else{
            return false;
        }
    }

    public function v_email($campo){

        // Patrón para encontrar direcciones de email
        $patron = "/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}\b/";
        if(preg_match($patron, $campo)){
            return true;
        }else{
            return false;
        }
    }


    public function v_strIntDes($campo){

        $sr = "/^[0-9a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\-_#@!¡.:;,?¿()\"\s\']+$/";
        if(preg_match($sr, $campo)){
            return true;
        }else{
            return false;
        }
    }

    
}
?>