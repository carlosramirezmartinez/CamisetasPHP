<?php

class Producto{
	private $id;
	private $categoria_id;
	private $nombre;
	private $descripcion;
	private $precio;
	private $stock;
	private $oferta;
	private $fecha;
	private $imagen;

	private $db;
	
	public function __construct() {
		$this->db = Database::connect();
	}
	
	function getId() {
		return $this->id;
	}

	function getCategoria_id() {
		return $this->categoria_id;
	}

	function getNombre() {
		return $this->nombre;
	}

	function getDescripcion() {
		return $this->descripcion;
	}

	function getPrecio() {
		return $this->precio;
	}

	function getStock() {
		return $this->stock;
	}

	function getOferta() {
		return $this->oferta;
	}

	function getFecha() {
		return $this->fecha;
	}

	function getImagen() {
		return $this->imagen;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setCategoria_id($categoria_id) {
		$this->categoria_id = $categoria_id;
	}

	function setNombre($nombre) {
		$this->nombre = $this->db->real_escape_string($nombre);
	}

	function setDescripcion($descripcion) {
		$this->descripcion = $this->db->real_escape_string($descripcion);
	}

	function setPrecio($precio) {
		$this->precio = $this->db->real_escape_string($precio);
	}

	function setStock($stock) {
		$this->stock = $this->db->real_escape_string($stock);
	}

	function setOferta($oferta) {
		$this->oferta = $this->db->real_escape_string($oferta);
	}

	function setFecha($fecha) {
		$this->fecha = $fecha;
	}

	function setImagen($imagen) {
		$this->imagen = $imagen;
	}

	public function getAll(){
		$productos = $this->db->query("SELECT * FROM productos ORDER BY id DESC");
		return $productos;
	}
	
	public function getAllCategory(){
		$sql = "SELECT p.*, c.nombre AS 'catnombre' FROM productos p "
				. "INNER JOIN categorias c ON c.id = p.categoria_id "
				. "WHERE p.categoria_id = {$this->getCategoria_id()} "
				. "ORDER BY id DESC";
		$productos = $this->db->query($sql);
		return $productos;
	}
	
	public function getRandom($limit){
		$productos = $this->db->query("SELECT * FROM productos ORDER BY RAND() LIMIT $limit");
		return $productos;
	}
	
	public function getOne(){
		$producto = $this->db->query("SELECT * FROM productos WHERE id = {$this->getId()}");
		return $producto->fetch_object();
	}
	
	// 7. Paginacion 27/12
	public function getAllCount(){
		$productos = $this->db->query("SELECT count(*) total FROM productos");
		$fila = $productos->fetch_assoc();
		$total = intval($fila['total']);
		return $total;
	}

	// 7. Paginacion 27/12
	public function getIndices($limite){
		$productos = $this->db->query("SELECT * FROM productos ORDER BY id DESC LIMIT ".$limite.", 4");
		return $productos;
	}
	
	public function save(){
		$sql = "INSERT INTO productos VALUES(NULL, {$this->getCategoria_id()}, '{$this->getNombre()}', '{$this->getDescripcion()}', '{$this->getPrecio()}', {$this->getStock()}, {$this->getOferta()}, CURDATE(), '{$this->getImagen()}');";
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
	public function edit(){
		$sql = "UPDATE productos SET nombre='{$this->getNombre()}', descripcion='{$this->getDescripcion()}', precio='{$this->getPrecio()}', stock={$this->getStock()}, oferta='{$this->getOferta()}' ,categoria_id='{$this->getCategoria_id()}'  ";
		
		if($this->getImagen() != null){
			$sql .= ", imagen='{$this->getImagen()}'";
		}
		
		$sql .= " WHERE id={$this->id};";
		
		
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
	public function delete(){
		$sql = "DELETE FROM productos WHERE id={$this->id}";
		$delete = $this->db->query($sql);
		
		$result = false;
		if($delete){
			$result = true;
		}
		return $result;
	}
	//5. Ofertas 13/1
	public function getOfertas(){
		$productos = $this->db->query("SELECT * FROM productos WHERE oferta='si'");
		return $productos;
	}

	public function getNoOfertas(){
		$productos = $this->db->query("SELECT * FROM productos WHERE oferta='no'");
		return $productos;
	}
	
	//4. Gestion de productos 26/1

	/**
	 * Obtener más información de los productos, el total de ventas realizadas,
	 *  producto más vendido, productos sin ventas, productos sin existencias.
	 */
	
	 //Total ventas count estado confirmar(?)
	 // Sin existencias stock = 0
	 // sin ventas

	//Una por vista
	public function getTotalVentas(){ //OK
		$productos = $this->db->query("SELECT productos.nombre as producto, (SELECT sum(unidades) FROM lineas_pedidos
										where productos.id = lineas_pedidos.producto_id) AS ventas
										from productos ORDER by ventas DESC");
		return $productos;
	}


	public function getSinVentas(){ //OK
		$productos = $this->db->query("SELECT * FROM productos 
									   WHERE id NOT IN (SELECT producto_id from lineas_pedidos);");
		return $productos;
	}

	public function getSinStock(){ //OK
		$productos = $this->db->query("SELECT * FROM productos WHERE stock=0;");
		return $productos;
	}

	public function getMasVendido(){ //OK
		$productos = $this->db->query("SELECT productos.nombre as producto, (SELECT sum(unidades) FROM lineas_pedidos
										where productos.id = lineas_pedidos.producto_id) AS ventas 
										from productos ORDER by ventas DESC limit 1;");
		return $productos;
	}
	
}