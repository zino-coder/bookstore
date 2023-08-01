@extends('admin.layout.layout')

@section('content')
    <div class="col-md-12">
        @if(session()->has('success'))
            <p class="alert alert-success">{{ session()->get('success') }}</p>
        @endif
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Categories</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">SKU</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Price</th>
                        <th scope="col">Category</th>
                        <th class="text-center" scope="col">Status</th>
                        <th scope="col">Special</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <th scope="row">{{ $product->name }}</th>
                            <td>{{ $product->sku }}</td>
                            <td>{{ number_format($product->stock) }}</td>
                            <td>{{ number_format($product->price) }}</td>
                            <td>{{ $product->category?->name }}</td>
                            <td class="text-center">
                                <a href="{{ route('products.update', ['id' => $product->id]) }}" data-visbility="{{ $product->is_active }}" class="change-status">
                                    @if($product->is_active)
                                        <i class="ri-eye-line"></i>
                                    @else
                                        <i class="ri-eye-off-line"></i>
                                    @endif
                                </a>
                            </td>
                            <td>
                                {!! $product->is_feature ? '<span class="badge bg-info">Feature</span>' : '' !!}
                                {!! $product->is_hot ? '<span class="badge bg-danger">Hot!!</span>' : '' !!}
                            </td>
                            <td>
                                <a href="{{ route('products.edit', ['id' => $product->id]) }}" class="btn btn-outline-primary"><i class="ri-edit-box-line"></i></a>
                                <a class="btn btn-outline-danger"><i class="ri-delete-bin-line"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection

@push('custom-script')
    <script>
        $(document).ready(function () {
            $('.change-status').on('click', function (e) {
                e.preventDefault();
                const statusIcon = [
                    '<i class="ri-eye-off-line"></i>',
                    '<i class="ri-eye-line"></i>'
                ]
                let url = $(this).attr('href')
                let is_active = $(this).attr('data-visbility');
                let _this = $(this)
                $.ajax({
                    type: 'PUT',
                    url: url,
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_active: is_active == 1 ? '0' : 1,
                    },
                    dataType: 'json',

                    success: function (data) {
                        console.log(_this)
                        _this.attr('data-visbility', data.is_active);
                        _this.empty();
                        _this.html(statusIcon[data.is_active]);
                    },
                    error: function (data) {
                        console.log(data, 1)
                    }
                })
            })
        })
    </script>
@endpush
