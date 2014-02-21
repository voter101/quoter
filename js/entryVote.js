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
        .done(function (output) {
            var json = $.parseJSON(output);
            UpdateEntryAfterVote(id, json);
        });
}

function UpdateEntryAfterVote(id, json) {
    var articleSelector = 'article[data-id=' + id + ']';
    $(articleSelector + ' .score .number').html(json.score);
    $(articleSelector + ' .score .voteMessage').html(json.message);
    if (json.positive == 1) {
        $(articleSelector + ' .score .voteUp').hide();
        $(articleSelector + ' .score .voteDown').show();
    } else {
        $(articleSelector + ' .score .voteDown').hide();
        $(articleSelector + ' .score .voteUp').show();
    }
}
