<?php
date_default_timezone_set('America/El_Salvador');

if(Helpers::ServerDomain() == TRUE){

define("HOST", "localhost"); 			//35.225.56.157 The host you want to connect to. 
define("USER", "superpol_erick"); 			// The database username. 
define("PASSWORD", "caca007125-"); 	// The database password.
	if(Helpers::ServerDemo() == TRUE){
		define("DATABASE", "superpol_demo_cozto");
		define("XSERV", "https://pizto.com/demo/");	
	} elseif(Helpers::ServerPractica() == TRUE){
		define("DATABASE", "superpol_practica_cozto");
		define("XSERV", "https://pizto.com/practica/");	
	} else {
		define("DATABASE", "superpol_cozto");
		define("XSERV", "https://pizto.com/login/");	
	}
  

} else if(Helpers::AmazonServer() == TRUE) {

define("HOST", "198.27.68.160"); 			//35.225.56.157 The host you want to connect to. 
define("USER", "superpol_erick"); 			// The database username. 
define("PASSWORD", "caca007125-"); 	// The database password. 
define("DATABASE", "superpol_demo_cozto"); 
define("XSERV", "http://http://3.18.81.185/cozto/");	

} else {

define("HOST", "localhost"); 			//35.225.56.157 The host you want to connect to. 
define("USER", "root"); 			// The database username. 
define("PASSWORD", "erick"); 	// The database password. 
define("DATABASE", "cozto_ventas"); 
define("XSERV", "http://localhost/cozto/");	

}

define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");
define("SECURE", FALSE);    // For development purposes only!!!!

// para el sistema
define("BASE_URL", "https://pizto.com/admin/");
define("BASEPATH", "https://pizto.com/admin/");	

?>