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
            var json = $.parseJSON(html);
            console.log(json);
            console.log(json.score);
            $('article[data-id='+ id + '] .score .number').html(json.score + "");
    });
}