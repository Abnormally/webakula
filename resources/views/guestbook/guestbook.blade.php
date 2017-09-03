@extends('layouts.app')

@section('title', 'Гостевая книга')

@section('description', 'Гостевая книга для пользователей. Тут можно оставить свой отзыв.')

@section('stylesheets')
<style type="text/css">
    .dl-well-fix {
        word-break: break-word;
    }

    .dl-panel-default-fix .panel-heading {
        background-color: rgb(200, 200, 200);
    }
</style>
@endsection

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
                        <input id="guest-name" type="text" class="form-control" minlength="2" maxlength="100" required>
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
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="avatar" class="col-md-2 control-label">Фотография:</label>

                    <div class="col-md-10">
                        <input id="avatar" type="file" class="form-control">
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

<article class="container" id="guest-book-holder">
    @foreach($posts->chunk(2) as &$temp)
    <div class="row">
        @foreach($temp as &$post)
        <div class="col-md-6">
            <div class="media panel panel-default dl-panel-default-fix">
                <div class="panel-heading">
                    <a href="mailto:{{ $post->email }}" style="color: inherit;"><h4 class="media-heading">{{ $post->name }}</h4></a>
                    <div class="pull-right">
                        <img src="{{ asset($post->avatar) }}?w=50&h=50&fit=crop" alt="{{ $post->name }}">
                    </div>
                </div>

                <div class="media-left media-middle">
                    <a href="#" onclick="event.preventDefault()">
                        <img class="media-object" src="{{ asset($post->avatar) }}?w=150&h=150&fit=crop" alt="{{ $post->name }}">
                    </a>
                </div>

                <div class="media-body">
                    <div class="panel-body" style="max-height: 100px;">
                        <p class="well dl-well-fix">{{ $post->content }}</p>
                    </div>
                </div>

                {{--<div class="panel-footer"></div>--}}
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
    <nav align="center">
        {{ $posts->links() }}
    </nav>
</article>
@endsection