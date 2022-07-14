@extends('layouts.app')

@section('title', 'GuacaTube')

@section('background', 'bg-light')

@section('content')
    <style>
        #prev {
            position: absolute;
            left: -15px;
        }

        #next {
            position: absolute;
            right: -15px;
        }
    </style>

    <div class="">
        <div class="row">
            <div class="col-12">
                <div id="carouselExampleControls" class="carousel carousel-dark slide mt-2 mb-3" data-bs-ride="false" data-bs-target="false">
                    <div class="carousel-inner">
                        <div class="carousel-item active px-3">
                            <div class="row justify-content-center">
                                <div class="col-auto m-0 p-0 mx-lg-2">
                                    @if(isset($categorySelected))
                                        <a  href="{{ route('home') }}" class="btn rounded-pill" style="border: solid 1px black; font-size: 0.8em">
                                            Tous
                                        </a>
                                    @else
                                        <button disabled name="category" class="btn rounded-pill" style="background: #111010;border: solid 1px black; font-size: 0.8em; color: white">
                                            Tous
                                        </button>
                                    @endif
                                </div>
                                @foreach($categories->take(4)->get() as $category)
                                    <div class="col-auto m-0 p-0 mx-lg-2">
                                        @if(isset($categorySelected) && $categorySelected->id == $category->id)
                                            <button disabled name="category" class="btn rounded-pill" style="background: #111010;border: solid 1px black; font-size: 0.8em; color: white">
                                                {{ $category->category_name }}
                                            </button>
                                        @else
                                            <form method="get">
                                                <button type="submit" name="category" value="{{ $category->id }}" class="btn rounded-pill" style="border: solid 1px black; font-size: 0.8em">
                                                    {{ $category->category_name }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @for($i = 0; $i < ($categories->count() - 4) / 5; $i++)
                            <div class="carousel-item px-3">
                                <div class="row justify-content-center">
                                    @foreach($categories->skip(4 + $i * 5)->take(5)->get() as $category)
                                        <div class="col-auto m-0 p-0 mx-1 mx-lg-2">
                                            @if(isset($categorySelected) && $categorySelected->id == $category->id)
                                                <button disabled name="category" class="btn rounded-pill" style="background: #111010;border: solid 1px black; font-size: 0.8em; color: white">
                                                    {{ $category->category_name }}
                                                </button>
                                            @else
                                                <form method="get">
                                                    <button type="submit" name="category" value="{{ $category->id }}" class="btn rounded-pill" style="border: solid 1px black; font-size: 0.8em">
                                                        {{ $category->category_name }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endfor
                    </div>
                    <button class="carousel-control-prev p-0 m-0" id="prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <i class="bi bi-chevron-left text-black" style="font-size: 1em"></i>
                    </button>
                    <button class="carousel-control-next p-0 m-0" id="next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <i class="bi bi-chevron-right text-black" style="font-size: 1em"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-start">
        @foreach($mostViewedThisWeek as $video)
            @component('component.cardVideo', ['video' => $video])
            @endcomponent
        @endforeach
    </div>
    </div>
@endsection
