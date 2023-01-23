
<h1>Administracion del Usuario</h1>


<a href="<?=base_url?>usuario/gestion" class="button button-small button">Volver</a>
<div class="form_container">

<form action="<?=base_url?>usuario/editarUsuario" method="POST">

		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" value="<?=isset($pro) && is_object($pro) ? $pro->nombre : ''; ?>"/>

		<label for="descripcion">Descripción</label>
		<textarea name="descripcion"><?=isset($pro) && is_object($pro) ? $pro->descripcion : ''; ?></textarea>

		<label for="precio">Precio</label>
		<input type="text" name="precio" value="<?=isset($pro) && is_object($pro) ? $pro->precio : ''; ?>"/>

		<label for="stock">Stock</label>
		<input type="number" name="stock" value="<?=isset($pro) && is_object($pro) ? $pro->stock : ''; ?>"/>

		
		
		<input type="submit" value="Guardar" />
        
	</form>
    
</div>