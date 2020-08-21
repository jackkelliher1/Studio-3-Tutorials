@extends('layouts.app')
@section('content')
    <h2 class="text-center">My Todos</h2>
    <ul class="list-group py-3 mb-3">
        @forelse($todos as $todo)
            <li class="list-group-item my-2">
                <h5 class="float-left">{{$todo->title}}</h5>
                <div class="clearfix"></div>
                <p>{{ \Illuminate\Support\Str::limit($todo, 500, '...') }}</p>
                <small class="float-right">{{$todo->created_at->diffForHumans()}}</small>
                <a href="{{route('todos.show',$todo->id)}}">Read More</a>
            </li>
        @empty
            <h4 class="text-center">No Todos Found!</h4>
        @endforelse
    </ul>

    <div class="d-flex justify-content-center">
        {{$todos->links('vendor.pagination.bootstrap-4')}} {{-- <- custom pagination view --}}
    </div>
@endsection