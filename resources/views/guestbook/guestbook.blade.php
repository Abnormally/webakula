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
            <div class="row">
                <div class="form-group{{-- has-error --}} col-md-6">
                    <label for="name" class="col-md-3 control-label">Имя</label>

                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name" required autofocus>

                        {{--
                        <span class="help-block">
                            <strong>Мыльца</strong>
                        </span>
                        --}}
                    </div>
                </div>

                <div class="form-group{{-- has-error --}} col-md-6">
                    <label for="email" class="col-md-3 control-label">E-Mail адрес</label>

                    <div class="col-md-8">
                        <input id="email" type="email" class="form-control" name="email" required>

                        {{--
                        <span class="help-block">
                            <strong>Мыльца</strong>
                        </span>
                        --}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <label for="post-text" class="col-md-12 control-label">Отзыв:</label>

                    <div class="col-md-12">
                        <textarea id="post-text" class="form-control" rows="5" name="post-text"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-footer clearfix">
            <div class="pull-right">
                <button id="new-post-send" class="btn btn-primary">Отправить отзыв</button>
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
        var post_button = $('#new-post-button');
        var post_form = $('#new-post-form');
        var post_send = $('#new-post-send');

        post_button.on('click', function () {
            post_button.hide();
            post_form.show();
        });

        post_send.on('click', function () {
            post_form.hide();
            post_button.show();
        });
    });
</script>
@endsection