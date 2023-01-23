<h1>Productos sin existencias</h1>
<a href="<?=base_url?>producto/gestion" class="button button-small button">Volver</a>
<table>
    <tr>
        <th>ID</th>
        <th>NOMBRE</th>
    </tr>
    <?php while ($product = $productosStock->fetch_object()) : ?>
    <tr>
        <td><?= $product->id; ?></td>
        <td><?= $product->nombre; ?></td>
    </tr>
    <?php endwhile; ?>
</table>