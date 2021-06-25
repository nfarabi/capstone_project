@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Page Copy</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active">Page Copy</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.pages.copy-process') }}" method="POST" role="form">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Page Copy Form</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group @errorClass('page_id')">
                                <label for="page_id">Pages</label>
                                <select id="page_id" name="page_id" class="form-control select2" data-placeholder="Select a page to Copy" style="width: 100%;">
                                    <option value=""></option>
                                    @foreach($pages as $page)
                                        <option value="{{ $page->id }}" {{ old('page_id') == $page->id ? 'selected' : '' }}>{{ $page->title }}</option>
                                    @endforeach
                                </select>
                                @errorMessage('page_id')
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
                    <input type="submit" value="Copy Page" class="btn btn-success float-right">
                </div>
            </div>
        </form>
    </section>
    <br />
    <!-- /.content -->
@endsection
