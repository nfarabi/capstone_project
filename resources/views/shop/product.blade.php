@extends('layouts.shop')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-12">
            <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                    <strong class="d-inline-block mb-2 text-primary">{{ optional($product->category)->name }}</strong>
                    <h3 class="mb-0">{{ $product->name }}</h3>
                    <div class="mb-1 text-muted">{{ $product->merchant->name }}</div>
                    <p class="card-text mb-auto">{{ $product->short_description }}</p>
                    <p class="card-text mb-auto">{!! nl2br($product->long_description) !!}</p>
                    <br />
                    <div style="display: inline;">
                        <a href="#" class="btn btn-sm btn-outline-secondary">Show detail</a>
                        <form action="{{ route('cart.store', $product->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary">Add to cart</button>
                        </form>
                    </div>
                </div>
                <div class="col-auto d-none d-lg-block">
                    <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                </div>
            </div>
        </div>
    </div>
@endsection
