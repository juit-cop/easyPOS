<div>
    <!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk -->
    @extends('layouts.app')

@section('content')
    <h1>注文作成</h1>
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        @foreach ($products as $product)
            <div>
                <label>
                    {{ $product->name }} ({{ $product->price }}円)
                    <input type="number" name="products[{{ $product->id }}]" value="0" min="0" class="product-quantity">
                </label>
            </div>
        @endforeach
        <div>
            <strong>合計: <span id="total-price">0</span>円</strong>
            <input type="hidden" name="total_price" id="total-price-input" value="0">
        </div>
        <button type="submit">注文する</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantities = document.querySelectorAll('.product-quantity');
            const totalPriceSpan = document.getElementById('total-price');
            const totalPriceInput = document.getElementById('total-price-input');
            const products = @json($products);

            function updateTotal() {
                let total = 0;
                quantities.forEach(function(input) {
                    const productId = input.name.match(/\d+/)[0];
                    const product = products.find(p => p.id == productId);
                    total += input.value * product.price;
                });
                totalPriceSpan.textContent = total;
                totalPriceInput.value = total;
            }

            quantities.forEach(function(input) {
                input.addEventListener('change', updateTotal);
            });
        });
    </script>
@endsection
</div>
