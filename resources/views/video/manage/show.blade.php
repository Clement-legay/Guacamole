@extends('layouts.app')

@section('title', $video->title . ' | ' . $video->user()->first()->username)

@section('head')
    <link rel="stylesheet" href="{{ asset('css/styleVideoForm.css') }}">
    <script src="{{ asset('js/scriptVideoForm.js') }}"></script>
@endsection

@section('background', 'p-4 me-5 pe-5')

@section('content')

    <form action="{{ route('video.update', $video->id()) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="flex-row pe-5 mb-2">
            <div class="d-flex align-items-center justify-content-between">
                <div class="col-auto flex-column">
                    <h3>Edit your video</h3>
                </div>
                <div class="col-5 flex-column">
                    <div class="flex-row d-flex justify-content-end">
                        <div class="col-auto m-0 p-0 flex-column">
                            <button type="button" class="btn btn-link m-0">CANCEL CHANGES</button>
                        </div>
                        <div class="col-auto p-0 m-0 flex-column me-2">
                            <button class="btn btn-primary m-0">UPLOAD</button>
                        </div>
                        <div class="col-auto flex-column p-0 m-0 me-2">
                            <div class="dropdown">
                                <button class="btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu p-0 m-0" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="{{ route('video.delete', $video->id()) }}">Delete <i class="bi bi-trash-fill"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-between">
            <div class="col-7">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-group" style="position: relative">
                            <label for="title" id="text-counter" class="counter">{{ strlen($video->title) }}/100</label>
                            <textarea type="text" oninput="count('title', 'text-counter', 100)" rows="2" placeholder="Title (mandatory)" class="form-control text-input @error('title') is-invalid @enderror" id="title" name="title">{{ $video->title }}</textarea>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="form-group" style="position: relative">
                            <label id="desc-counter" for="description" class="counter">{{ strlen($video->description) }}/191</label>
                            <textarea oninput="count('description', 'desc-counter', 191)" class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description" rows="8">{{ $video->description }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="form-group" style="position: relative" onfocusout="outCategories('autocomplete-categories')">
                            <textarea style="max-height: 38px; resize: none" type="text" aria-label="category" oninput="categoriesAutocomplete('category', 'autocomplete-categories', 'categories')" placeholder="Category" class="form-control @error('category') is-invalid @enderror" id="category" name="category">{{ $video->category()->first()->category_name }}</textarea>
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
                                <option value="null" selected>Select privacy</option>
                                <option value="public" @if($video->type == 'public') selected @endif><i class="bi bi-eye-fill"></i> Public</option>
                                <option value="private" @if($video->type == 'private') selected @endif><i class="bi bi-eye-slash-fill"></i> Private</option>
                                <option value="unlisted" @if($video->type == 'unlisted') selected @endif><i class="bi bi-eyeglasses"></i> Unlisted</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" value="{{ $video->tagsName() }}" aria-label="tags" oninput="checkMatch('tags')" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" placeholder="Tags">
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
                                    <div class="form-group">
                                        <video width="100%" height="auto" controls>
                                            <source src="{{ asset($video->video) }}" type="video/mp4">
                                        </video>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <p class="p-0 m-0 title-prop">Video link</p>
                                        <a href="{{ route('watch', $video->id()) }}" style="text-decoration: none" id="link" class="p-0 m-0 prop-link">{{ route('watch', $video->id()) }}</a>
                                    </div>
                                    <div class="col-12">
                                        <p class="p-0 m-0 title-prop">Video name</p>
                                        <p id="name" class="p-0 m-0 prop">{{ $video->title }}</p>
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
                                                <img src="{{ asset($video->thumbnail) }}" id="thumbnail-picture" alt="Thumbnail" class="img-fluid">
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
