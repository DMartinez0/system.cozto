<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


include_once 'application/common/Encrypt.php';

?>

<h1 class="h1-responsive">CONFIGURACIONES DE FACTURAS</h1>
Facturas a imprimir
    <table class="table table-sm table-striped">

   <thead>
     <tr>
       <th>Item</th>
       <th>Tx 0</th>
       <th>Tx 1</th>
     </tr>
   </thead>

   <tbody>
    <?
$r = $db->select("*", "facturar_opciones", "where td = ".$_SESSION['td']."");
?>
      <tr>
       <td>Ticket</td>
       <td>
          <div class="switch">
            <label>
             Off
              <input type="checkbox" <?php if($r["ax0"] == "1") echo 'checked = "checked"'; ?> id="ax0" name="ax0" >
              <span class="lever"></span> 
             On 
            </label>
          </div>
        </td>
       <td>
          <div class="switch">
            <label>
             Off
              <input type="checkbox" <?php if($r["ax1"] == "1") echo 'checked = "checked"'; ?> id="ax1" name="ax1" >
              <span class="lever"></span> 
             On 
            </label>
          </div>
      </td> 
     </tr>
      <tr>
       <td>Factura</td>
       <td>
          <div class="switch">
            <label>
             Off
              <input type="checkbox" <?php if($r["bx0"] == "1") echo 'checked = "checked"'; ?> id="bx0" name="bx0" >
              <span class="lever"></span> 
             On 
            </label>
          </div>
       </td>
       <td>
          <div class="switch">
            <label>
             Off
              <input type="checkbox" <?php if($r["bx1"] == "1") echo 'checked = "checked"'; ?> id="bx1" name="bx1" >
              <span class="lever"></span> 
             On 
            </label>
          </div>
      </td> 
     </tr>
      <tr>
       <td>Imprimir Antes</td>
       <td>
          <div class="switch">
            <label>
             Off
              <input type="checkbox" <?php if($r["cx0"] == "1") echo 'checked = "checked"'; ?> id="cx0" name="cx0" >
              <span class="lever"></span> 
             On 
            </label>
          </div>
       </td>
       <td>
          <div class="switch">
            <label>
             Off
              <input type="checkbox" <?php if($r["cx1"] == "1") echo 'checked = "checked"'; ?> id="cx1" name="cx1" >
              <span class="lever"></span> 
             On 
            </label>
          </div>
       </td> 
     </tr>
      <tr>
       <td>Exportacíon</td>
       <td>
          <div class="switch">
            <label>
             Off
              <input type="checkbox" <?php if($r["dx0"] == "1") echo 'checked = "checked"'; ?> id="dx0" name="dx0" >
              <span class="lever"></span> 
             On 
            </label>
          </div>
       </td>
       <td>
          <div class="switch">
            <label>
             Off
              <input type="checkbox" <?php if($r["dx1"] == "1") echo 'checked = "checked"'; ?> id="dx1" name="dx1" >
              <span class="lever"></span> 
             On 
            </label>
          </div>
       </td> 
     </tr>
      <tr>
       <td>Credito Fiscal</td>
       <td>
          <div class="switch">
            <label>
             Off
              <input type="checkbox" <?php if($r["ex0"] == "1") echo 'checked = "checked"'; ?> id="ex0" name="ex0" >
              <span class="lever"></span> 
             On 
            </label>
          </div>
       </td>
       <td>
          <div class="switch">
            <label>
             Off
              <input type="checkbox" <?php if($r["ex1"] == "1") echo 'checked = "checked"'; ?> id="ex1" name="ex1" >
              <span class="lever"></span> 
             On 
            </label>
          </div>
       </td> 
     </tr>

     <tr>
       <td>Ninguno</td>
       <td>
       </td>
       <td>
          <div class="switch">
            <label>
             Off
              <input type="checkbox" <?php if($r["ninguno"] == "1") echo 'checked = "checked"'; ?> id="ninguno" name="ninguno" >
              <span class="lever"></span> 
             On 
            </label>
          </div>
       </td> 
     </tr>

     <tr>
       <td>Nota de Envio</td>
       <td>
       </td>
       <td>
          <div class="switch">
            <label>
             Off
              <input type="checkbox" <?php if($r["nota_envio"] == "1") echo 'checked = "checked"'; ?> id="nota_envio" name="nota_envio" >
              <span class="lever"></span> 
             On 
            </label>
          </div>
       </td> 
     </tr>

     <tr>
       <td>Factura 2</td>
       <td>
          <div class="switch">
            <label>
             Off
              <input type="checkbox" <?php if($r["fx0"] == "1") echo 'checked = "checked"'; ?> id="fx0" name="fx0" >
              <span class="lever"></span> 
             On 
            </label>
          </div>
       </td>
       <td>
          <div class="switch">
            <label>
             Off
              <input type="checkbox" <?php if($r["fx1"] == "1") echo 'checked = "checked"'; ?> id="fx1" name="fx1" >
              <span class="lever"></span> 
             On 
            </label>
          </div>
      </td> 
     </tr>

     <tr>
       <td>Credito Fiscal 2</td>
       <td>
          <div class="switch">
            <label>
             Off
              <input type="checkbox" <?php if($r["gx0"] == "1") echo 'checked = "checked"'; ?> id="gx0" name="gx0" >
              <span class="lever"></span> 
             On 
            </label>
          </div>
       </td>
       <td>
          <div class="switch">
            <label>
             Off
              <input type="checkbox" <?php if($r["gx1"] == "1") echo 'checked = "checked"'; ?> id="gx1" name="gx1" >
              <span class="lever"></span> 
             On 
            </label>
          </div>
      </td> 
     </tr>
<?
 unset($r);  
   ?>
   </tbody>
</table>
<div id="contenido"></div>