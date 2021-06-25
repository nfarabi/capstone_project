@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Page Add</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active">Page Add</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.pages.store') }}" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Page Create Form</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group @errorClass('title')">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" placeholder="Enter title">
                                @errorMessage('title')
                            </div>
                            <div class="form-group @errorClass('slug')">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" name="slug" value="{{ old('slug') }}" class="form-control" placeholder="Leave blank to generate automatically">
                                @errorMessage('slug')
                            </div>
                            <div class="form-group @errorClass('excerpt')">
                                <label for="excerpt">Excerpt</label>
                                <input type="text" id="excerpt" name="excerpt" value="{{ old('excerpt') }}" class="form-control" placeholder="Enter excerpt">
                                @errorMessage('excerpt')
                            </div>
                            <div class="form-group @errorClass('image')">
                                <label for="image">Featured Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input" id="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                </div>
                                @errorMessage('image')
                            </div>
                            <div class="form-group">
                                <label>Page Content</label>
                                {{--<div class="card card-primary card-outline card-outline-tabs">--}}
                                    {{--<div class="card-header p-0 border-bottom-0">--}}
                                        <ul class="nav nav-tabs" id="page-content" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="page-content-html-tab" data-toggle="pill" href="#page-content-html" role="tab" aria-controls="page-content-html" aria-selected="true">HTML</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="page-content-css-tab" data-toggle="pill" href="#page-content-css" role="tab" aria-controls="page-content-css" aria-selected="false">CSS</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="page-content-js-tab" data-toggle="pill" href="#page-content-js" role="tab" aria-controls="page-content-js" aria-selected="false">JavaScript</a>
                                            </li>
                                        </ul>
                                    {{--</div>--}}
                                    <div class="card-body" style="padding-right: 0; padding-left: 0; padding-bottom: 0;">
                                        <div class="tab-content" id="page-contentContent">
                                            <div class="tab-pane fade show active" id="page-content-html" role="tabpanel" aria-labelledby="page-content-html-tab">
                                                <textarea name="code_html" class="form-control editor" data-mode="xml" rows="10" placeholder="Enter HTML ..."></textarea>
                                            </div>
                                            <div class="tab-pane fade" id="page-content-css" role="tabpanel" aria-labelledby="page-content-css-tab">
                                                <textarea name="code_css" class="form-control editor" data-mode="css" rows="10" placeholder="Enter CSS ..."></textarea>
                                            </div>
                                            <div class="tab-pane fade" id="page-content-js" role="tabpanel" aria-labelledby="page-content-js-tab">
                                                <textarea name="code_js" class="form-control editor" data-mode="javascript" rows="10" placeholder="Enter JavaScript ..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                {{--</div>--}}
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <!-- checkbox -->
                                    <div class="form-group @errorClass('is_featured')">
                                        <label for="is_featured">Featured</label>
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" name="is_featured" value="1" class="custom-control-input" id="is_featured">
                                            <label class="custom-control-label" for="is_featured"></label>
                                        </div>
                                        @errorMessage('is_featured')
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- checkbox -->
                                    <div class="form-group @errorClass('is_homepage')">
                                        <label for="is_homepage">Homepage</label>
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" name="is_homepage" value="1" class="custom-control-input" id="is_homepage">
                                            <label class="custom-control-label" for="is_homepage"></label>
                                        </div>
                                        @errorMessage('is_homepage')
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- checkbox -->
                                    <div class="form-group @errorClass('is_private')">
                                        <label for="is_private">Private</label>
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" name="is_private" value="1" class="custom-control-input" id="is_private">
                                            <label class="custom-control-label" for="is_private"></label>
                                        </div>
                                        @errorMessage('is_private')
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- checkbox -->
                                    <div class="form-group @errorClass('published_at')">
                                        <label for="published_at">Publish</label>
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" name="published_at" value="1" class="custom-control-input" id="published_at">
                                            <label class="custom-control-label" for="published_at"></label>
                                        </div>
                                        @errorMessage('published_at')
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Meta</label>
                                <div class="row">
                                    <div class="col-3">
                                        <input type="text" name="meta['key'][]" class="form-control" placeholder="Meta key">
                                    </div>
                                    <div class="col-8">
                                        <input type="text" name="meta['value'][]" class="form-control" placeholder="Meta content">
                                    </div>
                                    <div class="col-1">
                                        <button type="button" class="btn btn-danger float-right"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-3">
                                        <button type="button" class="btn btn-sm btn-default"><i class="fa fa-plus"></i> Add New Tag</button>
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
                    <input type="submit" value="Create new Page" class="btn btn-success float-right">
                </div>
            </div>
        </form>
    </section>
    <br />
    <!-- /.content -->
@endsection

@include('partials.admin.editor')
