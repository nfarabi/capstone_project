@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pages List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active">Pages List</li>
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
                            <h3 class="card-title">List of Pages</h3>

                            <div class="card-tools">
                                <a href="{{ route('admin.pages.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus"></i>
                                    Create
                                </a>
                                <a href="{{ route('admin.pages.copy') }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-copy"></i>
                                    Copy Page
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 1%">#</th>
                                        <th style="width: 20%">Title</th>
                                        <th style="width: 10%">Published</th>
                                        <th style="width: 15%">Updated</th>
                                        <th style="width: 25%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pages as $page)
                                        <tr>
                                            <td>#</td>
                                            <td>{{ $page->title }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('admin.pages.publish', $page) }}" method="POST" class="toggle-model">
                                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                        <input type="checkbox" name="is_published" id="is_published_{{ $page->id }}" class="custom-control-input" {{ ! $page->published_at ?: 'checked' }}>
                                                        <label class="custom-control-label" for="is_published_{{ $page->id }}"></label>
                                                    </div>

                                                    @method('PUT')
                                                    @csrf
                                                </form>
                                            </td>
                                            <td>{{ $page->updated_at->diffForHumans() }}</td>
                                            <td class="actions text-right">
                                                <a class="btn btn-primary btn-sm" href="{{ $page->getPermalink() }}" target="_blank">
                                                    <i class="fas fa-external-link-alt"></i>
                                                    View
                                                </a>
                                                <a class="btn btn-sm btn-warning" href="{{ route('admin.pages.translations.edit', $page) }}">
                                                    <i class="fas fa-paragraph"></i>
                                                    Translations
                                                </a>
                                                <a class="btn btn-sm btn-info" href="{{ route('admin.pages.edit', $page) }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="inline">
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
                                            <td colspan="5" class="text-center">No record found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        @include('partials.pagination', ['records' => $pages])
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
