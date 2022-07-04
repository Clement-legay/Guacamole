function selectItem(item) {
    if (item.id === 'video') {
        document.getElementById('name').innerText = item.files[0].name.split('.')[0];
        document.getElementById('size').innerText = Math.round(item.files[0].size / 1024 / 1024) + " MB";
    } else {
        let photo = item.files[0]
        let reader = new FileReader();
        reader.onload = function(event) {
            let image = $('.js-thumbnail-preview')[0];
            image.src = event.target.result;

            cropper = new Cropper(image, {
                viewMode: 1,
                aspectRatio: 1,
                minContainerWidth: 400,
                minContainerHeight: 400,
                minCropBoxWidth: 1920,
                minCropBoxHeight: 1080,
                movable: true,
                zoomable: true,
                ready: function () {
                    console.log('ready');
                    console.log(cropper.ready);
                }
            });

            $(cropperModalId).modal();
        };
        reader.readAsDataURL(photo);
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
}

function selectCategory(item, name, autocomplete) {
    document.getElementById(item).value = name
    document.getElementById(autocomplete).innerHTML = ""
}


let cropper;
let cropperModalId = '#cropperModal';

let $jsPhotoUploadInput = $('#thumbnail');
console.log($jsPhotoUploadInput);
$jsPhotoUploadInput.on('change', function() {
    let files = this.files;
    if (files.length > 0) {
        let photo = files[0];

        let reader = new FileReader();
        reader.onload = function(event) {
            let image = $('.js-thumbnail-preview')[0];
            image.src = event.target.result;

            cropper = new Cropper(image, {
                viewMode: 1,
                aspectRatio: 1,
                minContainerWidth: 400,
                minContainerHeight: 400,
                minCropBoxWidth: 271,
                minCropBoxHeight: 271,
                movable: true,
                ready: function () {
                    console.log('ready');
                    console.log(cropper.ready);
                }
            });

            $(cropperModalId).modal();
        };
        reader.readAsDataURL(photo);
    }
});

$('.js-save-cropped-thumbnail').on('click', function(event) {
    event.preventDefault();

    console.log(cropper.ready);

    let $button = $(this);
    $button.text('uploading...');
    $button.prop('disabled', true);

    const canvas = cropper.getCroppedCanvas({
        width: 1920,
        height: 1080,
        fillColor: '#000',
        imageSmoothingEnabled: false,
    });
    const base64encodedImage = canvas.toDataURL();
    $('#thumbnail-picture').attr('src', base64encodedImage);
    $(cropperModalId).modal('hide');
});


