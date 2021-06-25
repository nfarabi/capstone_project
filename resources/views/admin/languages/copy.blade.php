@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Language Copy</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Languages</a></li>
                        <li class="breadcrumb-item active">Language Copy</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.languages.copy-process') }}" method="POST" role="form">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Language Copy Form</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group @errorClass('language_id')">
                                <label for="language_id">Languages</label>
                                <select id="language_id" name="language_id" class="form-control select2" data-placeholder="Select a language to Copy" style="width: 100%;">
                                    <option value=""></option>
                                    @foreach($_languages as $language)
                                        <option value="{{ $language->id }}" {{ old('language_id') == $language->id ? 'selected' : '' }}>{{ $language->label }}</option>
                                    @endforeach
                                </select>
                                @errorMessage('language_id')
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
                    <input type="submit" value="Copy Language" class="btn btn-success float-right">
                </div>
            </div>
        </form>
    </section>
    <br />
    <!-- /.content -->
@endsection
