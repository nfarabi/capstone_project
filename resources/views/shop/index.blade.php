@extends('layouts.shop')

@section('title', 'Shop')

@section('content')
    <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
        <div class="col-md-6 px-0">
            <h1 class="display-4 font-italic">Title of a longer featured product</h1>
            <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and efficiently about what’s most interesting in this post’s contents.</p>
            <p class="lead mb-0"><a href="#" class="text-white font-weight-bold">Explore...</a></p>
        </div>
    </div>

    <div class="row mb-2">
        @forelse($products as $product)
            <div class="col-md-6">
                <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-primary">{{ optional($product->category)->name }}</strong>
                        <h3 class="mb-0">{{ $product->name }}</h3>
                        <div class="mb-1 text-muted">{{ $product->merchant->name }}</div>
                        <p class="card-text mb-auto">{{ $product->short_description }}</p>
                        <div style="display: inline;">
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-sm btn-outline-secondary">Show detail</a>
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
        @empty
            <div class="text-center">No record found</div>
        @endforelse
    </div>
@endsection
