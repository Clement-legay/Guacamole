let $modalBanner = $('#modalBanner');
let imageBanner = document.getElementById('image-banner');
let $modalPP = $('#modalPP');
let imagePP = document.getElementById('image-PP');
let cropper;

$("#banner").on("change", function(e){
    let files = e.target.files;
    let done = function (url) {
        imageBanner.src = url;
        $modalBanner.modal('show');
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

$("body").on("change", '#PP', function(e){
    let files = e.target.files;
    let done = function (url) {
        imagePP.src = url;
        $modalPP.modal('show');
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

$modalBanner.on('shown.bs.modal', function () {
    cropper = new Cropper(imageBanner, {
        aspectRatio: 16 / 3,
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

$("#cancelModalBanner").click(function(){
    $modalBanner.modal('hide');
});

$("#cropBanner").click(function(){
    const formTarget = document.getElementById('banner_cropped');
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
            const pictureRender = document.getElementById('banner-picture');
            pictureRender.src = reader.result;
            formTarget.value = reader.result;
            $modalBanner.modal('hide');
        }
    });
})

$modalPP.on('shown.bs.modal', function () {
    cropper = new Cropper(imagePP, {
        aspectRatio: 1,
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

$("#cancelModalPP").click(function(){
    $modalPP.modal('hide');
});

$("#cropPP").click(function(){
    const formTarget = document.getElementById('PP_cropped');
    canvas = cropper.getCroppedCanvas({
        fillColor: '#fff',
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high',
        backgroundColor: '#fff',
        minWidth: 200,
        minHeight: 200,
    });

    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        let reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function() {
            $.ajax({
                url: $('#url-avatar').val(),
                type: 'POST',
                data: {
                    profile_picture: reader.result,
                },
                success: function(data){
                    window.location.reload();
                },
                error: function(data){
                    console.log(data);
                }
            })
        }
    });
})
