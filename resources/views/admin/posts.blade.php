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
            <div id="post{{ $post->id }}" class="panel panel-default">
                <div class="panel-heading">
                    {{ $post->name }}
                </div>

                <div class="panel-body clearfix">
                    <div class="well" style="height: 100px; overflow: hidden">
                        {{ $post->content }}
                    </div>
                    <div class="pull-left">
                        <img src="{{ asset($post->avatar) }}" class="img-responsive" width="150px">
                    </div>
                    <div class="pull-right">
                        <p>Email: {{ $post->email }}</p>
                        <p>Создан: {{ $post->created_at }}</p>
                    </div>
                </div>

                <div class="panel-footer clearfix">
                    <div class="pull-right">
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