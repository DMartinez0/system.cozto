<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5) { ?>

<li><a href="?control" class="waves-effect arrow-r"><i class="fas fa-tv"></i> PANEL DE CONTROL </a></li>

<?php } ?>



<?php if($_SESSION["tipo_cuenta"] != 4) { 

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>

<li><a href="?corte" class="waves-effect arrow-r"><i class="fas fa-user"></i> CORTE DIARIO </a></li>


<?php } } ?>





<?php if($_SESSION["tipo_cuenta"] != 4) { 


if($_SESSION["caja_apertura"] == NULL){ ?>
<!-- <li><a id="abrirCaja" class="waves-effect arrow-r"><i class="fas fa-donate"></i> ABRIR CAJA </a></li> -->

<?
}
}
 ?>





<?php if($_SESSION["td"] == 65 or $_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5 ) { ?>
<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> HISTORIAL<i class="fa fa-angle-down rotate-icon"></i></a>
<?php } ?>
<div class="collapsible-body">
<ul class="list-unstyled">

<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5) { ?>

<li><a href="?consolidado" class="waves-effect"><i class="fas fa-cogs"></i> Consolidado Diario</a></li>

<li><a href="?vdiario" class="waves-effect"><i class="fas fa-cog"></i> Ventas Diarias</a></li>

<li><a href="?vmensual" class="waves-effect"><i class="fas fa-cogs"></i> Ventas Mensuales</a></li>

<li><a href="?hcortes" class="waves-effect"><i class="fas fa-cogs"></i> Historial de Cortes</a></li>
<li><a href="?cortez" class="waves-effect"><i class="fas fa-cogs"></i> Historial de Cortes Z</a></li>

<li><a href="?gdiario" class="waves-effect"><i class="fas fa-cog"></i> Gastos Diarios</a></li>
<li><a href="?gmensual" class="waves-effect"><i class="fas fa-cogs"></i> Gastos Mensuales</a></li>
<li><a href="?descuentos" class="waves-effect"><i class="fas fa-cogs"></i> Descuentos Diarios</a></li>
<li><a href="?utilidades" class="waves-effect"><i class="fas fa-cogs"></i> Utilidades</a></li>
<li><a href="?rmensual" class="waves-effect"><i class="fas fa-cog"></i> Reporte Mensual</a></li>
<li></li><a href="?listaventa" class="waves-effect"><i class="fas fa-cogs"></i> Listado de ventas</a></li>
<li><a href="?gra_semanal" class="waves-effect"><i class="fas fa-cog"></i> Grafico Semanal</a></li>
<li><a href="?gra_mensual" class="waves-effect"><i class="fas fa-cogs"></i> Grafico Mensual</a></li>
<li><a href="?gra_semestre" class="waves-effect"><i class="fas fa-cogs"></i> Grafico Semestral</a></li>
<li><a href="?gra_clientes" class="waves-effect"><i class="fas fa-cogs"></i> Grafico de Clientes</a></li>
<li><a href="?estadistica_costos" class="waves-effect"><i class="fas fa-address-book"></i> Estadistica de costos</a></li>
<?php } ?>
<li><a href="?ventasxuser" class="waves-effect"><i class="fas fa-cogs"></i> Ventas por usuario</a></li>
<li><a href="?nota_envio" class="waves-effect"><i class="fas fa-cogs"></i> Notas de envio</a></li>

</ul>
</div>
</li>





<?php if($_SESSION["tipo_cuenta"] != 4) { 

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> EFECTIVO<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?gastos" class="waves-effect"><i class="fas fa-cog"></i> Gastos y Compras</a></li>
<li><a href="?entradas" class="waves-effect"><i class="fas fa-cogs"></i> Entrada de Efectivo</a></li>
<li><a href="?remesas" class="waves-effect"><i class="fas fa-cogs"></i> Remesas de Efectivo</a></li>
<li><a href="?cuentas_banco" class="waves-effect"><i class="fas fa-cogs"></i> Movimiento de Cuentas</a></li>

</ul>
</div>
</li>

<?php } } ?>









<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-calculator"></i> INVENTARIO<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">


