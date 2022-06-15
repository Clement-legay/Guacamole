@extends('layouts.app')

@section('title', 'Create Video')

@section('head')

@endsection

@section('background', 'p-4 me-5 pe-5')

@section('content')

    <style>
        .title-prop {
            font-size: 0.75em;
            font-weight: 400;
        }

        .prop-link {
            font-size: 0.9em;
            font-weight: 500;
            color: #007bff;
        }

        .prop {
            font-size: 0.9em;
            font-weight: 500;
        }

        .btn-file {
            width: 100%;
            background: #67875E;
            color: white;
        }

        .counter {
            font-size: 0.7em;
            font-weight: 500;
            position: absolute;
            right: 0;
            bottom: 0;
            padding-bottom: 5px;
            padding-right: 5px;
        }

        .dropdown-item {
            cursor: pointer;
        }

        .dropdown-item:nth-child(2n) {
            background: #f5f5f5;
        }

        .text-input {
            width: 100%;
            resize: none;
        }

        #autocomplete-categories {
            width: 100%;
            position: absolute;
            z-index: 100;
            background: #fff;
            top: 36px;
            left: 0;
        }
    </style>

    <script>
        function selectItem(item) {
            if (item.id === 'video') {
                document.getElementById('name').innerText = item.files[0].name.split('.')[0];
                document.getElementById('size').innerText = Math.round(item.files[0].size / 1024 / 1024) + " MB";
            } else {
                document.getElementById('thumbnail-picture').src = URL.createObjectURL(item.files[0]);
            }
        }
        function count(item, counter, limit) {
            counter = document.getElementById(counter)
            item = document.getElementById(item)
            counter.innerText = item.value.length + " / " + limit

            if (item.value.length > limit) {
                counter.style.color = "red"
                item.classList.add("border-danger")
            } else {
                counter.style.color = "black"
                item.classList.remove("border-danger")
            }
        }

        function categoriesAutocomplete(input, autocompleteName, API) {
            autocomplete = document.getElementById(autocompleteName);
            input = document.getElementById(input)

            // empty autocomplete
            autocomplete.innerHTML = ""

            if (API === 'categories') {
                let xmlHttp = new XMLHttpRequest();
                xmlHttp.open( "GET", "{{ route('API_categories') }}?search=" + input.value + "&limit=5", false ); // false for synchronous request
                xmlHttp.send( null );
                let response = JSON.parse(xmlHttp.responseText)

                for (let i = 0; i < response.length; i++) {
                    // create html element
                    let element = document.createElement("p")
                    element.classList.add("dropdown-item")
                    element.classList.add("py-2")
                    element.classList.add("mb-0")
                    element.innerText = response[i].category_name
                    element.setAttribute("onclick", "selectCategory('category', '" + response[i].category_name + "', '" + autocompleteName + "')")

                    // append element to dropdown
                    autocomplete.appendChild(element)
                }
            }
        }

        function checkMatch(item) {
            item = document.getElementById(item)

            if (item.value.length === 1) {
                console.log("match")
                if (item.value[item.value.length -1] !== '#') {
                    item.value = '#' + item.value
                }
            } else if (item.value[item.value.length - 1] === ' ') {
                if (item.value.length > 1) {
                        item.value = item.value + '#'
                    }
                }

            // // innertext matches pattern
            // if (item.value.match(/^(#\w+( ?))+$/)) {
            //     item.classList.remove("border-danger")
            //     return true
            // } else {
            //     item.classList.add("border-danger")
            //     item.value = item.value.slice(0, -1)
            //     return false
            // }
        }

        function selectCategory(item, name, autocomplete) {
            document.getElementById(item).value = name
            document.getElementById(autocomplete).innerHTML = ""

        }

        function outCategories(autocomplete) {
            // document.getElementById(autocomplete).innerHTML = ""
        }
    </script>

    <form action="{{ route('video.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-between pe-5 mb-2">
            <div class="col-auto">
                <h3>Create your video</h3>
            </div>
            <div class="col-5">
                <div class="row justify-content-end">
                    <div class="col-auto m-0 p-0">
                        <button type="button" class="btn btn-link m-0">CANCEL CHANGES</button>
                    </div>
                    <div class="col-auto p-0 m-0">
                        <button class="btn btn-primary m-0">UPLOAD</button>
                    </div>
                    <div class="col-auto m-0 p-0 me-3">
                        <button type="button" class="btn m-0"><i class="bi bi-three-dots"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-7">
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
                            <input style="height: 38px" type="text" aria-label="category" oninput="categoriesAutocomplete('category', 'autocomplete-categories', 'categories')" placeholder="Category" class="form-control @error('category') is-invalid @enderror" id="category" name="category">
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
                                <option value="public"><i class="bi bi-eye-fill"></i> Public</option>
                                <option value="private"><i class="bi bi-eye-slash-fill"></i> Private</option>
                                <option value="unlisted"><i class="bi bi-eyeglasses"></i> Unlisted</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" aria-label="tags" oninput="checkMatch('tags')" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" placeholder="Tags">
                            @error('tags')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="row justify-content-between align-content-center pe-5">
                    <div class="col-12 mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-12 mb-3">
                                        <div class="form-group">
                                            <label for="video" id="videoOpener" class="btn btn-file" ><i class="bi bi-upload"></i> Upload a file</label>
                                            <input type="file" onchange="selectItem(video)" style="display: none" class=" @error('video') is-invalid @enderror" id="video" name="video">
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
                                                    <input type="file" onchange="selectItem(thumbnail)" style="display: none" class=" @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail" accept="image/gif, image/jpeg, image/png">
                                                    @error('thumbnail')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 px-5 my-3">
                                                <img src="https://via.placeholder.com/1920x1080" id="thumbnail-picture" alt="Thumbnail" class="img-fluid">
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
@endsection
