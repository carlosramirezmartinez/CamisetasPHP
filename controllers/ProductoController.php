<?php
require_once 'models/Producto.php';

class productoController{
	
	public function index(){
		$producto = new Producto();
		$productos = $producto->getRandom(6);
	
		// renderizar vista
		require_once 'views/producto/destacados.php';
	}
	
	public function ver(){
		if(isset($_GET['id'])){
			$id = $_GET['id'];
		
			$producto = new Producto();
			$producto->setId($id);
			
			$product = $producto->getOne();
			
		}
		require_once 'views/producto/ver.php';
	}
	
	public function gestion(){
		Utils::isAdmin();
		$producto = new Producto();
		
		//7. Sistema de Paginacion 28/12
		$total = $producto->getAllCount();
		$numPaginas = floor(abs($total - 1) / 5 + 1);

		if(!isset($_SESSION['pagina'])) {
			$_SESSION['pagina'] = 1;
			header("refresh:0");
		}
		
		if (isset ($_POST['pagina'])){
		$pagina = $_POST['pagina'];
		}
		else {
		$pagina = "Primera";
		}
	
		if ($pagina == "Primera") {
		  $_SESSION['pagina'] = 1;
		}
	
		if (($pagina == "Anterior") && ($_SESSION['pagina'] > 1)) {
		  $_SESSION['pagina']--;
		}
	
		if (($pagina == "Siguiente") && ($_SESSION['pagina'] < $numPaginas)) {
		  $_SESSION['pagina']++;
		  echo '<meta http-equiv="refresh" content="5" />';
		}
	
		if ($pagina == "Ultima") {
		  $_SESSION['pagina'] = $numPaginas;
		}

		$productos = $producto->getIndices(($_SESSION['pagina'] - 1) * 5);

		require_once 'views/producto/gestion.php';
	}
		
	
	public function crear(){
		Utils::isAdmin();
		require_once 'views/producto/crear.php';
	}
	
	public function save(){
		Utils::isAdmin();
		if(isset($_POST)){
			$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
			$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
			$precio = isset($_POST['precio']) ? $_POST['precio'] : false;
			$stock = isset($_POST['stock']) ? $_POST['stock'] : false;
			$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : false;
			$oferta = isset($_POST['oferta']) ? $_POST['oferta'] : false;
			// $imagen = isset($_POST['imagen']) ? $_POST['imagen'] : false;
			
			if($nombre && $descripcion && $precio && $stock && $categoria){
				$producto = new Producto();
				$producto->setNombre($nombre);
				$producto->setDescripcion($descripcion);
				$producto->setPrecio($precio);
				$producto->setStock($stock);
				$producto->setCategoria_id($categoria);
				$producto->setOferta($oferta);
				// Guardar la imagen
				if(isset($_FILES['imagen'])){
					$file = $_FILES['imagen'];
					$filename = $file['name'];
					$mimetype = $file['type'];

					if($mimetype == "image/jpg" || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif'){

						if(!is_dir('uploads/images')){
							mkdir('uploads/images', 0777, true);
						}

						$producto->setImagen($filename);
						move_uploaded_file($file['tmp_name'], 'uploads/images/'.$filename);
					}
				}
				
				if(isset($_GET['id'])){
					$id = $_GET['id'];
					$producto->setId($id);
					
					$save = $producto->edit();
				}else{
					$save = $producto->save();
				}
				
				if($save){
					$_SESSION['producto'] = "complete";
				}else{
					$_SESSION['producto'] = "failed";
				}
			}else{
				$_SESSION['producto'] = "failed";
			}
		}else{
			$_SESSION['producto'] = "failed";
		}
		header('Location:'.base_url.'Producto/gestion');
	}
	
	public function editar(){
		Utils::isAdmin();
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$edit = true;
			
			$producto = new Producto();
			$producto->setId($id);
			
			$pro = $producto->getOne();
			
			require_once 'views/producto/crear.php';
			
		}else{
			header('Location:'.base_url.'Producto/gestion');
		}
	}
	
	public function eliminar(){
		Utils::isAdmin();
		
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$producto = new Producto();
			$producto->setId($id);
			
			$delete = $producto->delete();
			if($delete){
				$_SESSION['delete'] = 'complete';
			}else{
				$_SESSION['delete'] = 'failed';
			}
		}else{
			$_SESSION['delete'] = 'failed';
		}
		
		header('Location:'.base_url.'Producto/gestion');
	}
	
	// 5. Ofertas 13/1
	public function ofertas(){
		$producto = new Producto();
		$productos = $producto->getOfertas();
	
		// renderizar vista
		require_once 'views/producto/ofertas.php';
	}

	//4. Más informacion (Obtener más información de los productos, el total de ventas realizadas,
	// producto más vendido, productos sin ventas, productos sin existencias.) 08/02
	public function productosVendidos(){
		Utils::isAdmin();
		
		$producto = new Producto();
		$productos = $producto->getAll();
		$productosVentas = $producto->getTotalVentas();

		require_once 'views/producto/totalventas.php';
	}

	public function productosSinVentas(){
		Utils::isAdmin();
		
		$producto = new Producto();
		$productos = $producto->getAll();
		$productosVentas = $producto->getSinVentas();

		require_once 'views/producto/sinventas.php';
	}

	public function productosSinStock(){
		Utils::isAdmin();
		
		$producto = new Producto();
		$productos = $producto->getAll();
		$productosStock = $producto->getSinStock();
	
		require_once 'views/producto/stock.php';
	}

	public function productoMasVendido(){
		Utils::isAdmin();
		
		$producto = new Producto();
		$productos = $producto->getAll();
		$productosVendido = $producto->getMasVendido();
	
		require_once 'views/producto/vendido.php';
	}
}
