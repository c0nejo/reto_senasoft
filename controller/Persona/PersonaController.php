<?php

    include_once '../model/Persona/PersonaModel.php';

    class PersonaController{

        private $obj;

        public function __construct(){
            //creamos un objeto del modelo para realizar las consultas
            $this->obj = new PersonaModel();
        }
        
        public function consultar(){
            $persona = $this->obj->consultar("*","persona per, especialidad espe, rol r","per.esp_id=espe.esp_id AND per.rol_id=r.rol_id");
            
            //consulta para los select en crear usuario
            $especialidad = $this->obj->consultar("*","especialidad");
            $rol = $this->obj->consultar("*","rol");
            include_once '../view/Persona/crear.php';
            include_once '../view/Persona/consultar.php';
        }

        public function crear(){
            if(isset($_POST)){
                $nombre = $_POST['nombre'];
                $especialidad = $_POST['especialidad'];
                $rol = $_POST['rol'];

                $id = $this->obj->autoincrement("persona","per_id");
                $ejecutar = $this->obj->insertar("persona",false,"$id,'$nombre',$rol,$especialidad");
                if(!$ejecutar){
                    echo "Hubo un problema:\n".$ejecutar;
                }
                redirect(getUrl("Persona","Persona","consultar"));
            }else{
                echo "No llegaron los datos";
                redirect(getUrl("Persona","Persona","consultar"));
            }
        }

        public function getEditar(){
            if(isset($_POST['id'])){
                $id = $_POST['id'];
                $datos = $this->obj->consultar("*","persona per","per.per_id=$id");
                $dat = mysqli_fetch_assoc($datos);
                include_once '../view/Persona/editar.php';
            }
        }

        public function editar(){
            if(isset($_POST)){
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $rol = $_POST['rol'];
                $especialidad = $_POST['especialidad'];
                
                $this->obj->editar(
                    "persona",
                    "persona.per_id=$id",
                    array(
                        "per_id"=>"'$id'",
                        "per_nombres"=>"'$nombre'",
                        "rol_id"=>"'$rol'",
                        "esp_id"=>"'$especialidad'"
                    )
                );
                redirect(getUrl("Persona","Persona","consultar"));
            }else{
                echo "No se enviaron los valores";
                redirect(getUrl("Persona","Persona","consultar"));
            }
        }

        public function eliminar(){
            if(isset($_GET)){
                $id = $_GET['id'];
                $this->obj->eliminar("persona","$id=persona.per_id");
                redirect(getUrl("Persona","Persona","consultar"));
            }else{
                echo "No se han enviado los parametros";
                redirect(getUrl("persona","persona","consultar"));
            }
        }
    }
?>