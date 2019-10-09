jQuery(document).ready(function($) {
    var lightboxActive = false;
    var selectedPhoto = 0;

    $('a[rel="lightbox"]').click(function(e) {
        e.preventDefault();

        let href = $(this).attr('href');
        updatePhoto(href);
        $('#household-photos-lightbox').css('display', 'block');
        lightboxActive = true;

        return false;
    });

    $('#household-photos-lightbox').click(function(e) {
        closeLightbox();
    });

    $(document).keyup(function (event) {
        let keyEsc = 27;
        let keyLeft = 37;
        let keyRight = 39;

        if (lightboxActive) {
            console.log('lightbox is active');
            if (event.keyCode == keyLeft) {
                selectPhotoPrev();
            } else if(event.keyCode == keyRight) {
                selectPhotoNext();
            } else if(event.keyCode == keyEsc) {
                closeLightbox();
            }
            console.log(event);
        } else {
            if (event.keyCode == keyLeft) {
                let photoNum = selectedPhoto - 1;
                if (photoNum > $('a[rel="lightbox"]').length) {
                    photoNum = $('a[rel="lightbox"]').length;
                }
                selectThumb(photoNum);
                console.log('album - left key');
            } else if(event.keyCode == keyRight) {
                let photoNum = selectedPhoto + 1;
                if (photoNum < 0) {
                    photoNum = 0;
                }
                selectThumb(photoNum);
                console.log('album - right key ' + selectThumb);
            }
        }
    });

    function closeLightbox() {
        lightboxActive = false;
        $('#household-photos-lightbox').css('display', 'none');
    }

    function selectThumb(photoNum) {
        selectedPhoto = photoNum;
        console.log(selectedPhoto);

        $('.card').removeClass('selected');
        $('.card:eq(' + photoNum + ')').addClass('selected');
    }

    function updatePhoto(href) {
        let img = '<img src="' + href + '" class="img-responsive" />';
        let imgContainer = '<div class="img-large" style="background-image: url(' + href + ');"></div>';
        $('#household-photos-lightbox .content').html(img);
    }

    function selectPhotoPrev() {
        selectedPhoto--;
        let href = $('.card:eq(' + selectedPhoto + ')').find('a[rel="lightbox"]').attr('href');
        updatePhoto(href);
    }

    function selectPhotoNext() {
        selectedPhoto++;
        let href = $('.card:eq(' + selectedPhoto + ')').find('a[rel="lightbox"]').attr('href');
        updatePhoto(href);
    }

    $('.btn-back').click(function() {
        selectPhotoPrev();
    });

    $('.btn-next').click(function() {
        selectPhotoNext();
    });
});
