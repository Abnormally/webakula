@extends('layouts.app')

@section('stylesheets')
<style type="text/css">
    .api-body {
        word-break: break-word;
        overflow: hidden;
        max-height: 200px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <button role="button" value="{{ route('api.posts.all') }}" class="btn btn-primary api-posts" data-toggle="modal" data-target="#api-modal">Все записи</button>
    <button role="button" value="{{ route('api.posts.actual') }}" class="btn btn-primary api-posts" data-toggle="modal" data-target="#api-modal">Актуальные записи</button>
    <button role="button" value="{{ route('api.posts.deleted') }}" class="btn btn-primary api-posts" data-toggle="modal" data-target="#api-modal">Удалённые записи</button>
</div>
<div class="container">
    <label role="button" class="btn btn-success api-load">
        Загрузить записи из .json
        <input type="file" class="hidden">
        <input type="hidden" value="{{ route('admin.posts.import') }}">
    </label>
</div>

<div id="api-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Данные с сервера</h4>
            </div>

            <div class="modal-body api-body">

            </div>

            <div class="modal-footer">
                <a type="button" class="btn btn-default api-download" href="">Скачать</a>
                <button type="button" class="btn btn-default" href="" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var api_button = {
            json: $('.api-posts'),
            download: $('.api-download'),
            load: $('.api-load'),
            body: $('.api-body')
        };

        api_button.json.on('click', function (event) {
            var file_name = event.currentTarget.value.split('/').pop() + '.json';

            $.get(event.currentTarget.value, function (data) {
                api_button.body.empty().append('<p>Ваши данные подготовлены и теперь вы можете их скачать как ' + file_name + ' .</p>');
                api_button.download.attr('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(data));
                api_button.download.attr('download', file_name);
            });
        });

        api_button.load.find('input').on('change', function () {
            var formData = new FormData();
            formData.append('posts', api_button.load.find('input[type="file"]')[0].files[0]);

            $.ajax({
                url: api_button.load.find('input[type="hidden"]').val(),
                method: "POST",
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (!response.errors)
                        new Noty({
                            layout: 'bottomLeft',
                            type: 'success',
                            text: 'Изменения внесены.',
                        }).show();
                    else
                        new Noty({
                            layout: 'bottomLeft',
                            type: 'success',
                            text: response.answer,
                        }).show();
                },
                error: function (error) {
                    console.log(error);

                    new Noty({
                        layout: 'bottomLeft',
                        type: 'warning',
                        text: 'Произошёл сбой на сервере. Приносим извенения за неполадки.',
                    }).show();
                }
            });
        });
    });
</script>
@endsection