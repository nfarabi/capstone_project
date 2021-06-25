@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Roles List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Roles</a></li>
                        <li class="breadcrumb-item active">Roles List</li>
                    </ol>
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
                            <h3 class="card-title">List of Roles</h3>

                            <div class="card-tools">
                                <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-primary">
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
                                        <th>Permissions</th>
                                        <th style="width: 25%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($roles as $role)
                                        <tr>
                                            <td>#</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @foreach ($role->permissions as $permission)
                                                    <span class="badge badge-teal">{{ $permission->name }}</span>
                                                @endforeach
                                            </td>
                                            <td class="actions text-right">
                                                {{--<a class="btn btn-primary btn-sm" href="{{ route('admin.roles.show', $role) }}">
                                                    <i class="fas fa-folder">
                                                    </i>
                                                    View
                                                </a>--}}
                                                <a class="btn btn-sm btn-info" href="{{ route('admin.roles.edit', $role) }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <form method="post" action="{{ route('admin.roles.destroy', $role) }}" class="inline">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                        Delete
                                                    </button>

                                                    @method('delete')
                                                    @csrf
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No record found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        @include('partials.pagination', ['records' => $roles])
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
