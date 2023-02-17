$(document).ready(function(){


// $(function() {
//     $('#cod').bind('blur', function(e) {
//         if(!isValid($(this).val())) {
//             e.preventDefault();
//             $(this).focus();
//         }
//     });
// });
//     function isValid(str) {
//         if(str === "hello") {
//             return true;
//         } else {
//             return false;
//         }
//     }


    $("body").on("click","#borrar-ticket",function(){
        var op = $(this).attr('op');
		var hash = $(this).attr('hash');
        var dataString = 'op='+op+'&hash='+hash;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#ver").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#ver").html(data); // lo que regresa de la busquea 
                $("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
            }
        });
    });                 



    $("body").on("click","#guardar",function(){
        var op = $(this).attr('op');
		var orden = $(this).attr('orden');
        var dataString = 'op='+op+'&orden='+orden;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#ver").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#ver").load('application/src/routes.php?op=93'); // ver productos de la orden 
                $("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
            }
        });
    });                 




    $("body").on("click","#select-orden",function(){
        var op = $(this).attr('op');
		var orden = $(this).attr('orden');
        var dataString = 'op='+op+'&orden='+orden;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#ver").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
            success: function(data) {  
               $("#ventana").html(data);          
               $("#ver").load('application/src/routes.php?op=93'); // ver productos de la orden 
               $("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
            }
        });
    });                 






///////////////////// para venta rapida

	$('#btn-busquedaR').click(function(e){ /// para el formulario
		e.preventDefault();
        if($('#cod').val() != ""){
    		$.ajax({
    			url: "application/src/routes.php?op=90",
    			method: "POST",
    			data: $("#form-busquedaR").serialize(),
    		// beforeSend: function(){
    		// 	$("#ver").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
      //           },
    		success: function(data){
    			$("#ver").html(data);
    			$("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
    			$("#form-busquedaR").trigger("reset");
    		}
    		});
        }
	})




    $("body").on("click","#modcant",function(){
        var op = $(this).attr('op');
		var cod = $(this).attr('cod');
        var dataString = 'op='+op+'&cod='+cod;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            // beforeSend: function () {
            //    $("#ver").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            // },
            success: function(data) {            
                $("#ver").load('application/src/routes.php?op=93'); // ver productos de la orden 
                $("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
            }
        });
    });                 








//// buscar productos

    $("#producto-busqueda").keyup(function(){ /// para la caja de busqueda
        $.ajax({
        type: "POST",
        url: "application/src/routes.php?op=" + Btags(),
        data:'keyword='+$(this).val(),
        beforeSend: function(){
            $("#muestra-busqueda").css("background","#FFF url(assets/img/LoaderIcon.gif) no-repeat 550px");
        },
        success: function(data){
            $("#muestra-busqueda").show();
            $("#muestra-busqueda").html(data);
            $("#producto-busqueda").css("background","#FFF");
        }
        });
    });



    $("body").on("click","#cancel-p",function(){
        $("#muestra-busqueda").hide();
        $("#p-busqueda").trigger("reset"); 
    });


// switch de busqueda por tags
    $("body").on("click","#busquedaTags",function(){ /// para el los botones de opciones

        if($(this).attr('checked')){ // es por que estaba activo
            $('#busquedaTags').removeAttr("checked","checked");
            $('#producto-busqueda').attr("placeholder","Ingrese el nombre del producto");
        } 
        else {
            $('#busquedaTags').attr("checked","checked");
            $('#producto-busqueda').attr("placeholder","Ingrese palabras claves a buscar");
        }
    });

function Btags(){

        if($("#busquedaTags").attr('checked')){ // es por que estaba activo
            var opnum = '500'; // 500 busqueda por tags
        } 
        else {
            var opnum = '75'; // 75 busqueda por nombre
        }

        return opnum;
}

/// switch
////////////////



    $("body").on("click","#select-p",function(){
    var cod = $(this).attr('cod');
        $.post("application/src/routes.php?op=90", {cod:cod}, 
        function(data){
            $("#muestra-busqueda").hide();
            $("#ver").html(data); // lo que regresa de la busquea 
            $("#p-busqueda").trigger("reset"); // no funciona
            $("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
        });
    });



//////////////cancelar
    $("body").on("click","#cancelar",function(){
        var op = $(this).attr('op');
        var dataString = 'op='+op;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#ver").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#ver").html(data); // lo que regresa de la busquea 
                $("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
            }
        });
    });   




