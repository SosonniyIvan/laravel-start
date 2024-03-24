@extends('layouts.app')

@section('content')
    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div class="row mb-5">
                <div class="col text-center">
                    <h3>{{$category->name}}</h3>
                </div>
            </div>
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-6 g-6 mb-5">
                @foreach($category->children as $child)
                    <div class="col d-flex align-items-center">
                        @include('categories.parts.button', ['category' => $child, 'classes' => 'w-100'])
                    </div>
                @endforeach
            </div>
            <hr>
            <div class="row row-cols-1 row-cols-sm-3 row-cols-md-4 g-4 mt-5">
                @each('products.parts.card', $products, 'product')
            </div>
            <div class="row row-cols-1 g-4 mt-4">
                <div class="col">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
