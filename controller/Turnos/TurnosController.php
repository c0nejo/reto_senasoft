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
            $sql = "SELECT per_id, per_nombres FROM persona";
            $nombres_per = $this->obj->query($sql);

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
            $fechac = date("y-m-d",strtotime($fecha_inicio));
            for($i = 0; $i < $dias+1; $i++){
                array_push($turnos["fechas"], [
                    "fecha" =>  $fechac,
                ]);
                $fechac = date("y-m-d",strtotime($fechac."+ 1 day"));
            }
        
            while ($horas > 0) {
                foreach ($per_id as $per) {
                    $datos = array();
                    $datos['persona'] = $per;
                    $datos['fecha_ingreso'] = $fecha;
                    if($hora > 0 && $hora < 12){
                        $tipo_hora = "am";
                    }else{
                        $tipo_hora = "pm";
                    }
                    $datos['hora_ent'] = $hora.":00".$tipo_hora;
                    $horas = $horas-$intensidad_horaria;
                    $hora = $hora+$intensidad_horaria;
                    if($hora >= 24){
                        $hora = $hora-24;
                        // $diaI = $diaI+1;
                        $fecha = date("y-m-d",strtotime($fecha."+ 1 day")); 
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
                    
                    /* echo "------------<br>";
                    echo "<pre>";
                    print_r($datos);
                    echo "</pre>"; */
                    if($horas <= 0){
                        break;
                    }
                }
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
                        }
                    }
                }
            $_SESSION["turnos"] = $turnos;
            // print_r(json_encode($turnos));
            /* echo "<pre>";
            print_r ($turnos);
            echo "</pre>";
            */
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
                    echo "<td>";
                    echo "Fecha: ".$fecha["fecha"];
                    echo "</td>";
                }
            echo "</tr>";
            echo "</thead>";
                foreach ($turnos["horarios"] as $horario) {
                    echo "<tr class='text-center' style='text-center'>";
                        echo "<td>";
                        foreach($nombres_per as $nombre){
                            if($nombre['per_id'] == $horario["id_persona"]){
                                echo $nombre['per_nombres'];
                            }
                        }
                        echo "</td>";
                        foreach ($turnos["fechas"] as $fecha) {
                            foreach ($turnos["horarios"][$horario["id_persona"]]["turnos"] as $turno) {
                                if($turno["fecha"] == $fecha["fecha"]){
                                    if($turno["descanso"] == 0){
                                        echo "<td>";
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
            echo "<a href='".getUrl("Turnos","Turnos","generarTurnos", false, "ajax")."'>";
            echo "<button class='btn btn-success'>";
            echo "Descargar formato";
            echo "</button>";
            echo "</a>";
            echo "<a href='".getUrl("Turnos","Turnos","generarTurnos")."'>";
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
?>