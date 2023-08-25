<h1>Order Success</h1>
<table border="1" style="border-collapse: collapse;">
    @foreach($order->orderItems as $item)
        <tr>
            <td>{{$item->product_name}}</td>
            <td>{{$item->price}}</td>
            <td>{{$item->amount}}</td>
            <td>{{$item->price * $item->amount}}</td>
        </tr>
    @endforeach
    <tr>
        <td>total</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
