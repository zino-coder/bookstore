@extends('admin.layout.layout')

@section('content')
    <div class="col-md-12">
        @if($errors->has('common'))
            <div class="alert alert-danger">
                {{ $errors->first('common') }}
            </div>
        @endif
        <form method="post" enctype="multipart/form-data" action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}">
            @csrf
            @if(isset($product))
                @method('put')
            @endif
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Product</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $product->name ?? '' }}" id="name" placeholder="">
                        @if($errors->has('name'))
                            <p class="text-danger">{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3">
                            {{ $product->description ?? '' }}
                        </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Parent Category</label>
                        <select class="form-select select2" id="parent_id" name="parent_id" aria-label="Default select example">
                            <option value="0">----------</option>
                            @foreach($parentCategories as $parentProduct)
                                <option value="{{ $parentProduct->id }}" {{ isset($product) && $product->parent_id == $parentProduct->id ? 'selected' : '' }}>{{ $parentProduct->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('parent_id'))
                            {{ $errors->first('parent_id') }}
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select select2" id="category" name="category_id" aria-label="Default select example">
                            <option value="0">----------</option>
                        </select>
                        @if($errors->has('parent_id'))
                            {{ $errors->first('parent_id') }}
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Tag</label>
                        <select class="select2" id="tags" name="tags[]" multiple>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail</label>
                        <input class="form-control" type="file" name="thumbnail" id="thumbnail">
                    </div>
                    <div class="mb-3">
                        <label for="catalog" class="form-label">Catalog</label>
                        <input class="form-control" name="catalog[]" type="file" id="catalog" multiple>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" name="is_active" type="checkbox" role="switch" id="is_active" {{ !isset($product) || $product->is_active ? 'checked' : ''}}>
                        <label class="form-check-label" for="is_active">Status</label>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('custom-script')
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });

            $('#category').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: '{{ route('categories.get-children') }}',
                    data: function (params) {
                        var query = {
                            parent_id: $('#parent_id').val(),
                            _token: '{{ csrf_token() }}'
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    dataType: 'json',
                    processResults: function (data, params) {
                        return {
                            results: data,
                        }
                    }
                },
            })
            $('#tags').select2({
                theme: 'bootstrap-5',
                tags: true,
                ajax: {
                    url: '{{ route('tags.index') }}',
                    data: function (params) {
                        var query = {
                            q: params.term,
                            page: params.page || 1 ,
                            _token: '{{ csrf_token() }}'
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    dataType: 'json',
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.data,
                            pagination: {
                                more: params.page < data.lastPage,
                            }
                        }
                    }
                },
            })
        })
        tinymce.init({
            selector: 'textarea',  // change this value according to your HTML
            plugins: 'image wordcount',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncentre alignright alignjustify | indent outdent | bullist numlist',
            image_list: [
                { title: 'My image 1', value: 'https://www.example.com/my1.gif' },
                { title: 'My image 2', value: 'http://www.moxiecode.com/my2.gif' }
            ],
            images_upload_url: '{{route('upload-image')}}'
        });
    </script>
@endpush
