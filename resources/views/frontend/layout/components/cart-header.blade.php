<div class="dropdown cart-dropdown type2 off-canvas mr-0 mr-lg-2">
    <a href="#" class="cart-toggle label-block link">
        <div class="cart-label d-lg-show">
            <span class="cart-name">Shopping Cart:</span>
            <span class="cart-price">${{ number_format(cart()->getTotal()) }}</span>
        </div>
        <i class="d-icon-bag"><span class="cart-count">{{ count(cart()->getContent()) }}</span></i>
    </a>
    <div class="canvas-overlay"></div>
    <!-- End Cart Toggle -->
    <div class="dropdown-box">
        <div class="canvas-header">
            <h4 class="canvas-title">Shopping Cart</h4>
            <a href="#" class="btn btn-dark btn-link btn-icon-right btn-close">close<i
                    class="d-icon-arrow-right"></i><span class="sr-only">Cart</span></a>
        </div>
        <div class="products scrollable">
            @foreach(cart()->getContent() as $id => $item)
            <div class="product product-cart">
                <figure class="product-media">
                    <a href="product.html">
                        <img src="images/cart/product-1.jpg" alt="product" width="80"
                             height="88" />
                    </a>
                    <button class="btn btn-link btn-close">
                        <i class="fas fa-times"></i><span class="sr-only">Close</span>
                    </button>
                </figure>
                <div class="product-detail">
                    <a href="product.html" class="product-name">{{ $item['name'] }}</a>
                    <div class="price-box">
                        <span class="product-quantity">{{ number_format($item['amount']) }}</span>
                        <span class="product-price">${{ number_format($item['price']) }}</span>
                    </div>
                </div>

            </div>
            @endforeach
            <!-- End of Cart Product -->
        </div>
        <!-- End of Products  -->
        <div class="cart-total">
            <label>Subtotal:</label>
            <span class="price">$139.00</span>
        </div>
        <!-- End of Cart Total -->
        <div class="cart-action">
            <a href="{{ route('cart.index') }}" class="btn btn-dark btn-link">View Cart</a>
            <a href="{{ route('checkout.index') }}" class="btn btn-dark"><span>Go To Checkout</span></a>
        </div>
        <!-- End of Cart Action -->
    </div>
    <!-- End Dropdown Box -->
</div>
