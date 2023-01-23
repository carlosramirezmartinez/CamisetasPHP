<?php
require_once 'models/Usuario.php';

class usuarioController{
	
	public function index(){
		echo "Controlador Usuarios, Acción index";
	}
	
	public function registro(){
		require_once 'views/usuario/registro.php';
	}
	
	public function save(){
		if(isset($_POST)){
			
			$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
			$apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
			$email = isset($_POST['email']) ? $_POST['email'] : false;
			$password = isset($_POST['password']) ? $_POST['password'] : false;
			
			if($nombre && $apellidos && $email && $password){
				$usuario = new Usuario();
				$usuario->setNombre($nombre);
				$usuario->setApellidos($apellidos);
				$usuario->setEmail($email);
				$usuario->setPassword($password);

				$save = $usuario->save();
				if($save){
					$_SESSION['register'] = "complete";
				}else{
					$_SESSION['register'] = "failed";
				}
			}else{
				$_SESSION['register'] = "failed";
			}
		}else{
			$_SESSION['register'] = "failed";
		}
		header("Location:".base_url.'usuario/registro');
	}
	
	public function login(){
		if(isset($_POST)){
			// Identificar al usuario
			// Consulta a la base de datos
			$usuario = new Usuario();
			$usuario->setEmail($_POST['email']);
			$usuario->setPassword($_POST['password']);
			
			$identity = $usuario->login();
			
			if($identity && is_object($identity)){
				$_SESSION['identity'] = $identity;
				
				if($identity->rol == 'admin'){
					$_SESSION['admin'] = true;
				}
				
			}else{
				$_SESSION['error_login'] = 'Identificación fallida !!';
			}
		
		}
		header("Location:".base_url);
	}
	
	public function logout(){
		if(isset($_SESSION['identity'])){
			unset($_SESSION['identity']);
		}
		
		if(isset($_SESSION['admin'])){
			unset($_SESSION['admin']);
		}
		
		header("Location:".base_url);
	}
	
	//1. Modificar Usuario 27/12, formulario para rellenar => Editar Usuario
	public function modificarUsuario(){
		$usuario = new Usuario();
		$id = $_SESSION['identity']->id;
		$nombre = $_SESSION['identity']->nombre;
		$apellidos = $_SESSION['identity']->apellidos;
		$email = $_SESSION['identity']->email;
		$rol = $_SESSION['identity']->rol;

		$_SESSION['error'] = " ";

		$usuarios2 = $usuario->getAll();

		require_once 'views/usuario/modificar.php';
	}

	//2. Modificar Usuario 9/1 Editar Usuario
	public function editarUsuario(){
		$id = $_POST['id'];
		$nombre = $_POST['nombre'];
		$apellidos = $_POST['apellidos'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		//$password2 = $_POST['password2'];
		//$password3 = $_POST['password3'];
		$rol = $_POST['rol'];

		//Modifica las variables de sesion si se modifica el propio perfil
		if ($id == $_SESSION['identity']->id){
			$_SESSION['identity']->id = $id;
			$_SESSION['identity']->nombre = $nombre;
			$_SESSION['identity']->apellidos = $apellidos;
			$_SESSION['identity']->email = $email;
			$_SESSION['identity']->rol = $rol;
			
		}

		$usuario = new Usuario();

		//Busca si el mail ya existe
		$usuarios = $usuario->getAll();
		while ($us = $usuarios->fetch_object()){
			if ($us->email == $email){
				$emailExiste = true;
			} else {
				$emailExiste = false;
			}
		}

		//Si el mail no existe ya, modifica el perfil
		if ($emailExiste == true){
			$_SESSION['error'] = "El mail al que ha intentado cambiar ya existe";
			//header("Location:".base_url."usuario/modificar");
		} else {
			$_SESSION['error'] = " ";
			$usuario->setId($id);
			$usuario->setNombre($nombre);
			$usuario->setApellidos($apellidos);
			$usuario->setEmail($email);
			$usuario->setPassword($password);
			$usuario->setRol($rol);

			$usuario = $usuario->modificarUsuario(); //ir al modelo

			header("Location:".base_url);
		}

		// Contraseña
	}
	
	//1. Eliminar Usuario 27/12
	public function eliminar(){
		Utils::isAdmin();

		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$usuario = new Usuario();
			$usuario->setId($id);
			
			$usuario = $usuario->borrar();
		}
		header("Location:".base_url."usuario/gestion");
	}

	//1. Vista Usuario 15/1
	public function gestion(){
		Utils::isAdmin();

		$usuario = new Usuario();

		$usuarios = $usuario->getAll();
		

		require_once 'views/usuario/gestion.php';
	}

	//1. Modificar Usuarios(Administracion) 13/2
	 
	public function editar(){
		Utils::isAdmin();

		$usuario = new Usuario();
		$id = $_GET['id'];
		$nombre="";
		$apellidos="";
		$email="";
		$password="";
		$rol="";
		$usuarios = $usuario->getAll();
		/*
		while ($us = $usuarios->fetch_object()){
			$usuario->getNombre($nombre);
			$usuario->getApellidos($apellidos);
			$usuario->getEmail($email);
			$usuario->getPassword($password);
			$usuario->getRol($rol);
		}
		*/
		require_once 'views/usuario/modificar.php';
		
	}

	//1. Más informacion (ver el importe total de los pedidos que ha realizado cada usuario, pendientes de entregar etc.) 28/01
	public function masinfo(){
		$id = $_GET['id'];

		$usuario = new Usuario();
		$usuario->setId($id);

		$usuarios = $usuario->getOne();
		$usuarios2 = $usuario->getAllPendientes();
		$usuarios3 = $usuario->getAllTotalPrecio();
		
		require_once 'views/usuario/masinfo.php';
	}
} // fin clase