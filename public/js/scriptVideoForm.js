function selectItem(item) {
    if (item.id === 'video') {
        document.getElementById('name').innerText = item.files[0].name.split('.')[0];
        document.getElementById('size').innerText = Math.round(item.files[0].size / 1024 / 1024) + " MB";
    } else {
        let thumbnail = document.getElementById('thumbnail-picture')
        thumbnail.src = URL.createObjectURL(item.files[0])
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

let $modal = $('#modal');
let image = document.getElementById('image');
let cropper;

$("body").on("change", "#thumbnail", function(e){
    let files = e.target.files;
    let done = function (url) {
        image.src = url;
        $modal.modal('show');
    };
    let reader;
    let file;
    let url;

    if (files && files.length > 0) {
        file = files[0];

        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
});

$modal.on('shown.bs.modal', function () {
    cropper = new Cropper(image, {
        aspectRatio: 16 / 9,
        viewMode: 1,
        dragMode: 'move',
        scalable: true,
        zoomable: true,
        touchDragZoom: true,
    });
}).on('hidden.bs.modal', function () {
    cropper.destroy();
    cropper = null;
});

$("#cancelModal").click(function(){
    $modal.modal('hide');
});

$("#crop").click(function(){
    canvas = cropper.getCroppedCanvas({
        fillColor: '#fff',
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high',
        backgroundColor: '#fff',
        minWidth: 300,
        minHeight: 200,
    });

    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        let reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function() {
            const pictureRender = document.getElementById('thumbnail-picture');
            if (pictureRender) {
                pictureRender.src = reader.result;
            } else {
                document.getElementById('thumbnailOpener').style.backgroundImage = "url(" + reader.result + ")"
            }
            $('#thumbnail_cropped').val(reader.result);
            $modal.modal('hide');
        }
    });
})




