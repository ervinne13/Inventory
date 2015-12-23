
function showLoading(show) {
    if (show === false) {
        setTimeout(function () {
            $('.page-loader-wrapper').fadeOut();
        }, 50);
    } else {
        $('.page-loader-wrapper').show();
    }
}
