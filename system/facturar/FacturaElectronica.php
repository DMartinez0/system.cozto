<?php 
class FacturaElectronica{




public function DTE(){ /// obtiene el json que se envia a la impresora local
		$db = new dbConn();

// $parametros = array();
// $a = $db->query("SELECT * FROM ticket_num WHERE orden = '".$_SESSION["orden_print"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
// foreach ($a as $b) {
//         $parametros = $b;
// } $a->close();
     
// $productos = array();
// $x = $db->query("SELECT * FROM ticket WHERE num_fac = '".$parametros["num_fac"]."' and orden = '".$_SESSION["orden_print"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
// foreach ($x as $z) {
//      $productos[] = $z;
// } $x->close();


// $parametros["productos"] = $productos;
// $parametros["tipoticket"] = $_SESSION["tipoticket"];
// $parametros["identidad"] = $_SESSION["td"];
// $parametros["config_imp"] = $_SESSION['config_imp'];
// $parametros["cajero"] = $_SESSION['nombre'];


// if($_SESSION["tipoticket"] == 0){

//     if ($r = $db->select("cliente", "ticket_cliente", "WHERE factura = '".$parametros["num_fac"]."' and tx = " . $_SESSION["tx"] . " and td = " .  $_SESSION["td"])) { 
//     $hashcliente = $r["cliente"];
//     } unset($r);  
    
    
//     if ($r = $db->select("nombre, documento, direccion, telefono", "clientes", "WHERE hash = '".$hashcliente."' and td = " .  $_SESSION["td"])) { 
//     $parametros["nombre"] = $r["nombre"];
//     $parametros["documento"] = $r["documento"];
//     $parametros["direccion"] = $r["direccion"];
//     $parametros["telefono"] = $r["telefono"];
//     } unset($r);  
    
    
//     if ($sx = $db->select("sum(stotal), sum(imp), sum(retencion), sum(total)", "ticket", "WHERE num_fac = '".$parametros["num_fac"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and tipo = ".$_SESSION["tipoticket"]."")) { 
//            $parametros["stotal"]=$sx["sum(stotal)"];
//            $parametros["imp"]=$sx["sum(imp)"];
//            $parametros["totalRetencion"]=$sx["sum(retencion)"];
//            $parametros["total"]=$sx["sum(total)"];
//         } unset($sx); 
     
//         if(isset($_SESSION['credito_sin_factura'])) { 

//             if ($r = $db->select("hash", "creditos", "WHERE factura = '".$parametros["num_fac"]."' and orden = '".$_SESSION["orden_print"]."' and tx = " . $_SESSION["tx"] . " and td = " .  $_SESSION["td"])) { 
//                 $credito = $r["hash"];
//             } unset($r);  
            
//             $parametros["credito"] = $credito;
            
//             if ($abonos = $db->select("sum(abono)", "creditos_abonos", "WHERE credito = '".$credito."' and edo = 1 and td = ".$_SESSION["td"]."")){  
//                 $totalAbonos = $abonos["sum(abono)"];
//             }unset($abonos); 
        
//             $parametros["abonos"] = $totalAbonos;
//         }

//     $parametros["c_cliente"] = $_SESSION["config_cliente"];
//     $parametros["c_propietario"] = $_SESSION["config_propietario"];
//     $parametros["c_telefono"] = $_SESSION["config_telefono"];
//     $parametros["c_direccion"] = $_SESSION["config_direccion"];
//     $parametros["c_giro"] = $_SESSION["config_giro"];
    
    
//     }


// if($_SESSION["tipoticket"] == 1){

// if ($r = $db->select("cliente", "ticket_cliente", "WHERE factura = '".$parametros["num_fac"]."' and orden = '".$_SESSION["orden_print"]."' and tx = " . $_SESSION["tx"] . " and td = " .  $_SESSION["td"])) { 
// $hashcliente = $r["cliente"];
// } unset($r);  


// if ($r = $db->select("nombre, documento, direccion, telefono", "clientes", "WHERE hash = '".$hashcliente."' and td = " .  $_SESSION["td"])) { 
// $parametros["nombre"] = $r["nombre"];
// $parametros["documento"] = $r["documento"];
// $parametros["direccion"] = $r["direccion"];
// $parametros["telefono"] = $r["telefono"];
// } unset($r);  


// if ($sx = $db->select("sum(stotal), sum(imp), sum(retencion), sum(total)", "ticket", "WHERE num_fac = '".$parametros["num_fac"]."' and orden = '".$_SESSION["orden_print"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and tipo = ".$_SESSION["tipoticket"]."")) { 
//        $parametros["stotal"]=$sx["sum(stotal)"];
//        $parametros["imp"]=$sx["sum(imp)"];
//        $parametros["totalRetencion"]=$sx["sum(retencion)"];
//        $parametros["total"]=$sx["sum(total)"];
//     } unset($sx); 
 
//     if(isset($_SESSION['credito_sin_factura'])) { 

//         if ($r = $db->select("hash", "creditos", "WHERE factura = '".$parametros["num_fac"]."' and orden = '".$_SESSION["orden_print"]."' and tx = " . $_SESSION["tx"] . " and td = " .  $_SESSION["td"])) { 
//             $credito = $r["hash"];
//         } unset($r);  
        
//         $parametros["credito"] = $credito;
        
//         if ($abonos = $db->select("sum(abono)", "creditos_abonos", "WHERE credito = '".$credito."' and edo = 1 and td = ".$_SESSION["td"]."")){  
//             $totalAbonos = $abonos["sum(abono)"];
//         }unset($abonos); 
    
//         $parametros["abonos"] = $totalAbonos;
//     }

// $parametros["c_cliente"] = $_SESSION["config_cliente"];
// $parametros["c_propietario"] = $_SESSION["config_propietario"];
// $parametros["c_telefono"] = $_SESSION["config_telefono"];
// $parametros["c_direccion"] = $_SESSION["config_direccion"];
// $parametros["c_giro"] = $_SESSION["config_giro"];


// }



// if($_SESSION["tipoticket"] == 2){

// if ($r = $db->select("cliente", "ticket_cliente", "WHERE factura = '".$parametros["num_fac"]."' and orden = '".$_SESSION["orden_print"]."' and tx = " . $_SESSION["tx"] . " and td = " .  $_SESSION["td"])) { 
// $hashcliente = $r["cliente"];
// } unset($r);  

// if($_SESSION["root_taller"] == "on") { 

//     if ($r = $db->select("documento", "facturar_documento_factura", "WHERE factura = '".$parametros["num_fac"]."' and tx = " . $_SESSION["tx"] . " and td = " .  $_SESSION["td"])) { 
//         $documento = $r["documento"];
//     } unset($r);  
    
//     $parametros["documento"] = $documento;
    
//     if ($r = $db->select("cliente, giro, registro, direccion, departamento", "taller_cliente", "WHERE nit = '$documento' and td = " .  $_SESSION["td"])) { 
//         $parametros["cliente"] = $r["cliente"];
//         $parametros["giro"] = $r["giro"];
//         $parametros["registro"] = $r["registro"];
//         $parametros["direccion"] = $r["direccion"];
//         $parametros["departamento"] = $r["departamento"];
//     } unset($r);  
// }

// if ($r = $db->select("nombre, documento, direccion, telefono", "clientes", "WHERE hash = '".$hashcliente."' and td = " .  $_SESSION["td"])) { 
// $parametros["nombre"] = $r["nombre"];
// $parametros["documento"] = $r["documento"];
// $parametros["direccion"] = $r["direccion"];
// $parametros["telefono"] = $r["telefono"];
// } unset($r); 

// $parametros["hashcliente"] = $hashcliente;

// if(isset($_SESSION['credito_sin_factura'])) { 

//     if ($r = $db->select("hash", "creditos", "WHERE factura = '".$parametros["num_fac"]."' and orden = '".$_SESSION["orden_print"]."' and tx = " . $_SESSION["tx"] . " and td = " .  $_SESSION["td"])) { 
//         $credito = $r["hash"];
//     } unset($r);  
    
//     $parametros["credito"] = $credito;
    
//     if ($abonos = $db->select("sum(abono)", "creditos_abonos", "WHERE credito = '".$credito."' and edo = 1 and td = ".$_SESSION["td"]."")){  
//         $totalAbonos = $abonos["sum(abono)"];
//     }unset($abonos); 

//     $parametros["abonos"] = $totalAbonos;
// }



// if ($sx = $db->select("sum(stotal), sum(imp), sum(retencion), sum(total)", "ticket", "WHERE num_fac = '".$parametros["num_fac"]."' and orden = '".$_SESSION["orden_print"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and tipo = ".$_SESSION["tipoticket"]."")) { 
//        $parametros["stotal"]=$sx["sum(stotal)"];
//        $parametros["imp"]=$sx["sum(imp)"];
//        $parametros["totalRetencion"]=$sx["sum(retencion)"];
//        $parametros["total"]=$sx["sum(total)"];
//     } unset($sx); 
 

// }



// if($_SESSION["tipoticket"] == 3){

//     if ($r = $db->select("documento", "facturar_documento_factura", "WHERE factura = '".$parametros["num_fac"]."' and tx = " . $_SESSION["tx"] . " and td = " .  $_SESSION["td"]." order by id desc limit 1")) { 
//         $documento = $r["documento"];
//     } unset($r);  

//         $parametros["documento"] = $documento;

//     if($_SESSION["root_taller"] == "on") { 
//         if ($r = $db->select("cliente, giro, registro, direccion, departamento", "taller_cliente", "WHERE nit = '$documento' and td = " .  $_SESSION["td"])) { 
//             $parametros["cliente"] = $r["cliente"];
//             $parametros["giro"] = $r["giro"];
//             $parametros["registro"] = $r["registro"];
//             $parametros["direccion"] = $r["direccion"];
//             $parametros["departamento"] = $r["departamento"];
//         } unset($r);  
//     } else {
//         if ($r = $db->select("cliente, giro, registro, direccion, departamento", "facturar_documento", "WHERE documento = '$documento' and td = " .  $_SESSION["td"])) { 
//             $parametros["cliente"] = $r["cliente"];
//             $parametros["giro"] = $r["giro"];
//             $parametros["registro"] = $r["registro"];
//             $parametros["direccion"] = $r["direccion"];
//             $parametros["departamento"] = $r["departamento"];
//         } unset($r);  
//     }

//     if(isset($_SESSION['credito_sin_factura'])) { 

//         if ($r = $db->select("hash", "creditos", "WHERE factura = '".$parametros["num_fac"]."' and orden = '".$_SESSION["orden_print"]."' and tx = " . $_SESSION["tx"] . " and td = " .  $_SESSION["td"])) { 
//             $credito = $r["hash"];
//         } unset($r);  
        
//         $parametros["credito"] = $credito;
        
//         if ($abonos = $db->select("sum(abono)", "creditos_abonos", "WHERE credito = '".$credito."' and edo = 1 and td = ".$_SESSION["td"]."")){  
//             $totalAbonos = $abonos["sum(abono)"];
//         }unset($abonos); 
    
//         $parametros["abonos"] = $totalAbonos;
//     }


// if ($sx = $db->select("sum(stotal), sum(imp), sum(retencion), sum(total)", "ticket", "WHERE num_fac = '".$parametros["num_fac"]."' and orden = '".$_SESSION["orden_print"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and tipo = ".$_SESSION["tipoticket"]."")) { 
//        $parametros["stotal"]=$sx["sum(stotal)"];
//        $parametros["imp"]=$sx["sum(imp)"];
//        $parametros["totalRetencion"]=$sx["sum(retencion)"];
//        $parametros["total"]=$sx["sum(total)"];
//     } unset($sx); 
 
// }





// if($_SESSION["tipoticket"] == 4){

// if ($r = $db->select("cliente", "ticket_cliente", "WHERE factura = '".$parametros["num_fac"]."' and orden = '".$_SESSION["orden_print"]."' and tx = " . $_SESSION["tx"] . " and td = " .  $_SESSION["td"])) { 
// $hashcliente = $r["cliente"];
// } unset($r);  



// if ($r = $db->select("nombre, documento, direccion", "clientes", "WHERE hash = '".$hashcliente."' and td = " .  $_SESSION["td"])) { 
// $parametros["nombre"] = $r["nombre"];
// $parametros["documento"] = $r["documento"];
// $parametros["direccion"] = $r["direccion"];
// } unset($r);  



// if ($sx = $db->select("sum(stotal), sum(imp), sum(total)", "ticket", "WHERE num_fac = '".$parametros["num_fac"]."' and orden = '".$_SESSION["orden_print"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and tipo = ".$_SESSION["tipoticket"]."")) { 
//        $parametros["stotal"]=$sx["sum(stotal)"];
//        $parametros["imp"]=$sx["sum(imp)"];
//        $parametros["totalRetencion"]=$sx["sum(retencion)"];
//        $parametros["total"]=$sx["sum(total)"];
//     } unset($sx); 
 

// }


// echo json_encode($parametros);
$datos = array();
$datos['nit'] = "02072103861029";
$datos['activo'] = true;
$datos['passwordPri'] = "ericknunez";
$datos['id_sistema'] = "D45CD5DD-8831-46F7-85C0-2BBF378A9AEE";
$datos['idEnvio'] = 2; // numero de orden (string)
$datos['dteJson']['identificacion']['version'] = 3;
$datos['dteJson']['identificacion']['ambiente'] = "00";

$datos['dteJson']['identificacion']['numeroControl'] = "DTE-03-00000000-000000000000001";
$datos['dteJson']['identificacion']['codigoGeneracion'] = "D45CD5DD-8831-46F7-9210-2DA27724254E"; // codigo de cada ticket_num
$datos['dteJson']['identificacion']['tipoDte'] = "03";

echo json_encode($datos);
		

}// termina le funcion









} // fin de la clase

 ?>


 