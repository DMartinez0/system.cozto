<?php 
class VerCotizaciones{


    public function VerCotizacion($cot){
        if ($_SESSION['td'] == 55) { // 55 f&f
            $this->IndustriasFF($cot);
        }
        if ($_SESSION['td'] == 91) { // 91  DDALTEC
              $this->ddaltec($cot);
          
        } else {
            $this->general($cot);
        }
    }

    
  public function IndustriasFF($cotizacion){
    $db = new dbConn();

    if ($r = $db->select("cliente, fecha, correlativo, caduca", "cotizaciones_data", "WHERE id = '".$cotizacion."' and td = ". $_SESSION["td"] ."")) { 
        $cliente = $r["cliente"]; 
        $fecha = $r["fecha"]; 
        $correlativo = $r["correlativo"]; 
        $caduca = $r["caduca"]; 
    } unset($r); 
    
    if ($r = $db->select("*", "clientes", "WHERE hash = '".$cliente."' and td = ". $_SESSION["td"] ."")) { 
        $nombre = $r["nombre"];
        $documento = $r["documento"];
        $direccion = $r["direccion"];
        $municipio = $r["municipio"];
        $departamento = $r["departamento"];
         } unset($r); 


   echo '<div class="container-fluid letras">
   <!-- Encabezado -->
 <div class="row">
   <div class="col-3 text-center"><img src="'.XSERV.'assets/img/logo/FYF.png" width="200px" alt=""></div>
   <div class="col-6 text-center">
       <div class="letras1 font-weight-bold mt-3">INDUSTRIAS F & F</div>
       <div class="letras1 font-weight-bold"> Servicio de torno</div>
       <div class="letras2 font-weight-bold">
       Final E. Mancía, Lote # 35, Bo. Las
       Flores,
       Metapán, Santa Ana
       </div>
       <div class="letras2 font-weight-bold">
       TELS.: 7498-5138 / 7866-6426
       </div>
   </div>
   <div class="letras1 col-3 text-center  font-weight-bold">
     <div class="bordeado-x1 border-bold" style="height: 100%;">
       <div class="font-weight-bold mt-3">COTIZACION</div>
       <div>NO. '. str_pad($correlativo, 8, "0", STR_PAD_LEFT) .'</div>
     </div>
   </div>
 </div>
 <!-- Datos generales  -->
 <div class="letras2 bordeado-x1 border-bold mt-2  font-weight-bold">
   <div class="ml-3">
         <div class="row">
           <div class="col-8">
               CLIENTE: '. $nombre .'
           </div>
           <div class="col-4 text-center">
               <div class="font-weight-bold">FECHA</div>';
            //    <div class="row">
            //      <div class="col">DIA</div>
            //      <div class="col">MES</div>
            //      <div class="col">AÑo</div>
            //    </div>
               echo '<div>'.Fechas::FechaEscrita($fecha) .'</div>
           </div>
         </div>
   </div>
   <div class="ml-3">
       DIRECCION: '. $direccion .' '.$municipio.' '.$departamento.'
   </div>
 </div>
 <!-- Contenido de productos  -->
 <table class="table table-sm table-round mt-2">
   <thead>
     <th class="letras3 font-weight-bold">CANT.</th>
     <th class="letras3 font-weight-bold">DESCRIPCION</th>
     <th class="letras3 font-weight-bold">PRECIO</th>
     <th class="letras3 font-weight-bold text-nowrap">VENTAS</th>
   </thead>
   <tbody>';

/// productos 10 por todo
$a = $db->query("SELECT * FROM cotizaciones WHERE cotizacion = '".$correlativo."' and td = ".$_SESSION["td"]."");
$cantidadP = $a->num_rows;

$pv = 0; $st=0; $im=0; $to=0;
foreach ($a as $b) {
$pv = $pv + $b["pv"]; 
$st = $st + $b["stotal"]; 
$im = $im + $b["imp"]; 
$to = $to + $b["total"];

echo '<tr>
       <td class="letras3 font-weight-bold">'.$b["cant"].'</td>
       <td class="letras3 font-weight-bold">'.$b["producto"].'</td>
       <td class="letras3 font-weight-bold"></td>';
       if ($b["stotal"] == 0) {
        echo '<td class="letras3 font-weight-bold"></td>';
       } else {
        echo '<td class="letras3 font-weight-bold text-nowrap">'.Helpers::Dinero($b["stotal"]).'</td>';
       }
echo '</tr>';
    }  
$a->close();

$nNum = 10 - $cantidadP;
for ($i=0; $i < $nNum; $i++) { 
    echo '<tr>
            <td class="letras3 font-weight-bold">&nbsp</td>
            <td class="letras3 font-weight-bold"></td>
            <td class="letras3 font-weight-bold"></td>
            <td class="letras3 font-weight-bold"></td>
          </tr>';
}


// Materiales fila
    echo '<tr>
       <td colspan="2" class="text-center font-weight-bold">MATERIALES</td>
       <td></td>
       <td></td>
     </tr>';

// lista de materiales 6 por todo
$a = $db->query("SELECT * FROM cotizaciones_materiales WHERE cotizacion = '".$correlativo."' and td = ".$_SESSION["td"]."");
$cantidadM = $a->num_rows;
foreach ($a as $b) {
echo '<tr>
       <td class="letras3 font-weight-bold"></td>
       <td class="letras3 font-weight-bold">'.$b["material"].'</td>
       <td class="letras3 font-weight-bold"></td>';
       if ($b["precio"] != 0) {
        echo '<td class="letras3 font-weight-bold">'.Helpers::Dinero($b["precio"]).'</td>';
       } else {
        echo '<td class="letras3 font-weight-bold"></td>';
       }

     echo '</tr>';
    }  
$a->close();


$nNum2 = 5 - $cantidadM;
for ($i=0; $i < $nNum2; $i++) { 
    echo '<tr>
            <td class="letras3 font-weight-bold">&nbsp</td>
            <td class="letras3 font-weight-bold"></td>
            <td class="letras3 font-weight-bold"></td>
            <td class="letras3 font-weight-bold"></td>
          </tr>';
}

echo '<tr>
       <td colspan="2" rowspan="5" class="letras2 font-weight-bold">SON: '.Dinero::DineroEscrito($to).' </td>
       <td class="letras3 font-weight-bold">SUMAS</td>
       <td class="letras3 font-weight-bold text-nowrap">'.Helpers::Dinero($st).'</td>
     </tr>
     <tr>
       <td class="letras3 font-weight-bold">13% IVA</td>
       <td class="letras3 font-weight-bold text-nowrap">'.Helpers::Dinero($im).'</td>
     </tr>
     <tr>
       <td class="letras3 font-weight-bold">SUBTOTAL</td>
       <td class="letras3 font-weight-bold text-nowrap">'.Helpers::Dinero($to).'</td>
     </tr>
     <tr>
       <td class="letras3 font-weight-bold">(-) IVA RET.</td>
       <td class="letras3 font-weight-bold text-nowrap"></td>
     </tr>
     <tr>
       <td class="letras3 font-weight-bold">TOTAL</td>
       <td class="letras3 font-weight-bold text-nowrap">'.Helpers::Dinero($to).'</td>
     </tr>
 
 
   </tbody>
 </table>
 
 <!-- // datos finales -->
   <div class="row">
     <div class="col text-center">
       <div class="mt-3">Nombre: ____________________________________</div>
       <div class="mt-3">Firma: _______________________________________</div>
       <div class="text-center">Persona que Recibe</div>
     </div>
     <div class="col text-center">
       <div class="mt-3">Nombre: ____________________________________</div>
       <div class="mt-3">Firma: _______________________________________</div>
       <div class="text-center">Persona que Entrega</div>
     </div>
   </div>
   
 
   
 </div>';
}





    


