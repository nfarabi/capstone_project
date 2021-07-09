@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Category Add</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.product-categories.store') }}" method="POST" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product Category Create Form</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group @errorClass('name')">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="Enter name">
                                @errorMessage('name')
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="5" placeholder="Enter description ...">{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group @errorClass('parent_id')">
                                <label for="parent_id">Parent Category</label>
                                <select id="parent_id" name="parent_id" class="form-control select2" data-placeholder="Select Parent Category" style="width: 100%;">
                                    <option></option>
                                    @foreach($productCategories as $category)
                                        <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @errorMessage('parent_id')
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <!-- checkbox -->
                                    <div class="form-group @errorClass('activated_at')">
                                        <label for="activated_at">Activate</label>
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" name="activated_at" value="1" class="custom-control-input" id="activated_at">
                                            <label class="custom-control-label" for="activated_at"></label>
                                        </div>
                                        @errorMessage('activated_at')
                                    </div>
                                </div>
                            </div>

                            @csrf
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                    <input type="submit" value="Create new Language" class="btn btn-success float-right">
                </div>
            </div>
        </form>
    </section>
    <br />
    <!-- /.content -->
@endsection
