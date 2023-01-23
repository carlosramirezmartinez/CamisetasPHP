<?php
require_once 'models/Categoria.php';
require_once 'models/Producto.php';

class categoriaController{
	
	public function index(){
		Utils::isAdmin();
		$categoria = new Categoria();
		// $categorias = $categoria->getAll();
		// 3. con la funcion getAllwithValues(), incluyo una vinculacion con productos con un join
		// para obtener el stock disponible y + caracteristicas 15/1
		$categorias = $categoria->getAllwithValues();
		
		require_once 'views/categoria/index.php';
	}
	
	public function ver(){
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			
			// Conseguir categoria
			$categoria = new Categoria();
			$categoria->setId($id);
			$categoria = $categoria->getOne();
			
			// Conseguir productos;
			$producto = new Producto();
			$producto->setCategoria_id($id);
			$productos = $producto->getAllCategory();
		}
		
		require_once 'views/categoria/ver.php';
	}
	
	public function crear(){
		Utils::isAdmin();
		require_once 'views/categoria/crear.php';
	}
	
	public function save(){
		Utils::isAdmin();
	    if(isset($_POST) && isset($_POST['nombre'])){
			// Guardar la categoria en bd
			$categoria = new Categoria();
			$categoria->setNombre($_POST['nombre']);
			$save = $categoria->save();
		}
		header("Location:".base_url."categoria/index");
	}
	
	// 3. Borrar Categoria 21/12
	public function borrar(){
		Utils::isAdmin();

		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$categoria = new Categoria();
			$categoria->setId($id);
			
			$delete = $categoria->borrar(); //Va al modelo categoria
			if($delete){
				$_SESSION['delete'] = 'complete';
			}else{
				$_SESSION['delete'] = 'failed';
			}
		}else{
			$_SESSION['delete'] = 'failed';
		}
		header("Location:".base_url."categoria/index");
	}

	// 3. Editar Categoria 23/12
	public function editar(){
		Utils::isAdmin();
		$id = $_GET['id'];
		$nombre = $_POST['categoria'];

		// Guardar la categoria en bd
		$categoria = new Categoria();
		$categoria->setNombre($nombre);
		$categoria->setId($id);
		$categoria = $categoria->editar();

		header("Location:".base_url."categoria/index");
	}


	//Redirecciona a la vista para editar categoria
	public function modificar(){
		Utils::isAdmin();

		$id = $_GET['id'];
		require_once 'views/categoria/modificar.php';// Creamos una nueva vista modificar las categorias
	}

	//3. Stock categoria 14/1
	public function stock(){
		Utils::isAdmin();

		$categoria = new Categoria();
		$stock = $categoria->stock();
	}
	
}