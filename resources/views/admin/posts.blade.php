@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($posts->chunk(2) as &$temp)
    <div class="container">
        @foreach($temp as &$post)
        <div class="col-md-6">
            <div class="media panel {{ $posts_headings[$post->reaction] }}">
                <div class="panel-heading">
                    <a href="mailto:{{ $post->email }}"><h4 class="media-heading">{{ $post->name }}</h4></a>
                    <div class="pull-right">
                        <img src="{{ asset('img/guestbook/emo/' . $post->reaction . '.png') }}?w=50&h=50&fit=crop" alt="{{ $post->name }}">
                    </div>
                </div>

                <div class="media-left media-middle">
                    <a href="#" onclick="event.preventDefault()">
                        <img class="media-object" src="{{ asset($post->avatar) }}?w=150&h=150&fit=crop" alt="{{ $post->name }}">
                    </a>
                </div>

                <div class="media-body">
                    <div class="panel-body dl-post-body-fix">
                        <p class="well dl-well-fix">{{ $post->content }}</p>
                    </div>
                </div>

                <div class="panel-footer clearfix">
                    <div class="pull-right" role="group">
                        @if($post->status === 0 || $post->status === 3)
                        <a role="button" class="btn btn-primary button-publish" href="" onclick="event.preventDefault()">
                            <span class="fa fa-edit"></span> Опубликовать
                        </a>
                        @endif
                        @if($post->status === 0 || $post->status === 2)
                        <a role="button" class="btn btn-primary button-hide" href="" onclick="event.preventDefault()">
                            <span class="fa fa-eye"></span> Скрыть
                        </a>
                        @endif
                        <a role="button" class="btn btn-danger button-remove" href="" onclick="event.preventDefault()">
                            <span class="fa fa-cut"></span> Удалить
                        </a>
                        <input type="hidden" value="{{ $post->id }}">
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
</div>
@endsection