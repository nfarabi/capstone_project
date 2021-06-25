@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Page Translations Edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ $page->title }}</a></li>
                        <li class="breadcrumb-item active">Page Translations Edit</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.pages.translations.update', $page) }}" method="POST" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Page Edit Form</h3>
                        </div>

                        <div class="card-body">
                            @foreach($language_lines as $language_line)
                                <div class="form-group">
                                    <label for="title">{{ $language_line->key }}</label>
                                    <textarea name="language_line[{{ $language_line->key }}]" class="form-control editor" data-mode="xml" rows="20" placeholder="Enter HTML ...">{!! $language_line->getTranslation() !!}</textarea>
                                </div>
                            @endforeach

                            @method('PUT')
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
    <br />
    <!-- /.content -->
@endsection

@include('partials.admin.editor')