<?php if($_SESSION["tipo_cuenta"] != 4) { 
?>

<?php 
if($_SESSION["root_autoparts"] == "on"){
 ?>
<li><a href="?autoproadd" class="waves-effect"><i class="fas fa-plus"></i> Nuevo Repuesto</a></li>
<?php
 }

 if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>
<li><a href="?proadd" class="waves-effect"><i class="fas fa-plus"></i> Nuevo Producto</a></li> 
<li><a href="?proup" class="waves-effect"><i class="fas fa-pencil-alt"></i> Actualizar Producto</a></li>
<li><a href="?proagregar" class="waves-effect"><i class="fas fa-columns"></i> Agregar Productos</a></li>
<li><a href="?proaverias" class="waves-effect"><i class="fas fa-database"></i> Descontar Averias</a></li>

<?php
}





if($_SESSION["root_autoparts"] == "on" or $_SESSION["root_taller"] == "on"){
 ?>
<li><a href="?autoopciones" class="waves-effect arrow-r"><i class="fas fa-handshake"></i> Marcas y modelos</a></li>
<?php } 



if($_SESSION["root_autoparts"] == "on"){
 ?>
<li><a href="?autoverproductos" class="waves-effect arrow-r"><i class="fas fa-handshake"></i> Productos por marca</a></li>
<?php } ?>




<?php  if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>

<li><a href="?proopciones" class="waves-effect arrow-r"><i class="fas fa-handshake"></i> Opciones</a></li>
<?php  } ?>
<li><a href="?compuestos" class="waves-effect"><i class="fas fa-address-book"></i> Productos Compuestos</a></li>
<?php  } ?>

<li><a href="?productos" class="waves-effect"><i class="fas fa-address-book"></i> Todos los productos</a></li>
<!-- <li><a href="?" class="waves-effect"><i class="fas fa-database"></i> Cambios</a></li>
<li><a href="?" class="waves-effect arrow-r"><i class="fas fa-database"></i> Devoluciones</a></li> -->
<li><a href="?bajasexistencias" class="waves-effect"><i class="fas fa-address-book"></i> Bajas Existencias</a></li>
<?php 
if($_SESSION["root_autoparts"] != "on"){
 ?>
<li><a href="?vencimientos" class="waves-effect"><i class="fas fa-address-book"></i> Proximos Vencimientos</a></li>
<?php } ?>


<?php 
if($_SESSION["config_pesaje"] == "on"){
 ?>
<li><a href="?pesaje" class="waves-effect"><i class="fas fa-plus"></i> Pesar Productos</a></li>
 <?php }   ?>

 <li><a href="?listadoproductos" class="waves-effect"><i class="fas fa-address-book"></i> Productos Vendidos</a></li>

 <?php
if($_SESSION['root_repartidor']){ 
echo '<li><a href="?reporte_repartidor" class="waves-effect"><i class="fas fa-cogs"></i> Reporte Repartidor</a></li>';
}
?>

</ul>
</div>
</li>






<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5) { 


	if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-calculator"></i> HERRAMIENTAS<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?ingresorapido" class="waves-effect"><i class="fas fa-plus"></i> Ingreso Rápido</a></li>
<li><a href="?modificarproducto" class="waves-effect"><i class="fas fa-plus"></i> Modificar Productos</a></li>
<li><a href="?ajustedeinventario" class="waves-effect"><i class="fas fa-plus"></i> Ajustar Inventario</a></li>
<li><a href="?importarproducto" class="waves-effect"><i class="fas fa-plus"></i> Importar desde Excel</a></li>
<li><a href="?restartprecio" class="waves-effect"><i class="fas fa-database"></i> Reestablecer Precio</a></li>

</ul>
</div>
</li>




 <?php } 

 }  ?>










<?php if($_SESSION["root_ecommerce"] == "on") { 
?>


<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-truck"></i> ECOMMERCE <i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?epedidos" class="waves-effect"><i class="fas fa-truck"></i> Pedidos</a></li>
<li><a href="?eusuarios" class="waves-effect"><i class="fas fa-truck"></i> Usuarios</a></li>
<li><a href="?eproductos" class="waves-effect"><i class="fas fa-truck"></i> Producto Ecommerce</a></li>
<li><a href="?ecategorias" class="waves-effect"><i class="fas fa-cogs"></i> Categorias Ecommerce</a></li>

</ul>
</div>
</li>

<?php  } ?>





