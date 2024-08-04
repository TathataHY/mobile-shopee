<?php
// Sanitizar y validar el item_id de la consulta GET
$item_id = filter_input(INPUT_GET, 'item_id', FILTER_SANITIZE_NUMBER_INT) ?? 1;
$productFound = false;

// Obtener datos del producto y buscar el item_id
foreach ($product->getData() as $item) {
    if ((int)$item['item_id'] === (int)$item_id) {
        $productFound = true;
        $itemName = htmlspecialchars($item['item_name'], ENT_QUOTES, 'UTF-8');
        $itemBrand = htmlspecialchars($item['item_brand'], ENT_QUOTES, 'UTF-8');
        $itemImage = htmlspecialchars($item['item_image'], ENT_QUOTES, 'UTF-8');
        $itemPrice = number_format($item['item_price'], 2, '.', ',');
        break; // Salir del bucle una vez que se encuentra el item
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['product_sale_submit'])) {
    $userId = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    $itemId = filter_input(INPUT_POST, 'item_id', FILTER_SANITIZE_STRING);

    if ($userId && $itemId) {
        $cart->addToCart($userId, $itemId);
    } else {
        echo 'Invalid input';
    }
}

if (!$productFound) {
    echo '<div class="d-flex justify-content-center align-items-center" style="height: 300px;">
            <div class="text-center">
                <h2 class="font-weight-bold">Product not found</h2>
                <p class="text-muted">We couldn\'t find the product you were looking for.</p>
                <a href="/" class="btn color-secondary-bg mt-3 text-white">Go Back to Home</a>
            </div>
          </div>';
    return; // Terminar el script si no se encuentra el producto
}
?>

