<?php

    include_once '../lib/conf/connection.php';

    class MasterModel extends Connection{

        public function query($sql){
            $result = mysqli_query($this->getConnect(),$sql);
            return $result;
        }
        public function insertar($table,$fields=false,$values){

            if($fields!=false){
                $fields="($fields)";
            }
    
    
            
              $sql="insert into $table $fields values($values)";
    
            $ejecutar=mysqli_query($this->getConnect(),$sql);
            if(!$ejecutar){
                echo mysqli_error($this->getConnect());
            }
        }
    
        public function editar($table,$condicion=false,$campos){
    
            if($condicion!=false){
                $condicion= "where ". $condicion;
            }
            $actualizar="";
            foreach($campos as $campo=>$valor){
                $actualizar.="$campo=$valor,";
            }
            $campos=substr($actualizar,0,-1);
    
            $sql="update $table set $campos $condicion";
            $ejecutar=mysqli_query($this->getConnect(),$sql);
            if(!$ejecutar){
                echo mysqli_error($this->getConnect());
            }
    
        }
    
    
    
        public function consultar($campos,$tabla,$condicion=false){
    
            if($condicion!=false){
                $condicion="where $condicion";
            }
    
            $sql="select $campos from $tabla $condicion";
            $ejecutar=mysqli_query($this->getConnect(),$sql);
            if($ejecutar){
                return $ejecutar;
            }
            else{
                echo mysqli_error($this->getConnect());
            }
    
    
        }
    
        public function eliminar($table,$condicion){
    
            $sql="delete from $table where $condicion";
    
            $ejecutar=mysqli_query($this->getConnect(),$sql);
            if(!$ejecutar){
                echo mysqli_error($this->getConnect());
            }
        }
        
        public function autoIncrement($table,$field){
            $sql="SELECT MAX($field) FROM $table";
            $result=$this->query($sql);
            $account=mysqli_fetch_row($result);

            return end($account)+1;
        }

        public function CargaSelectGeneral($campo, $tabla){
            $sql = "SELECT $campo FROM $tabla";

            $consultar = $this->query($sql);
            $num = mysqli_num_rows($consultar);

            if ($num > 0) {
                while ($dato = mysqli_fetch_row($consultar)) {
                    echo "<option value='" . $dato[0] . "'> ".$dato[1]."</option>";
                }
            }
        }

        public function CargaSelected($campo, $tabla, $condicion){

            $sql = "SELECT $campo FROM $tabla";

            $consultar = $this->query($sql);
            $num = mysqli_num_rows($consultar);
            if ($num > 0) {
                while ($dato = mysqli_fetch_row($consultar)) {
                    if ($dato[0] == $condicion) {
                        echo "<option selected value='" . $dato[0] . "'>" . $dato[1] . "</option>";
                    } else {
                        echo "<option value='" . $dato[0] . "'>" . $dato[1] . "</option>";
                    }
                }
            }
        }
    }
