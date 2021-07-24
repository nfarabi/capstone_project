@extends('layouts.shop')

@section('title', 'Shopping Cart')

@section('content')

    <div class="cart-section container">
        <div>
            @if (session()->has('success_message'))
                <div class="alert alert-success">
                    {{ session()->get('success_message') }}
                </div>
            @endif

            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Cart::count() > 0)

                <h2>{{ Cart::count() }} item(s) in Shopping Cart</h2>

                <div class="cart-table">
                    @foreach (Cart::content() as $item)
                        @php
                            //dd($item->model);
                        @endphp
                        <div class="cart-table-row">
                            <div class="cart-table-row-left">
                                <a href="{{ route('product.show', $item->model->id) }}"></a>
                                <div class="cart-item-details">
                                    <div class="cart-table-item"><a href="{{ route('product.show', $item->model->id) }}">{{ $item->model->name }}</a></div>
                                    <div class="cart-table-description">{{ $item->model->details }}</div>
                                </div>
                            </div>
                            <div class="cart-table-row-right">
                                <div class="cart-table-actions">
                                    <form action="{{ route('cart.destroy', $item->rowId) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                    </form>

                                    {{--<form action="{{ route('cart.switchToSaveForLater', $item->rowId) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="cart-options">Save for Later</button>
                                    </form>--}}
                                </div>
                                <div>
                                    <select class="quantity" data-id="{{ $item->rowId }}" data-productQuantity="{{ $item->model->quantity }}">
                                        @for ($i = 1; $i < 5 + 1 ; $i++)
                                            <option {{ $item->qty == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div>{{ present_price($item->subtotal) }}</div>
                            </div>
                        </div> <!-- end cart-table-row -->
                    @endforeach

                </div> <!-- end cart-table -->

                @if (! session()->has('coupon'))

                    <a href="#" class="have-code">Have a Code?</a>

                    <div class="have-code-container">
{{--                        <form action="{{ route('coupon.store') }}" method="POST">--}}
{{--                            @csrf--}}
{{--                            <input type="text" name="coupon_code" id="coupon_code">--}}
{{--                            <button type="submit" class="button button-plain">Apply</button>--}}
{{--                        </form>--}}
                    </div> <!-- end have-code-container -->
                @endif

                <div class="cart-totals">
{{--                    <div class="cart-totals-left">--}}
{{--                        Shipping is free because we’re awesome like that. Also because that’s additional stuff I don’t feel like figuring out :).--}}
{{--                    </div>--}}

                    <div class="cart-totals-right">
                        <div>
                            Subtotal <br>
                            @if (session()->has('coupon'))
                                Code ({{ session()->get('coupon')['name'] }})
                                <form action="{{ route('coupon.destroy') }}" method="POST" style="display:block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="font-size:14px;">Remove</button>
                                </form>
                                <hr>
                                New Subtotal <br>
                            @endif
                            Tax (20%)<br>
                            <span class="cart-totals-total">Total</span>
                        </div>
                        <div class="cart-totals-subtotal">
                            {{ present_price(Cart::subtotal(0,0,'')) }} <br>
                            @if (session()->has('coupon'))
                                -{{ present_price($discount) }} <br>&nbsp;<br>
                                <hr>
                                {{ present_price($newSubtotal) }} <br>
                            @endif
                            {{ present_price( Cart::tax(0,0,'') ) }} <br>
                            <span class="cart-totals-total">{{ present_price( Cart::total(0,0,'')) }}</span>
                        </div>
                    </div>
                </div> <!-- end cart-totals -->

                <div class="cart-buttons">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary">Continue Shopping</a>
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary">Proceed to Checkout</a>
                </div>

            @else

                <h3>No items in Cart!</h3>
                <div class="spacer"></div>
                <a href="{{ route('home') }}" class="button">Continue Shopping</a>
                <div class="spacer"></div>

            @endif

            @if (Cart::instance('saveForLater')->count() > 0)

                <h2>{{ Cart::instance('saveForLater')->count() }} item(s) Saved For Later</h2>

                <div class="saved-for-later cart-table">
                    @foreach (Cart::instance('saveForLater')->content() as $item)
                        <div class="cart-table-row">
                            <div class="cart-table-row-left">
                                <a href="{{ route('product.show', $item->model->slug) }}"><img src="{{ asset('img/products/'.$item->model->slug.'.jpg') }}" alt="item" class="cart-table-img"></a>
                                <div class="cart-item-details">
                                    <div class="cart-table-item"><a href="{{ route('product.show', $item->model->slug) }}">{{ $item->model->name }}</a></div>
                                    <div class="cart-table-description">{{ $item->model->details }}</div>
                                </div>
                            </div>
                            <div class="cart-table-row-right">
                                <div class="cart-table-actions">
                                    <form action="{{ route('saveForLater.destroy', $item->rowId) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cart-options">Remove</button>
                                    </form>

                                    <form action="{{ route('saveForLater.switchToCart', $item->rowId) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="cart-options">Move to Cart</button>
                                    </form>
                                </div>

                                <div>{{ $item->model->presentPrice() }}</div>
                            </div>
                        </div> <!-- end cart-table-row -->
                    @endforeach

                </div> <!-- end saved-for-later -->

            @else

                <h3>You have no items Saved for Later.</h3>

            @endif

        </div>

    </div> <!-- end cart-section -->



@endsection

@section('extra-js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        (function(){
            const classname = document.querySelectorAll('.quantity')

            Array.from(classname).forEach(function(element) {
                element.addEventListener('change', function() {
                    const id = element.getAttribute('data-id')
                    const productQuantity = element.getAttribute('data-productQuantity')

                    axios.patch(`/cart/${id}`, {
                        quantity: this.value,
                        productQuantity: productQuantity
                    })
                        .then(function (response) {
                            // console.log(response);
                            window.location.href = '{{ route('cart.index') }}'
                        })
                        .catch(function (error) {
                            // console.log(error);
                            window.location.href = '{{ route('cart.index') }}'
                        });
                })
            })
        })();
    </script>
@endsection
