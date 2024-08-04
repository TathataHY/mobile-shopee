<?php
// Obtener marcas de productos y asegurar unicidad
$brand = array_map(fn ($pro) => $pro['item_brand'], $product_shuffle);
$uniqueBrands = array_unique($brand);
sort($uniqueBrands);
shuffle($product_shuffle); // Opcional: Mezclar productos si es necesario

// Procesar el formulario si se envió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['special_price_submit'])) {
    $userId = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    $itemId = filter_input(INPUT_POST, 'item_id', FILTER_SANITIZE_STRING);

    if ($userId && $itemId) {
        $cart->addToCart($userId, $itemId);
    } else {
        // Manejo de error: entrada no válidaca
        // Considera agregar un mensaje de error o manejo de errores
    }
}

// Obtener los IDs de los productos en el carrito
$in_cart = $cart->getCartId($product->getData('cart'));
?>


<section id="special-price">
    <div class="container">
        <h4 class="font-rubik font-size-20">Special Price</h4>
        <div id="filters" class="button-group text-right font-baloo font-size-16">
            <button class="btn is-checked" data-filter="*">All Brand</button>
            <?php foreach ($uniqueBrands as $brand) : ?>
                <button class="btn" data-filter=".<?= htmlspecialchars($brand, ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars($brand, ENT_QUOTES, 'UTF-8') ?>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="grid">
            <?php array_map(function ($item) use ($in_cart) { ?>
                <div class="grid-item border <?= htmlspecialchars($item['item_brand'], ENT_QUOTES, 'UTF-8') ?>">
                    <div class="item py-2" style="width: 200px">
                        <div class="product font-raleway">
                            <a href="<?php echo htmlspecialchars(sprintf('product.php?item_id=%s', $item['item_id'])); ?>">
                                <img src="<?= htmlspecialchars($item['item_image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($item['item_name'], ENT_QUOTES, 'UTF-8') ?>" class="img-fluid" />
                            </a>
                            <div class="text-center">
                                <h6><?= htmlspecialchars($item['item_name'], ENT_QUOTES, 'UTF-8') ?></h6>
                                <div class="rating text-warning font-size-12">
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="far fa-star"></i></span>
                                </div>
                                <div class="price py-2">
                                    <span>$<?= htmlspecialchars(number_format($item['item_price'], 2, '.', ','), ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                                <form method="post">
                                    <input type="hidden" name="item_id" value="<?= htmlspecialchars($item['item_id'], ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="user_id" value="<?= htmlspecialchars(1, ENT_QUOTES, 'UTF-8') ?>">

                                    <?php
                                    $isInCart = in_array($item['item_id'], $in_cart ?? []);
                                    $buttonClass = $isInCart ? 'btn-success' : 'btn-warning';
                                    $buttonText = $isInCart ? 'In the Cart' : 'Add to Cart <i class="fas fa-shopping-cart"></i>';
                                    $disabledAttr = $isInCart ? 'disabled' : '';
                                    ?>

                                    <button type="submit" name="special_price_submit" class="btn <?= $buttonClass ?> font-size-12" <?= $disabledAttr ?>>
                                        <?= $buttonText ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }, $product_shuffle) ?>
        </div>
    </div>
</section>