$('#ModalBusqueda').on('shown.bs.modal', function() { // para autofocus en el modal
  $(this).find('[autofocus]').focus();
});


$('#ModalBalanza').on('shown.bs.modal', function() { // para autofocus en el modal
  $(this).find('[autofocus]').focus();
});





/// llamar modal cantidad
    $("body").on("click","#xcantidad",function(){ 
        
        $('#ModalCantidad').modal('show');
        
        var cantidad = $(this).attr('cantidad');
        var codigox = $(this).attr('codigox');
        var op = $(this).attr('op');

        $('#codigox').attr("value", codigox);
        $('#cantidad').attr("value", cantidad);
        
    });




    $('#btn-Ccantidad').click(function(e){ /// cambia la cantidad de los productos
        e.preventDefault();
        $.ajax({
            url: "application/src/routes.php?op=90",
            method: "POST",
            data: $("#form-Ccantidad").serialize(),
            beforeSend: function () {
                $('#btn-Ccantidad').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
            },
            success: function(data){
                $('#btn-Ccantidad').html('Agregar').removeClass('disabled');
               $("#form-Ccantidad").trigger("reset");
               $('#ModalCantidad').modal('hide');
               $("#ver").html(data); // lo que regresa de la busquea 
               $("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
            }
        })
    })




/// llamar modal descuento
    $("body").on("click","#xdescuento",function(){ 
        
        $('#ModalDescuento').modal('show');
        
        var ddescuento = $(this).attr('ddescuento');
        var dcantidad = $(this).attr('dcantidad');
        var dcodigo = $(this).attr('dcodigo');
        var porcentaje = $(this).attr('dporcentaje');

        $('#dcodigo').attr("value", dcodigo);
        $('#dcantidad').attr("value", dcantidad);

        if(ddescuento != "0.00"){
            $('#ver-descuento').html('<div class="border border-light alert alert-success alert-dismissible"><div align="center">El total descuento en este producto es: $'+ddescuento+' ('+porcentaje+'%)<br></div></div>');
            $('#ver-btndescuento').html('<a id="del-descuento" dcantidad="'+dcantidad+'" dcodigo="'+dcodigo+'" ddescuento="0" class="btn btn-danger btn-rounded waves-effect waves-light">Quitar Descuento</a>');
            $('#ver-btndescuento').show();
        } else {
            $('#ver-descuento').html('<div class="border border-light alert alert-danger alert-dismissible"><div align="center">No se ha aplicado descuento a este producto</div></div>');
            $('#ver-btndescuento').hide();
        }
    });



    $('#btn-Ddescuento').click(function(e){ /// cambia la cantidad de los productos
        e.preventDefault();
        $.ajax({
            url: "application/src/routes.php?op=94",
            method: "POST",
            data: $("#form-Ddescuento").serialize(),
            beforeSend: function () {
                $('#btn-Ddescuento').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
            },
            success: function(data){
               $('#btn-Ddescuento').html('Agregar').removeClass('disabled');
               $("#form-Ddescuento").trigger("reset");
               $('#ModalDescuento').modal('hide');
               $("#ver").load('application/src/routes.php?op=93'); // ver productos de la orden 
               $("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
            }
        })
    })


/// cambiar para porcentaje o establecer cantidad de propina
    $("body").on("click","#prop",function(){ /// para el los botones de opciones

        if($(this).attr('checked')){ // es por que estaba activo
            $('#prop').removeAttr("checked","checked");
            var dir = 'op=154&edo=0';
        } 
        else {
            $('#prop').attr("checked","checked");
            var dir = 'op=154&edo=1';
        }
    
    QueryGo(dir);   
    
    });

function QueryGo(dir){

        var dataString = dir;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#load").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#load").html(data); // lo que regresa de la busquea 
            }

    });      
}

