@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Role Add</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Roles</a></li>
                        <li class="breadcrumb-item active">Role Add</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <form role="form" method="post" action="{{ route('admin.roles.store') }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Role Create Form</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group @errorClass('name')">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="Enter name">
                                @errorMessage('name')
                            </div>
                            <div class="form-group @errorClass('permissions')">
                                <label for="roles">Permissions</label>
                                <select multiple="multiple" id="permissions" name="permissions[]" class="form-control select2" data-placeholder="Select Permission" style="width: 100%;">
                                    @foreach($permissions as $permission)
                                        <option value="{{ $permission->name }}" {{ in_array($permission->name, old('permissions', [])) ? 'selected' : '' }}>{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                                @errorMessage('permissions')
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
                    <input type="submit" value="Create new Role" class="btn btn-success float-right">
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection
