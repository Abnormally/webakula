@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($posts as &$post)
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $post->name }}
        </div>

        <div class="panel-body clearfix">
            <div class="well">
                {{ $post->content }}
            </div>
            <div class="pull-right">
                <p>Email: {{ $post->email }}</p>
                <p>Создан: {{ $post->created_at }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection