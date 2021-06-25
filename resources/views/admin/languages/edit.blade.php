@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Language Edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Languages</a></li>
                        <li class="breadcrumb-item active">Language Edit</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.languages.update', $language) }}" method="POST" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Language Edit Form</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group @errorClass('label')">
                                <label for="label">Label</label>
                                <input type="text" id="label" name="label" value="{{ old('label', $language->label) }}" class="form-control" placeholder="Enter label">
                                @errorMessage('label')
                            </div>
                            <div class="form-group @errorClass('code')">
                                <label for="code">Code</label>
                                <input type="text" id="code" name="code" value="{{ old('code', $language->code) }}" class="form-control" placeholder="Enter code">
                                @errorMessage('code')
                            </div>
                            <div class="form-group @errorClass('locale')">
                                <label for="locale">Code</label>
                                <input type="text" id="locale" name="locale" value="{{ old('locale', $language->locale) }}" class="form-control" placeholder="Enter locale">
                                @errorMessage('locale')
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control editor" data-mode="xml" rows="20" placeholder="Enter address ...">{{ old('address', $language->address) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="copyright">Copyright</label>
                                <textarea name="copyright" id="copyright" class="form-control editor" data-mode="xml" rows="20" placeholder="Enter copyright ...">{{ old('copyright', $language->copyright) }}</textarea>
                            </div>
                            <div class="form-group @errorClass('facebook_url')">
                                <label for="facebook_url">Facebook URL</label>
                                <input type="text" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $language->facebook_url) }}" class="form-control" placeholder="Enter Facebook URL">
                                @errorMessage('facebook_url')
                            </div>
                            <div class="form-group @errorClass('instagram_url')">
                                <label for="instagram_url">Instagram URL</label>
                                <input type="text" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $language->instagram_url) }}" class="form-control" placeholder="Enter Ingtagram URL">
                                @errorMessage('instagram_url')
                            </div>
                            <div class="form-group @errorClass('linkedin_url')">
                                <label for="linkedin_url">LinkedIn URL</label>
                                <input type="text" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $language->linkedin_url) }}" class="form-control" placeholder="Enter LinkedIn URL">
                                @errorMessage('linkedin_url')
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <!-- checkbox -->
                                    <div class="form-group @errorClass('activated_at')">
                                        <label for="activated_at">Activate</label>
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" name="activated_at" value="1" class="custom-control-input" id="activated_at" {{ ! old('activated_at', $language->activated_at) ?: 'checked' }}>
                                            <label class="custom-control-label" for="activated_at"></label>
                                        </div>
                                        @errorMessage('activated_at')
                                    </div>
                                </div>
                            </div>

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
