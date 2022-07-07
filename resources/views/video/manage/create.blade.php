@extends('layouts.app')

@section('title', 'Create Video')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/styleVideoForm.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endsection

@section('background', 'p-lg-4 me-lg-5 pe-lg-5 px-3 pt-2')

@section('content')
    <script>
        function categoriesAutocomplete(input, autocompleteName, API) {
            autocomplete = document.getElementById(autocompleteName);
            input = document.getElementById(input)

            if (input.value[input.value.length - 1] === '\n') {
                input.value = input.value.slice(0, -1)
            }

            autocomplete.innerHTML = ""

            if (API === 'categories') {
                let xmlHttp = new XMLHttpRequest();
                xmlHttp.open( "GET", "{{ route('API_categories') }}?search=" + input.value + "&limit=5", false ); // false for synchronous request
                xmlHttp.send( null );
                let response = JSON.parse(xmlHttp.responseText)

                for (let i = 0; i < response.length; i++) {
                    let element = document.createElement("p")
                    element.classList.add("dropdown-item")
                    element.classList.add("py-2")
                    element.classList.add("mb-0")
                    element.innerText = response[i].category_name
                    element.setAttribute("onclick", "selectCategory('category', '" + response[i].category_name + "', '" + autocompleteName + "')")

                    autocomplete.appendChild(element)
                }
            }
        }
    </script>

    <form action="{{ route('video.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-between pe-lg-5 mb-2">
            <div class="col-lg-auto col-6">
                <h3 style="font-size: 1.1em">Create your video</h3>
            </div>
            <div class="col-lg-5 col-6">
                <div class="row justify-content-end">
                    <div class="col-auto p-0 m-0">
                        <button class="btn btn-primary m-0 text-white">UPLOAD</button>
                    </div>
                    <div class="col-auto m-0 p-0 me-3">
                        <button type="button" class="btn m-0"><i class="bi bi-three-dots-vertical"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-lg-7 col-12">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-group" style="position: relative">
                            <label for="title" id="text-counter" class="counter">0/100</label>
                            <textarea type="text" oninput="count('title', 'text-counter', 100)" rows="2" class="form-control text-input @error('title') is-invalid @enderror" id="title" name="title" placeholder="Titre (mandatory)">{{ old('title') }}</textarea>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="form-group" style="position: relative">
                            <label id="desc-counter" for="description" class="counter">0/191</label>
                            <textarea oninput="count('description', 'desc-counter', 191)" class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description" rows="8">{{ old('description') }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="form-group" style="position: relative" onfocusout="outCategories('autocomplete-categories')">
                            <textarea style="height: 38px" type="text" aria-label="category" oninput="categoriesAutocomplete('category', 'autocomplete-categories', 'categories')" rows="1" placeholder="Category" class="form-control @error('category') is-invalid @enderror" id="category" name="category">{{ old('category') }}</textarea>
                            <div id="autocomplete-categories">

                            </div>
                            @error('category')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="form-group">
                            <select name="type" aria-label="privacy" class="form-control @error('type') is-invalid @enderror" id="type">
                                <option value="null">Select privacy</option>
                                <option value="public" {{ old('type') === 'public' ? 'selected' : '' }}><i class="bi bi-eye-fill"></i> Public</option>
                                <option value="private" {{ old('type') === 'private' ? 'selected' : '' }}><i class="bi bi-eye-slash-fill"></i> Private</option>
                                <option value="unlisted" {{ old('type') === 'unlisted' ? 'selected' : '' }}><i class="bi bi-eyeglasses"></i> Unlisted</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" value="{{ old('tags') }}" aria-label="tags" oninput="checkMatch('tags')" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" placeholder="Tags">
                            @error('tags')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-12 pt-4 pt-lg-0">
                <div class="row justify-content-between align-content-center pe-lg-5">
                    <div class="col-12 mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-12 mb-3">
                                        <div class="form-group">
                                            <label for="video" id="videoOpener" class="btn btn-file" ><i class="bi bi-upload"></i> Upload a file</label>
                                            <input type="file" onchange="selectItem(video)" style="display: none" class=" @error('video') is-invalid @enderror" id="video" name="video" accept="video/*">
                                            @error('video')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{--                                    <div class="col-12 mb-3">--}}
                                    {{--                                        <p class="p-0 m-0 title-prop">Video link</p>--}}
                                    {{--                                        <p id="link" class="p-0 m-0 prop-link">Unknown</p>--}}
                                    {{--                                    </div>--}}
                                    <div class="col-12 mb-3">
                                        <p class="p-0 m-0 title-prop">Video name</p>
                                        <p id="name" class="p-0 m-0 prop">Unknown</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="p-0 m-0 title-prop">Video size</p>
                                        <p id="size" class="p-0 m-0 prop">0</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card bg-light">
                            <div class="card-body pb-0">
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <div class="row justify-content-center">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="thumbnail" id="thumbnailOpener" class="btn btn-file"><i class="bi bi-upload"></i> Upload a thumbnail</label>
                                                    <input type="file" style="display: none" class=" @error('thumbnail_cropped') is-invalid @enderror" id="thumbnail" name="thumbnail" accept="image/gif, image/jpeg, image/png">
                                                    <input type="hidden" name="thumbnail_cropped" id="thumbnail_cropped">
                                                    @error('thumbnail_cropped')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>


                                                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body px-0">
                                                                <div class="row justify-content-center px-0">
                                                                    <div class="col-11 px-0">
                                                                        <img style="max-height: 500px" id="image" src="#" alt="tre">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" id="cancelModal">Cancel</button>
                                                                <button type="button" class="btn btn-primary" id="crop">Crop</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 px-5 my-3">
                                                <img src="https://via.placeholder.com/1920x1080" id="thumbnail-picture" alt="Thumbnail" style="width: 100%; aspect-ratio: 16 / 9">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="{{ asset('js/scriptVideoForm.js') }}"></script>
@endsection
