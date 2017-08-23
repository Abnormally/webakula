@extends('layouts.app')

@section('title', 'Гостевая книга')

@section('description', 'Гостевая книга для пользователей. Тут можно оставить свой отзыв.')

@section('content')
<article class="container">
    <div id="new-post-form" style="display: none" class="panel panel-primary">
        <div class="panel-heading">
            Оставьте ваш отзыв
        </div>

        <div class="panel-body">
            @if(Auth::guest())
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="guest-name" class="col-md-3 control-label">Имя</label>

                    <div class="col-md-8">
                        <input id="guest-name" type="text" class="form-control" minlength="2" maxlength="100" required autofocus>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="guest-email" class="col-md-3 control-label">E-Mail адрес</label>

                    <div class="col-md-8">
                        <input id="guest-email" pattern="^([\w\.\-])+@(([\w\-])+\.)+([\w]{2,4})+$" data-pattern-error="Данный адрес почты не верный." type="email" class="form-control" maxlength="100" required>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="guest-post" class="col-md-12 control-label">Отзыв:</label>

                    <div class="col-md-12">
                        <textarea id="guest-post" class="form-control" rows="5" minlength="10" required></textarea>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-footer clearfix">
            <div class="pull-right">
                <button type="submit" id="new-post-send" class="btn btn-primary">Отправить отзыв</button>
                <button type="reset" id="new-post-cancel" class="btn btn-danger">Отмена</button>
            </div>
        </div>
    </div>

    <button id="new-post-button" class="btn btn-primary center-block" style="margin-bottom: 20px">Оставить отзыв</button>
</article>

<article class="container">
    @foreach($posts->chunk(2) as &$temp)
    <div class="row">
        @foreach($temp as &$post)
        <div class="col-md-6">
            <div class="panel @if($post->reaction === 0){{ 'panel-default' }}@elseif($post->reaction === 1){{ 'panel-success' }}@else{{ 'panel-danger' }}@endif clearfix">
                <div class="panel-heading">
                    <a href="mailto:{{ $post->email }}" style="color: inherit">{{ $post->name }}</a>
                </div>

                <img class="panel-body img-responsive pull-left" src="" alt="{{ $post->name }}">

                <div class="panel-body pull-right clearfix">
                    <div class="well">{{ $post->content }}</div>
                    <div class="pull-right">Опубликовано: {{ $post->created_at }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
</article>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var gpost = {
            post_button: $('#new-post-button'),
            post_form: $('#new-post-form'),
            post_send: $('#new-post-send'),
            post_cancel: $('#new-post-cancel'),
            guest_name: $('#guest-name'),
            guest_email: $('#guest-email'),
            guest_post: $('#guest-post'),
        };

        gpost.post_form.validator();

        function clear_form() {
            $('.with-errors').empty();
            $('.has-error').removeClass('has-danger').removeClass('has-error');

            gpost.guest_name.val(null);
            gpost.guest_email.val(null);
            gpost.guest_post.val(null);
            gpost.post_form.hide();
            gpost.post_button.show();
        }

        gpost.post_cancel.on('click', function () {
            clear_form();
        });

        gpost.post_button.on('click', function () {
            gpost.post_button.hide();
            gpost.post_form.show();
        });

        gpost.post_send.on('click', function () {
            if (gpost.post_send.hasClass('disabled')) return;

            $('.with-errors').empty();
            $('.has-error').removeClass('has-danger').removeClass('has-error');

            $.post('{{ route('guestbook.post') }}', {
                '_token': '{{ csrf_token() }}',
                'name': gpost.guest_name.val(),
                'email': gpost.guest_email.val(),
                'text': gpost.guest_post.val(),
                'reaction': 0
            }, function (data) {
                var response = JSON.parse(data);

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
                        layout: 'bottomCenter',
                        type: 'success',
                        modal: true,
                        text: 'Спасибо за ваш отзыв, ' + response.name
                        + '. Он появится на странице, как только будет одобрен модератором. <br>'
                        + '<br> Для закрытия этого сообщения просто нажмите на него.',
                    }).show();

                    clear_form();
                }
            });
        });
    });
</script>
@endsection