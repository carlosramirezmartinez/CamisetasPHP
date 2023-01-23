<h1>Algunos de nuestros productos en oferta</h1>

<?php while($product = $productos->fetch_object()): ?>
	<div class="product">
		<a href="<?=base_url?>producto/ver&id=<?=$product->id?>">
			<?php if($product->imagen != null): ?>
				<img src="<?=base_url?>uploads/images/<?=$product->imagen?>" />
			<?php else: ?>
				<img src="<?=base_url?>assets/img/camiseta.png" />
			<?php endif; ?>
			<h2>
				<?=$product->nombre?>
				<?php if ($product->oferta == "si"): ?>
            	<p style="color:red";>Oferta!!!</p>
        		<?php endif; ?>
			</h2>
		</a>
		<p><del><?=$product->precio * 1.2?></del> &nbsp; <?=$product->precio?></p>
        <!--Manejador stock 02/02-->
				<?php if($product->stock>0):?>
				<a href="<?=base_url?>carrito/add&id=<?=$product->id?>" class="button">Comprar</a>
				<?php else :?>
				<!--<h2 style="color:red">No disponible</h2>-->
				<a class="button button-red">Agotado</a>
				<?php endif ?>		
	</div>
<?php endwhile; ?>