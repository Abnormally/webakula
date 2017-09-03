@extends('layouts.app')

@section('content')
<div class="container">
    <nav align="center">
        {{ $posts->links() }}
    </nav>
    @foreach($posts->chunk(2) as &$temp)
    <div class="container">
        @foreach($temp as &$post)
        <div class="col-md-6">
            <div class="media panel panel-success">
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

                <div class="panel-footer clearfix">
                    <div class="pull-right btn-group" role="group">
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