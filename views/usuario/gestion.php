<!-- GESTIONAR USUARIO 16/1 -->
<h1>Administración de usuarios</h1>
<a href="<?=base_url?>usuario/registro" class="button button-small">
	Crear usuario
</a>


<table>
	<tr>
		<th>ID</th>
		<th>ROL</th>
		<th>USUARIO</th>
		<th>E-MAIL</th>
	</tr>
	<?php 
		while ($us = $usuarios->fetch_object()):
	?>
		<tr>
			<td><?=$us->id;?></td>
			<td><?=$us->rol;?></td>
			<td><?=$us->nombre." ".$us->apellidos;?></td>
    	    <td><?=$us->email;?></td>
			
			<td>
				<a href="<?=base_url?>usuario/masinfo&id=<?=$us->id?>" class="button button-gestion">+ Info</a>
				<a href="<?=base_url?>usuario/editar&id=<?=$us->id?>" class="button button-gestion">Editar</a>
				<a href="<?=base_url?>usuario/eliminar&id=<?=$us->id?>" class="button button-gestion button-red">Eliminar</a>
			</td>
		</tr>
	<?php endwhile; ?>

</table>