<h1>Más información del Usuario <?php echo $id ?></h1>
<a href="<?=base_url?>usuario/gestion" class="button button-small button">Volver</a>


<table>

  <tr>
		<th>USUARIO</th>
	</tr>

  <?php while ($us = $usuarios->fetch_object()): ?>
  <tr>
		<td style="padding-top: 5px"><?=$us->nombre." ".$us->apellidos;?></td>
  </tr>
  <?php endwhile; ?>

  <tr>
		<th style="padding-top: 10px">PEDIDOS PENDIENTES</th>
	</tr>

  <?php while ($us2 = $usuarios2->fetch_object()): ?>
  <tr>
		<td style="padding-top: 5px"><?=$us2->pendientesentrega;?></td>
  </tr>
  <?php endwhile; ?>

  <tr>
		<th style="padding-top: 10px">TOTAL GASTADO</th>
	</tr>

  <?php while ($us3 = $usuarios3->fetch_object()): ?>
  <tr>
		<td style="padding-top: 5px"><?=$us3->totalgastado;?></td>
  </tr>
  <?php endwhile; ?>

</table>