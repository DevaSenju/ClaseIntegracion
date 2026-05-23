<section class="card form-card">
    <div class="section-header">
        <div>
            <h2>Nuevo movimiento</h2>
            <p>Registra ventas o reabastecimientos y actualiza la tabla de inventario.</p>
        </div>
        <a href="?route=/movements">Volver</a>
    </div>

    <form method="post" action="?route=/movements/store" class="form-grid">
        <label>
            <span>Producto</span>
            <select name="product_id" required>
                <option value="">Selecciona un producto</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?= e($product['id']) ?>" <?= selected($values['product_id'] ?? '', $product['id']) ?>>
                        <?= e($product['sku']) ?> - <?= e($product['name']) ?> (stock: <?= e($product['stock']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            <span>Tipo</span>
            <select name="type" required>
                <option value="restock" <?= selected($values['type'] ?? 'restock', 'restock') ?>>Reabastecimiento</option>
                <option value="sale" <?= selected($values['type'] ?? '', 'sale') ?>>Venta</option>
            </select>
        </label>

        <label>
            <span>Cantidad</span>
            <input type="number" min="1" name="quantity" required value="<?= e($values['quantity'] ?? '1') ?>">
        </label>

        <label class="full-width">
            <span>Nota</span>
            <textarea name="note" rows="3" placeholder="Ejemplo: venta mostrador, compra a proveedor..."><?= e($values['note'] ?? '') ?></textarea>
        </label>

        <div class="form-actions">
            <button type="submit">Guardar movimiento</button>
        </div>
    </form>
</section>
