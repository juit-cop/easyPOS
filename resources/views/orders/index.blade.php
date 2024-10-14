<div>
    <!-- When there is no desire, all things are at peace. - Laozi -->
    @extends('layouts.app')

@section('content')
    <h1>注文一覧</h1>
    <div id="orders-chart"></div>
    <ul>
        @foreach ($orders as $order)
            <li>
                注文ID: {{ $order->id }} - 合計: {{ $order->total_price }}円
                <ul>
                    @foreach ($order->orderItems as $item)
                        <li>{{ $item->product->name }} - {{ $item->quantity }}個</li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const orders = @json($orders);
        const labels = orders.map(order => `注文 ${order.id}`);
        const data = orders.map(order => order.total_price);

        new Chart(document.getElementById('orders-chart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: '注文金額',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
</div>
