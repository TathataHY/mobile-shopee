<?php
shuffle($product_shuffle);

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['top_sale_submit'])) {
    $userId = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    $itemId = filter_input(INPUT_POST, 'item_id', FILTER_SANITIZE_STRING);

    if ($userId && $itemId) {
        $cart->addToCart($userId, $itemId);
    } else {
        echo 'Invalid input';
    }
}
?>

<section id="top-sale">
    <div class="container py-5">
        <h4 class="font-rubik font-size-20">Top Sale</h4>
        <hr />
        <div class="owl-carousel owl-theme">
            <?php foreach ($product_shuffle as $item) { ?>
                <div class="item py-2">
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

                                <button type="submit" name="top_sale_submit" class="btn <?= $buttonClass ?> font-size-12" <?= $disabledAttr ?>>
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