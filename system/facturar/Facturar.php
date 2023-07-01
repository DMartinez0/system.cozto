<?php 
class Facturar{



	public function ModFactura($data){ /// cambiar estado de factura
		$db = new dbConn();

		$cambio = array();	

		switch ($data["iden"]) {
			case "ninguno":
				$cambio["ninguno"] = $data["edo"];
				break;
			case "nota_envio":
					$cambio["nota_envio"] = $data["edo"];
				break;
			case "ax0":
				$cambio["ax0"] = $data["edo"];
				break;
			case "ax1":
				$cambio["ax1"] = $data["edo"];
				break;
			case "bx0":
				$cambio["bx0"] = $data["edo"];
				break;
			case "bx1":
				$cambio["bx1"] = $data["edo"];
				break;
			case "cx0":
				$cambio["cx0"] = $data["edo"];
				break;
			case "cx1":
				$cambio["cx1"] = $data["edo"];
				break;
			case "dx0":
				$cambio["dx0"] = $data["edo"];
				break;
			case "dx1":
				$cambio["dx1"] = $data["edo"];
				break;
			case "ex0":
				$cambio["ex0"] = $data["edo"];
				break;
			case "ex1":
				$cambio["ex1"] = $data["edo"];
				break;
			case "fx0":
				$cambio["fx0"] = $data["edo"];
				break;
			case "fx1":
				$cambio["fx1"] = $data["edo"];
				break;
			case "gx0":
				$cambio["gx0"] = $data["edo"];
				break;
			case "gx1":
				$cambio["gx1"] = $data["edo"];
				break;
		}


		$a = $db->query("SELECT * FROM facturar_opciones WHERE td = ".$_SESSION["td"]."");
		if($a->num_rows > 0){    
		    if (Helpers::UpdateId("facturar_opciones", $cambio, "td = ".$_SESSION["td"]."")) {
		        Alerts::Alerta("success","Realizado!","Registros actualizados correctamente");
		    }		
		} else {
		    $cambio["td"] = $_SESSION["td"];
			$cambio["hash"] = Helpers::HashId();
			$cambio["time"] = Helpers::TimeId();
		    if ($db->insert("facturar_opciones", $cambio)) {
		    	Alerts::Alerta("success","Realizado!","Registros actualizados correctamente");
		    } 			
		}

		$a->close();     
	}




public function ObtenerEstadoFactura($efectivo, $factura){ // esta funcion obtiene el estado de la factura, el tx o si es local o web para decidir cual factura mostrar
		$db = new dbConn();
		$imprimir = new Impresiones(); 

if($_SESSION["td"] == 10){
		echo '<a href="system/facturar/facturas/'.$_SESSION["td"].'/ticket_web.php?factura='.$factura.'" class="btn-floating btn-sm btn-info" title="Imprimir Factura" target="_blank"><i class="fas fa-print"></i></a>';
} else {

	if($_SESSION["tipoticket"] == 1){
		$imprimir->Ticket($efectivo, $factura);
	}
	if($_SESSION["tipoticket"] == 2){
		$imprimir->Factura($efectivo, $factura);
	}
	if($_SESSION["tipoticket"] == 12){
		$imprimir->Factura($efectivo, $factura);
	}
	if($_SESSION["tipoticket"] == 3){
		$imprimir->CreditoFiscal($efectivo, $factura);
	}
	if($_SESSION["tipoticket"] == 13){
		$imprimir->CreditoFiscal($efectivo, $factura);
	}
	if($_SESSION["tipoticket"] == 4){
		$imprimir->Exportacion($efectivo, $factura);
	}
	if($_SESSION["tipoticket"] == 8){
		$imprimir->NotaEnvio($efectivo, $factura);
	}
	if($_SESSION["tipoticket"] == 0){
		$imprimir->Ninguno($efectivo, $factura);
	}
}

}// termina le funcion









public function TiposTicketActivos(){ // esta funcion obtiene los ticket activos para mostrarlos como oopciones
		$db = new dbConn();
// a =  ticket. b =  factura, e = Credito fiscal

if($_SESSION["tx"] == 0){

    if ($r = $db->select("nota_envio, ninguno, ax0, bx0, dx0, ex0, fx0, gx0", "facturar_opciones", "WHERE td = ".$_SESSION["td"]."")) { 
        $envio = $r["nota_envio"]; $ninguno = $r["ninguno"]; $ax = $r["ax0"]; $bx = $r["bx0"]; $dx = $r["dx0"]; $ex = $r["ex0"]; $fx = $r["fx0"]; $gx = $r["gx0"];
    } unset($r);  

} else {
    
    if ($r = $db->select("nota_envio, ninguno, ax1, bx1, dx1, ex1, fx1, gx1", "facturar_opciones", "WHERE td = ".$_SESSION["td"]."")) { 
        $envio = $r["nota_envio"]; $ninguno = $r["ninguno"]; $ax = $r["ax1"]; $bx = $r["bx1"]; $dx = $r["dx1"]; $ex = $r["ex1"]; $fx = $r["fx1"]; $gx = $r["gx1"];
    } unset($r);  
}

if($ax == 1){
echo '<a id="opticket" tipo="1" class="btn btn-cyan">Ticket</a>';
}
if($ex == 1){
echo '<a id="opticket" tipo="3" class="btn btn-brown">Credito Fiscal</a>';
}
if($fx == 1){
echo '<a id="opticket" tipo="12" class="btn btn-succeess">Factura 2</a>';
}

if($gx == 1){
echo '<a id="opticket" tipo="13" class="btn btn-danger">Credito Fiscal 2</a>';
}

if($bx == 1){
echo '<a id="opticket" tipo="2" class="btn btn-indigo">Factura</a>';
}
if($dx == 1){
echo '<a id="opticket" tipo="4" class="btn btn-secondary">Exportación</a>';
}

if($ninguno == 1){
	echo '<a id="opticket" tipo="0" class="btn btn-elegant">Ninguno</a>';
}

if($envio == 1){
	echo '<a id="opticket" tipo="8" class="btn btn-success">Nota Envio</a>';
}

}// termina le funcion















} // fin de la clase

 ?>


 