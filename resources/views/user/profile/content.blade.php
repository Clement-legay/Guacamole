@extends('layouts.app')

@section('title', 'Your Content')

@section('background', 'bg-light p-4')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/styleVideoForm.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ModalFormVideo.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-xl-8">
            <h3>Contenu de la chaîne</h3>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Video</th>
                    <th scope="col"></th>
                    <th scope="col">Visibility</th>
                    <th scope="col">Date</th>
                    <th scope="col">Views</th>
                    <th scope="col">Comments</th>
                    <th scope="col">% Likes</th>
                </tr>
                </thead>
                <tbody>
                @foreach(auth()->user()->videos()->orderBy('created_at', 'desc')->get() as $video)
                    <tr onclick="doNav('{{ $video->status == 'processed' ? route('profile.draftEdit', $video->id64()) : route('video.details', $video->id64()) }}')" class="video_row">
                        <td>
                            <img width="150" height="84" src="{{ $video->thumbnail() }}" alt="{{ $video->title }}">
                        </td>
                        <td>
                            <p>{{ $video->title }}</p>
                            <p>{{ $video->description }}</p>
                        </td>
                        <td>{{ $video->type }}</td>
                        <td>{{ $video->created_at->format('d F Y') }}</td>
                        <td>{{ $video->views()->get()->count() }}</td>
                        <td>{{ $video->comments()->get()->count() }}</td>
                        <td>{{ $video->likes()->get()->count() > 0 ? $video->likes()->get()->count() / ($video->likes()->get()->count() + $video->dislikes()->get()->count()) * 100 : 0}}%</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if(isset($create) && $create)

        <!-- Button trigger modal -->
        <button type="button" style="display: none" id="openModal" data-bs-toggle="modal" data-bs-target="#staticBackdrop"></button>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header py-2 px-4">
                        <h5 class="modal-title" id="staticBackdropLabel">Upload a video</h5>
                        <a href="{{ route('profile.content') }}" class="close btn py-0">
                            <span aria-hidden="true" style="font-size: 2em">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body position-relative" style="height: 80vh" id="dropZone">
                        <div style="height: 100%" class="row d-flex align-items-center justify-content-center">
                            <form id="videoForm" action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-12">
                                    <div class="row justify-content-center">
                                        <div class="col-auto">
                                            <div onclick="video.click()" id="button-file" class="btn bg-light rounded-circle" style="height: 125px; width: 125px">
                                                <div class="line l1" style="left: 8%"></div>
                                                <div class="line l2" style="left: 16%"></div>
                                                <div class="line l3" style="left: 24%"></div>
                                                <div class="line l4" style="left: 32%"></div>
                                                <div class="line l5" style="left: 40%"></div>
                                                <div class="line l6" style="left: 48%"></div>
                                                <div class="line l7" style="left: 56%"></div>
                                                <div class="line l8" style="left: 64%"></div>
                                                <div class="line l9" style="left: 72%"></div>
                                                <div class="line l10" style="left: 80%"></div>
                                                <div class="line l11" style="left: 88%"></div>
                                                <div id="iconUpload" class="base">
                                                    <i class="bi bi-upload" style="font-size: 3em; color: grey"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row justify-content-center">
                                        <div class="col-auto">
                                            <p class="text-center p-0 mb-0 mt-3" style="font-size: 0.9em">Glissez-déposez les fichiers vidéo que vous souhaitez mettre en ligne</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row justify-content-center">
                                        <div class="col-auto">
                                            <span class="text-center p-0" style="font-size: 0.80em">Vos vidéos resteront privées jusqu'à leur publication.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row justify-content-center mt-3">
                                        <div class="col-auto">
                                            <label for="video" id="videoOpener" class="btn btn-file" >Upload a file</label>
                                            <input type="file" style="display: none" class=" @error('video') is-invalid @enderror" id="video"  name="video" accept="video/*">
                                            @error('video')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="bottom-full w-100 mb-3">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <p class="text-center p-0 mb-0" style="font-size: 0.65em">By uploading a video on Guacatube, you agree to the Guacatube's <a style="text-decoration: none" href="#">Terms of Service</a> and <a style="text-decoration: none" href="#">Community Guidelines</a></p>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <p class="text-center p-0 mb-0" style="font-size: 0.65em">Be careful not to infringe on the copyrights or privacy rights of others.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script defer>
            {{--$('#preview').ready(async function () {--}}
            let iconUpload = $('#iconUpload');
            let videoInput = $('#video');
            let buttonFile = $('#button-file');
            let buttonFileOpener = $('#videoOpener');
            loading = false;

            $('body').ready(

                $('#dropZone').on('dragover', function(e) {
                    let fileInput = document.getElementById('video');
                    if (fileInput.files.length === 0) {
                        if (iconUpload.hasClass('rotate-back')) {
                            iconUpload.removeClass('rotate-back');
                        } else {
                            iconUpload.removeClass('base');
                        }
                        iconUpload.addClass('rotate');
                        e.preventDefault();
                        e.stopPropagation();
                        $(this).addClass('drag-over');
                    }
                }).on('dragleave', function(e) {
                    let fileInput = document.getElementById('video');
                    if (fileInput.files.length === 0) {
                        iconUpload.removeClass('rotate');
                        iconUpload.addClass('rotate-back');
                        e.preventDefault();
                        e.stopPropagation();
                        $(this).removeClass('drag-over');
                    }
                }).on('drop', function(e) {
                    let fileInput = document.getElementById('video');
                    if (fileInput.files.length === 0) {
                        e.preventDefault();
                        e.stopPropagation();
                        if (e.originalEvent.dataTransfer.files[0].type.includes('video')) {
                            fileInput.files = e.originalEvent.dataTransfer.files;
                        } else {
                            $(this).removeClass('drag-over');
                            $(this).addClass('drag-error');
                        }

                        $(this).removeClass('drag-over');
                        fileUpload();
                    }
                }),


                videoInput.change(function() {
                    fileUpload()
                })
            )

            async function fileUpload() {
                let fileInput = document.getElementById('video');
                if (fileInput.files.length > 0) {
                    buttonFile.addClass('upload-disabled');
                    buttonFileOpener.addClass('btn-disabled');
                    videoInput.prop('disabled', true);
                    buttonFile.addClass('button-charging');
                    iconUpload.removeClass('rotate');
                    iconUpload.addClass('flying');
                    loading = true;

                    let formData = new FormData();
                    formData.append('video', fileInput.files[0]);
                    formData.append('title', fileInput.files[0].name);

                    $.ajax({
                        url: '{{ route('API_upload_video_file', Auth::user()->id64()) }}',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {
                            window.location.href = '{{ route('profile.uploadSuccess') }}?video=' + btoa(data.video_id);
                        },
                        error: function(data) {
                            console.log(data);
                        },
                    });
                }
            }


            document.getElementById('openModal').click();
            {{--    $.ajax({--}}
            {{--        url: '{{ route('API_frame_get', ['video' => $video->id64(), 'timestamp' => 48]) }}',--}}
            {{--        type: 'GET',--}}
            {{--        success: function(data) {--}}
            {{--            console.log(data.frame)--}}
            {{--            // decode base64 string to image--}}
            {{--            $('#preview').attr('src', 'data:image/JFIF;base64,' + data.frame);--}}

            {{--        },--}}
            {{--        error: function (data) {--}}
            {{--            console.log(data);--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}
        </script>
    @endif

    @if(isset($draft))
        <!-- Button trigger modal -->
        <button type="button" style="display: none" id="openModal" data-bs-toggle="modal" data-bs-target="#staticBackdrop"></button>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header py-2 px-4">
                        <h5 class="modal-title" id="staticBackdropLabel">{{ $draft->title }}</h5>
                        <a href="{{ route('profile.content') }}" class="close btn py-0">
                            <span aria-hidden="true" style="font-size: 2em">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body position-relative" id="dropZone">
                        <div style="height: 100%" class="row d-flex align-items-start justify-content-center">
                            <form id="videoForm" action="{{ route('profile.draftUpdate', $draft->id64()) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row justify-content-between">
                                    <div class="col-lg-7 col-12">
                                        <div class="row">
                                            <div class="col-12 mb-4">
                                                <div class="form-group" style="position: relative">
                                                    <label for="title" id="text-counter" class="counter">{{ strlen($draft->title) ?? strlen(old('title'))  }}/100</label>
                                                    <textarea type="text" oninput="count('title', 'text-counter', 100)" rows="2" class="form-control text-input @error('title') is-invalid @enderror" id="title" name="title" placeholder="Titre (mandatory)">{{ $draft->title ?? old('title') }}</textarea>
                                                    @error('title')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 mb-4">
                                                <div class="form-group" style="position: relative">
                                                    <label id="desc-counter" for="description" class="counter">{{ strlen($draft->description) ?? strlen(old('description'))  }}/191</label>
                                                    <textarea oninput="count('description', 'desc-counter', 191)" class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description" rows="8">{{ $draft->description ?? old('description') }}</textarea>
                                                    @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div class="form-group" style="position: relative" onfocusout="outCategories('autocomplete-categories')">
                                                    <textarea style="height: 38px" type="text" aria-label="category" oninput="categoriesAutocomplete('category', 'autocomplete-categories', 'categories')" rows="1" placeholder="Category" class="form-control @error('category') is-invalid @enderror" id="category" name="category">{{ $draft->category()->name ?? old('category') }}</textarea>
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
                                                        <option value="public" {{ $draft->type === 'public' ? 'selected' : '' }}><i class="bi bi-eye-fill"></i> Public</option>
                                                        <option value="private" {{ $draft->type === 'private' ? 'selected' : '' }}><i class="bi bi-eye-slash-fill"></i> Private</option>
                                                        <option value="unlisted" {{ $draft->type === 'unlisted' ? 'selected' : '' }}><i class="bi bi-eyeglasses"></i> Unlisted</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="text" value="{{ $draft->tagsName() ?? old('tags') }}" aria-label="tags" oninput="checkMatch('tags')" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" placeholder="Tags">
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
                                        <div class="row justify-content-between align-content-center">
                                            <div class="col-12 mb-3">
                                                <div class="card bg-light">
                                                    <div class="card-body p-0">
                                                        <div class="row justify-content-center">
                                                            <div class="form-group">
                                                                @if($draft->status == 'pending')
                                                                    <div class="d-flex align-items-center row p-0 m-0" style="background: #e8e8e8; width: 100%; aspect-ratio: 16/9">
                                                                        <div class="col-12">
                                                                            <p class="text-center" style="font-size: 0.80em">Your video's process will start soon.</p>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    @component('component.playerJS', ['video' => $draft])
                                                                    @endcomponent
                                                                @endif
                                                            </div>
                                                            <div class="col-12 mb-3 pt-2 px-4">
                                                                <p class="p-0 m-0 title-prop">Video link</p>
                                                                <a href="{{ route('watch', $draft->id64()) }}" style="text-decoration: none" id="link" class="p-0 m-0 prop-link">{{ route('watch', $draft->id64()) }}</a>
                                                            </div>
                                                            <div class="col-12 pb-2 px-4">
                                                                <p class="p-0 m-0 title-prop">Video name</p>
                                                                <p id="name" class="p-0 m-0 prop">{{ $draft->title }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-start my-2 m-0">
                                    <div class="col-12 my-2">
                                        <p class="mb-0" style="font-size: 0.9em; font-weight: 500">Thumbnail</p>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>
                                            <input type="radio" name="thumbnail-radio" class="card-input-element" value="inputPic"/>
                                        <div class="card bg-light card-input" style="position: relative">
                                            <div class="card-body p-0">
                                                <div style="aspect-ratio: 16/9; width: 100%; background: #e8e8e8; background-size: contain" id="thumbnailOpener">
                                                    <input type="file" style="display: none" class=" @error('thumbnail_cropped') is-invalid @enderror" id="thumbnail" name="thumbnail" accept="image/gif, image/jpeg, image/png">
                                                    <input aria-label="file" type="hidden" name="thumbnail_cropped" id="thumbnail_cropped">
                                                    <div class="row d-flex justify-content-center align-items-center py-2 h-100">
                                                        <div class="col-auto">
                                                            <i id="buttonThumbnailOpener" class="bi bi-image-fill" style="cursor: pointer;"></i>
                                                        </div>
                                                        <div class="col-12">
                                                            <p class="text-center m-0">Import thumbnail</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('thumbnail_cropped')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror


                                                <div class="modal fade" id="modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
                                        </div>
                                        </label>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>
                                            <input checked type="radio" name="thumbnail-radio" class="card-input-element" value="frame+0.25"/>
                                        <div class="card bg-light card-input" style="position: relative">
                                            <div class="card-body p-0">
                                                <div style="aspect-ratio: 16/9; width: 100%; background: #e8e8e8">
                                                    @if($draft->status == 'pending')
                                                        <div class="skeleton-loader"></div>
                                                    @else
                                                        <img alt="thumbnail-sample-1" style="height: 100%; width: 100%" src="{{ $draft->getFrameForHtml($draft->duration * 0.25) }}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        </label>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>
                                            <input type="radio" name="thumbnail-radio" class="card-input-element" value="frame+0.50"/>
                                        <div class="card bg-light card-input" style="position: relative">
                                            <div class="card-body p-0">
                                                <div style="aspect-ratio: 16/9; width: 100%; background: #e8e8e8">
                                                    @if($draft->status == 'pending')
                                                        <div class="skeleton-loader"></div>
                                                    @else
                                                        <img alt="thumbnail-sample-2" style="height: 100%; width: 100%" src="{{ $draft->getFrameForHtml($draft->duration * 0.50) }}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        </label>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>
                                            <input type="radio" name="thumbnail-radio" class="card-input-element" value="frame+0.75"/>
                                        <div class="card bg-light card-input" style="position: relative">
                                            <div class="card-body p-0">
                                                <div style="aspect-ratio: 16/9; width: 100%; background: #e8e8e8">
                                                    @if($draft->status == 'pending')
                                                        <div class="skeleton-loader"></div>
                                                    @else
                                                        <img alt="thumbnail-sample-3" style="height: 100%; width: 100%" src="{{ $draft->getFrameForHtml($draft->duration * 0.75) }}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer row justify-content-between py-1">
                        <div class="col-auto">
                            <div class="row justify-content-around">
                                <div class="col-auto">
                                    <i style="color: #065fd3; font-size: 1.3em" class="bi bi-upload"></i>
                                </div>
                                <div class="col-auto">
                                    @if($draft->quality() == 'low')
                                        <i style="color: #065fd3; font-size: 1.3em" class="bi bi-badge-sd-fill"></i>
                                    @elseif($draft->quality() == 'medium')
                                        <i style="color: #065fd3; font-size: 1.3em" class="bi bi-badge-hd-fill"></i>
                                    @elseif($draft->quality() == 'high')
                                        <i style="color: #065fd3; font-size: 1.3em" class="bi bi-badge-4k-fill"></i>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    <i style="font-size: 1.3em;{{ $draft->status == 'pending' ? '' : 'color: #065fd3' }}" class="bi bi-check-circle"></i>
                                </div>
                                <div class="col-auto">
                                    @if($draft->status == 'pending')
                                        <p class="p-0 m-0 pt-1" style="font-size: 0.8em" id="textProcessing">Your video's process will start soon.</p>
                                    @else
                                        <p class="p-0 m-0 pt-1" style="font-size: 0.8em" id="textProcessing">Your video is now up and running !</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button id="sendForm" class="btn btn-primary text-white">Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <script defer>
                let thumbnailOpener = document.getElementById('thumbnailOpener');
                let thumbnail = document.getElementById('thumbnail');
                let thumbnail_cropped = document.getElementById('thumbnail_cropped');

                $('body').ready(
                    $('#buttonThumbnailOpener').click(function(){
                        document.getElementById('thumbnail').click();
                    }),

                    $('#sendForm').click(function(){
                        $('#videoForm').submit();
                    }),
                )

                const progress = () => {
                    $.ajax(
                        {
                            url: '{{ route('API_process_progress', $draft->id64()) }}',
                            method: 'GET',
                            success: function(data){
                                data.progress === 100 ? setTimeout(() => {
                                    window.location.reload();
                                }, 1000) : updateProgress(data.progress);
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        }
                    )
                }

                const updateProgress = (state) => {
                    if (state > 0) {
                        $('#textProcessing').text('Processing... ' + state + '%');
                        setTimeout(() => {progress()}, 1000);
                    } else {
                        setTimeout(() => {progress()}, 1000);
                    }
                }

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

                @if($draft->status == 'pending')
                progress();
                @endif

                document.getElementById('openModal').click();
                {{--    $.ajax({--}}
                {{--        url: '{{ route('API_frame_get', ['video' => $video->id64(), 'timestamp' => 48]) }}',--}}
                {{--        type: 'GET',--}}
                {{--        success: function(data) {--}}
                {{--            console.log(data.frame)--}}
                {{--            // decode base64 string to image--}}
                {{--            $('#preview').attr('src', 'data:image/JFIF;base64,' + data.frame);--}}

                {{--        },--}}
                {{--        error: function (data) {--}}
                {{--            console.log(data);--}}
                {{--        }--}}
                {{--    });--}}
                {{--});--}}
            </script>

            <script src="{{ asset('js/scriptVideoForm.js') }}"></script>
    @endif

@endsection
