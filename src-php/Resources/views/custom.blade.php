@if($model->action)
    <a href="{{ $model->action }}">{{ $model->label }}</a>
@else
    <span>{{ $model->label }}</span>
@endif
