$(document).ready(function () {
  $("#banner-area .owl-carousel").owlCarousel({
    items: 1,
    loop: true,
    dots: true,
    autoplay: true,
  });

  $("#top-sale .owl-carousel").owlCarousel({
    loop: true,
    nav: true,
    dots: false,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 3,
      },
      1000: {
        items: 5,
      },
    },
  });

  $("#new-phones .owl-carousel").owlCarousel({
    loop: true,
    nav: false,
    dots: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 3,
      },
      1000: {
        items: 5,
      },
    },
  });

  $("#blogs .owl-carousel").owlCarousel({
    loop: true,
    nav: false,
    dots: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 3,
      },
    },
  });

  var $grid = $(".grid").isotope({
    itemSelector: ".grid-item",
    layoutMode: "fitRows",
  });

  $(".button-group").on("click", "button", function () {
    var filterValue = $(this).attr("data-filter");
    $grid.isotope({ filter: filterValue });
  });

  let $qty_up = $(".qty .qty-up");
  let $qty_down = $(".qty .qty-down");
  let $deal_price = $("#deal-price");

  $qty_up.click(function (e) {
    let $input = $(`.qty_input[data-id='${$(this).data("id")}']`);
    let $price = $(`.product_price[data-id='${$(this).data("id")}']`);

    $.ajax({
      url: "template/ajax.php",
      type: "post",
      data: { itemid: $(this).data("id") },
      success: function (result) {
        let item_price = parseFloat(result[0]["item_price"]); // Asegúrate de convertir a número
        if ($input.val() >= 1 && $input.val() < 10) {
          $input.val(function (i, oldval) {
            return ++oldval;
          });

          $price.text((item_price * $input.val()).toFixed(2));

          let current_deal_price = parseFloat($deal_price.text()) || 0; // Convierte el texto a número
          $deal_price.text((current_deal_price + item_price).toFixed(2));
        }
      },

      error: function (result) {
        console.log(result.responseText);
      },
    });
  });

  $qty_down.click(function (e) {
    let $input = $(`.qty_input[data-id='${$(this).data("id")}']`);
    let $price = $(`.product_price[data-id='${$(this).data("id")}']`);

    $.ajax({
      url: "template/ajax.php",
      type: "post",
      data: { itemid: $(this).data("id") },
      success: function (result) {
        let item_price = parseFloat(result[0]["item_price"]); // Asegúrate de convertir a número
        if ($input.val() > 1 && $input.val() <= 10) {
          $input.val(function (i, oldval) {
            return --oldval;
          });

          $price.text((item_price * $input.val()).toFixed(2));

          let current_deal_price = parseFloat($deal_price.text()) || 0; // Convierte el texto a número
          $deal_price.text((current_deal_price - item_price).toFixed(2));
        }
      },
    });
  });
});
