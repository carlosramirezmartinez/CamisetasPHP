<?php if (isset($categoria)): ?>
	<h1><?= $categoria->nombre ?></h1>
	<?php if ($productos->num_rows == 0): ?>
		<p>No hay productos para mostrar</p>
	<?php else: ?>

		<?php while ($product = $productos->fetch_object()): ?>
			<div class="product">
				<a href="<?= base_url ?>producto/ver&id=<?= $product->id ?>">
					<?php if ($product->imagen != null): ?>
						<img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" />
					<?php else: ?>
						<img src="<?= base_url ?>assets/img/camiseta.png" />
					<?php endif; ?>
					<h2><?= $product->nombre ?>
					<!-- Manejador oferta --->
					<?php if ($product->oferta == "si"): ?>
						<p style="color:red";>Oferta!!!</p>
					<?php else: ?>
						<p>&nbsp;</p>
        			<?php endif; ?>
					</h2>
				</a>
				<!--5. Aplicar oferta 19/2-->
				<?php if ($product->oferta == "no"): ?>
				<p><?= $product->precio ?></p>
				<?php else: ?>
				<p style="color:red";><del><?=$product->precio * 1.2?></del> &nbsp; <?=$product->precio?></p>
				<?php endif; ?>

				<!--Manejador stock 02/02-->
				<?php if($product->stock>0):?>
				<a href="<?=base_url?>carrito/add&id=<?=$product->id?>" class="button">Comprar</a>
				<?php else :?>
				<!--<h2 style="color:red">No disponible</h2>-->
				<a class="button button-red">Agotado</a>
				<?php endif ?>			
			</div>
		<?php endwhile; ?>

	<?php endif; ?>
<?php else: ?>
	<h1>La categoría no existe</h1>
<?php endif; ?>