<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-columns"></i> COTIZACIONES <i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">
<li><a href="?cotizar" class="waves-effect"><i class="fas fa-columns"></i> Nueva Cotizaci&oacuten </a></li>
<li><a href="?cotizaciones" class="waves-effect"><i class="fas fa-address-book"></i> Ver Cotizaciones </a></li>
</ul>
</div>
</li>










<?php if($_SESSION["tipo_cuenta"] != 4) { 

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {

if($_SESSION["root_tipo_sistema"] != 1) { 
?>
<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-money-bill-alt"></i> CREDITOS<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?creditos" class="waves-effect"><i class="fas fa-money-bill-alt"></i> Buscar Credito</a></li>
<li><a href="?creditospendientes" class="waves-effect"><i class="fas fa-money-bill-alt"></i> Creditos Pendientes</a></li>
</ul>
</div>
</li>
<?php } } } ?>







<?php if($_SESSION["tipo_cuenta"] != 4) { 

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {

if($_SESSION["root_tipo_sistema"] != 1) { 
?>
<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-money-bill-alt"></i> CUENTAS POR PAGAR<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?cuentas" class="waves-effect"><i class="fas fa-money-bill-alt"></i> Ver todas las cuentas</a></li>
</ul>
</div>
</li>
<?php } } } ?>



<?php if($_SESSION["root_taller"] == "on") { 
?>
<li><a class="collapsible-header waves-effect arrow-r"><i class="far fa-user"></i> CLIENTES TALLER<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?clientes" class="waves-effect"><i class="fas fa-user"></i> Clientes</a></li>
<li><a href="?vehiculos" class="waves-effect"><i class="fas fa-address-book"></i> Vehiculos</a></li>
<li><a href="?mantenimiento" class="waves-effect"><i class="fas fa-address-book"></i> Mantenimiento</a></li>

</ul>
</div>
</li>

<?php }  ?>




<?php if($_SESSION["root_taller"] != "on") { 
?>
<li><a class="collapsible-header waves-effect arrow-r"><i class="far fa-user"></i> CLIENTES<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?clienteadd" class="waves-effect"><i class="fas fa-user"></i> Agregar Cliente</a></li>
<li><a href="?clientever" class="waves-effect"><i class="fas fa-address-book"></i> Ver Cliente</a></li>

</ul>
</div>
</li>

<?php }  ?>




<?php if($_SESSION["tipo_cuenta"] != 4) {  ?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-user-alt"></i> PROVEEDORES<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?proveedoradd" class="waves-effect"><i class="fas fa-user"></i> Agrega Proveedor</a></li>
<li><a href="?proveedorver" class="waves-effect"><i class="fas fa-barcode"></i> Ver Proveedores</a></li>

</ul>
</div>
</li>

<?php } ?>








<?php if($_SESSION["tipo_cuenta"] != 4 and $_SESSION["root_tipo_sistema"] == 3) {  /// planilla 

if($_SESSION["root_tipo_sistema"] != 1 or $_SESSION["root_tipo_sistema"] != 2) { 

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-user-alt"></i> PLANILLA<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">
<li><a href="?planillasver" class="waves-effect"><i class="fas fa-search"></i> Ver Planillas</a></li>
<li><a href="?addempleado" class="waves-effect"><i class="fas fa-user"></i> Agrega Empleado</a></li>
<li><a href="?verempleado" class="waves-effect"><i class="fas fa-barcode"></i> Ver Empleados</a></li>
<li><a href="?pdescuentos" class="waves-effect"><i class="fas fa-search"></i> Aplicar Descuentos</a></li>

</ul>
</div>
</li>

<?php } } 

} ?>







<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> FACTURAS<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<?php if($_SESSION["config_mayorista"] == "on"){
	if($_SESSION["precio_mayorista_activo"] == TRUE){ $text_may = "Desactivar precio Mayoreo"; } else { $text_may = "Activar precio Mayoreo"; }
echo '<li><a href="application/src/routes.php?op=510"  class="waves-effect"><i class="fas fa-cog"></i> '.$text_may.'</a></li>';
} ?>

