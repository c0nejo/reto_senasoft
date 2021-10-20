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

        public function crearTurnos()
        {
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];
            $intensidad_horaria = $_POST['intensidad_horaria'];
            $esp_id = $_POST['esp_id'];
            $per_id = $_POST['per_id'];

            $fecha_i = new DateTime($fecha_inicio);
            $fecha_f = new DateTime($fecha_fin);
            $dias = $fecha_i->diff($fecha_f)->days;
    
            $horas = ($dias+1)*24;
            $hora = 6;
            $turnos["horarios"] = array();
            $turnos["fechas"] = array();
            for ($i=0; $i < count($per_id); $i++) {
                $turnos["horarios"][$per_id[$i]] = [
                    "id_persona" => $per_id[$i],
                    "horas" => 0,
                    "turnos" => [

                    ],
                    "dias_descanso" => 0,
                ];
            }
            $fecha = date("y-m-d",strtotime($fecha_inicio));
            for($i = 0; $i < $dias; $i++){
                $fecha = date("y-m-d",strtotime($fecha."+ 1 day"));
                array_push($turnos["fechas"], [
                    "fecha" =>  $fecha,
                ]);
            }
            while ($horas > 0) {
                foreach ($per_id as $per) {
                    $datos = array();
                    $datos['persona'] = $per;
                    $datos['fecha_ingreso'] = $fecha;
                    $datos['hora_ent'] = $hora;
                    $horas = $horas-$intensidad_horaria;
                    $hora = $hora+$intensidad_horaria;
                    if($hora >= 24){
                        $hora = $hora-24;
                        // $diaI = $diaI+1;
                        $fecha = date("y-m-d",strtotime($fecha."+ 1 day")); 
                    }
                    $datos['fecha_salida'] = $fecha;
                    $datos['hora_sal'] = $hora.":00";
                    array_push($turnos["horarios"][$per]["turnos"], [
                        "fecha" =>  $datos['fecha_ingreso'],
                        "hora_entrada" => $datos['hora_ent'],
                        "hora_salida" =>  $datos['hora_sal'],
                    ]);
                    
                    /* echo "------------<br>";
                    echo "<pre>";
                    print_r($datos);
                    echo "</pre>"; */
                    if($horas <= 0){
                        break;
                    }
                }
            }
            
            // print_r(json_encode($turnos));
            /* echo "<pre>";
            print_r ($turnos);
            echo "</pre>"; */
            echo "<table class='table table-bordered'>";
            echo "<tr class='text-center'>";
            echo "<td>";
            echo "</td>";
                foreach ($turnos["fechas"] as $fecha) {
                    echo "<td>";
                    echo $fecha["fecha"];
                    echo "</td>";
                }
            echo "</tr>";
                foreach ($turnos["horarios"] as $horario) {
                    echo "<tr class='text-center'>";
                    echo "<td>";
                    echo "</td>";
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
                <label class="form-check-label" for="'.$con['per_id'].'">
                <li class="list-group-item">
                    <input class="form-check-input per_id" type="checkbox" value="'.$con['per_id'].'" name="per_id[]" id="'.$con['per_id'].'">
                    ';
                        echo $con['per_nombres'];
                echo '
                </li>
                </label>';
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
    /* while ($horas > 0) {

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
    } */

?>