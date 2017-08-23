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

        <div class="panel-footer clearfix">
            <div class="pull-right">
                <a role="button" class="btn btn-primary">
                    <span class="fa fa-edit"></span> Опубликовать
                </a>

                <a role="button" class="btn btn-primary">
                    <span class="fa fa-eye"></span> Скрыть
                </a>

                <a role="button" class="btn btn-danger" href="{{ route('admin.remove', ['id' => $post->id]) }}" onclick="event.preventDefault()">
                    <span class="fa fa-cut"></span> Удалить
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {

    });
</script>
@endsection