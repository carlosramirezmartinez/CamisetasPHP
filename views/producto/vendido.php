<h1>Producto más vendido</h1>
<a href="<?=base_url?>producto/gestion" class="button button-small button">Volver</a>
<table>
    <tr>
        <th>PRODUCTO</th>
        <th>VENTAS</th>
    </tr>
    <?php while ($product = $productosVendido->fetch_object()) : ?>
    <tr>
        <td><?= $product->producto; ?></td>
        <td><?= $product->ventas; ?></td>
    </tr>
    <?php endwhile; ?>
    
</table>