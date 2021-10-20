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
            /* $intensidad_horaria = $_POST['intensidad_horaria'];
            $esp_id = $_POST['esp_id']; */
            $per_id = $_POST['per_id'];
            $fecha_i = new DateTime($fecha_inicio);
            $fecha_f = new DateTime($fecha_fin);
            $dias = $fecha_i->diff($fecha_f)->days;
            /* $matriz = [
                ["nombre" => "pepe", "id" => 1],
                ["nombre" => "juan", "id" => 2],
                ["nombre" => "jose", "id" => 3],
                ["nombre" => "carlos", "id" => 4],
            ];
            $horario = [
                ["dia" => "lunes"],
                ["dia" => "Martes"],
                ["dia" => "Miercoles"],
                ["dia" => "Jueves"],
                ["dia" => "Viernes"],
                ["dia" => "Sabado"],
                ["dia" => "Domingo"],
            ]; */
            echo "<table class='table table-bordered mt-3'>";
            for ($i=0; $i < count($per_id); $i++) {
                if($i == 0){
                    echo "<tr>";
                    for ($j=0; $j <= $dias; $j++) {
                        if ($j != 0) {
                            echo "<td>";
                            date_add($fecha_i, date_interval_create_from_date_string("1 day"));
                            echo "Dia: ".date_format($fecha_i,"d-m-Y");
                            echo "</td>";
                        }else{
                            echo "<td>";
                            echo " "; 
                            echo "</td>";
                        }
                    }
                    echo "</tr>";
                }
                echo "<tr>";
                    echo "<td>";
                    echo " Id persona: ".$per_id[$i];
                    echo "</td>";

                for ($j=0; $j < $dias; $j++) {
                    
                    echo "<td>";
                    echo " ";
                    echo "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
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
    while ($horas > 0) {

        foreach ($personas as $per) {

            $datos = array();
            $datos['persona'] = $per;
            $datos['fecha_ingreso'] = $fecha;
            $datos['hora_ent'] = $hora;
            $horas = $horas-$intensidad_horaria;
            $hora = $hora+$intensidad_horaria;
            if($hora >= 24){
                $hora = $hora-24;
                $diaI = $diaI+1;
                
                if ($diaI == 28 && $mesI == 2) {
                    $fecha = date("y-m-d",strtotime($fecha."+1 month"));
                    $fecha = date("y-m-d",strtotime($fecha."-28 days")); 
                    $diaI = $diaI-28;
                    $mesI = $mesI+1;

                }else if ($diaI == 30 && ($mesI == 4 or $mesI == 6 or $mesI == 9 or $mesI == 11)) {
                    $fecha = date("y-m-d",strtotime($fecha."+1 month"));
                    $fecha = date("y-m-d",strtotime($fecha."-30 days")); 
                    $diaI = $diaI-30;
                    $mesI = $mesI+1;

                }else if ($diaI == 31) {

                    if ($mesI != 12) {
                        $fecha = date("y-m-d",strtotime($fecha."+1 month"));
                        $fecha = date("y-m-d",strtotime($fecha."-31 days")); 
                        $diaI = $diaI-31;
                        $mesI = $mesI+1;
                    }else{
                        $fecha = date("y-m-d",strtotime($fecha."+1 year"));
                        $fecha = date("y-m-d",strtotime($fecha."-11 month"));
                        $fecha = date("y-m-d",strtotime($fecha."-31 days")); 
                        $diaI = 1;
                        $mesI = 1;
                        $yearI = $yearI+1;
                        
                    }
                        
                }
                 $fecha = date("y-m-d",strtotime($fecha."+ 1 days")); 
            }
            $datos['fecha_salida'] = $fecha;
            $datos['hora_sal'] = $hora;
            echo "------------<br>";
            print_r($datos);
            array_push($turnos, $datos);
        }
    }

?>