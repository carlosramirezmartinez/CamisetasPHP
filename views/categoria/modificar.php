<h1>Modificar categoria</h1>

<form action="<?=base_url?>categoria/editar&id=<?=$id;?>" method="POST">
	<label for="categoria">Nombre</label>
	<input type="text" name="categoria" required/>
	
	<input type="submit" value="Guardar" />
</form>