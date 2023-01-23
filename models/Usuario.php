<?php

class Usuario{
	private $id;
	private $nombre;
	private $apellidos;
	private $email;
	private $password;
	private $rol;
	private $imagen;
	private $db;
	
	public function __construct() {
		$this->db = Database::connect();
	}
	
	function getId() {
		return $this->id;
	}

	function getNombre() {
		return $this->nombre;
	}

	function getApellidos() {
		return $this->apellidos;
	}

	function getEmail() {
		return $this->email;
	}

	function getPassword() {
		return password_hash($this->db->real_escape_string($this->password), PASSWORD_BCRYPT, ['cost' => 4]);
	}

	function getRol() {
		return $this->rol;
	}

	function getImagen() {
		return $this->imagen;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setNombre($nombre) {
		$this->nombre = $this->db->real_escape_string($nombre);
	}

	function setApellidos($apellidos) {
		$this->apellidos = $this->db->real_escape_string($apellidos);
	}

	function setEmail($email) {
		$this->email = $this->db->real_escape_string($email);
	}

	function setPassword($password) {
		$this->password = $password;
	}

	function setRol($rol) {
		$this->rol = $rol;
	}

	function setImagen($imagen) {
		$this->imagen = $imagen;
	}

	public function save(){
		$sql = "INSERT INTO usuarios VALUES(NULL, '{$this->getNombre()}', '{$this->getApellidos()}', '{$this->getEmail()}', '{$this->getPassword()}', 'user', null);";
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
	public function login(){
		$result = false;
		$email = $this->email;
		$password = $this->password;
		
		// Comprobar si existe el usuario
		$sql = "SELECT * FROM usuarios WHERE email = '$email'";
		$login = $this->db->query($sql);
		
		
		if($login && $login->num_rows == 1){
			$usuario = $login->fetch_object();
			
			// Verificar la contraseña
			$verify = password_verify($password, $usuario->password);
			
			if($verify){
				$result = $usuario;
			}
		}
		
		return $result;
	}
	
	//1. VER LISTA DE USUARIOS 21/12
	public function getAll(){
		$usuarios = $this->db->query("SELECT * FROM usuarios ORDER BY id ASC");
		
		return $usuarios;
	}

	//1. BORRAR USUARIOS 21/12
	public function borrar(){
		$sql = "DELETE FROM usuarios WHERE id={$this->id};";
		$usuario = $this->db->query($sql);
	}

	//2. Cambiar datos usuario 11/01
	public function modificarUsuario(){
		$sql = "UPDATE usuarios SET nombre='{$this->getNombre()}', apellidos='{$this->getApellidos()}', email='{$this->getEmail()}', password='{$this->getPassword()}', rol='{$this->getRol()}' WHERE id={$this->getId()} ";
		$usuario = $this->db->query($sql);
		return $usuario;

		
	}

	//1. + Informacion del usuario 25/01
	public function getOne(){
		$usuarios = $this->db->query("SELECT * FROM usuarios WHERE id={$this->getId()};");
		
		return $usuarios;
	}
	public function getAllPendientes(){
		$usuarios = $this->db->query("SELECT count(id) as pendientesentrega 
									  FROM pedidos 
									  WHERE estado='confirm' AND usuario_id={$this->getId()} 
									  GROUP BY usuario_id 
									  ORDER BY usuario_id ASC");

		return $usuarios;
	}
	

	public function getAllTotalPrecio(){
		$usuarios = $this->db->query("SELECT sum(coste) as totalgastado 
									  FROM pedidos 
									  WHERE usuario_id={$this->getId()} 
									  GROUP BY usuario_id 
									  ORDER BY usuario_id ASC");

		return $usuarios;
	}


	
	
}