  public function general($cotizacion){
       $db = new dbConn();
       

if ($r = $db->select("cliente, fecha, correlativo, caduca", "cotizaciones_data", "WHERE id = '".$cotizacion."' and td = ". $_SESSION["td"] ."")) { 
    $cliente = $r["cliente"]; 
    $fecha = $r["fecha"]; 
    $correlativo = $r["correlativo"]; 
    $caduca = $r["caduca"]; 
} unset($r); 

if ($r = $db->select("*", "clientes", "WHERE hash = '".$cliente."' and td = ". $_SESSION["td"] ."")) { 
    $nombre = $r["nombre"];
    $documento = $r["documento"];
    $direccion = $r["direccion"];
    $municipio = $r["municipio"];
    $departamento = $r["departamento"];
     } unset($r); 

echo '<div class="row">
      <div class="col-8">
              <div class="text-center">
              <h3>'. $_SESSION['config_cliente'] .'</h3>
              </div>
              <div><h3>
              Dirección: '. $_SESSION['config_direccion'] .'
              </h3></div>
              <div><h3>
              Teléfono: '. $_SESSION['config_telefono'] .'
              </h3></div>

      </div>

        <div class="col-4 text-right">
        <img alt="" src="'.XSERV.'assets/img/logo/'.$_SESSION['config_imagen'].'" height="200" id="logo-neg" class="img-fluid" />
        </div>
</div>

<hr />';

echo '<div class="row">
      <div class="col-8">
              <div>
              <h4>Cliente: '. $nombre .'</h4>
              </div>
              <div><h4>
              Dirección: '. $direccion .' '.$municipio.' '.$departamento.'
              </h4></div>

      </div>
        <div class="col-4 text-right">
       
       		<div>
              <h4>Creada : '. $fecha .'</h4>
             </div>
			<div>
              <h4>Cotización : '. $correlativo .'</h4>
             </div>
        </div>
	</div>


	<pre>Detalles de la cotización</pre>';

$a = $db->query("SELECT * FROM cotizaciones WHERE cotizacion = '".$correlativo."' and td = ".$_SESSION["td"]."");

        if($a->num_rows > 0){
            echo '<table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">Cant</th>
                <th scope="col">Producto</th>
                <th scope="col">Precio</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Impuesto</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>';
            $pv = 0; $st=0; $im=0; $to=0;
            foreach ($a as $b) {
            $pv = $pv + $b["pv"]; 
            $st = $st + $b["stotal"]; 
            $im = $im + $b["imp"]; 
            $to = $to + $b["total"];
            echo '<tr>
                  <th scope="row">'.$b["cant"].'</th>
                  <td>'.$b["producto"].'</td>
                  <td>'.$b["pv"].'</td>
                  <td>'.$b["stotal"].'</td>
                  <td>'.$b["imp"].'</td>
                  <td>'.$b["total"].'</td>
                </tr>';
            }
            echo '<tr>
                  <td></td>
                  <td>Total</td>
                  <th>'.Helpers::Dinero($pv).'</th>
                  <th>'.Helpers::Dinero($st).'</th>
                  <th>'.Helpers::Dinero($im).'</th>
                  <th>'.Helpers::Dinero($to).'</th>
                </tr>';

            echo '</tbody>
              </table>';
        }  $a->close();

  
echo '<div class="row mt-4">
      <div class="col-12">
              <div>
              <h3> Cotización válida hasta el: '. Fechas::FechaEscrita($caduca) .'</h3>
              </div>
      </div>
</div>';



  }


