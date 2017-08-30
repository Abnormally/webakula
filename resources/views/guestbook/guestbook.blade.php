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

<article class="container">
    @foreach($posts->chunk(2) as &$temp)
    <div class="row">
        @foreach($temp as &$post)
        <div class="col-md-6">
            <div class="panel @if($post->reaction === 0){{ 'panel-default' }}@elseif($post->reaction === 1){{ 'panel-success' }}@else{{ 'panel-danger' }}@endif">
                <div class="panel-heading clearfix">
                    <a href="mailto:{{ $post->email }}" style="color: inherit">{{ $post->name }}</a>
                    <div class="pull-right">Опубликовано: {{ $post->updated_at }}</div>
                </div>

                <div class="panel-body row">
                    <div class="col-md-6">
                        <img class="img-responsive" width="150px" src="{{ asset($post->avatar) }}" alt="{{ $post->name }}">
                    </div>
                    <div class="col-md-6">
                        <div class="well" style="width: 100%; height: 100px; overflow: hidden">{{ $post->content }}</div>
                    </div>
                </div>
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