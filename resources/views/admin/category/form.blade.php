@extends('admin.layout.layout')

@section('content')
    <div class="col-md-12">
        @if($errors->has('common'))
            <div class="alert alert-danger">
                {{ $errors->first('common') }}
            </div>
        @endif
        <form method="post" action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}">
            @csrf
            @if(isset($category))
                @method('put')
            @endif
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Category</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $category->name ?? '' }}" id="name" placeholder="">
                        @if($errors->has('name'))
                            <p class="text-danger">{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3">
                            {{ $category->description ?? '' }}
                        </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Parent Category</label>
                        <select class="form-select" id="parent_id" name="parent_id" aria-label="Default select example">
                            <option value="0">----------</option>
                            @foreach($parentCategories as $parentCategory)
                                <option value="{{ $parentCategory->id }}" {{ isset($category) && $category->parent_id == $parentCategory->id ? 'selected' : '' }}>{{ $parentCategory->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('parent_id'))
                            {{ $errors->first('parent_id') }}
                        @endif
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" name="is_active" type="checkbox" role="switch" id="is_active" {{ !isset($category) || $category->is_active ? 'checked' : ''}}>
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
            $('#parent_id').select2({
                theme: 'bootstrap-5'
            });
        })
    </script>
@endpush
