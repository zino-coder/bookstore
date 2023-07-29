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
                        <th scope="col">Alias</th>
                        <th scope="col">Parent</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created At</th>
                        <td>Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <th scope="row">{{ $category->name }}</th>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->parentCategory?->name }}</td>
                            <td>
                                <a href="{{ route('categories.update', ['id' => $category->id]) }}" data-visbility="{{ $category->is_active }}" class="change-status">
                                @if($category->is_active)
                                    <i class="ri-eye-line"></i>
                                @else
                                    <i class="ri-eye-off-line"></i>
                                @endif
                                </a>
                            </td>
                            <td>{{ $category->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>
                                <a href="{{ route('categories.edit', ['id' => $category->id]) }}" class="btn btn-outline-primary"><i class="ri-edit-box-line"></i></a>
                                <a class="btn btn-outline-danger"><i class="ri-delete-bin-line"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $categories->links() }}
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
