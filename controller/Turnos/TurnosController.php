<?php 
    include_once '../model/Turnos/TurnosModel.php';

    class TurnosController{

        private $obj;

        public function __construct()
        {
            $this->obj = new TurnosModel();
        }
    
        public function getCrear(){

            include_once '../view/turnos/home.php';
        }

        public function crearTurnos(){
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];
            $intensidad_horaria = $_POST['intensidad_horaria'];
            $esp_id = $_POST['esp_id'];
            $per_id = $_POST['per_id'];

            echo $fecha_inicio;
            echo "<br>";
            echo $fecha_fin;
            echo "<br>";
            echo $intensidad_horaria;
            echo "<br>";
            echo $esp_id;
            echo "<br>";
            foreach($per_id as $per){
                echo $per;
                echo "<br>";
            }
        }

        public function consultPersonal(){
            $esp_id = $_POST["esp_id"];
            $sql = "SELECT * FROM persona WHERE esp_id = $esp_id";
            $consulta = $this->obj->query($sql);

            echo '<ul class="list-group mb-3">';
            foreach($consulta as $con){
                echo '
                <li class="list-group-item">
                    <input class="form-check-input" type="checkbox" value="'.$con['per_id'].'" name="per_id[]">
                    <label class="form-check-label" for="">';
                        echo $con['per_nombres'];
                echo '
                    </label>
                </li>';
            }
            echo '</ul>';
        }
    
    
        public function crear(){
            
        }
    
        
        public function consultar()
        {
            // $Turnos = $this->objTurnos->consultar("*", "salida_bodega");
            // include_once '../View/Turnos/consult.php';
        }
    }

?>