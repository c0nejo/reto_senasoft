<?php 
    include_once '../model/Turnos/TurnosModel.php';
    require_once 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Color;

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
            //Consulta el nombre de las personas en la base de datos
            $sql = "SELECT per_id, per_nombres FROM persona";
            $nombres_per = $this->obj->query($sql);
            //Recupera los datos enviados en el formulario
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];
            $intensidad_horaria = $_POST['intensidad_horaria'];
            $esp_id = $_POST['esp_id'];
            $per_id = $_POST['per_id'];
            $turnos_cantidad = $_POST['turno_dia'];
            $cantidad_turnos = ($turnos_cantidad * floor(24/$intensidad_horaria));
            //Convierte las fechas aun formato de fecha
            $fecha_i = new DateTime($fecha_inicio);
            $fecha_f = new DateTime($fecha_fin);
            //Devuelve los dias que hay entre dos fechas
            $dias = $fecha_i->diff($fecha_f)->days;
            
            //Muktiplica la cantidad de dias por las 24 horas del dia
            $horas = ($dias+1)*24;
            //Hora inicial de primer turno
            $hora = 6;
            //Crea array para guardar el horario y las fechas
            $turnos["horarios"] = array();
            $turnos["fechas"] = array();
            //Crea un objeto por cada persona
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

            //Guarda todas las fechas que hay entra la fecha de inicio y la fecha fin
            $fechac = date("y-m-d",strtotime($fecha_inicio));
            for($i = 0; $i < $dias+1; $i++){
                array_push($turnos["fechas"], [
                    "fecha" =>  $fechac,
                ]);
                $fechac = date("y-m-d",strtotime($fechac."+ 1 day"));
            }
            //Elije la primera persona al azar
            $primera_persona = array_rand($per_id, 1);
            //Inicio de algoritmo
            while ($horas > 0) {
                //Recorre cada una de las personas elegidas en el formulario
                for ($i = 0; $i < $cantidad_turnos; $i++) {
                    $per = $per_id[$primera_persona];
                    $datos = array();
                    $datos['persona'] = $per;
                    $datos['fecha_ingreso'] = $fecha;
                    if($hora > 0 && $hora < 12){
                        $tipo_hora = "am";
                    }else{
                        $tipo_hora = "pm";
                    }
                    $datos['hora_ent'] = $hora.":00".$tipo_hora;
                    $hora = $hora+$intensidad_horaria;
                    if($hora >= 24){
                        $hora = $hora-24;
                    }
                    $datos['fecha_salida'] = $fecha;

                    if($hora > 0 && $hora < 12){
                        $tipo_hora = "am";
                    }else{
                        $tipo_hora = "pm";
                    }
                    $datos['hora_sal'] = $hora.":00".$tipo_hora;

                    array_push($turnos["horarios"][$per]["turnos"], [
                        "fecha" =>  $datos['fecha_ingreso'],
                        "hora_entrada" => $datos['hora_ent'],
                        "hora_salida" =>  $datos['hora_sal'],
                        "descanso" =>  0,
                    ]);

                    $turnos["horarios"][$per]["horas"] += $intensidad_horaria;
                    $primera_persona++;
                    //$hora = $hora-$intensidad_horaria;
                    if ($per == end($per_id)) {
                        $primera_persona = 0;
                    }
                    if($horas <= 0){
                        break;
                    }
                }
                $horas = $horas-$intensidad_horaria;
                if($hora >= 24){
                    $hora = $hora-24;
                }
                $fecha = date("y-m-d",strtotime($fecha."+ 1 day"));

                $hora = $hora+$intensidad_horaria;
            }
            //Agregar descansos
                //recorre Las personas
                foreach ($turnos["horarios"] as $horario) {
                    //recorre las fechas de trabajo
                    foreach ($turnos["fechas"] as $fecha) {
                        //recorre los turnos de cada persona
                        $contador = 0;
                        foreach ($turnos["horarios"][$horario["id_persona"]]["turnos"] as $turno) {
                            if($fecha["fecha"] == $turno["fecha"]){
                                $contador++;   
                            }
                        } 
                        if($contador == 0){
                            array_push($turnos["horarios"][$horario["id_persona"]]["turnos"], [
                                "fecha" =>  $fecha["fecha"],
                                "hora_entrada" => "",
                                "hora_salida" =>  "",
                                "descanso" =>  1,
                            ]);
                            $turnos["horarios"][$horario["id_persona"]]["dias_descanso"] += 1;
                        }
                    }
                }
            $_SESSION["turnos"] = $turnos;
            // print_r(json_encode($turnos));
            /* echo "<pre>";
            print_r ($turnos);
            echo "</pre>"; */
            
            echo "<div class=''>";
            echo "<h4 class='display-6'>Turnos generados</h4>";
            echo "<hr>";
            echo "</div>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered'>";
            echo "<thead class='table-dark'>";
            echo "<tr class='text-center'>";
            echo "<td>";
            echo "</td>";
                foreach ($turnos["fechas"] as $fecha) {
                    echo "<th scope='col'>";
                    echo "Fecha: ".$fecha["fecha"];
                    echo "</th>";
                }
            echo "</tr>";
            echo "</thead>";
                foreach ($turnos["horarios"] as $horario) {
                    echo "<tr class='text-center' style='text-center'>";
                        echo "<th>";
                        foreach($nombres_per as $nombre){
                            if($nombre['per_id'] == $horario["id_persona"]){
                                echo $nombre['per_nombres'];
                            }
                        }
                        echo "</th>";
                        foreach ($turnos["fechas"] as $fecha) {
                            foreach ($turnos["horarios"][$horario["id_persona"]]["turnos"] as $turno) {
                                if($turno["fecha"] == $fecha["fecha"]){
                                    if($turno["descanso"] == 0){
                                        echo "<td scope='col'>";
                                        echo $turno["hora_entrada"]." hasta ".$turno["hora_salida"];
                                        echo "</td>";
                                    }else{
                                        echo "<td class='bg-success align-middle' style='background-color: red; color: white;'>";
                                        echo "Descanso";
                                        echo "</td>";
                                    } 
                                }
                            }
                        }
                    echo "</tr>";
                }
            echo "</table>";
            echo "</div>";
            echo "<hr>";
            echo "<div>";
            echo "<a href='".getUrl("Turnos","Turnos","getCrear")."'>";
            echo "<button class='btn btn-danger ms-3'>";
            echo "Cancelar";
            echo "</button>";
            echo "</a>";
            echo "<button class='btn btn-warning ms-3' onClick='window.location.reload();'>";
            echo "Generar nuevamente";
            echo "</button>";
            echo "<a href='".getUrl("Turnos","Turnos","generarTurnos", false, "ajax")."'>";
            echo "<button class='btn btn-success ms-3'>";
            echo "Descargar formato";
            echo "</button>";
            echo "</a>";
            echo "<a href='".getUrl("Turnos","Turnos","")."'>";
            echo "<button class='btn btn-primary ms-3'>";
            echo "Guardar y descargar";
            echo "</button>";
            echo "</a>";
            echo "</div>";
        }
        public function generarTurnos()
        {
            $turnos = $_SESSION["turnos"];
            $sql = "SELECT per_id, per_nombres FROM persona";
            $nombres_per = $this->obj->query($sql);
            
            $sheet = new Spreadsheet();
            $excel = $sheet->getActiveSheet();

            $letra = "B";
            foreach ($turnos["fechas"] as $fecha) {
                $letra++;
                $excel->setCellValue($letra."2", "".$fecha["fecha"]);
                $excel->getColumnDimension($letra)->setWidth(30);
                $excel->getStyle($letra)->getAlignment()->setHorizontal('center');
            }
            $excel->getStyle('C2:'.$letra.'2')
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THICK)
                    ->setColor(new Color('000000'));

            $excel->getColumnDimension('B')->setWidth(40);
            $num = 2;
            foreach ($turnos["horarios"] as $horario) {
                $letra = "B";
                $num++;
                $excel->getStyle($letra)->getAlignment()->setHorizontal('center');
                foreach($nombres_per as $nombre){
                    if($nombre['per_id'] == $horario["id_persona"]){
                        $excel->setCellValue("".$letra.$num, "".$nombre['per_nombres']);
                        $excel->getStyle("".$letra.$num.":".$letra.$num)
                                ->getBorders()
                                ->getAllBorders()
                                ->setBorderStyle(Border::BORDER_THICK)
                                ->setColor(new Color('000000'));
                    }
                }
                foreach ($turnos["fechas"] as $fecha) {
                    foreach ($turnos["horarios"][$horario["id_persona"]]["turnos"] as $turno) {
                        if($turno["fecha"] == $fecha["fecha"]){
                            $letra++;
                            if($turno["descanso"] == 0){
                                $excel->setCellValue("".$letra.$num, "".$turno["hora_entrada"]." hasta ".$turno["hora_salida"]);
                            }else{
                                $excel->setCellValue("".$letra.$num, "Descanso");
                                $excel->getStyle("".$letra.$num)
                                            ->getFill()
                                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                            ->getStartColor()
                                            ->setARGB('00ff00');
                            } 
                        }
                    }
                }
                
            }
            $excel->getStyle('C3:'.$letra.$num)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
            
            $writer = new Xlsx($sheet);

            $filename = "Reporte.xlsx";
            $ruta = "./".$filename;
            try {
                $writer->save($ruta);
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');

            $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($sheet, 'Xlsx');
            $objWriter->save('php://output');
            unlink($ruta);
            
        }

        public function consultPersonal(){
            $esp_id = $_POST["esp_id"];
            $sql = "SELECT * FROM persona WHERE esp_id = $esp_id";
            $consulta = $this->obj->query($sql);

            echo '<ul class="list-group mb-3 mt-3">';
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
?>