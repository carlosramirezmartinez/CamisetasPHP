<?php if (isset($product)): ?>
	<h1><?= $product->nombre ?></h1>
	<div id="detail-product">
		<div class="image">
			<?php if ($product->imagen != null): ?>
				<img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" />
			<?php else: ?>
				<img src="<?= base_url ?>assets/img/camiseta.png" />
			<?php endif; ?>
		</div>
		<div class="data">
			<p class="description"><?= $product->descripcion ?></p>
			<p class="price"><?= $product->precio ?>$</p>
			 
			 <?php if($product->stock>0):?>
				<a href="<?=base_url?>carrito/add&id=<?=$product->id?>" class="button">Comprar</a>
				<?php else :?>
				<!--<h2 style="color:red">No disponible</h2>-->
				<a class="button button-red">Agotado</a>
				<?php endif ?>
			<h1>
				<?php if ($product->oferta == "si"): ?>
            	<h1 style="color:red";><b>Oferta!!!</b></h1>
        		<?php endif; ?>
			</h1>
		</div>
	</div>
<?php else: ?>
	<h1>El producto no existe</h1>
<?php endif; ?>
