
<h1>Editar Usuario </h1>
<a href="<?=base_url?>usuario/gestion" class="button button-small button">Volver</a>

<!-- ver vista producto/crear -->
<form action="<?=base_url?>usuario/editarUsuario" method="POST">
	<label for="id">Id</label>
	<input type="number" name="id" value="<?=$id;?>" readonly>
	
	<label for="nombre">Nombre</label>
	<input type="text" name="nombre" required value="<?=$nombre?>"/>
	
	<label for="apellidos">Apellidos</label>
	<input type="text" name="apellidos" required value="<?=$apellidos?>"/>
	
	<label for="email">Email</label>
	<input type="email" name="email" required value="<?=$email?>"/>
	
	<label for="password">Contraseña</label>
	<input type="password" name="password" required/>
<!--
	<label for="password2">Nueva contraseña</label>
	<input type="password" name="password2"/>

	<label for="password3">Repite contraseña</label>
	<input type="password" name="password3"/>
-->
	<?php if(isset($_SESSION['admin']) && $_SESSION['admin']== true):?>
	<label for="rol">Rol</label>
	<p style="padding-top: 5px;"><input type="radio" name="rol" value="admin" checked> Administrador</p><br>
    <p><input type="radio" name="rol" value="user"> Usuario</p>
	<?php else: ?>
	<label for="rol">Rol</label>
	<p style="padding-top: 5px;"><input type="radio" name="rol" value="user" checked> Usuario</p>
	<?php endif; ?>

	<input type="submit" value="Modificar" />
</form>