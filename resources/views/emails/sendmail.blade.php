@component('mail::message')


    hello dear
    the status of "{{$content->title}}" task  updated to
    {{ $content->status == \FatemeMahmoodi\LaravelToDo\Enums\TaskStatus::OPEN ? 'open':'close' }}

    Thanks
    {{ config('app.name') }}
@endcomponent
