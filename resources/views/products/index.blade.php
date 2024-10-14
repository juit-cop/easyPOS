<div>
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
    @extends('layouts.app')

@section('content')
    <h1>商品一覧</h1>
    <ul>
        @foreach ($products as $product)
            <li>{{ $product->name }} - {{ $product->price }}円</li>
        @endforeach
    </ul>
@endsection
</div>