///////


    $("body").on("click","#del-descuento",function(){
    var dcantidad = $(this).attr('dcantidad');
    var dcodigo = $(this).attr('dcodigo');
    var descuento = $(this).attr('ddescuento');
       
        $.post("application/src/routes.php?op=94", {dcantidad:dcantidad, dcodigo:dcodigo, descuento:descuento}, 
        function(data){
               $('#ModalDescuento').modal('hide');
               $("#ver").load('application/src/routes.php?op=93'); // ver productos de la orden 
               $("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
        });
    });












// para ModalBalanza

    $("body").on("click","#xbalanza",function(){ // llamar nada mas a los productos
        
        $('#ModalBalanza').modal('show');
        
        // var op = "429";

        // var dataString = 'op='+op;

        // $.ajax({
        //     type: "POST",
        //     url: "application/src/routes.php",
        //     data: dataString,
        //     beforeSend: function () {
        //        $("#productos_bal").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
        //     },
        //     success: function(data) {            
        //         $("#productos_bal").html(data); // lo que regresa de la busquea 
        //     }
        // }); 
    });



    $("body").on("click","#xfacturar",function(){ // llamar nada mas a los productos

        var op = "428";
        var probal = $(this).attr('probal');
        var dataString = 'op='+op+'&probal='+probal;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#ver").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
            success: function(data) {            
                $('#ModalBalanza').modal('hide');
                $("#ver").html(data); // lo que regresa de la busquea 
                $("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
            }
        }); 
    });



    $('#btn-balanza').click(function(e){ /// cambia la cantidad de los productos
        e.preventDefault();
        $.ajax({
            url: "application/src/routes.php?op=428",
            method: "POST",
            data: $("#form-balanza").serialize(),
            beforeSend: function () {
                // $('#btn-balanza').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
            },
            success: function(data){
               // $('#btn-balanza').html('Agregar').removeClass('disabled');
               $("#form-balanza").trigger("reset");
               $('#ModalBalanza').modal('hide');
               $("#ver").html(data); // lo que regresa de la busquea 
               $("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
            }
        });
    });





// lamar modal ticket
    $("body").on("click","#mticket",function(){ 
        $('#ModalTicket').modal('show');
        var op = "547";
        var dataString = 'op='+op;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#contenidomticket").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#contenidomticket").html(data); // lo que regresa de la busquea 
            }
        }); 

    });



    $("body").on("click","#opticket",function(){ // llamar nada mas a los productos

        var op = "551";
        var tipo = $(this).attr('tipo');
        var dataString = 'op='+op+'&tipo='+tipo;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            success: function(data) {            
                $('#ModalTicket').modal('hide');
                $("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
            }
        }); 
    });







    $("body").on("click","#agrupado",function(){
        var op = "586";
        var dataString = 'op='+op;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            success: function(data) {            
                $("#msj_agrupado").html(data);
            }
        });
    });                 


  
    $('#btn-comment').click(function(e){ /// cambia la cantidad de los productos
        e.preventDefault();
        $.ajax({
            url: "application/src/routes.php?op=700",
            method: "POST",
            data: $("#form-comment").serialize(),
            beforeSend: function () {
                $('#btn-comment').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
            },
            success: function(data){
               $('#btn-comment').html('Agregar').removeClass('disabled');
               $("#form-comment").trigger("reset");
               $('#ModalComentario').modal('hide');
                $("#msj_comment").html(data);
            }
        })
    })

    $("#form-comment").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
        if (e.which == 13) {
        return false;
        }
    });
    
	$("body").on("click","#selectComment",function(){
        $('#ModalComentario').modal('show');
        var iden = $(this).attr('iden');
        $('#iden').attr("value", iden);
        var op = "701";
        var dataString = 'op='+op+'&iden='+iden;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            success: function(data) {            
                $("#msj_comment").html(data);
            }
        });    
    });



    $("body").on("click","#btnCorrelativo",function(){ 
        $('#ModalTicket').modal('hide');
        $('#ModalCorrelativo').modal('show');

        var op = "714";
        var dataString = 'op='+op;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#contenidocorrelativo").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#contenidocorrelativo").html(data); // lo que regresa de la busquea 
            }
        }); 

    });

    $('#btn-correlativo').click(function(e){ /// cambia la cantidad de los productos
        e.preventDefault();
        $.ajax({
            url: "application/src/routes.php?op=713",
            method: "POST",
            data: $("#form-correlativo").serialize(),
            beforeSend: function () {
                $('#btn-correlativo').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
            },
            success: function(data){
               $('#btn-correlativo').html('Asignar').removeClass('disabled');
               $("#form-correlativo").trigger("reset");
               $("#contenidocorrelativo").html(data);
            }
        })
    })


}); // termina query