$(document).ready(function () {
    $('#input-file').on('change', function () {

        $('#movie_properties').css('display', 'block');
        $('#movie-upload-wrapper').css('display', 'none');

        let movie = this.files[0];
        let movieName = movie.name.split('.').slice(0,1).join('.');
        let movieId = $(this).data('movie-id');
        let url = $(this).data('url');
        console.log(url);
        $('#movie_name').val(movieName);

        let formData = new FormData();
        formData.append('movie_id', movieId);
        formData.append('name', movieName);
        formData.append('movie', movie);

        $.ajax({
            url: url,
            data: formData,
            method: 'POST',
            processData: false,
            contentType:false,
            cache: false,
            success: function(movieBeforeProcessing) {

                let interval = setInterval(function () {

                    $.ajax({
                        url: `/dashboard/movies/${movieBeforeProcessing.id}`,
                        success: function (movieWhileProcessing) {

                            $('#movie-upload-text').html('Processing');
                            $('#movie-upload-progress').css('width', movieWhileProcessing.percent + '%');
                            $('#movie-upload-progress').html(movieWhileProcessing.percent + '%');

                            if (movieWhileProcessing.percent == 100) {
                                clearInterval(interval);
                                $('#movie-upload-text').html('Processed');
                                $('#movie-submit-btn').css('display', 'block');
                            }
                        }
                    })

                }, 300);
            },
            xhr: function () {
                let xhr = window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        let percentComplete = Math.round(evt.loaded / evt.total * 100) + '%';
                        $('#movie-upload-progress').css('width', percentComplete).html(percentComplete);
                    }
                }, false);
                return xhr;
            }
        });

    }); // end of file change


    $('#select_all').on('click', function () {

        $('input:checkbox').not(this).prop('checked', this.checked);

    }); // end select all

    /*
    $('#logout').on('click', function (event) {
        event.preventDefault();

        $('#logout-form').submit();
    });

     */

});
