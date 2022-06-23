@extends('layouts.app')

@section('title', 'GuacaTube')

@section('background', 'bg-light')

@section('content')
<div class="p-2 px-3">
    <div class="row mb-4 ms-1">
        <div class="col-auto m-0 p-0">
            @if(isset($categorySelected))
                <a  href="{{ route('home') }}" class="btn rounded-pill" style="border: solid 1px black; font-size: 0.9em">
                    Tous
                </a>
            @else
                <button disabled name="category" class="btn rounded-pill" style="background: #111010;border: solid 1px black; font-size: 0.9em; color: white">
                    Tous
                </button>
            @endif
        </div>
        @foreach($categories as $category)
            <div class="col-auto m-0 p-0 mx-1">
                @if(isset($categorySelected) && $categorySelected->id == $category->id)
                    <button disabled name="category" class="btn rounded-pill" style="background: #111010;border: solid 1px black; font-size: 0.9em; color: white">
                        {{ $category->category_name }}
                    </button>
                @else
                    <form method="get">
                        <button type="submit" name="category" value="{{ $category->id }}" class="btn rounded-pill" style="border: solid 1px black; font-size: 0.9em">
                            {{ $category->category_name }}
                        </button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
    <div class="row justify-content-start">
        @foreach($mostViewedThisWeek as $video)
                @component('component.cardVideo', ['video' => $video])
                @endcomponent
            @endforeach
    </div>
</div>
@endsection
