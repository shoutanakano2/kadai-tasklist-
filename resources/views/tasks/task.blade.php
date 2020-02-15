@extends('layouts.app')

@section('content')

<ul class="media-list">
    @foreach ($tasks as $task)
        <li class="media mb-3">
          
            <div class="media-body">
 
 
                <div>
                    <p class="mb-0">{!! nl2br(e($task->content)) !!}</p>
                    <p class="mb-0">{!! nl2br(e($task->status)) !!}</p>
                </div>
                <div>
                    @if (Auth::id() == $task->user_id)
                        {!! Form::open(['route' => ['tasks.destroy', $task->id], 'method' => 'delete']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </li>
    @endforeach
</ul>
{{ $tasks->links('pagination::bootstrap-4') }}

@endsection
