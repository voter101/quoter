$(document).ready(function () {
    $(".entry .score a").click(function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var url = $(this).attr('href');
        return VoteAjax(id, url);
    });
});

function VoteAjax(id, url) {
    $.ajax({url: url})
        .done(function(html) {
            $('article[data-id='+ id + '] .score .number').html(html);
    });
}