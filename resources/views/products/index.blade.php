
    <h1>Categories and Products</h1>

    @foreach ($categories as $category)
        <h2>{{ $category->name }}</h2>

        @foreach ($category->products as $product)
            <div class="product">
                <h3>{{ $product->name }}</h3>
                <p>Price: ${{ $product->price }}</p>
                <div class="add-to-cart-container" data-product-id="{{ $product->id }}">
                    <button class="add-to-cart">Add to Cart</button>
                </div>
            </div>
        @endforeach
    @endforeach

    <div id="cart-container">
        <h2>Add to Cart</h2>
        @php
            $total = 0;
            $user = auth()->check() ? auth()->user()->id : 0;
            $cart = session()->get('cart.'.$user, []);
        @endphp
        @foreach ($cart as $productId => $item)
                @php
                    $total += $item['quantity'] * $item['price'];
                @endphp
            <div class="cart-item" data-product-id="{{ $productId }}">
                <span>{{ $item['name'] }}</span>
                <span>Quantity: <span class="quantity">{{ $item['quantity'] }}</span></span>
                <span>Total: $<span class="total">{{ $item['quantity'] * $item['price'] }}</span></span>
                <button class="plus">+</button>
                <button class="minus">-</button>
            </div>
            @endforeach
            <span>Total: $<span class="total">{{ $total }}</span></span>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.add-to-cart').on('click', function () {
                var productId = $(this).closest('.add-to-cart-container').data('product-id');
                $.ajax({
                    url: "{{ route('products.addToCartAjax') }}",
                    type: 'POST',
                    cache:false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                    },
                    success: function (response) {
                        alert(response.message);
                        updateCart();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });

            $(document).on('click', '.plus', function () {
                var productId = $(this).closest('.cart-item').data('product-id');
                $.ajax({
                    url: "{{ route('products.updateToCartAjax') }}",
                    type: 'POST',
                    cache:false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        type: 'plus',
                    },
                    success: function (response) {
                        updateCart();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });

            $(document).on('click', '.minus', function () {
                var productId = $(this).closest('.cart-item').data('product-id');
                    $.ajax({
                    url: "{{ route('products.updateToCartAjax') }}",
                    type: 'POST',
                    cache:false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        type: 'minus',
                    },
                    success: function (response) {
                        updateCart();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
                });

            function updateCart() {
                $('#cart-container').load(location.href + " #cart-container");
            }
        });
    </script>
