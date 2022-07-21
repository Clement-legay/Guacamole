@extends('layouts.app')

@section('title', 'GuacaTube | Administration')

@section('background', 'p-4')

@section('content')

    <script>
        $('body').ready(function() {
            $.ajax({
                url: '{{ route('video.API_videos') }}',
                type: 'GET',
                headers: {
                    'Authorization': 'Basic UmFjZVB1dGluZTpibGFibGFibGE='
                },
                params: {
                    'page': 1,
                    'limit': 10
                },
                success: function(data) {
                    console.log(data);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
    </script>

<div class="row justify-content-center">
    <div class="col-12 col-xl-8">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="row justify-content-between">
                    <div class="col-auto">
                        <h3>API Key</h3>
                    </div>
                    <div class="col-auto">
                        @if(Auth::user()->apikey())
                            <button disabled  class="text-white btn btn-primary">Create API Key</button>
                        @else
                            <a href="{{ route('admin.token.generate') }}" class="text-white btn btn-primary">Create API Key</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-10">
                @if(Auth::user()->apikey())
                <div class="card mt-5">
                    <div class="card-body">
                        <div class="row d-flex justify-content-around align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-key" style="font-size: 1.5em"></i>
                            </div>
                            <div class="col-auto">
                                <p class="card-title">Authorization : <span style="font-weight: 500">Basic {{ Auth::user()->apikey()->key() }}</span></p>
                            </div>
                            <div class="col-auto">
                                <span style="font-size: 0.9em; font-weight: 450">{{ Auth::user()->apikey()->created_at->format('d/m/y') }}</span>
                            </div>
                            <div class="col-auto">
                                <a class="btn" href="{{route('admin.token.delete')}}"><i class="bi bi-trash3-fill" style="font-size: 1.2em"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    <div class="row justify-content-center mt-5">
                        <div class="col-auto mt-5">
                            <p style="font-size: 1.1em; font-weight: 500">You have not generate any API key yet..</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if(route('admin.token.generate') == url()->current())

    <!-- Button trigger modal -->
    <button type="button" style="display: none" id="openModal" data-bs-toggle="modal" data-bs-target="#staticBackdrop"></button>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Generate API Key</h5>
                    <button type="button" style="font-size: 1.5em" class="close btn" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body px-5 pt-0 pb-0">
                    <form method="post" action="{{ route('admin.token.generate') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group">
                                    <input aria-label="key" class="form-control mt-5 mb-2 @error('key') is-invalid " @enderror id="key" name="key" value="{{ old('key') }}" type="text" placeholder="ex: superkeyamazing">
                                    @error('key')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end mb-2">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary text-white">Generate</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script defer>
            document.getElementById('openModal').click();
        </script>
@endif
@endsection
