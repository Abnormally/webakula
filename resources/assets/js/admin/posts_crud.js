/**
 * Created by Darkling on 30.08.2017.
 */
$(document).ready(function () {
    var buttons = {
        publish: $('.button-publish'),
        hide: $('.button-hide'),
        remove: $('.button-remove')
    };

    function messages(type, message) {
        new Noty({
            layout: 'bottomLeft',
            type: type,
            text: message,
        }).show();
    }

    buttons.publish.on('click', function (e) {
        var post_id = e.currentTarget.parentElement.lastChild.value;

        $.get(laroute.route('admin.publish', { id: post_id }), [], function (data) {
            if (data === 'true') {
                messages(
                    'success',
                    'Отзыв успешно опубликован.'
                );

                $('#post' + post_id)
                    .removeClass('panel-default')
                    .removeClass('panel-danger')
                    .removeClass('panel-primary')
                    .addClass('panel-success');
            } else {
                messages(
                    'warning',
                    'При публикации отзыва возникли неполадки.'
                );
            }
        });
    });

    buttons.hide.on('click', function (e) {
        var post_id = e.currentTarget.parentElement.lastChild.value;

        $.get(laroute.route('admin.hide', { id: post_id }), [], function (data) {
            if (data === 'true') {
                messages(
                    'success',
                    'Отзыв успешно скрыт.'
                );

                $('#post' + post_id)
                    .removeClass('panel-default')
                    .removeClass('panel-danger')
                    .removeClass('panel-success')
                    .addClass('panel-primary');
            } else {
                messages(
                    'warning',
                    'При скрытии отзыва возникли неполадки.'
                );
            }
        });
    });

    buttons.remove.on('click', function (e) {
        var post_id = e.currentTarget.parentElement.lastChild.value;

        $.get(laroute.route('admin.remove', { id: post_id }), [], function (data) {
            if (data === 'true') {
                messages(
                    'success',
                    'Отзыв успешно удалён.'
                );

                $('#post' + post_id)
                    .removeClass('panel-default')
                    .removeClass('panel-success')
                    .removeClass('panel-primary')
                    .addClass('panel-danger');
            } else {
                messages(
                    'warning',
                    'При удалении отзыва возникли неполадки.'
                );
            }
        });
    });
});