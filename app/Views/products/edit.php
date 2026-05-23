<section class="card form-card">
    <div class="section-header">
        <div>
            <h2>Editar producto</h2>
            <p>Actualiza la tabla de productos. El stock se modifica desde movimientos.</p>
        </div>
        <a href="?route=/products">Volver</a>
    </div>

    <div class="info-strip">
        <strong>Stock actual:</strong> <?= e($stock) ?> unidades
    </div>

    <form method="post" action="?route=/products/update" class="form-grid">
        <input type="hidden" name="id" value="<?= e($product['id'] ?? '') ?>">

        <label>
            <span>SKU</span>
            <input type="text" name="sku" required value="<?= e($product['sku'] ?? '') ?>">
        </label>

        <label>
            <span>Nombre</span>
            <input type="text" name="name" required value="<?= e($product['name'] ?? '') ?>">
        </label>

        <label>
            <span>Precio</span>
            <input type="number" step="0.01" min="0" name="price" required value="<?= e($product['price'] ?? '0.00') ?>">
        </label>

        <label>
            <span>Estado</span>
            <select name="active">
                <option value="1" <?= selected($product['active'] ?? true, true) ?>>Activo</option>
                <option value="0" <?= selected($product['active'] ?? false, false) ?>>Inactivo</option>
            </select>
        </label>

        <div class="form-actions">
            <button type="submit">Guardar cambios</button>
        </div>
    </form>
</section>
