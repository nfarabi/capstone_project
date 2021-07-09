@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Category List</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-prirary cardutline direct-chat direct-chat-primary">
                        <div class="card-header">
                            <h3 class="card-title">List of Product Categories</h3>

                            <div class="card-tools">
                                <a href="{{ route('admin.product-categories.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus"></i>
                                    Create
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 1%">#</th>
                                        <th>Name</th>
                                        <th style="width: 10%">Active</th>
                                        <th>Parent</th>
                                        <th style="width: 15%">Updated</th>
                                        <th style="width: 25%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($productCategories as $category)
                                        <tr>
                                            <td>#</td>
                                            <td>{{ $category->name }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('admin.product-categories.activate', $category) }}" method="POST" class="toggle-model">
                                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                        <input type="checkbox" name="activated_at" id="activated_at_{{ $category->id }}" class="custom-control-input" {{ ! $category->activated_at ?: 'checked' }}>
                                                        <label class="custom-control-label" for="activated_at_{{ $category->id }}"></label>
                                                    </div>

                                                    @method('PUT')
                                                    @csrf
                                                </form>
                                            </td>
                                            <td>{{ !empty($category->parent) ? $category->parent->name : '-' }}</td>
                                            <td>{{ $category->updated_at->diffForHumans() }}</td>
                                            <td class="actions text-right">
                                                <a class="btn btn-sm btn-info" href="{{ route('admin.product-categories.edit', $category) }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.product-categories.destroy', $category) }}" method="POST" class="inline">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                        Delete
                                                    </button>

                                                    @method('DELETE')
                                                    @csrf
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No record found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
