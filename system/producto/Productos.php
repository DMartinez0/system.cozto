<?php 
class Productos{

		public function __construct() { 
     	} 


	public function AddProducto($datos){ // lo que viede del formulario principal
		$db = new dbConn();
    if($this->CompCod($datos["cod"]) == TRUE){
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos
        
                $dotox["xmedida"] = $datos["xmedida"]; unset($datos["xmedida"]);

                if($datos["gravado"] == NULL) $datos["gravado"] = 0;
                if($datos["receta"] == NULL) $datos["receta"] = 0;
                if($datos["servicio"] == NULL) $datos["servicio"] = 0;
                if($datos["compuesto"] == NULL) $datos["compuesto"] = 0;
                if($datos["caduca"] == NULL) $datos["caduca"] = 0;
                if($datos["dependiente"] == NULL) $datos["dependiente"] = 0;
                if($datos["promocion"] == NULL) $datos["promocion"] = 0;
                if($datos["verecommerce"] == NULL) $datos["verecommerce"] = 0;
                if($datos["descuento"] == NULL) $datos["descuento"] = 0;
                $datos["descripcion"] = strtoupper($datos["descripcion"]);
                $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
                $datos["td"] = $_SESSION["td"];
              if ($db->insert("producto", $datos)) {
                  
                  if($_SESSION["root_autoparts"] == "on"){ // si es autopartrs  lo agrego datos
                    $auto = new Autoparts(); 
                    $auto->InsertDataProduct($datos["cod"]);  
                  }

                  if($_SESSION["root_taller"] == "on"){ // si es taller agrego datos
                    $taller = new TallerProductos(); 
                    $taller->InsertDataProduct($datos["cod"]);
                    $taller->AddMedida($datos["cod"], $dotox["xmedida"]);  
                  }


                  $this->Redirect($datos);
              }           

      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }

    } else {
      Alerts::Alerta("error","Error!","El codigo del producto ya existe!");
    }
  
	}




  

 public function CompCod($codigo){
$db = new dbConn();

$a = $db->query("SELECT * FROM producto WHERE cod = '".$codigo."' and td = ".$_SESSION["td"]."");
$cantcod = $a->num_rows;
$a->close();

    if($cantcod > 0){
       return FALSE;
    } else {
      return TRUE;
    }
 }




  public function CompruebaForm($datos){

        if($datos["cod"] == NULL or
          $datos["descripcion"] == NULL or
          $datos["cantidad"] == NULL or
          $datos["existencia_minima"] == NULL or
          $datos["categoria"] == NULL or
          $datos["medida"] == NULL){
          return FALSE;
        } elseif($_SESSION["root_autoparts"] != "on" and $datos["proveedor"] == NULL){  
         return FALSE;
        } else {
         return TRUE;
        }
  }


  public function Redirect($datos){
      if($datos["servicio"] === "on"){
        echo '<script>
        window.location.href="?modal=proadd&key='. $datos["cod"] .'&step=1&cad=0&com=0&dep=0";
        </script>';
      } else {
        echo '<script>
        window.location.href="?modal=proadd&key='. $datos["cod"] .'&step=1&cad='. $datos["caduca"] .'&com='. $datos["compuesto"] .'&dep='. $datos["dependiente"] .'";
        </script>';
      }
  }

  public function IngresarProducto($datox){ // ingresa un nuevo lote de productos
      $db = new dbConn();
      $kardex = new Kardex();
          if($datox["precio_costo"] != NULL){

            // debo actualizar el total (cantidad) de producto
                    if ($r = $db->select("cantidad", "producto", "WHERE cod = '".$datox["producto"]."' and td = ".$_SESSION["td"]."")) { 
                        $canti = $r["cantidad"];
                    } unset($r); 
                                          
              $datos = array();
              $datos["producto"] = $datox["producto"];
              $datos["cant"] = $canti;
              $datos["existencia"] = $canti;
              $datos["precio_costo"] = $datox["precio_costo"];
              $datos["caduca"] = $datox["caduca_submit"];
              $datos["caducaF"] = Fechas::Format($datox["caduca_submit"]);
              $datos["comentarios"] = $datox["comentarios"];
              $datos["user"] = $_SESSION["user"];
              $datos["fecha"] = date("d-m-Y");
              $datos["hora"] = date("H:i:s");
              $datos["fecha_ingreso"] = Fechas::Format(date("d-m-Y"));
              $datos["td"] = $_SESSION["td"];
              $datos["hash"] = $hash = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
              if ($db->insert("producto_ingresado", $datos)) {
                $kardex->IngresarProductoKardex($datox["producto"], $canti, $hash, $datox["precio_costo"]);
                 echo '<script>
                  window.location.href="?modal=proadd&key='. $datox["producto"] .'&step=2&com='. $datox["com"] .'&dep='. $datox["dep"] .'";
                  </script>'; 
                }
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }

  }



  public function AddPrecios($datox){ // ingresa un nuevo lote de productos
      $db = new dbConn();
          if($datox["cantidad"] != NULL or $datox["precio"] != NULL){
              $datos = array();
              $datos["producto"] = $datox["producto"];
              $datos["cant"] = $datox["cantidad"];
              $datos["precio"] = $datox["precio"];
              $datos["td"] = $_SESSION["td"];
              $datos["hash"] = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
              if ($db->insert("producto_precio", $datos)) {

                 Alerts::Alerta("success","Realizado!","Precio agregado correctamente!");
                
              }
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }
          $this->VerPrecios($datox["producto"]);
  }


  public function VerPrecios($producto){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM producto_precio WHERE producto = '$producto' and td = ".$_SESSION["td"]."");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Precio</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["cant"].'</td>
                      <td>'.$b["precio"].'</td>
                      <td><a id="delprecio" hash="'.$b["hash"].'" op="31" producto="'.$producto.'" ><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';

          } $a->close();  
  }


  public function DelPrecios($hash, $producto){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("producto_precio", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Precio eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerPrecios($producto);
  }



  public function CompuestoBusqueda($dato){ // Busqueda para compuestos
    $db = new dbConn();
// echo '<ul id="producto-list">
// <a href="index.php?key="><li onClick="selectProducto(\'descripcion\');">Descripcion</li></a>
// </ul>';

          $a = $db->query("SELECT * FROM producto WHERE (cod like '%".$dato["keyword"]."%' or descripcion like '%".$dato["keyword"]."%') and td = ".$_SESSION["td"]." limit 10");
           if($a->num_rows > 0){
            echo '<table class="table table-sm table-hover">';
    foreach ($a as $b) {
               echo '<tr>
                      <td scope="row"><a id="select-p" cod="'. $b["cod"] .'" descripcion="'. $b["descripcion"] .'"><div>
                      '. $b["cod"] .'  || '. $b["descripcion"] .'</div></a></td>
                    </tr>'; 
    }  $a->close();

        echo '
        </table>';
          } else {
            echo "El criterio de busqueda no corresponde a un producto";
          }
  }


    public function AddCompuesto($datox){
      $db = new dbConn();
          if($datox["cantidad"] != NULL or $datox["producto-codigo"] != NULL){
              $datos = array();
              $datos["producto"] = $datox["producto"];
              $datos["cant"] = $datox["cantidad"];
              $datos["agregado"] = $datox["producto-codigo"];
              $datos["td"] = $_SESSION["td"];
              $datos["hash"] = Helpers::HashId();
               $datos["time"] = Helpers::TimeId();
              if ($db->insert("producto_compuestos", $datos)) {

                 Alerts::Alerta("success","Realizado!","Compuesto agregado correctamente!");
                
              }
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }
           $this->VerCompuesto($datox["producto"]);
    }



  public function GetNombreProducto($cod){
      $db = new dbConn();
      if ($r = $db->select("descripcion", "producto", "WHERE cod = '".$cod."' and td = ".$_SESSION["td"]."")) { 
        $nombre = $r["descripcion"];
      }  unset($r); 
      return $nombre;
  }

  public function VerCompuesto($producto){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM producto_compuestos WHERE producto = '$producto' and td = ".$_SESSION["td"]."");
          if($a->num_rows > 0){

        echo 'PRODUCTOS QUE LO COMPONE
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Producto Agregado</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["cant"].'</td>
                      <td>'.$this->GetNombreProducto($b["agregado"]).'</td>
                      <td><a id="delcompuesto" hash="'.$b["hash"].'" op="34" producto="'.$producto.'"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';

          } $a->close();  
  }

  public function DelCompuesto($hash, $producto){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("producto_compuestos", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Compuesto eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerCompuesto($producto);
  }



    public function AddDependiente($datox){
      $db = new dbConn();
          if($datox["cantidad"] != NULL or $datox["producto-codigo"] != NULL){
              $datos = array();
              $datos["producto"] = $datox["producto"];              
              $datos["dependiente"] = $datox["producto-codigo"];
              $datos["cant"] = $datox["cantidad"];
              $datos["td"] = $_SESSION["td"];
              $datos["hash"] = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
              if ($db->insert("producto_dependiente", $datos)) {

                  Alerts::Alerta("success","Realizado!","Dependiente agregado correctamente!");
              }
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }
        $this->VerDependiente($datox["producto"]);
    }


  public function VerDependiente($producto){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM producto_dependiente WHERE producto = '$producto' and td = ".$_SESSION["td"]."");
          if($a->num_rows > 0){

        echo 'PRODUCTO QUE LO COMPONE
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Producto Agregado</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["cant"].'</td>
                      <td>'.$this->GetNombreProducto($b["dependiente"]).'</td>
                      <td><a id="deldependiente" hash="'.$b["hash"].'" op="36" producto="'.$producto.'" ><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';

          } $a->close();  
  }


  public function DelDependiente($hash, $producto){ // elimina dependiente
    $db = new dbConn();
        if (Helpers::DeleteId("producto_dependiente", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Dependiente eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerDependiente($producto);
  }




//////////tags

  public function TagsBusqueda($keyword){ // Busquedade tags agragados
    $db = new dbConn();
      $a = $db->query("SELECT * FROM producto_tags WHERE tag like '%".$keyword."%' and td = ".$_SESSION["td"]." GROUP BY tag limit 3");
           if($a->num_rows > 0){
            echo '<table class="table table-sm table-hover">';
                 foreach ($a as $b) {
                 echo '<tr>
                        <td scope="row"><a id="select-tag" tag="'. $b["tag"] .'">'. $b["tag"] .'</a></td>
                      </tr>'; 
             }  $a->close();

        echo '
        </table>';
          } 
  }



    public function AddTag($datox){
      $db = new dbConn();

      $producto = $datox["producto"];

      // print_r($datox);
          if($datox["etiquetas"] != NULL){
          // verifico si hay tag para el producto si hay lo extraigo y le agrego uno mas, sino agrego uno nuevo
              $a = $db->query("SELECT * FROM producto_tags WHERE producto = '$producto' and td = " . $_SESSION['td']);
              if ($a->num_rows > 0) {
                    $tags = array();
                    $iden = 0;

                    foreach ($a as $b) {
                        $tags[$iden] = $b['tag'];
                        $iden ++;
                    }

                    Helpers::DeleteId("producto_tags", "producto = '$producto' and td = " . $_SESSION['td']);

                    $cadena = NULL;
                    $counter = 1;
                    foreach ($tags as $tag) {
                      if ($counter == 1) {
                        $cadena .=  trim($tag);
                      } else {
                        $cadena .= ',' . trim($tag);
                      }
                        $counter ++;
                    }
                    $cadena = $cadena . ',' . $datox["etiquetas"];
                    $datos = array();
                    $datos["producto"] = $producto;              
                    $datos["tag"] = $cadena;
                    $datos["td"] = $_SESSION["td"];
                    $datos["hash"] = Helpers::HashId();
                    $datos["time"] = Helpers::TimeId();
                    $db->insert("producto_tags", $datos);
              
              $a->close();
              } 
              else {
                $datos = array();
                $datos["producto"] = $producto;              
                $datos["tag"] = $datox["etiquetas"];
                $datos["td"] = $_SESSION["td"];
                $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
                $db->insert("producto_tags", $datos);

              }


              $this->VerTag($producto);
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }
    }


    public function DelTag($hash, $producto){ // elimina dependiente
      $db = new dbConn();


      $a = $db->query("SELECT * FROM producto_tags WHERE producto = '$producto' and td = " . $_SESSION['td']);
      if ($a->num_rows > 0) {
            $tags = array();

            foreach ($a as $b) {
                $tags = $b['tag'];
            }


            $tags = explode(',', $tags);


            $i = 0;
            $cadena = null;
            foreach ($tags as $tag) {
              if ($hash == $tag) {
                unset($tag);
              } else {
                if ($i == 0) {
                  $cadena .= $tag;
                } else {
                  $cadena .= "," . $tag;
                }
                $i++;
              }

            }


            if ($cadena == '') {
                Helpers::DeleteId("producto_tags", "producto = '$producto' and td = " . $_SESSION['td']);
                Alerts::Alerta("success","Eliminado!","Etiqueta eliminada correctamente!");
            } else {

              $cambio = array();
              $cambio["tag"] = $cadena;
              Helpers::UpdateId("producto_tags", $cambio, "producto = '$producto' and td = " . $_SESSION['td']); 

            Alerts::Alerta("success","Eliminado!","Etiqueta eliminada correctamente!");
            }
      $a->close();
      }
        $this->VerTag($producto);
    }




  public function VerTag($producto){
      $db = new dbConn();

      if ($r = $db->select("tag", "producto_tags", "WHERE producto = '$producto' and td = ".$_SESSION["td"]."")) { 
        $tags = $r["tag"];
    } unset($r); 

    if ($tags) {
      $tags = explode(',', $tags);
      foreach ($tags as $tag) {
        echo '<div class="chip cyan lighten-4">
                  '.$tag.'
                <a id="deltag" hash="'.$tag.'" op="39" producto="'.$producto.'"> 
                <i class="close fa fa-times"></i>
                </a>
              </div>';
      }
    }


  }



/////// asignar ubicacion

    public function AddUbicacionAsig($datox){
      $db = new dbConn(); 
      // aqui comruebo si se le puede agregar
        if ($r = $db->select("sum(cant)", "ubicacion_asig", "WHERE producto = ".$datox["producto"]." and td = ".$_SESSION["td"]."")) { $suma = $r["sum(cant)"]; } unset($r);
              $prototal = $this->CuentaProductosU($datox["producto"]);

              $disponible = $prototal - $suma;
        if($disponible >= $datox["cantidad"]){       
          if($datox["cantidad"] != NULL or $datox["ubicacion"] != NULL){
              $datos = array();
              $datos["ubicacion"] = $datox["ubicacion"];              
              $datos["producto"] = $datox["producto"];
              $datos["cant"] = $datox["cantidad"];
              $datos["td"] = $_SESSION["td"];
              $datos["hash"] = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
              if ($db->insert("ubicacion_asig", $datos)) {
                  Alerts::Alerta("success","Agregado!","Agregado correctamente!");
              }
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }
      } else {
        Alerts::Alerta("error","Error!","La cantidad disponible es menor a la que desea asignar!");
      }
      $this->VerUbicacionAsig($datox["producto"]);

    }



  public function VerUbicacionAsig($producto){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM ubicacion_asig WHERE producto = '$producto' and td = ".$_SESSION["td"]."");
          if($a->num_rows > 0){

        echo 'DONDE SE ENCUETRA UBICADO EL PRODUCTO
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Ubicacion Agregado</th>
              <th scope="col">Eliminar</th>
              <th scope="col">Principal</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
          $canta = 0;
              foreach ($a as $b) { 
                $ubica = $b["ubicacion"];
                if ($r = $db->select("ubicacion, predeterminada", "ubicacion", "WHERE hash = '$ubica' and td = ".$_SESSION["td"]."")) { 
                        $nombre = $r["ubicacion"];
                        $predeterminada = $r["predeterminada"];
                      }  unset($r); 
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["cant"].'</td>
                      <td>'.$nombre.'</td>
                      <td><a id="delubicacionasig" hash="'.$b["hash"].'" op="41" producto="'.$producto.'" ><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                      <td>';
                  if($predeterminada == 1){
                    echo '<i class="fa fa-check-circle fa-lg green-text"></i>';
                  }                  
                  echo '</td>
                    </tr>';
                    $canta =  $canta + $b["cant"];          
              }
        echo '</tbody>
        </table>

        Total Asignado: ' . $canta;

          } $a->close();  
  }



  public function DelUbicacionAsig($hash, $producto){ // elimina ubicacion asig
    $db = new dbConn();
        if (Helpers::DeleteId("ubicacion_asig", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Ubicacion eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerUbicacionAsig($producto);
  }


  public function SelectUbicacion(){ // Es el Select de la Ubicacion Para poder Recargarlo
    $db = new dbConn();
    $a = $db->query("SELECT hash, ubicacion FROM ubicacion WHERE td = ".$_SESSION["td"].""); 
           echo '<select class="browser-default custom-select" id="ubicacion" name="ubicacion">
                  <option selected disabled>Ubicaci&oacuten</option>';

             foreach ($a as $b) {
              echo '<option value="'. $b["hash"] .'">'. $b["ubicacion"] .'</option>'; 
                } $a->close();
          echo '</select>';          

  }

  public function CuentaProductosU($cod){ //
    $db = new dbConn();
        if ($r = $db->select("cantidad", "producto", "WHERE cod = '$cod' and td = ".$_SESSION["td"]."")) { 
        $total = $r["cantidad"];
    } unset($r);  
    return $total; 

  }


// para igualar la ubicacion al salir
  public function IgualarUbicacion($producto){ 
    $db = new dbConn();

    $cantidad = $this->CuentaProductosU($producto);

    $a = $db->query("SELECT sum(cant) FROM ubicacion_asig WHERE producto = '$producto' and td = ".$_SESSION["td"]."");
    foreach ($a as $b) {
        $suma=$b["sum(cant)"];
    } $a->close();

$dif = $cantidad - $suma;

// busco la predeterminada
    if ($r = $db->select("hash", "ubicacion", "WHERE predeterminada = 1 and td = ".$_SESSION["td"]."")) { 
        $hashpredet = $r["hash"];
    } unset($r);  

    if ($r = $db->select("cant", "ubicacion_asig", "WHERE producto = '$producto' and ubicacion = '$hashpredet' and td = ".$_SESSION["td"]."")) { 
        $cantpredet = $r["cant"];
    } unset($r);  

// verifico si exite ya el producto asignado
$a = $db->query("SELECT * FROM ubicacion_asig WHERE producto = '$producto' and ubicacion = '$hashpredet' and td = ".$_SESSION["td"]."");
$exispredet = $a->num_rows;
$a->close();

if($exispredet == 0){
 // agrego el registro
    $datos = array();
    $datos["ubicacion"] = $hashpredet;
    $datos["producto"] = $producto;
    $datos["cant"] = $dif;
    $datos["td"] = $_SESSION["td"];
    $datos["hash"] = Helpers::HashId();
    $datos["time"] = Helpers::TimeId();
    $db->insert("ubicacion_asig", $datos); 
} else {
  // actualiza el registro
  $up = $suma - $cantpredet;
  $up = $cantidad - $up;

    $cambio = array();
    $cambio["cant"] = $up;
    Helpers::UpdateId("ubicacion_asig", $cambio, "producto = '$producto' and ubicacion = '".$hashpredet."' and td = ".$_SESSION["td"]."");
}



  }



///////////////// caracteristicas asign

    public function AddCaracteristicaAsig($datox){
      $db = new dbConn(); 
      // aqui comruebo si se le puede agregar
        if ($r = $db->select("sum(cant)", "caracteristicas_asig", "WHERE caracteristica = ".$datox["caracteristica"]." and producto = ".$datox["producto"]." and td = ".$_SESSION["td"]."")) { $suma = $r["sum(cant)"]; } unset($r);
              $prototal = $this->CuentaProductosU($datox["producto"]);

              $disponible = $prototal - $suma;
        if($disponible >= $datox["cantidad"]){       
          if($datox["cantidad"] != NULL or $datox["caracteristica"] != NULL){
              $datos = array();
              $datos["caracteristica"] = $datox["caracteristica"];              
              $datos["producto"] = $datox["producto"];
              $datos["cant"] = $datox["cantidad"];
              $datos["td"] = $_SESSION["td"];
              $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
              if ($db->insert("caracteristicas_asig", $datos)) {
                  Alerts::Alerta("success","Agregado!","Agregado correctamente!");
              }
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }
      } else {
        Alerts::Alerta("error","Error!","La cantidad disponible es menor a la que desea asignar!");
      }
      $this->VerCaracteristicaAsig($datox["producto"]);
    }



  public function VerCaracteristicaAsig($producto){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM caracteristicas_asig WHERE producto = '$producto' and td = ".$_SESSION["td"]."");
          if($a->num_rows > 0){

        echo 'CARACTERISTICAS ASIGNADAS
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Caracteristica Agregado</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
          $canta = 0;
              foreach ($a as $b) { 
                if ($r = $db->select("caracteristica", "caracteristicas", "WHERE hash = '".$b["caracteristica"]."' and td = ".$_SESSION["td"]."")) { 
                        $nombre = $r["caracteristica"];
                      }  unset($r); 
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["cant"].'</td>
                      <td>'.$nombre.'</td>
                      <td><a id="delcaracteristicaasig" hash="'.$b["hash"].'" op="44" producto="'.$producto.'" ><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';
                    $canta =  $canta + $b["cant"];          
              }
        echo '</tbody>
        </table>

        Total Asignado: ' . $canta;

          } $a->close();  
  }



  public function DelCaracteristicaAsig($hash, $producto){ // elimina ubicacion asig
    $db = new dbConn();
        if (Helpers::DeleteId("caracteristicas_asig", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Caracteristica eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerCaracteristicaAsig($producto);
  }

  public function SelectCaracteristica(){ // Es el Select de la Ubicacion Para poder Recargarlo
    $db = new dbConn();
    $a = $db->query("SELECT hash, caracteristica FROM caracteristicas WHERE td = ".$_SESSION["td"].""); 
           echo '<select class="browser-default custom-select" id="caracteristica" name="caracteristica">
                  <option selected disabled>Caracteristica</option>';

             foreach ($a as $b) {
              echo '<option value="'. $b["hash"] .'">'. $b["caracteristica"] .'</option>'; 
                } $a->close();
          echo '</select>';          

  }




// /////////////////  categorias








  public function AddCategoria($datos){ // agrega una categoria para ponersela al producto
    $db = new dbConn();

      if($datos["categoria"] != NULL){
              $datos["categoria"] = strtoupper($datos["categoria"]);
              $datos["hash"] = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("producto_categoria", $datos)) {
                   Alerts::Alerta("success","Agregado!","Agregado Correctamente!");
                  
              }else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
          }
      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
      $this->VerCategoria();
  }


  public function AddSubCategoria($datos){ // agrega una sub categoria para ponersela al producto
    $db = new dbConn();

      $datos["categoria"] = $datos["categoriax"]; unset($datos["categoriax"]);
 
      if($datos["categoria"] != NULL and $datos["subcategoria"] != NULL){
              $datos["subcategoria"] = $datos["subcategoria"];
              $datos["hash"] = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("producto_categoria_sub", $datos)) {
                   Alerts::Alerta("success","Agregado!","Agregado Correctamente!");
                  
              }else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
          }
      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
      $this->VerCategoria();
  }


  public function VerCategoria(){ // listado de categorias
    $db = new dbConn();

      $a = $db->query("SELECT categoria, hash FROM producto_categoria WHERE td = ".$_SESSION["td"]."");
      if($a->num_rows > 0){
    echo '<table class="table table-sm table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Categoria</th>
          <th scope="col">Eliminar</th>
        </tr>
      </thead>
      <tbody>';
      $n = 1;
          foreach ($a as $b) { ;
            echo '<tr>
                  <th scope="row">'. $n ++ .'</th>
                  <td>'.$b["categoria"].'</td>
                  <td><a id="xdelete" valor="1" tipo="1" hash="'.$b["hash"].'" op="23" ><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                </tr>';  
                
                $x = $db->query("SELECT subcategoria, hash FROM producto_categoria_sub WHERE categoria = '".$b["hash"]."' and td = ".$_SESSION["td"]."");
                          foreach ($x as $y) { ;
                    echo '<tr class="blue lighten-5">
                          <th scope="row"> -- </th>
                          <td>'.$y["subcategoria"].'</td>
                          <td><a id="xdelete" valor="1" tipo="2" hash="'.$y["hash"].'" op="23" ><i class="fa fa-minus-circle fa-lg red-text"></i></a>

                          <a id="cedit" hash="'.$y["hash"].'" op="23z" ><i class="fa fa-edit fa-lg green-text ml-4"></i></a>

                          </td>
                        </tr>';                            
                  }  $x->close();
      
                        
          }
    echo '</tbody>
    </table>';

      } $a->close();
  }



  public function NombreCat($hash){ // nombre de categorias
    $db = new dbConn();
    if ($r = $db->select("subcategoria", "producto_categoria_sub", "WHERE hash = '".$hash."' and td = ".$_SESSION["td"]."")) { 
        echo $r["subcategoria"];
    } unset($r);  
  }



  public function RenameCat($data){ //cambia nombre
    $db = new dbConn();

      $cambio = array();
      $cambio["subcategoria"] = $data["ncategoria"];
      if(Helpers::UpdateId("producto_categoria_sub", $cambio, "hash='".$data["hash"]."' 
        and td = ".$_SESSION["td"]."")){
        Alerts::Alerta("success","Renombrada!","Categoria Renombrada correctamente!");
      }  else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        }

      $this->VerCategoria();
  }





  public function DelCategoria($hash, $tipo){ // elimina categoria
    $db = new dbConn();

    if($tipo == "1"){
        if (Helpers::DeleteId("producto_categoria", "hash='$hash'")) {
            Helpers::DeleteId("producto_categoria_sub", "categoria='$hash'"); // borro las subcategorias
           Alerts::Alerta("success","Eliminado!","Categoria eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
    }

    if($tipo == "2"){
        if (Helpers::DeleteId("producto_categoria_sub", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Sub categoria eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
    }

      $this->VerCategoria();
  }








// Unidades de medida

  public function AddUnidad($datos){ // agrega una unidad de medida para ponersela al producto
    $db = new dbConn();

      if($datos["nombre"] != NULL and $datos["abreviacion"] != NULL){
              $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("producto_unidades", $datos)) {
                  
                  Alerts::Alerta("success","Agregado!","Agregado Correctamente!");
                  
              }else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
          }
      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
      $this->VerUnidad();
  }




  public function VerUnidad(){ // listado de Unidad
    $db = new dbConn();

      $a = $db->query("SELECT * FROM producto_unidades WHERE td = ".$_SESSION["td"]."");
      if($a->num_rows > 0){
    echo '<table class="table table-sm table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Unidad de medida</th>
          <th scope="col">Abreviaci&oacuten</th>
          <th scope="col">Eliminar</th>
        </tr>
      </thead>
      <tbody>';
      $n = 1;
          foreach ($a as $b) { ;
            echo '<tr>
                  <th scope="row">'. $n ++ .'</th>
                  <td>'.$b["nombre"].'</td>
                  <td>'.$b["abreviacion"].'</td>
                  <td><a id="xdelete" valor="2" hash="'.$b["hash"].'" op="25"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                </tr>';          
          }
    echo '</tbody>
    </table>';

      } $a->close();
  }



  public function DelUnidad($hash){ // elimina Unidad
    $db = new dbConn();
        if (Helpers::DeleteId("producto_unidades", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Categoria eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerUnidad();
  }





// caracteristicas

  public function AddCaracteristica($datos){ // agrega una caracteritica para ponersela al producto
    $db = new dbConn();

      if($datos["caracteristica"] != NULL){
              $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("caracteristicas", $datos)) {
                  
                  Alerts::Alerta("success","Agregado!","Agregado Correctamente!");
                  
              }else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
          }
      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
      $this->VerCaracteristica();
  }




  public function VerCaracteristica(){ // listado de caracteristicas
    $db = new dbConn();

      $a = $db->query("SELECT * FROM caracteristicas WHERE td = ".$_SESSION["td"]."");
      if($a->num_rows > 0){
    echo '<table class="table table-sm table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Caracteristica</th>
          <th scope="col">Eliminar</th>
        </tr>
      </thead>
      <tbody>';
      $n = 1;
          foreach ($a as $b) { ;
            echo '<tr>
                  <th scope="row">'. $n ++ .'</th>
                  <td>'.$b["caracteristica"].'</td>
                  <td><a id="xdelete" valor="3" hash="'.$b["hash"].'" op="27"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                </tr>';          
          }
    echo '</tbody>
    </table>';

      } $a->close();
  }



  public function DelCaracteristica($hash){ // elimina caracteristica
    $db = new dbConn();
        if (Helpers::DeleteId("caracteristicas", "hash='$hash'")) {
            Helpers::DeleteId("caracteristicas_asig", "caracteristica='$hash' and td = " . $_SESSION["td"]);
           Alerts::Alerta("success","Eliminado!","Caracteristica eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerCaracteristica();
  }








// ubicacion

  public function AddUbicacion($datos){ // agrega una ubicacion para ponersela al producto
    $db = new dbConn();

$a = $db->query("SELECT * FROM ubicacion WHERE td = ".$_SESSION["td"]."");
if($a->num_rows == 0){
  $predet = 1;
} else {
  $predet = 0;
} $a->close();


      if($datos["ubicacion"] != NULL){
              $datos["predeterminada"] = $predet;
              $datos["hash"] = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("ubicacion", $datos)) {
                  
                  Alerts::Alerta("success","Agregado!","Agregado Correctamente!");
                  
              }else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
          }
      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
      $this->VerUbicacion();
  }




  public function VerUbicacion(){ // listado de ubicacion
    $db = new dbConn();

      $a = $db->query("SELECT * FROM ubicacion WHERE td = ".$_SESSION["td"]."");
      if($a->num_rows > 0){
    echo '<table class="table table-sm table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Ubicaci&oacuten</th>
          <th scope="col">Eliminar</th>
          <th scope="col">Principal</th>
        </tr>
      </thead>
      <tbody>';
      $n = 1;
          foreach ($a as $b) { ;
            echo '<tr>
                  <th scope="row">'. $n ++ .'</th>
                  <td>'.$b["ubicacion"].'</td>
                  <td><a id="xdelete" valor="4" hash="'.$b["hash"].'" op="29"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                  <td>';
                  if($b["predeterminada"] == 1){
                    echo '<i class="fas fa-check-circle fa-lg green-text"></i>';
                  } else {
                    echo '<i class="fas fa-ban fa-lg red-text"></i>';
                  }                  
                  echo '

                  <a id="uedit" hash="'.$b["hash"].'" op="28z" ><i class="fa fa-edit fa-lg green-text ml-4"></i></a>
                  </td>
                </tr>';          
          }
    echo '</tbody>
    </table>';

      } $a->close();
  }


  public function NombreUbi($hash){ // nombre de categorias
    $db = new dbConn();
    if ($r = $db->select("ubicacion", "ubicacion", "WHERE hash = '".$hash."' and td = ".$_SESSION["td"]."")) { 
        echo $r["ubicacion"];
    } unset($r);  
  }



  public function RenameUbi($data){ //cambia nombre
    $db = new dbConn();

      $cambio = array();
      $cambio["ubicacion"] = $data["nubicacion"];
      if(Helpers::UpdateId("ubicacion", $cambio, "hash='".$data["uhash"]."' 
        and td = ".$_SESSION["td"]."")){
        Alerts::Alerta("success","Renombrada!","Ubicación Renombrada correctamente!");
      }  else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        }

      $this->VerUbicacion();
  }






  public function DelUbicacion($hash){ // elimina ubicacion
    $db = new dbConn();
// verifico que no sea la predeterminada

    if ($r = $db->select("predeterminada", "ubicacion", "WHERE hash='$hash' and td = ".$_SESSION["td"]."")) { 
        $predeterminada = $r["predeterminada"];
    } unset($r);  

if($predeterminada != "1"){

   
// veo cal es la predeterminada
    if ($r = $db->select("hash", "ubicacion", "WHERE predeterminada = 1 and td = ".$_SESSION["td"]."")) { 
        $hashpredet = $r["hash"];
    } unset($r);  


    $a = $db->query("SELECT producto, cant, ubicacion FROM ubicacion_asig WHERE ubicacion='$hash' and td = ".$_SESSION["td"]."");
    foreach ($a as $b) {

        $producto = $b["producto"];
        $cant = $b["cant"];
        $ubicacion = $b["ubicacion"];

    if ($r = $db->select("cant", "ubicacion_asig", "WHERE producto='".$b["producto"]."' and ubicacion = '$hashpredet' and td = ".$_SESSION["td"]."")) { 
        $cantpredet = $r["cant"];
    } unset($r);  
 // actualizo
          $cambio = array();
          $cambio["cant"] = $cantpredet + $cant;
          Helpers::UpdateId("ubicacion_asig", $cambio, "producto='".$b["producto"]."' and ubicacion = '".$hashpredet."' and td = ".$_SESSION["td"]."");   

    } $a->close();

//


        if (Helpers::DeleteId("ubicacion", "hash='$hash'")) {
          Helpers::DeleteId("ubicacion_asig", "ubicacion='$hash' and td = " . $_SESSION["td"] );  
           Alerts::Alerta("success","Eliminado!","Ubicacion eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        }
} else {
  Alerts::Alerta("error","Error!","No se puede eliminar la ubicación predeterminada!");
}       
      $this->VerUbicacion();
  }








  public function VerTodosProductos($npagina, $orden, $dir){
      $db = new dbConn();

  $limit = 25;
  $adjacents = 2;
  if($npagina == NULL) $npagina = 1;
  $a = $db->query("SELECT * FROM producto WHERE td = ". $_SESSION['td'] ."");
  $total_rows = $a->num_rows;
  $a->close();

  $total_pages = ceil($total_rows / $limit);
  
  if(isset($npagina) && $npagina != NULL) {
    $page = $npagina;
    $offset = $limit * ($page-1);
  } else {
    $page = 1;
    $offset = 0;
  }

if($dir == "desc") $dir2 = "asc";
if($dir == "asc") $dir2 = "desc";

 $a = $db->query("SELECT producto.cod, producto.descripcion, producto.cantidad, producto.existencia_minima, producto.compuesto, producto.dependiente, producto.servicio, producto_categoria_sub.subcategoria FROM producto INNER JOIN producto_categoria_sub ON producto.categoria = producto_categoria_sub.hash and producto.td = ".$_SESSION["td"]." order by ".$orden." ".$dir." limit $offset, $limit");
      
      if($a->num_rows > 0){
          echo '<div class="table-responsive">
          <table class="table table-sm table-striped">
        <thead>
          <tr>
            <th class="th-sm"><a id="paginador" op="54" iden="1" orden="producto.cod" dir="'.$dir2.'">Cod</a></th>';

            if($this->CompruebaSiMarca() == TRUE){
              echo '<th class="th-sm"><a >Marca</a></th>';
            }

          echo '<th class="th-sm"><a id="paginador" op="54" iden="1" orden="producto.descripcion" dir="'.$dir2.'">Producto</a></th>
            <th class="th-sm"><a id="paginador" op="54" iden="1" orden="producto.cantidad" dir="'.$dir2.'">Cantidad</a></th>
            <th class="th-sm"><a id="paginador" op="54" iden="1" orden="producto.categoria" dir="'.$dir2.'">Categoria</a></th>
            <th class="th-sm">Precio</th>
            <th class="th-sm d-none d-md-block"><a id="paginador" op="54" iden="1" orden="producto.existencia_minima" dir="'.$dir2.'">Minimo</a></th>
            <th class="th-sm">Ver</th>
          </tr>
        </thead>
        <tbody>';
        foreach ($a as $b) {
        // obtener el nombre y detalles del producto
    if ($r = $db->select("*", "pro_dependiente", "WHERE iden = ".$b["producto"]." and td = ". $_SESSION["td"] ."")) { 
        $producto = $r["nombre"]; } unset($r); 


 if ($r = $db->select("precio", "producto_precio", "WHERE producto = '".$b["cod"]."' and td = ". $_SESSION["td"] ."")) { 
        $precio = $r["precio"]; } unset($r); 

/// cantidad de productos dependientes


          echo '<tr>
                      <td>'.$b["cod"].'</td>';

  if($this->CompruebaSiMarca() == TRUE){
    echo '<th class="th-sm"><a >'.$this->MostrarMarca($b["cod"]).'</a></th>';
  }

/// cantidad solo si es producto, si es servio o dependiente no aplica
if($b["compuesto"] == "on"){
  $cantidad = '<i class="fas fa-exclamation-triangle text-info"></i>';
} else if($b["dependiente"] == "on"){
  $cantidad = '<i class="fas fa-exclamation-circle text-info"></i>';
} else if($b["servicio"] == "on"){
  $cantidad = '<i class="fas fa-exclamation-circle text-info"></i>';
} else {
  $cantidad = $b["cantidad"];
}

                echo '<td>'.$b["descripcion"].'</td>
                      <td>'.$cantidad.'</td>
                      <td>'.$b["subcategoria"].'</td>
                      <td>'.$precio.'</td>
                      <td class="d-none d-md-block">'.$b["existencia_minima"].'</td>
                      <td>
                      <a href="?kardex&key='.$b["cod"].'"><i class="fab fa-korvue fa-lg blue-text"></i></a>
                      <a id="xver" op="55" key="'.$b["cod"].'"><i class="fas fa-search fa-lg green-text ml-3"></i></a>';

// aqui iria el  de borrar producto
if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5){
    echo '<a id="delpro" op="550" iden="'.$b["cod"].'"> <i class="fas fa-trash fa-lg red-text ml-3"></i></a>';
    echo '<a id="barcode" op="122" iden="'.$b["cod"].'"> <i class="fas fa-barcode fa-lg back-text ml-3"></i></a>';
}


                      echo '</td>
                    </tr>';
        }
        echo '</tbody>
        </table>
        </div>';


      }
        $a->close();

  if($total_pages <= (1+($adjacents * 2))) {
    $start = 1;
    $end   = $total_pages;
  } else {
    if(($page - $adjacents) > 1) {  
      if(($page + $adjacents) < $total_pages) {  
        $start = ($page - $adjacents); 
        $end   = ($page + $adjacents); 
      } else {              
        $start = ($total_pages - (1+($adjacents*2))); 
        $end   = $total_pages; 
      }
    } else {
      $start = 1; 
      $end   = (1+($adjacents * 2));
    }
  }
echo $total_rows . " Registros encontrados";
   if($total_pages > 1) { 

$page <= 1 ? $enable = 'disabled' : $enable = '';
    echo '<ul class="pagination pagination-sm justify-content-center">
    <li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="54" iden="1" orden="'.$orden.'" dir="'.$dir.'">&lt;&lt;</a>
      </li>';
    
    $page>1 ? $pagina = $page-1 : $pagina = 1;
    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="54" iden="'.$pagina.'" orden="'.$orden.'" dir="'.$dir.'">&lt;</a>
      </li>';

    for($i=$start; $i<=$end; $i++) {
      $i == $page ? $pagina =  'active' : $pagina = '';
      echo '<li class="page-item '.$pagina.'">
        <a class="page-link" id="paginador" op="54" iden="'.$i.'" orden="'.$orden.'" dir="'.$dir.'">'.$i.'</a>
      </li>';
    }

    $page >= $total_pages ? $enable = 'disabled' : $enable = '';
    $page < $total_pages ? $pagina = ($page+1) : $pagina = $total_pages;
    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="54" iden="'.$pagina.'" orden="'.$orden.'" dir="'.$dir.'">&gt;</a>
      </li>';

    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="54" iden="'.$total_pages.'" orden="'.$orden.'" dir="'.$dir.'">&gt;&gt;</a>
      </li>

      </ul>';
     }  // end pagination 



    if ($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 5) {
    // boton de imprimir
      echo '<div class="row justify-content-center">
          <a href="system/imprimir/imprimir.php?op=10" class="btn btn-info my-2 btn-rounded btn-sm waves-effect" title="Imprimir todos los productos">Imprimir Todo</a>
        </div>';


         echo '<div class="text-right"><a href="system/documentos/inventario.php" >Descargar Excel</a></div>';      
    }




  } // termina productos









  
  public function VerProductosSearch($npagina, $orden, $dir, $search){
    $db = new dbConn();

$limit = 15;
$adjacents = 2;
if($npagina == NULL) $npagina = 1;
$a = $db->query("SELECT * FROM producto WHERE (cod like '%".$search."%' or descripcion like '%".$search."%') and td = ". $_SESSION['td'] ."");
$total_rows = $a->num_rows;
$a->close();

$total_pages = ceil($total_rows / $limit);

if(isset($npagina) && $npagina != NULL) {
  $page = $npagina;
  $offset = $limit * ($page-1);
} else {
  $page = 1;
  $offset = 0;
}

if($dir == "desc") $dir2 = "asc";
if($dir == "asc") $dir2 = "desc";

$a = $db->query("SELECT producto.cod, producto.descripcion, producto.cantidad, producto.existencia_minima, producto.compuesto, producto.dependiente, producto.servicio, producto_categoria_sub.subcategoria FROM producto INNER JOIN producto_categoria_sub ON producto.categoria = producto_categoria_sub.hash and (producto.cod like '%".$search."%' or producto.descripcion like '%".$search."%') and producto.td = ".$_SESSION["td"]." order by ".$orden." ".$dir." limit $offset, $limit");
    
    if($a->num_rows > 0){
        echo '<div class="table-responsive">
        <table class="table table-sm table-striped">
      <thead>
        <tr>
          <th class="th-sm"><a id="paginador" op="54-b" iden="1" orden="producto.cod" dir="'.$dir2.'">Cod</a></th>';

          if($this->CompruebaSiMarca() == TRUE){
            echo '<th class="th-sm"><a >Marca</a></th>';
          }

        echo '<th class="th-sm"><a id="paginador" op="54-b" iden="1" orden="producto.descripcion" dir="'.$dir2.'">Producto</a></th>
          <th class="th-sm"><a id="paginador" op="54-b" iden="1" orden="producto.cantidad" dir="'.$dir2.'">Cantidad</a></th>
          <th class="th-sm"><a id="paginador" op="54-b" iden="1" orden="producto.categoria" dir="'.$dir2.'">Categoria</a></th>
          <th class="th-sm">Precio</th>
          <th class="th-sm d-none d-md-block"><a id="paginador" op="54-b" iden="1" orden="producto.existencia_minima" dir="'.$dir2.'">Minimo</a></th>
          <th class="th-sm">Ver</th>
        </tr>
      </thead>
      <tbody>';
      foreach ($a as $b) {
      // obtener el nombre y detalles del producto
  if ($r = $db->select("*", "pro_dependiente", "WHERE iden = ".$b["producto"]." and td = ". $_SESSION["td"] ."")) { 
      $producto = $r["nombre"]; } unset($r); 


if ($r = $db->select("precio", "producto_precio", "WHERE producto = '".$b["cod"]."' and td = ". $_SESSION["td"] ."")) { 
      $precio = $r["precio"]; } unset($r); 

/// cantidad de productos dependientes


        echo '<tr>
                    <td>'.$b["cod"].'</td>';

if($this->CompruebaSiMarca() == TRUE){
  echo '<th class="th-sm"><a >'.$this->MostrarMarca($b["cod"]).'</a></th>';
}

/// cantidad solo si es producto, si es servio o dependiente no aplica
if($b["compuesto"] == "on"){
$cantidad = '<i class="fas fa-exclamation-triangle text-info"></i>';
} else if($b["dependiente"] == "on"){
$cantidad = '<i class="fas fa-exclamation-circle text-info"></i>';
} else if($b["servicio"] == "on"){
$cantidad = '<i class="fas fa-exclamation-circle text-info"></i>';
} else {
$cantidad = $b["cantidad"];
}

              echo '<td>'.$b["descripcion"].'</td>
                    <td>'.$cantidad.'</td>
                    <td>'.$b["subcategoria"].'</td>
                    <td>'.$precio.'</td>
                    <td class="d-none d-md-block">'.$b["existencia_minima"].'</td>
                    <td>
                      <a href="?kardex&key='.$b["cod"].'"><i class="fab fa-korvue fa-lg blue-text"></i></a>
                      <a id="xver" op="55" key="'.$b["cod"].'"><i class="fas fa-search fa-lg green-text ml-3"></i></a>';
// aqui iria el  de borrar producto
if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5){
  echo '<a id="delpro" op="550" iden="'.$b["cod"].'"> <i class="fas fa-trash fa-lg red-text ml-3"></i></a>';
  echo '<a id="barcode" op="122" iden="'.$b["cod"].'"> <i class="fas fa-barcode fa-lg back-text ml-3"></i></a>';
}


                    echo '</td>
                  </tr>';
      }
      echo '</tbody>
      </table>
      </div>';


    }
      $a->close();

if($total_pages <= (1+($adjacents * 2))) {
  $start = 1;
  $end   = $total_pages;
} else {
  if(($page - $adjacents) > 1) {  
    if(($page + $adjacents) < $total_pages) {  
      $start = ($page - $adjacents); 
      $end   = ($page + $adjacents); 
    } else {              
      $start = ($total_pages - (1+($adjacents*2))); 
      $end   = $total_pages; 
    }
  } else {
    $start = 1; 
    $end   = (1+($adjacents * 2));
  }
}
echo $total_rows . " Registros encontrados";
 if($total_pages > 1) { 

$page <= 1 ? $enable = 'disabled' : $enable = '';
  echo '<ul class="pagination pagination-sm justify-content-center">
  <li class="page-item '.$enable.'">
      <a class="page-link" id="paginador" op="54-b" iden="1" orden="'.$orden.'" dir="'.$dir.'">&lt;&lt;</a>
    </li>';
  
  $page>1 ? $pagina = $page-1 : $pagina = 1;
  echo '<li class="page-item '.$enable.'">
      <a class="page-link" id="paginador" op="54-b" iden="'.$pagina.'" orden="'.$orden.'" dir="'.$dir.'">&lt;</a>
    </li>';

  for($i=$start; $i<=$end; $i++) {
    $i == $page ? $pagina =  'active' : $pagina = '';
    echo '<li class="page-item '.$pagina.'">
      <a class="page-link" id="paginador" op="54-b" iden="'.$i.'" orden="'.$orden.'" dir="'.$dir.'">'.$i.'</a>
    </li>';
  }

  $page >= $total_pages ? $enable = 'disabled' : $enable = '';
  $page < $total_pages ? $pagina = ($page+1) : $pagina = $total_pages;
  echo '<li class="page-item '.$enable.'">
      <a class="page-link" id="paginador" op="54-b" iden="'.$pagina.'" orden="'.$orden.'" dir="'.$dir.'">&gt;</a>
    </li>';

  echo '<li class="page-item '.$enable.'">
      <a class="page-link" id="paginador" op="54-b" iden="'.$total_pages.'" orden="'.$orden.'" dir="'.$dir.'">&gt;&gt;</a>
    </li>

    </ul>';
   }  // end pagination 


// boton de imprimir
echo '<div class="row justify-content-center">
        <a href="system/imprimir/imprimir.php?op=10" class="btn btn-info my-2 btn-rounded btn-sm waves-effect" title="Imprimir todos los productos">Imprimir Todo</a>
      </div>';


       echo '<div class="text-right"><a href="system/documentos/inventario.php" >Descargar Excel</a></div>';      

} // termina productos












  public function ProductosResumen(){
      $db = new dbConn();


 $a = $db->query("SELECT cod, descripcion, cantidad FROM producto WHERE td = ".$_SESSION["td"]."");
      
      if($a->num_rows > 0){
          echo '<div class="table-responsive">
          <table class="table table-sm table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th class="th-sm">Producto</th>
            <th class="th-sm">Cantidad</th>
            <th class="th-sm">Precio Venta</th>
            <th class="th-sm ">Vendidos</th>
            <th class="th-sm">Ver</th>
          </tr>
        </thead>
        <tbody>';
        $n = 1;
        foreach ($a as $b) {
        // obtener el nombre y detalles del producto
   

    if ($r = $db->select("precio", "producto_precio", "WHERE cant = 1 and producto = '".$b["cod"]."' and td = ". $_SESSION["td"] ."")) { 
        $precio = $r["precio"]; } unset($r); 



    $ax = $db->query("SELECT sum(cant) FROM ticket WHERE cod = '".$b["cod"]."' and td = ". $_SESSION["td"] ."");
    foreach ($ax as $bx) {
        $vendidos=$bx["sum(cant)"];
    } $ax->close();

          echo '<tr>
                      <td>'.$n ++.'</td>
                      <td>'.$b["descripcion"].'</td>
                      <td>'.$b["cantidad"].'</td>
                      <td>'.Helpers::Dinero($precio).'</td>
                      <td>'.$vendidos.'</td>
                      <td><a id="xver" op="55" key="'.$b["cod"].'"><i class="fas fa-search fa-lg green-text"></i></a></td>
                    </tr>';
        }
        echo '</tbody>
        </table>
        </div>';
      }
        $a->close();


  } // termina productos










  public function DetallesProducto($data){
      $db = new dbConn();

    $a = $db->query("SELECT  producto.informacion, producto.cod, producto.descripcion, producto.cantidad, producto.existencia_minima, producto.caduca, producto.compuesto, producto.gravado, producto.receta, producto.dependiente, producto.servicio, producto_categoria_sub.subcategoria, producto_unidades.nombre, proveedores.nombre as proveedores FROM producto INNER JOIN producto_categoria_sub ON producto.categoria = producto_categoria_sub.hash INNER JOIN producto_unidades ON producto.medida = producto_unidades.hash INNER JOIN proveedores ON producto.proveedor = proveedores.hash WHERE producto.cod = '".$data["key"]."' AND producto.td = ".$_SESSION["td"]."");
    
    if($a->num_rows > 0){
        foreach ($a as $b) {    
          
        echo '<blockquote class="blockquote bq-primary">
              <p class="bq-title">'. $b["cod"] .' | '. $b["descripcion"].'</p>
            </blockquote>';

        echo '<ul class="list-group">
              <li class="list-group-item">Categoria: <strong>'. $b["subcategoria"] .'</strong> || Unidad de Medida: <strong>'. $b["nombre"] .'</strong>  || Proveedor: <strong>'. $b["proveedores"] .'</strong></li>
            </ul>';        


        echo '<div class="row mt-2"> 
        <div class="col-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Candidad</h5>
                <p class="card-text"><h1>'. $b["cantidad"] .'</h1></p>
              </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Minima</h5>
                <p class="card-text"><h1>'. $b["existencia_minima"] .'</h1></p>
              </div>
            </div>
        </div>
        </div>';


          // echo '<ul class="list-group">
          //           <li class="list-group-item">Caduca: <strong>'. $b["caduca"] .'</strong>  || Compuesto: <strong>'. $b["compuesto"] .'</strong>  || Gravado: <strong>'. $b["gravado"] .'</strong> </li>
          //           <li class="list-group-item">Receta: '. $b["receta"] .'  ||  Dependiente: <strong>'. $b["dependiente"] .'</strong>  || Servicio: '. $b["servicio"] .' </li>
          //         </ul>'; 
        }

        echo "<hr>";

              $ap = $db->query("SELECT * FROM producto_precio WHERE producto = '".$data["key"]."' AND td = ".$_SESSION["td"]."");
              if($ap->num_rows > 0){
              echo '<h3>Precios Establecidos</h3>';
              echo '<table class="table table-sm table-hover table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                      </tr>
                    </thead>
                    <tbody>';
              foreach ($ap as $bp) {
                 echo '<tr>
                        <td>'.$bp["cant"].'</td>
                        <td><strong>'.Helpers::Dinero($bp["precio"]).'</strong></td>';
              } $ap->close();
              echo '</tbody>
                  </table>';
              } else {
                Alerts::Mensajex("No se he establecido un precio",'danger',$boton,$boton2);
              }

        // precio asignado al lote
        if ($bus = $db->select("precio_venta", "producto_ingresado", "WHERE existencia <= cant and existencia > 0 and precio_venta != 0 and producto = '".$data["key"]."' and td = ". $_SESSION["td"] ." order by time desc limit 1")){ 
          $preciolote = $bus["precio_venta"];
        } unset($r); 

        if ($preciolote != NULL) {
          echo '<li class="list-group-item d-flex justify-content-between align-items-center">PRECIO ASIGNADO A ESTE LOTE
                 <span class="badge badge-secondary badge-pill">'.Helpers::Dinero($preciolote).'</span></li>';
        }



        echo "<hr>";



if ($_SESSION["root_taller"] == "on") {


$aniox = array();
$am = $db->query("SELECT anio FROM taller_anios WHERE producto = '".$data["key"]."' and td = " .$_SESSION["td"]);
if ($am->num_rows > 0) {
   foreach ($am as $bm) {
      $aniox[] = $bm["anio"];
  }

  $yearx = NULL;
  foreach ($aniox as $key => $year) {
   $yearx .= ' <span class="badge badge-pill badge-default font-weight-bold">'.$year.' </span> ';
  }

  echo $yearx;
  echo '<hr class="mb-3">';
} $am->close();



$modelox = array();
$am = $db->query("SELECT modelo FROM taller_modelos WHERE producto = '".$data["key"]."' and td = " .$_SESSION["td"]);
if ($am->num_rows > 0) {
  foreach ($am as $bm) {
      $modelox[] = $bm["modelo"];
  } 

  $model = NULL;
  foreach ($modelox as $key => $modelx) {
   $model .= ' <span class="badge badge-pill badge-primary font-weight-bold"> '.Helpers::GetData("autoparts_modelo","modelo", "hash", $modelx).' </span> ';
  }

  echo $model;
  echo '<hr class="mb-3">';
} $am->close();



}








              $au = $db->query("SELECT ubicacion.ubicacion, ubicacion_asig.cant FROM ubicacion_asig, ubicacion WHERE ubicacion_asig.ubicacion = ubicacion.hash AND ubicacion_asig.producto = '".$data["key"]."' AND ubicacion_asig.td = ".$_SESSION["td"]."");
              if($au->num_rows > 0){
                  echo '<ul class="list-group">
                        <li class="list-group-item active">Ubicacion del Producto</li>';
                  foreach ($au as $bu) {
                     echo '<li class="list-group-item d-flex justify-content-between align-items-center">'.$bu["ubicacion"].' 
                     <span class="badge badge-primary badge-pill">'.Helpers::Format($bu["cant"]).'</span></li>';
                  } $au->close();
                  echo '</ul>';
              } 
              // else {
              //   Alerts::Mensajex("No hay ubicaci&oacuten asignada","warning",$boton,$boton2);
              // }

              $ac = $db->query("SELECT caracteristicas.caracteristica, caracteristicas_asig.cant FROM caracteristicas_asig, caracteristicas WHERE caracteristicas_asig.caracteristica = caracteristicas.hash AND caracteristicas_asig.producto = '".$data["key"]."' AND caracteristicas_asig.td = ".$_SESSION["td"]."");
              if($ac->num_rows > 0){
              echo '<ul class="list-group">
                    <li class="list-group-item list-group-item-success">Caracteristicas del Producto</li>';
              foreach ($ac as $bc) {
                 echo '<li class="list-group-item d-flex justify-content-between align-items-center">'.$bc["caracteristica"].'
                 <span class="badge badge-secondary badge-pill">'.Helpers::Format($bc["cant"]).'</span></li>';
              } $ac->close();
              echo '</ul>';
            } 
            // else {
            //     Alerts::Mensajex("No hay caracteristica asignada","warning",$boton,$boton2);
            //   }


        /// si es un producto compuesto o promocion
        if($b["compuesto"] == "on"){

              $ap = $db->query("SELECT * FROM producto_compuestos WHERE producto = '".$data["key"]."' AND td = ".$_SESSION["td"]."");
              if($ap->num_rows > 0){
              echo '<h3>Productos que componen este elemento</h3>';
              echo '<table class="table table-sm table-hover table-striped">
                    <thead>
                      <tr>
                        <th scope="col">C&oacutedigo</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Existencias</th>
                      </tr>
                    </thead>
                    <tbody>';
              foreach ($ap as $bp) {
                 echo '<tr>
                        <td>'.$bp["agregado"].'</td>
                        <td><strong>'.$this->GetNombreProducto($bp["agregado"]).'</strong></td>
                        <td><strong>'.$this->CuentaProductosU($bp["agregado"]).'</strong></td>';
              } $ap->close();
              echo '</tbody>
                  </table>';
              }


        }
        ///       

        $this->VerTagModal($data["key"]);


            if ($b["informacion"] != NULL) {
              echo '<p class="note note-light mt-4"><strong>Comentarios: </strong>'.$b["informacion"].'</p>';
            }


      } else {
                Alerts::Mensajex("No se encuentra el producto","danger",$boton,$boton2);
              } $a->close();
       
  }







  public function VerTagModal($producto){
      $db = new dbConn();

          if ($r = $db->select("tag", "producto_tags", "WHERE producto = '$producto' and td = ".$_SESSION["td"]."")) { 
            $tags = $r["tag"];
        } unset($r); 
    
        if ($tags) {
          $tags = explode(',', $tags);
          echo '<strong class="mr-2">Palabras Clave: </strong>';
          foreach ($tags as $tag) {
                  echo '<div class="badge badge-pill badge-light mr-3">
                  '.$tag.'
               </div>';
          }
        }

  }





  public function BajasExistencias($npagina, $orden, $dir){
      $db = new dbConn();

  $limit = 12;
  $adjacents = 2;
  if($npagina == NULL) $npagina = 1;
  $a = $db->query("SELECT * FROM producto WHERE cantidad <= existencia_minima and td = ". $_SESSION['td'] ."");
  $total_rows = $a->num_rows;
  $a->close();

  $total_pages = ceil($total_rows / $limit);
  
  if(isset($npagina) && $npagina != NULL) {
    $page = $npagina;
    $offset = $limit * ($page-1);
  } else {
    $page = 1;
    $offset = 0;
  }

if($dir == "desc") $dir2 = "asc";
if($dir == "asc") $dir2 = "desc";

 $a = $db->query("SELECT producto.cod, producto.descripcion, producto.cantidad, producto.existencia_minima, producto_categoria_sub.subcategoria FROM producto INNER JOIN producto_categoria_sub ON producto.categoria = producto_categoria_sub.hash and producto.cantidad <= producto.existencia_minima and producto.td = ".$_SESSION["td"]." order by ".$orden." ".$dir." limit $offset, $limit");
      
      if($a->num_rows > 0){
          echo '<table class="table table-sm table-striped">
        <thead>
          <tr>
            <th class="th-sm"><a id="paginador" op="56" iden="1" orden="producto.cod" dir="'.$dir2.'">Cod</a></th>
            <th class="th-sm"><a id="paginador" op="56" iden="1" orden="producto.descripcion" dir="'.$dir2.'">Producto</a></th>
            <th class="th-sm"><a id="paginador" op="56" iden="1" orden="producto.cantidad" dir="'.$dir2.'">Cantidad</a></th>
            <th class="th-sm"><a id="paginador" op="56" iden="1" orden="producto.categoria" dir="'.$dir2.'">Categoria</a></th>
            <th class="th-sm d-none d-md-block"><a id="paginador" op="56" iden="1" orden="producto.existencia_minima" dir="'.$dir2.'">Minimo</a></th>
            <th class="th-sm">Ver</th>
          </tr>
        </thead>
        <tbody>';
        foreach ($a as $b) {
        // obtener el nombre y detalles del producto
    if ($r = $db->select("*", "pro_dependiente", "WHERE iden = ".$b["producto"]." and td = ". $_SESSION["td"] ."")) { 
        $producto = $r["nombre"]; } unset($r); 

          echo '<tr>
                      <td>'.$b["cod"].'</td>
                      <td>'.$b["descripcion"].'</td>
                      <td>'.$b["cantidad"].'</td>
                      <td>'.$b["subcategoria"].'</td>
                      <td class="d-none d-md-block">'.$b["existencia_minima"].'</td>
                      <td><a id="xver" op="55" key="'.$b["cod"].'"><i class="fas fa-search fa-lg green-text"></i></a></td>
                    </tr>';
        }
        echo '</tbody>
        </table>';
      }
        $a->close();

  if($total_pages <= (1+($adjacents * 2))) {
    $start = 1;
    $end   = $total_pages;
  } else {
    if(($page - $adjacents) > 1) {  
      if(($page + $adjacents) < $total_pages) {  
        $start = ($page - $adjacents); 
        $end   = ($page + $adjacents); 
      } else {              
        $start = ($total_pages - (1+($adjacents*2))); 
        $end   = $total_pages; 
      }
    } else {
      $start = 1; 
      $end   = (1+($adjacents * 2));
    }
  }
echo $total_rows . " Registros encontrados";
   if($total_pages > 1) { 

$page <= 1 ? $enable = 'disabled' : $enable = '';
    echo '<ul class="pagination pagination-sm justify-content-center">
    <li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="56" iden="1" orden="'.$orden.'" dir="'.$dir.'">&lt;&lt;</a>
      </li>';
    
    $page>1 ? $pagina = $page-1 : $pagina = 1;
    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="56" iden="'.$pagina.'" orden="'.$orden.'" dir="'.$dir.'">&lt;</a>
      </li>';

    for($i=$start; $i<=$end; $i++) {
      $i == $page ? $pagina =  'active' : $pagina = '';
      echo '<li class="page-item '.$pagina.'">
        <a class="page-link" id="paginador" op="56" iden="'.$i.'" orden="'.$orden.'" dir="'.$dir.'">'.$i.'</a>
      </li>';
    }

    $page >= $total_pages ? $enable = 'disabled' : $enable = '';
    $page < $total_pages ? $pagina = ($page+1) : $pagina = $total_pages;
    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="56" iden="'.$pagina.'" orden="'.$orden.'" dir="'.$dir.'">&gt;</a>
      </li>';

    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="56" iden="'.$total_pages.'" orden="'.$orden.'" dir="'.$dir.'">&gt;&gt;</a>
      </li>

      </ul>';
     }  // end pagination 
  } // termina productos














///// precios Mayorita

  public function AddPreciosMayorista($datox){ // ingresa un nuevo lote de productos
      $db = new dbConn();
          if($datox["cantidad"] != NULL or $datox["precio"] != NULL){
              $datos = array();
              $datos["producto"] = $datox["producto"];
              $datos["cant"] = $datox["cantidad"];
              $datos["precio"] = $datox["precio"];
              $datos["td"] = $_SESSION["td"];
              $datos["hash"] = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
              if ($db->insert("producto_precio_mayorista", $datos)) {

                 Alerts::Alerta("success","Realizado!","Precio agregado correctamente!");
                
              }
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }
          $this->VerPreciosMayorista($datox["producto"]);
  }


  public function VerPreciosMayorista($producto){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM producto_precio_mayorista WHERE producto = '$producto' and td = ".$_SESSION["td"]."");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Precio</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["cant"].'</td>
                      <td>'.$b["precio"].'</td>
                      <td><a id="delpreciomayorista" hash="'.$b["hash"].'" op="31x" producto="'.$producto.'" ><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';

          } $a->close();  
  }


  public function DelPrecioMayorista($hash, $producto){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("producto_precio_mayorista", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Precio eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerPreciosMayorista($producto);
  }
















  public function AddPrecioPromo($datox){ // ingresa un nuevo lote de productos
      $db = new dbConn();
          if($datox["preciopromo"] != NULL){

/// reviso si tiene precio, sino tiene agrego sino acualizo
$a = $db->query("SELECT * FROM producto_precio_promo WHERE producto = '".$datox["pro_promo"]."' and td = ".$_SESSION["td"]."");
$registros = $a->num_rows;
$a->close();
      if($registros == 0){

              $datos = array();
              $datos["producto"] = $datox["pro_promo"];
              $datos["precio"] = $datox["preciopromo"];
              $datos["td"] = $_SESSION["td"];
              $datos["hash"] = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
              if ($db->insert("producto_precio_promo", $datos)) {

                 Alerts::Alerta("success","Realizado!","Precio agregado correctamente!");
                
              }
        } else {

          $cambio = array();
          $cambio["precio"] = $datox["preciopromo"];
          if(Helpers::UpdateId("producto_precio_promo", $cambio, "producto = '".$datox["pro_promo"]."' and td = ".$_SESSION["td"]."")){
            Alerts::Alerta("success","Realizado!","Precio agregado correctamente!");
          }

        }


          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }
          $this->VerPrecioPromo($datox["pro_promo"]);

  }



  public function VerPrecioPromo($producto){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM producto_precio_promo WHERE producto = '$producto' and td = ".$_SESSION["td"]."");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Precio</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["precio"].'</td>
                      <td><a id="delpreciopromo" hash="'.$b["hash"].'" op="31y" producto="'.$producto.'" ><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';

          } $a->close();  
  }



  public function DelPrecioPromo($hash, $producto){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("producto_precio_promo", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Precio eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerPrecioPromo($producto);
  }


  public function VerPrecioPromox($producto){
      $db = new dbConn();
    if ($r = $db->select("precio", "producto_precio_promo", "WHERE producto = '$producto' and td = ".$_SESSION["td"]."")) { 
        return $r["precio"];
    } unset($r);  

  }



  public function DelProducto($cod){ // esta funcion elimina permanentemente el producto
      $db = new dbConn();
        if (Helpers::DeleteId("producto", "cod='$cod' and td = ". $_SESSION["td"] ."" )) {

          Helpers::DeleteId("caracteristicas_asig", "producto='$cod' and td = ". $_SESSION["td"] ."");
          Helpers::DeleteId("producto_averias", "producto='$cod' and td = ". $_SESSION["td"] ."");
          Helpers::DeleteId("producto_compuestos", "producto='$cod' and td = ". $_SESSION["td"] ."");
          Helpers::DeleteId("producto_dependiente", "producto='$cod' and td = ". $_SESSION["td"] ."");
          Helpers::DeleteId("producto_ingresado", "producto='$cod' and td = ". $_SESSION["td"] ."");
          Helpers::DeleteId("producto_precio", "producto='$cod' and td = ". $_SESSION["td"] ."");
          Helpers::DeleteId("producto_precio_mayorista", "producto='$cod' and td = ". $_SESSION["td"] ."");
          Helpers::DeleteId("producto_precio_promo", "producto='$cod' and td = ". $_SESSION["td"] ."");
          Helpers::DeleteId("producto_tags", "producto='$cod' and td = ". $_SESSION["td"] ."");
          Helpers::DeleteId("ubicacion_asig", "producto='$cod' and td = ". $_SESSION["td"] ."");
          Helpers::DeleteId("marca_asig", "producto='$cod' and td = ". $_SESSION["td"] ."");
          Helpers::DeleteId("kardex", "cod='$cod' and td = ". $_SESSION["td"] ."");


      $a = $db->query("SELECT imagen FROM producto_imagenes WHERE producto='$cod' and td = ". $_SESSION["td"] ."");
      foreach ($a as $b) {
          if(Helpers::DeleteId("producto_imagenes", "producto='$cod' and td = ". $_SESSION["td"] ."")){
              if (file_exists("../../assets/img/productos/" . $_SESSION["td"] . "/" . $b["imagen"])) { unlink("../../assets/img/productos/" . $_SESSION["td"] . "/" . $b["imagen"]); }
          }
      } $a->close();

           Alerts::Alerta("success","Eliminado!","Eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 

      $this->VerTodosProductos(1, "producto.id", "asc");

  }












// funciones de Marca

  public function AddMarca($datos){ // agrega una Marca de medida para ponersela al producto
    $db = new dbConn();

      if($datos["marca"] != NULL){
              $datos["hash"] = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("marcas", $datos)) {
                  
                  Alerts::Alerta("success","Agregado!","Agregado Correctamente!");
                  
              }else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
          }
      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
      $this->VerMarcas();
  }




  public function VerMarcas(){ // listado de Marca
    $db = new dbConn();

      $a = $db->query("SELECT * FROM marcas WHERE td = ".$_SESSION["td"]."");
      if($a->num_rows > 0){
    echo '<table class="table table-sm table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Marca</th>
          <th scope="col">Eliminar</th>
        </tr>
      </thead>
      <tbody>';
      $n = 1;
          foreach ($a as $b) { ;
            echo '<tr>
                  <th scope="row">'. $n ++ .'</th>
                  <td>'.$b["marca"].'</td>
                  <td><a id="xdelete" valor="5" hash="'.$b["hash"].'" op="564"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                </tr>';          
          }
    echo '</tbody>
    </table>';

      } $a->close();
  }



  public function DelMarca($hash){ // elimina Marca
    $db = new dbConn();
        if (Helpers::DeleteId("marcas", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Categoria eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerMarcas();
  }





public function CambiarMarca($data){
        $db = new dbConn();

  /// reviso si tiene marca el producto
$a = $db->query("SELECT * FROM marca_asig WHERE producto = '".$data["cod"]."' and td = ".$_SESSION["td"]."");
$registros = $a->num_rows;
$a->close();
      if($registros == 0){

              $datos = array();
              $datos["marca"] = $data["iden"];
              $datos["producto"] = $data["cod"];
              $datos["td"] = $_SESSION["td"];
              $datos["hash"] = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
              if ($db->insert("marca_asig", $datos)) {

                 Alerts::Alerta("success","Realizado!","Agregado correctamente!");
                
              }
        } else {

          $cambio = array();
          $cambio["marca"] = $data["iden"];
          if(Helpers::UpdateId("marca_asig", $cambio, "producto = '".$data["cod"]."' and td = ".$_SESSION["td"]."")){
            Alerts::Alerta("success","Realizado!","Agregado correctamente!");
          }

        }

      $this->VerMarca($data["cod"]);
}





public function VerMarca($cod){
        $db = new dbConn();

    if ($r = $db->select("marca", "marca_asig", "WHERE producto = '".$cod."' and td =".$_SESSION["td"]."")) { 
       $codigo = $r["marca"];
    } unset($r);  

    if($codigo != NULL){
      if ($r = $db->select("marca", "marcas", "WHERE hash = '".$codigo."' and td =".$_SESSION["td"]."")) { 
         echo '<div class="text-center text-success font-weight-bold">Marca Asignada</div>';
         echo '<div class="text-center text-info font-weight-bold h3">'.$r["marca"].'</div>';
      } unset($r);  
    } else {
        echo '<div class="text-center text-danger font-weight-bold">No se ecncuentra marca registrada</div>';
    }

}




//// codigo repetido de producto
  public function CompruebaSiMarca(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM marcas WHERE td = ".$_SESSION["td"]."");
          if($a->num_rows > 0){
            return TRUE;
          } else {
            return FALSE;
          }
          $a->close();  
  }


  public function MostrarMarca($producto){
      $db = new dbConn();
    if ($r = $db->select("marca", "marca_asig", "WHERE producto = '".$producto."' and td = ".$_SESSION["td"]."")) { 
        $marca = $r["marca"];
    } unset($r);  

    if ($r = $db->select("marca", "marcas", "WHERE hash = '".$marca."' and td = ".$_SESSION["td"]."")) { 
        return $r["marca"];
    } unset($r);  

  }







} // Termina la lcase

?>