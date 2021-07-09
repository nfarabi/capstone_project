@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Add</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product Create Form</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group @errorClass('name')">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="Enter name">
                                @errorMessage('name')
                            </div>
                            <div class="form-group @errorClass('sku')">
                                <label for="sku">SKU</label>
                                <input type="text" id="sku" name="sku" value="{{ old('sku') }}" class="form-control" placeholder="Enter sku">
                                @errorMessage('sku')
                            </div>
                            <div class="form-group @errorClass('price')">
                                <label for="price">Price</label>
                                <input type="number" id="price" name="price" value="{{ old('price') }}" class="form-control" placeholder="Enter price in cents">
                                @errorMessage('price')
                            </div>
                            <div class="form-group">
                                <label for="short_description">Description</label>
                                <textarea name="short_description" id="short_description" class="form-control" rows="2" placeholder="Enter short description ...">{{ old('short_description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="long_description">Description</label>
                                <textarea name="long_description" id="long_description" class="form-control" rows="5" placeholder="Enter long description ...">{{ old('long_description') }}</textarea>
                            </div>
                            <div class="form-group @errorClass('category_id')">
                                <label for="category_id">Product Category</label>
                                <select id="category_id" name="category_id" class="form-control select2" data-placeholder="Select Product Category" style="width: 100%;">
                                    <option></option>
                                    @foreach($productCategories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @errorMessage('category_id')
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
                                <div class="col-sm-3">
                                    <div class="form-group @errorClass('inventory')">
                                        <label for="inventory">Inventory</label>
                                        <input type="number" id="inventory" name="inventory" value="{{ old('inventory') }}" class="form-control" placeholder="Amount (e.g. 50)">
                                        @errorMessage('inventory')
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group @errorClass('discount')">
                                        <label for="discount">Discount</label>
                                        <input type="number" id="discount" name="discount" value="{{ old('discount') }}" class="form-control" placeholder="Enter %">
                                        @errorMessage('discount')
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
                    <input type="submit" value="Create new Product" class="btn btn-success float-right">
                </div>
            </div>
        </form>
    </section>
    <br />
    <!-- /.content -->
@endsection
