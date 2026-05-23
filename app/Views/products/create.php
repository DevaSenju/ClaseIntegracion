<section class="card form-card">
    <div class="section-header">
        <div>
            <h2>Nuevo producto</h2>
            <p>Guarda el producto en la tabla de productos y crea su registro inicial de inventario.</p>
        </div>
        <a href="?route=/products">Volver</a>
    </div>

    <form method="post" action="?route=/products/store" class="form-grid">
        <label>
            <span>SKU</span>
            <input type="text" name="sku" required value="<?= e($values['sku'] ?? '') ?>">
        </label>

        <label>
            <span>Nombre</span>
            <input type="text" name="name" required value="<?= e($values['name'] ?? '') ?>">
        </label>

        <label>
            <span>Precio</span>
            <input type="number" step="0.01" min="0" name="price" required value="<?= e($values['price'] ?? '0.00') ?>">
        </label>

        <label>
            <span>Stock inicial</span>
            <input type="number" min="0" name="initial_stock" required value="<?= e($values['initial_stock'] ?? '0') ?>">
        </label>

        <label class="checkbox-field">
            <input type="checkbox" name="active" value="1" <?= !empty($values['active']) ? 'checked' : '' ?>>
            <span>Producto activo</span>
        </label>

        <div class="form-actions">
            <button type="submit">Guardar producto</button>
        </div>
    </form>
</section>
