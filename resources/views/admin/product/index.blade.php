@extends('admin.layout.layout')

@section('content')
    {{ request()->fullUrl() }}
    <div class="col-md-12">
        @if(session()->has('success'))
            <p class="alert alert-success">{{ session()->get('success') }}</p>
        @endif
            <form method="get" action="{{ route('products.index') }}">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Categories</h4>
            </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <input class="form-control" type="text" name="s">
                        </div>
                        <div class="col-3">
                            <select class="form-select" name="category_id">
                                <option value="">Choose Category</option>
                                @foreach($categories as $category)
                                    <optgroup label="{{$category->name}}">
                                        @foreach($category->children as $child)
                                            <option value="{{ $child->id }}">{{ $child->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <select class="form-select" name="status">
                                <option value="is_hot">Hot</option>
                                <option value="is_feature">Feature</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <select class="form-select" name="sort">
                                <option value="name_asc">a->z</option>
                                <option value="mame_desc">z->a</option>
                                <option value="price_asc">lowest price</option>
                                <option value="price_desc">hightest price</option>
                            </select>
                        </div>
                    </div>
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
            @if($products->lastPage() > 1 )
            <div class="card-footer">
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link">Previous</a>
                        </li>
                        @for($i = 1; $i <= $products->lastPage(); $i++)
                        <li class="page-item"><a class="page-link" href="{{ request()->fullUrl() . '&page=' . $i }}">{{ $i }}</a></li>
                        @endfor
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
                @endif
            </form>
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
