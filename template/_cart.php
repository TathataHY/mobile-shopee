<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['delete-cart-submit']) || isset($_POST['wishlist-submit']))) {
    $item_id = isset($_POST['item_id']) ? intval($_POST['item_id']) : null;

    if ($item_id) {
        // Eliminar del carrito
        if (isset($_POST['delete-cart-submit'])) {
            $deletedrecord = $cart->deleteCart($item_id);
        }

        // Guardar para después
        if (isset($_POST['wishlist-submit'])) {
            $cart->saveForLater($item_id);
        }
    }
}

// Recuperar los items del carrito
$cartItems = $product->getData('cart');
$subTotal = [];

foreach ($cartItems as $item) {
    $Cart = $product->getProduct($item['item_id']);

    foreach ($Cart as $itemDetails) {
        $subTotal[] = $itemDetails['item_price'];
    }
}

// Calcular subtotal y cantidad de items
$totalItems = count($subTotal);
$totalPrice = number_format(array_sum($subTotal), 2, '.', ',');

?>

<section id="cart" class="py-3 mt-3 mb-5">
    <div class="container-fluid w-75">
        <h5 class="font-baloo font-size-20">Shopping Cart</h5>
        <div class="row">
            <div class="col-sm-9">
                <?php foreach ($cartItems as $item) : ?>
                    <?php
                    $Cart = $product->getProduct($item['item_id']);

                    foreach ($Cart as $itemDetails) :
                        $item_id = htmlspecialchars($itemDetails['item_id'], ENT_QUOTES, 'UTF-8');
                        $item_name = htmlspecialchars($itemDetails['item_name'], ENT_QUOTES, 'UTF-8');
                        $item_brand = htmlspecialchars($itemDetails['item_brand'], ENT_QUOTES, 'UTF-8');
                        $item_image = htmlspecialchars($itemDetails['item_image'], ENT_QUOTES, 'UTF-8');
                        $item_price = htmlspecialchars(number_format($itemDetails['item_price'], 2, '.', ','), ENT_QUOTES, 'UTF-8');
                    ?>
                        <!-- cart item -->
                        <div class="row border-top py-3 mt-3">
                            <div class="col-sm-2">
                                <img src="<?= $item_image ?>" alt="<?= $item_name ?>" class="img-fluid" />
                            </div>
                            <div class="col-sm-8">
                                <h5 class="font-baloo font-size-20"><?= $item_name ?></h5>
                                <small>by <?= $item_brand ?></small>
                                <div class="d-flex">
                                    <div class="rating text-warning font-size-12">
                                        <span><i class="fas fa-star"></i></span>
                                        <span><i class="fas fa-star"></i></span>
                                        <span><i class="fas fa-star"></i></span>
                                        <span><i class="fas fa-star"></i></span>
                                        <span><i class="far fa-star"></i></span>
                                    </div>
                                    <a href="#" class="px-2 font-raleway font-size-14">
                                        20,534 ratings
                                    </a>
                                </div>
                                <div class="qty d-flex pt-2">
                                    <div class="d-flex font-raleway w-25">
                                        <button class="qty-up border bg-light" data-id="<?= $item_id ?>">
                                            <span class="sr-only">Increment</span>
                                            <i class="fas fa-angle-up"></i>
                                        </button>
                                        <input type="text" data-id="<?= $item_id ?>" class="qty_input border px-2 w-100 bg-light" disabled value="1" placeholder="1" />
                                        <button class="qty-down border bg-light" data-id="<?= $item_id ?>">
                                            <span class="sr-only">Decrement</span>
                                            <i class="fas fa-angle-down"></i>
                                        </button>
                                    </div>
                                    <form method="post">
                                        <input type="hidden" name="item_id" value="<?= $item_id ?>">
                                        <button type="submit" class="btn font-baloo text-danger px-3 border-right" name="delete-cart-submit">
                                            Delete
                                        </button>
                                    </form>
                                    <form method="post">
                                        <input type="hidden" name="item_id" value="<?= $item_id ?>">
                                        <button type="submit" class="btn font-baloo text-danger" name="wishlist-submit">
                                            Save for Later
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-2 text-right">
                                <div class="font-size-20 text-danger font-baloo">
                                    $<span class="product_price" data-id="<?= $item_id ?>"><?= $item_price ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
            <div class="col-sm-3">
                <div class="sub-total border text-center mt-2">
                    <h6 class="font-size-12 font-raleway text-success py-3">
                        <i class="fas fa-check"></i> Your order is eligible for free
                        shipping!
                    </h6>
                    <div class="border-top py-4">
                        <h5 class="font-baloo font-size-20">
                            Subtotal (<?= $totalItems ?> items):
                            <span class="text-danger">$</span><span class="text-danger" id="deal-price"><?= $totalPrice ?></span>
                        </h5>
                        <button type="submit" class="btn btn-warning mt-3">
                            Proceed to Buy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>