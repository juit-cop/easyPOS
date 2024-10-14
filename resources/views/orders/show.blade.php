<div>
    <!-- You must be the change you wish to see in the world. - Mahatma Gandhi -->
    @extends('layouts.app')

@section('content')
    <h1>注文詳細</h1>
    <p>注文ID: {{ $order->id }}</p>
    <p>合計金額: {{ $order->total_price }}円</p>
    <h2>注文商品</h2>
    <ul>
        @foreach ($order->orderItems as $item)
            <li>{{ $item->product->name }} - {{ $item->quantity }}個</li>
        @endforeach
    </ul>
@endsection

</div>
