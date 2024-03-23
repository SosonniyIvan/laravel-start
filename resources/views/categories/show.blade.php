@extends('layouts.app')

@section('content')
    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-6 g-6 mb-5">
                @foreach($categories as $category)
                    <div class="col d-flex align-items-center">
                        @include('categories.parts.button', ['category' => $category, 'classes' => 'w-100'])
                        @foreach($childs as $child)
                            <div class="col d-flex align-items-center">
                                @include('categories.parts.button', ['child' => $child, 'classes' => 'w-100'])
                            </div>
                        @endforeach
                    </div>
                    <div class="col d-flex align-items-center">
                        @include('categories.parts.button', ['product' => $product, 'classes' => 'w-100 red'])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
