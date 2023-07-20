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
                            <td>-</td>
                            <td>
                                @if($category->is_active)
                                    <i class="ri-eye-line"></i>
                                @else
                                    <i class="ri-eye-off-line"></i>
                                @endif
                            </td>
                            <td>{{ $category->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>
                                <a class="btn btn-outline-primary"><i class="ri-edit-box-line"></i></a>
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
