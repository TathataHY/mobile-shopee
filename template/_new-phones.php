<?php
// Mezclar productos
shuffle($product_shuffle);

// Procesar solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_phones_submit'])) {
    // Sanitizar y validar entradas
    $userId = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    $itemId = filter_input(INPUT_POST, 'item_id', FILTER_SANITIZE_STRING);

    // Verificar que las entradas sean válidas
    if ($userId && $itemId) {
        $cart->addToCart($userId, $itemId);
    } else {
        // Manejo de errores: entradas no válidas
        // Puedes agregar un mensaje de error o manejar el problema de otra manera
    }
}
?>


<section id="new-phones">
    <div class="container">
        <h4 class="font-rubik font-size-20">New Phones</h4>
        <hr />
        <div class="owl-carousel owl-theme">
            <?php foreach ($product_shuffle as $item) { ?>
                <div class="item py-2 bg-light">
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
                                $isInCart = in_array($item['item_id'], $cart->getCartId($product->getData('cart')) ?? []);
                                $buttonClass = $isInCart ? 'btn-success' : 'btn-warning';
                                $buttonText = $isInCart ? 'In the Cart' : 'Add to Cart <i class="fas fa-shopping-cart"></i>';
                                $disabledAttr = $isInCart ? 'disabled' : '';
                                ?>

                                <button type="submit" name="new_phones_submit" class="btn <?= $buttonClass ?> font-size-12" <?= $disabledAttr ?>>
                                    <?= $buttonText ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>