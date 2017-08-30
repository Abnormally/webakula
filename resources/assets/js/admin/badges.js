/**
 * Created by Darkling on 30.08.2017.
 */
$(document).ready(function () {
    $.get(laroute.route('admin.getbadges'), [], function (data) {
        data = JSON.parse(data);

        var badges = {
            waiting: $('#posts-new'),
            published: $('#posts-published'),
            hidden: $('#posts-hidden')
        };

        for (var i = 0; i < data.length; i++) {
            if (data[i].status === 0) {
                badges.waiting.empty().append(data[i].total);
            } else if (data[i].status === 2) {
                badges.published.empty().append(data[i].total);
            } else if (data[i].status === 3) {
                badges.hidden.empty().append(data[i].total);
            }
        }

        if (!badges.waiting.text()) badges.waiting.append(0);
        if (!badges.published.text()) badges.published.append(0);
        if (!badges.hidden.text()) badges.hidden.append(0);
    });
});