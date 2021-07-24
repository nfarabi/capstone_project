<header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
        <div class="col-4 pt-1">
{{--            <a class="text-muted" href="#">Subscribe</a>--}}
        </div>
        <div class="col-4 text-center">
            <a class="blog-header-logo text-dark" href="{{ route('home') }}">FastShop</a>
        </div>
        <div class="col-4 d-flex justify-content-end align-items-center">
            <a class="text-muted" href="#" aria-label="Search">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512" width="20" height="20"><title>Search</title><path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"/></svg>
            </a>
            &nbsp;&nbsp;
            <a class="text-muted" href="#" aria-label="Cart">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512" width="20" height="20"><title>Cart</title><circle cx="176" cy="416" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="400" cy="416" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M48 80h64l48 272h256"/><path d="M160 288h249.44a8 8 0 007.85-6.43l28.8-144a8 8 0 00-7.85-9.57H128" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
            </a>
            &nbsp;&nbsp;
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('register') }}">Sign up</a>
            &nbsp;&nbsp;
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('login') }}">Log in</a>
        </div>
    </div>
</header>

<div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-between">
    @foreach($_categories as $category)
        <a class="p-2 text-muted" href="#">{{ $category->name }}</a>
        @endforeach
    </nav>
</div>
