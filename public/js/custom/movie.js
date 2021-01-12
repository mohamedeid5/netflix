let favCount = $('#fav-count').data('fav-count');

$(function () {

    $(document).on('click', '.movie__fav-button', function (e) {

        e.preventDefault();

        let url = $(this).data('url');
        let movieId = $(this).data('movie-id');
        let isFavored = $(this).hasClass('fw-900');

        toggleFavored(url, isFavored,movieId);

    });

}); // end of document

function toggleFavored(url, isFavored, movieId) {

    !isFavored ? favCount++ : favCount--;

    favCount > 9 ? $('#fav-count').html('9+') : $('#fav-count').html(favCount);

    $('.movie-' + movieId).toggleClass('fw-900');

    $.ajax({
        url: url,
        method: 'POST'
    })

} // end of toggleFavored
