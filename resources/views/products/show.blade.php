<!-- resources/views/products/show.blade.php -->


    <h1>{{ $product->name }}</h1>
    <p>Price: ${{ $product->price }}</p>
    <p>Description: {{ $product->description }}</p>

    <div id="cart">
        <button class="minus">-</button>
        <input type="text" id="quantity" value="1" readonly>
        <button class="plus">+</button>
        <p>Total Price: $<span id="totalPrice">{{ $product->price }}</span></p>
        <button id="addToCart">Add to Cart</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            var quantityInput = $('#quantity');
            var totalPriceElement = $('#totalPrice');

            $('.plus').on('click', function () {
                quantityInput.val(parseInt(quantityInput.val()) + 1);
                updateTotalPrice();
            });

            $('.minus').on('click', function () {
                var currentQuantity = parseInt(quantityInput.val());
                if (currentQuantity > 1) {
                    quantityInput.val(currentQuantity - 1);
                    updateTotalPrice();
                }
            });

            $('#addToCart').on('click', function () {
                var productId = "{{ $product->id }}";
                var quantity = parseInt(quantityInput.val());

                $.ajax({
                    url: "{{ route('products.addToCartAjax') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function (response) {
                        alert(response.message);
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });

            function updateTotalPrice() {
                var price = "{{ $product->price }}";
                var quantity = parseInt(quantityInput.val());
                var totalPrice = price * quantity;
                totalPriceElement.text(totalPrice.toFixed(2));
            }
        });
    </script>
