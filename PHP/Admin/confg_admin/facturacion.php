<?php 

	session_start();

	try {
            
        $base= new PDO("mysql:host=localhost; dbname=cableunet", 'root', '');

        $base->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    } catch (Exception $e) {
        die("Error ....  " . $e->getMessage());   
    }

	if (isset($_POST['compra_serv'])) {
		
		$precio=$_POST['compra_serv'];
		$band = true;

		$sql="SELECT * FROM USUARIOS";
		$result=$base->prepare($sql);
		$result->execute();

		$sql2="SELECT * FROM facturacion";
		$existe=$base->prepare($sql2);
		$existe->execute();

		while ($current = $result->fetch(PDO::FETCH_ASSOC)) {

			while ($valida = $existe->fetch(PDO::FETCH_ASSOC)) {
				
				if ($precio == $valida['fact_servicios'] && $_SESSION['usuario'] == $valida['usuario']) {

					echo '<script language="javascript">alert("Ya tienes suscrito este paquete.");</script>';
					echo "<script>window.location='../../user/planes/plan_serv.php';</script>"; 

					$band=false;
				}

				if ($valida['activo'] == 1 && $_SESSION['usuario'] == $valida['usuario']) {
					
					echo '<script language="javascript">alert("Ya tienes suscrito un paquete de servicios.");</script>';
					echo "<script>window.location='../../user/planes/plan_serv.php';</script>";

					$band=false;
				}
			}
			
			if ($_SESSION['usuario'] == $current['usuario'] && $band) {
				
				$sql1="INSERT INTO facturacion (usuario,fact_servicios,activo) VALUES (?,?,?)";
				$facturado=$base->prepare($sql1);
				$facturado->execute([$current['usuario'],$precio,1]);
			}
		}
	}

	if (isset($_POST['compra_canal'])) {
		
		$precio=$_POST['compra_canal'];
		$band = true;

		$sql="SELECT * FROM USUARIOS";
		$result=$base->prepare($sql);
		$result->execute();

		$sql2="SELECT * FROM facturacion";
		$existe_c=$base->prepare($sql2);
		$existe_c->execute();

		while ($current = $result->fetch(PDO::FETCH_ASSOC)) {	

			while ($valida = $existe_c->fetch(PDO::FETCH_ASSOC)) {
				
				if ($precio == $valida['fact_canal'] && $_SESSION['usuario'] == $valida['usuario']) {

					echo '<script language="javascript">alert("Ya tienes suscrito este paquete.");</script>';
					echo "<script>window.location='../../user/planes/plan_canal.php';</script>"; 

					$band=false;
				}

				if ($valida['activo'] == 2 && $_SESSION['usuario'] == $valida['usuario']) {
					
					echo '<script language="javascript">alert("Ya tienes suscrito un paquete de canales.");</script>';
					echo "<script>window.location='../../user/planes/plan_canal.php';</script>";

					$band=false;
				}
			}
			
			if ($_SESSION['usuario'] == $current['usuario'] && $band) {
				
				$sql1="INSERT INTO facturacion (usuario,fact_canal,activo) VALUES (?,?,?)";
				$facturado=$base->prepare($sql1);
				$facturado->execute([$current['usuario'],$precio,2]);
			}
		}
	}	
 ?>


 <!DOCTYPE html>
 <html>
 <head>
 	<title>Facturación</title>
 	<link rel="stylesheet" type="text/css" href="../../../css/registro.css">
 	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 </head>
 <body style="background-color: #CBCBCB">

 	<div class="container registrado" style="background-color: #E7E7E7">
 		<h1>Paquete registrado con exito</h1>

 		<div style="background-color: #7D88A1">
 			<a href="../../user/index.php">Ir a inicio</a>
 		</div>

	 	
 	</div>

	 	
 
 </body>
 </html>