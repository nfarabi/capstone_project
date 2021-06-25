@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User Edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Users</a></li>
                        <li class="breadcrumb-item active">User Edit</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <form role="form" method="post" action="{{ route('admin.users.update', $user) }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">User Edit Form</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group @errorClass('name')">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" placeholder="Enter name">
                                @errorMessage('name')
                            </div>
                            <div class="form-group @errorClass('email')">
                                <label for="email">Email address</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" placeholder="Enter email">
                                @errorMessage('email')
                            </div>
                            <div class="form-group @errorClass('password')">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                                @errorMessage('password')
                            </div>
                            <div class="form-group @errorClass('password_confirmation')">
                                <label for="password-confirm">Password Confirm</label>
                                <input type="password" id="password-confirm" name="password_confirmation" class="form-control" placeholder="Password Confirm">
                                @errorMessage('password_confirmation')
                            </div>
                            <div class="form-group @errorClass('roles')">
                                <label for="roles">Role</label>
                                <select id="roles" name="roles[]" class="form-control select2" data-placeholder="Select Role" style="width: 100%;">
                                    <option></option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ in_array($role->name, old('roles', $user->roles->pluck('name')->toArray())) ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @errorMessage('roles')
                            </div>

                            @method('put')
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
                    <input type="submit" value="Save Changes" class="btn btn-success float-right">
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection
