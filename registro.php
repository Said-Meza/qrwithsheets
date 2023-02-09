<?php
  include("/xampp/htdocs/appQRREGISTRO/programacion.php");
  include("/xampp/htdocs/appQRREGISTRO/phpqrcode/qrlib.php");
  include_once('tbs_class.php'); 
  include_once('plugins/tbs_plugin_opentbs.php'); 
?>

<?php
    $filename='';
  if ($_POST) 
  {
        $nombre=( isset($_POST['nombre']) )? $_POST['nombre']:"";
        $telefono=( isset($_POST['telefono']) )? $_POST['telefono']:"";
        $matricula=( isset($_POST['matricula']) )? $_POST['matricula']:"";
        $correo=( isset($_POST['correo']) )? $_POST['correo']:"";
        $carrea=( isset($_POST['carrera']) )? $_POST['carrera']:"";
        $grado=( isset($_POST['grado']) )? $_POST['grado']:"";

        //genera qr
        $dir='temp/';

        if (!file_exists($dir)) 
            mkdir(($dir));
        
        $filename = $dir.'test.png';

        $tamanio=7;
        $level='M';
        $fromsize=3;
        $contenido= 'Aceptado Gracias por Venir:|'.$nombre.'|'.$telefono.'|'.$matricula.'|'.$correo.'|'.$carrea.'|'.$grado;

        QRcode::png($contenido,$filename,$level,$tamanio);
          //guarda en la base de datos
          $con= new Conexion();

          $sentenciasql="INSERT INTO `alumnos`(`nombre`, `telefono`, `correo`, `carrera`, `matricula`)
          VALUES ('$nombre','$telefono','$correo','$carrea','$matricula');";
          //echo $sentenciasql;

          $con->ejecutar($sentenciasql);
          $con=null;
          


              $TBS = new clsTinyButStrong; 
              $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); 
              //Parametros
              $nomprofesor = $nombre;
              $fechaprofesor = date('Y-m-d');
              $firmadecano = $filename ;
              //Cargando template
              $template = 'QR_B.docx';
              $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);
              //Escribir Nuevos campos
              $TBS->MergeField('pro.nomprofesor', $nomprofesor);
              $TBS->MergeField('pro.fechaprofesor', $fechaprofesor);
              $TBS->VarRef['x'] = $firmadecano;

              $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);

              $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && 
              ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
              $output_file_name = str_replace('.', '_'.date('Y-m-d').'_'.$nombre.$save_as.'.', $template);
              if ($save_as==='') {
                  $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); 
                  header("Location:registro.php");
                  exit();
              } 
              else 
              {
                  $TBS->Show(OPENTBS_FILE, $output_file_name);
                  exit("File [$output_file_name] has been created.");
                  header("Location:registro.php");
              }

          header("Location:registro.php");
  }
  
?>

<!doctype html>
<html lang="en">

<head>
  <title>Registro</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.0.2 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css">
</head>

<body>

  <div class="contenedor" id="contenedor">
    <header>
      <h1>REGISTRO PARA EL EVENTO</h1>
      <p>Ingrese su Informacion</p>
    </header>
    <div class="form" id="form" >
      <form action="" method="post">


        <label for="nombre">Nombre:</label>
        <input type="text" required class="form-controll" name="nombre" id="nombre"
        placeholder="Ej. Juan Perez Hernandez">

        <label for="Telefono">Telefono:</label>
        <input type="text" class="form-x5" name="telefono" id="form-x5" placeholder="Ej. 782 422 32 43">


        <label for="matricula">Matricula:</label>
        <input type="text" required class="form-x1" name="matricula" id="form-x1" placeholder="Ej. 222P2222">

        <label for="correo">Correo:</label>
        <input type="text" class="form-x2" name="correo" id="form-x2" placeholder="Ej. ITSPR@ITSPozarica.EDU.MX">

        <label class="label" for="ocupacion">Carrera:</label><br />
        <select class="form-x4" name="carrera" id="carrera">
          <option value="0">[Escoje una Opcion]</option>
          <option value="SISTEMAS COMPUTACIONALES">SISTEMAS COMPUTACIONALES</option>
          <option value="NANOTECNOLOGIA">NANOTECNOLOGIA</option>
          <option value="ELECTRICIDAD">ELECTRICIDAD</option>
          <option value="MECATRONICA">MECATRONICA</option>
          <option value="ELECTROMECANICA">ELECTROMECANICA</option>
          <option value="GEOCIENCIAS">GEOCIENCIAS</option>
          <option value="CONTADOR PUBLICO">CONTADOR PUBLICO</option>
          <option value="PETROLERA">PETROLERA</option>
          <option value="GESTION EMPRESARIAL">GESTION EMPRESARIAL</option>
          <option value="PETROLERA">PETROLERA</option>
          <option value="INDUSTRIAL">INDUSTRIAL</option>
        </select>

        <label class="label" for="semestre">Grado:</label><br />
        <select class="form-x3" name="semestre" id="semestre">
          <option value="">[Escoge un Semestre]</option>
          <option value="1">1°</option>
          <option value="2">2°</option>
          <option value="3">3°</option>
          <option value="4">4°</option>
          <option value="5">5°</option>
          <option value="6">6°</option>
          <option value="7">7°</option>
          <option value="8">8°</option>
          <option value="9">9°</option>
          <option value="10">10°</option>
          <option value="11">11°</option>
          <option value="12">12°</option>
          <option value="13">13°</option>
          <option value="14">14°</option>
          <option value="15">15°</option>
        </select>

        <button class="btn btn-primary">Generar Codigo QR</button>

      </form>
    </div>
    <div class="container" style="text-align:center ;">
   <!--   <h3> Presiona para Descargar la Imagen o Toma Captura de Pantalla </h3>
    --><?php 
         
            echo '<a href="imagen.png" download><img src= " '.$filename.' " /></a>';
         
          
      ?>
    </div>

    <!--<div class="qr_code" id="qr_code">
      <label for="" >  "Favor de Descargar la Imagen y Presentarla el Dia del Evento"</label>
      <img src="img/qr.png" alt="">
      
      <button class="" id="descargar">Descargar QR</button>
      <a name="" id="" class="btn btn-primary" href="index.html" role="button">Regresar</a>
    </div>-->
  </div>

  <script src="qr.js"></script>
  <script src="filesaver.js"></script>
</body>

</html>