<li><a href="?reportef" class="waves-effect"><i class="fas fa-cogs"></i> Facturas Emitidas</a></li>
<li><a href="?mod_nit" class="waves-effect"><i class="fas fa-cogs"></i> Agregar Cliente Credito F.</a></li>
<?php
if($_SESSION['root_comment_ticket'] == "on") {
?>
<li><a href="?busquedaOpt" class="waves-effect"><i class="fas fa-cogs"></i> Buscar <?php echo $_SESSION["root_extra"] ?></a></li>
<?
}
?>
<!-- <li><a  class="waves-effect"><i class="fas fa-cog"></i> Opciones</a></li>
<li><a  class="waves-effect"><i class="fas fa-cogs"></i> Imprimir Facturas</a></li> -->

</ul>
</div>
</li>








<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5) { ?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> REPORTES<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">
<li><a href="?ventadetalle" class="waves-effect"><i class="fas fa-cogs"></i> Detalles de ventas</a></li>

<li><a href="?ventaagrupado" class="waves-effect"><i class="fas fa-cog"></i> Ventas Agrupadas</a></li>
<li><a href="?gastodetallado" class="waves-effect"><i class="fas fa-cogs"></i> Detalle de Gastos</a></li>
<li><a href="?ingresos" class="waves-effect"><i class="fas fa-cogs"></i> Productos Ingresados</a></li>
<li><a href="?raverias" class="waves-effect"><i class="fas fa-cogs"></i> Productos Averiados</a></li>

</ul>
</div>
</li>

<?php } ?>




<?php if($_SESSION["root_transferencias"] == "on"){ ?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> TRANSFERENCIAS<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?transferencias" class="waves-effect"><i class="fas fa-cogs"></i> Aceptar Ordenes</a></li>
<li><a href="?enviadas" class="waves-effect"><i class="fas fa-cogs"></i> Ordenes Enviadas</a></li>

<?php if($_SESSION["tipo_cuenta"] == 1) { ?>
<li><a href="?asociar" class="waves-effect"><i class="fas fa-cogs"></i> Asociar Cuentas</a></li>
<?php } ?>
</ul>
</div>
</li>


<?php } ?>








<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> CONFIGURACIONES<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">


<?php  
if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
 ?>


<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 5) { ?>

<li><a href="?configuraciones" class="waves-effect"><i class="fas fa-cog"></i> Configuraciones</a></li>
<?php if(Helpers::ServerDomain() == FALSE) { ?>
<li><a href="?tablas" class="waves-effect"><i class="fas fa-cogs"></i> Tablas a respaldar</a></li>
<?php  } ?>
<?php  } ?>


<?php if($_SESSION["tipo_cuenta"] == 1) { ?>
<li><a href="?mod_factura" class="waves-effect"><i class="fas fa-cogs"></i> Configuraciones Facturas</a></li>
<li><a href="?root" class="waves-effect"><i class="fas fa-cogs"></i> Configuraciones Root</a></li>
<?php } ?>


<?php  } ?>

<li><a href="?user" class="waves-effect arrow-r"><i class="fas fa-user"></i> Usuarios </a></li>


<li><a href="?ctc" class="waves-effect"><i class="fas fa-cogs"></i> Cambiar Cuenta</a></li>


</ul>
</div>
</li>




<!-- 
<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> Opciones<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?configuraciones" class="waves-effect"><i class="fas fa-cog"></i> Configuraciones</a></li>
<li><a href="?root" class="waves-effect"><i class="fas fa-cogs"></i> Configuraciones Root</a></li>
<li><a href="?root" class="waves-effect"><i class="fas fa-cogs"></i> Respaldos</a></li>

</ul>
</div>
</li> -->








<li><a href="application/includes/logout.php" class="waves-effect arrow-r"><i class="fas fa-power-off"></i> SALIR </a></li>

</ul>
</li>

<small>Version: <?php echo VERSION . " Data: " . Helpers::DBVersion(); ?> </small>