  public function ddaltec($cotizacion){
    $db = new dbConn();
    

if ($r = $db->select("cliente, fecha, correlativo, caduca", "cotizaciones_data", "WHERE id = '".$cotizacion."' and td = ". $_SESSION["td"] ."")) { 
 $cliente = $r["cliente"]; 
 $fecha = $r["fecha"]; 
 $correlativo = $r["correlativo"]; 
 $caduca = $r["caduca"]; 
} unset($r); 

if ($r = $db->select("*", "clientes", "WHERE hash = '".$cliente."' and td = ". $_SESSION["td"] ."")) { 
 $nombre = $r["nombre"];
 $documento = $r["documento"];
 $direccion = $r["direccion"];
 $municipio = $r["municipio"];
 $departamento = $r["departamento"];
  } unset($r); 

echo '<div class="row">
   <div class="col-8">
           <div class="text-center">
           <h3>'. $_SESSION['config_cliente'] .'</h3>
           </div>
           <div><h3>
           Dirección: '. $_SESSION['config_direccion'] .'
           </h3></div>
           <div><h3>
           Teléfono: '. $_SESSION['config_telefono'] .'
           </h3></div>
           <div><h3>
           WhatsApp: 7944 5330
           </h3></div>

   </div>

     <div class="col-4 text-right">
     <img alt="" src="'.XSERV.'assets/img/logo/'.$_SESSION['config_imagen'].'" height="200" id="logo-neg" class="img-fluid" />
     </div>
</div>

<hr />';

echo '<div class="row">
   <div class="col-8">
           <div>
           <h4>Cliente: '. $nombre .'</h4>
           </div>
           <div><h4>
           Dirección: '. $direccion .' '.$municipio.' '.$departamento.'
           </h4></div>

   </div>
     <div class="col-4 text-right">
    
        <div>
           <h4>Creada : '. $fecha .'</h4>
          </div>
   <div>
           <h4>Cotización : '. $correlativo .'</h4>
          </div>
     </div>
</div>


<pre>Detalles de la cotización</pre>';

$a = $db->query("SELECT * FROM cotizaciones WHERE cotizacion = '".$correlativo."' and td = ".$_SESSION["td"]."");

     if($a->num_rows > 0){
         echo '<table class="table table-striped table-sm">
         <thead>
           <tr>
             <th scope="col">Cant</th>
             <th scope="col">Producto</th>
             <th scope="col">Precio</th>
             <th scope="col">Subtotal</th>
             <th scope="col">Impuesto</th>
             <th scope="col">Total</th>
           </tr>
         </thead>
         <tbody>';
         $pv = 0; $st=0; $im=0; $to=0;
         foreach ($a as $b) {
         $pv = $pv + $b["pv"]; 
         $st = $st + $b["stotal"]; 
         $im = $im + $b["imp"]; 
         $to = $to + $b["total"];
         echo '<tr>
               <th scope="row">'.$b["cant"].'</th>
               <td>'.$b["producto"].'</td>
               <td>'.$b["pv"].'</td>
               <td>'.$b["stotal"].'</td>
               <td>'.$b["imp"].'</td>
               <td>'.$b["total"].'</td>
             </tr>';
         }
         echo '<tr>
               <td></td>
               <td>Total</td>
               <th>'.Helpers::Dinero($pv).'</th>
               <th>'.Helpers::Dinero($st).'</th>
               <th>'.Helpers::Dinero($im).'</th>
               <th>'.Helpers::Dinero($to).'</th>
             </tr>';

         echo '</tbody>
           </table>';
     }  $a->close();


echo '<div class="row mt-4">
   <div class="col-12">
           <div>
           <h3> Cotización válida hasta el: '. Fechas::FechaEscrita($caduca) .'</h3>
           </div>
   </div>
</div>';

echo '<p>Producto Fabricados/Instalados, entrega de 8 a 15 dias hábiles, después de entregado el 60% de anticipo.</p>
<p>Precios Incluyen IVA y estan sujetos a cambios sin previo aviso.</p>
<p>Cheque a nombre de DDALTEC S.A. DE C.V.</p>
<p>Cualquier consulta estamos a la orden.</p>';


}










} // Termina la lcase

?>