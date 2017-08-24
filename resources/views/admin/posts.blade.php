@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($posts as &$post)
    <div id="post{{ $post->id }}" class="panel panel-default">
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
    @endforeach
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var status = {{ $status }}, temp;

        var paths = {
            publish: '{{ route('admin.publish', ['id' => 0]) }}'.slice(0, -1),
            hide: '{{ route('admin.hide', ['id' => 0]) }}'.slice(0, -1),
            remove: '{{ route('admin.remove', ['id' => 0]) }}'.slice(0, -1)
        };

        var buttons = {
            publish: $('.button-publish'),
            hide: $('.button-hide'),
            remove: $('.button-remove')
        };

        var counters = {
            unpublished: $('#posts-new'),
            published: $('#posts-published'),
            hidden: $('#posts-hidden')
        };

        function messages(type, message) {
            new Noty({
                layout: 'topLeft',
                type: type,
                text: message,
            }).show();
        }

        buttons.publish.on('click', function (e) {
            var post_id = e.currentTarget.parentElement.lastChild.value;

            $.get(paths.publish + post_id, [], function (data) {
                if (data === 'true') {
                    messages(
                        'success',
                        'Отзыв успешно опубликован.'
                    );

                    $('#post' + post_id)
                        .removeClass('panel-default')
                        .removeClass('panel-danger')
                        .removeClass('panel-primary')
                        .addClass('panel-success');

                    if (status === 0) {
                        temp = parseInt(counters.unpublished.text()) - 1;
                        counters.unpublished.empty().append(temp);
                    }

                    if (status === 3) {
                        temp = parseInt(counters.hidden.text()) - 1;
                        counters.hidden.empty().append(temp);
                    }

                    temp = parseInt(counters.published.text()) + 1;
                    counters.published.empty().append(temp);
                } else {
                    messages(
                        'danger',
                        'При публикации отзыва возникли неполадки.'
                    );
                }
            });
        });

        buttons.hide.on('click', function (e) {
            var post_id = e.currentTarget.parentElement.lastChild.value;

            $.get(paths.hide + post_id, [], function (data) {
                if (data === 'true') {
                    messages(
                        'success',
                        'Отзыв успешно скрыт.'
                    );

                    $('#post' + post_id)
                        .removeClass('panel-default')
                        .removeClass('panel-danger')
                        .removeClass('panel-success')
                        .addClass('panel-primary');

                    if (status === 0) {
                        temp = parseInt(counters.unpublished.text()) - 1;
                        counters.unpublished.empty().append(temp);
                    }

                    if (status === 2) {
                        temp = parseInt(counters.published.text()) - 1;
                        counters.published.empty().append(temp);
                    }

                    temp = parseInt(counters.hidden.text()) + 1;
                    counters.hidden.empty().append(temp);
                } else {
                    messages(
                        'danger',
                        'При скрытии отзыва возникли неполадки.'
                    );
                }
            });
        });

        buttons.remove.on('click', function (e) {
            var post_id = e.currentTarget.parentElement.lastChild.value;

            $.get(paths.remove + post_id, [], function (data) {
                if (data === 'true') {
                    messages(
                        'success',
                        'Отзыв успешно удалён.'
                    );

                    $('#post' + post_id)
                        .removeClass('panel-default')
                        .removeClass('panel-success')
                        .removeClass('panel-primary')
                        .addClass('panel-danger');

                    if (status === 0) {
                        temp = parseInt(counters.unpublished.text()) - 1;
                        counters.unpublished.empty().append(temp);
                    }

                    if (status === 2) {
                        temp = parseInt(counters.published.text()) - 1;
                        counters.published.empty().append(temp);
                    }

                    if (status === 3) {
                        temp = parseInt(counters.hidden.text()) - 1;
                        counters.hidden.empty().append(temp);
                    }
                } else {
                    messages(
                        'danger',
                        'При удалении отзыва возникли неполадки.'
                    );
                }
            });
        });
    });
</script>
@endsection