<section id="product" class="py-3">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <img src="<?= $itemImage ?>" alt="<?= $itemName ?>" class="img-fluid" />
                <div class="form-row pt-4 font-size-16 font-baloo">
                    <div class="col">
                        <button type="submit" id="cart-btn" class="btn btn-danger form-control">
                            Proceed to Buy
                        </button>
                    </div>
                    <div class="col">
                        <form method="post">
                            <input type="hidden" name="item_id" value="<?= htmlspecialchars($item['item_id'], ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="user_id" value="<?= htmlspecialchars(1, ENT_QUOTES, 'UTF-8') ?>">

                            <?php
                            $isInCart = in_array($item['item_id'], $cart->getCartId($product->getData('cart')) ?? []);
                            $buttonClass = $isInCart ? 'btn-success' : 'btn-warning';
                            $buttonText = $isInCart ? 'In the Cart' : 'Add to Cart <i class="fas fa-shopping-cart"></i>';
                            $disabledAttr = $isInCart ? 'disabled' : '';
                            ?>

                            <button type="submit" name="product_sale_submit" class="btn <?= $buttonClass ?> font-size-16 form-control" <?= $disabledAttr ?>>
                                <?= $buttonText ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 py-5">
                <h5 class="font-baloo font-size-20"><?= $itemName ?></h5>
                <small>by <?= $itemBrand ?></small>
                <div class="d-flex">
                    <div class="rating text-warning font-size-12">
                        <!-- Aquí podrías mostrar las estrellas de la calificación -->
                        <span><i class="fas fa-star"></i></span>
                        <span><i class="fas fa-star"></i></span>
                        <span><i class="fas fa-star"></i></span>
                        <span><i class="fas fa-star"></i></span>
                        <span><i class="far fa-star"></i></span>
                    </div>
                    <a href="#" class="px-2 font-raleway font-size-14">
                        20,534 ratings | 1000+ answered questions
                    </a>
                </div>
                <hr class="m-0" />
                <table class="my-3">
                    <tr class="font-raleway font-size-14">
                        <td>M.R.P:</td>
                        <td><strike>$162.00</strike></td>
                    </tr>
                    <tr class="font-raleway font-size-14">
                        <td>Deal Price:</td>
                        <td class="font-size-20 text-danger">
                            $<span><?= $itemPrice ?></span>
                            <small class="text-dark font-size-12">
                                &nbsp;&nbsp;Inclusive of all taxes
                            </small>
                        </td>
                    </tr>
                    <tr class="font-raleway font-size-14">
                        <td>You Save:</td>
                        <td><span class="font-size-16 text-danger">$12.00</span></td>
                    </tr>
                </table>
                <div id="policy">
                    <div class="d-flex">
                        <div class="return text-center mr-5">
                            <div class="font-size-20 my-2 color-secondary">
                                <span class="fas fa-retweet border p-3 rounded-pill"></span>
                            </div>
                            <a href="#" class="font-raleway font-size-12">
                                10 Days <br />Replacement
                            </a>
                        </div>
                        <div class="return text-center mr-5">
                            <div class="font-size-20 my-2 color-secondary">
                                <span class="fas fa-truck border p-3 rounded-pill"></span>
                            </div>
                            <a href="#" class="font-raleway font-size-12">
                                Daily Tuition <br />Deliverd
                            </a>
                        </div>
                        <div class="return text-center mr-5">
                            <div class="font-size-20 my-2 color-secondary">
                                <span class="fas fa-check-double border p-3 rounded-pill"></span>
                            </div>
                            <a href="#" class="font-raleway font-size-12">
                                1 Year <br />Warranty
                            </a>
                        </div>
                    </div>
                </div>
                <hr />
                <div id="order-details" class="font-raleway d-flex flex-column text-dark">
                    <small>Delivery by : Mar 29 - Apr 1</small>
                    <small>
                        Sold by <a href="#">Daily Electronics</a> (4.5 out of 5
                        stars)
                    </small>
                    <small>
                        <i class="fas fa-map-marker-alt color-primary"></i>
                        &nbsp;&nbsp;Deliver to Customer - 424201
                    </small>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="color my-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="font-baloo">Color:</h6>
                                <div class="p-2 color-yellow-bg rounded-circle">
                                    <button class="btn font-size-14">
                                        <span class="sr-only">Yellow</span>
                                    </button>
                                </div>
                                <div class="p-2 color-primary-bg rounded-circle">
                                    <button class="btn font-size-14">
                                        <span class="sr-only">Primary</span>
                                    </button>
                                </div>

                                <div class="p-2 color-secondary-bg rounded-circle">
                                    <button class="btn font-size-14">
                                        <span class="sr-only">Secondary</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="qty d-flex">
                            <h6 class="font-baloo">Qty:</h6>
                            <div class="px-4 d-flex font-raleway">
                                <button class="qty-up border bg-light" data-id="pro1">
                                    <span class="sr-only">Increment</span>
                                    <i class="fas fa-angle-up"></i>
                                </button>
                                <input type="text" data-id="pro1" class="qty_input border px-2 w-50 bg-light" disabled value="1" placeholder="1" />
                                <button data-id="pro1" class="qty-down border bg-light">
                                    <span class="sr-only">Decrement</span>
                                    <i class="fas fa-angle-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="size my-3">
                    <h6 class="font-baloo">Size:</h6>
                    <div class="d-flex justify-content-between w-75">
                        <div class="p-2 border font-rubik">
                            <button class="btn p-0 font-size-14">4GB RAM</button>
                        </div>
                        <div class="p-2 border font-rubik">
                            <button class="btn p-0 font-size-14">6GB RAM</button>
                        </div>
                        <div class="p-2 border font-rubik">
                            <button class="btn p-0 font-size-14">8GB RAM</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <h6 class="font-rubik">Product Description</h6>
                <hr />
                <p class="font-rale font-size-14">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repellat inventore vero numquam error est ipsa, consequuntur temporibus debitis nobis sit, delectus officia ducimus dolorum sed corrupti. Sapiente optio sunt provident, accusantium eligendi eius reiciendis animi? Laboriosam, optio qui? Numquam, quo fuga. Maiores minus, accusantium velit numquam a aliquam vitae vel?</p>
                <p class="font-rale font-size-14">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repellat inventore vero numquam error est ipsa, consequuntur temporibus debitis nobis sit, delectus officia ducimus dolorum sed corrupti. Sapiente optio sunt provident, accusantium eligendi eius reiciendis animi? Laboriosam, optio qui? Numquam, quo fuga. Maiores minus, accusantium velit numquam a aliquam vitae vel?</p>
            </div>
        </div>
    </div>
</section>