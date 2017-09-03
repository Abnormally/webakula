/**
 * Created by Darkling on 30.08.2017.
 */
$(document).ready(function () {
    var gpost = {
        post_button: $('#new-post-button'),
        post_form: $('#new-post-form'),
        post_send: $('#new-post-send'),
        post_cancel: $('#new-post-cancel'),
        guest_name: $('#guest-name'),
        guest_email: $('#guest-email'),
        guest_post: $('#guest-post'),
        guest_reaction: $('input[name="reaction"]'),
        guest_reaction_val: 1,
        guest_book_holder: $('#guest-book-holder'),
    };

    gpost.post_form.validator();

    function clear_class() {
        gpost.post_form
            .removeClass('panel-default')
            .removeClass('dl-panel-default-fix')
            .removeClass('panel-danger')
            .removeClass('panel-success')
            .removeClass('panel-primary')
    }

    function clear_form() {
        $('.with-errors').empty();
        $('.has-error').removeClass('has-danger').removeClass('has-error');

        gpost.guest_name.val(null);
        gpost.guest_email.val(null);
        gpost.guest_post.val(null);
        gpost.post_form.hide();
        clear_class();
        gpost.post_form.addClass('panel-primary');
        gpost.post_button.show();
        gpost.guest_book_holder.show();
        $('#avatar').val(null);
    }

    gpost.post_cancel.on('click', function () {
        clear_form();
    });

    gpost.post_button.on('click', function () {
        gpost.post_button.hide();
        gpost.guest_book_holder.hide();
        gpost.post_form.show();
    });

    gpost.guest_reaction.on('click', function (event) {
        gpost.guest_reaction_val = parseInt(event.currentTarget.defaultValue);
        clear_class();

        switch (gpost.guest_reaction_val) {
            case 0:
                gpost.post_form.addClass('panel-danger');
                break;
            case 1:
                gpost.post_form.addClass('panel-default').addClass('dl-panel-default-fix');
                break;
            case 2:
                gpost.post_form.addClass('panel-success');
                break;
            default:
                gpost.post_form.addClass('panel-primary');
        }
    });

    gpost.post_send.on('click', function () {
        if (gpost.post_send.hasClass('disabled')) return;

        $('.with-errors').empty();
        $('.has-error').removeClass('has-danger').removeClass('has-error');

        var formData = new FormData();
        formData.append('file', $('#avatar')[0].files[0]);
        formData.append('name', gpost.guest_name.val());
        formData.append('email', gpost.guest_email.val());
        formData.append('text', gpost.guest_post.val());
        if (gpost.guest_reaction_val !== 1) formData.append('reaction', gpost.guest_reaction_val);

        $.ajax({
            url: laroute.route('guestbook.post'),
            method: "POST",
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);

                if (response.has_errors) {
                    if (response.errors.name) {
                        gpost.guest_name.parent().parent().addClass('has-danger').addClass('has-error');
                        gpost.guest_name.next().append(response.errors.name[0]);
                    }

                    if (response.errors.email) {
                        gpost.guest_email.parent().parent().addClass('has-danger').addClass('has-error');
                        gpost.guest_email.next().append(response.errors.email[0]);
                    }

                    if (response.errors.text) {
                        gpost.guest_post.parent().parent().addClass('has-danger').addClass('has-error');
                        gpost.guest_post.next().append(response.errors.text[0]);
                    }
                } else {
                    new Noty({
                        layout: 'bottomLeft',
                        type: 'success',
                        text: 'Спасибо за ваш отзыв, ' + response.name
                        + '. Он появится на странице, как только будет одобрен модератором. <br>'
                        + '<br> Для закрытия этого сообщения просто нажмите на него.',
                    }).show();

                    clear_form();
                }
            },
            error: function (error) {
                console.log(error.message);

                new Noty({
                    layout: 'bottomLeft',
                    type: 'warning',
                    text: 'Произошёл сбой на сервере. Приносим извенения за неполадки.',
                }).show();
            }
        });
    });
});