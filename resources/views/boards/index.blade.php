@extends('layouts.app')

@section('content')
    <h1 class="text-3xl">Boards</h1>
    <div class="w-full">
        <button class="btn btn-primary">Add Board</button>
    </div>
    <board-list :boards="{{ $boards }}"></board-list>
@endsection
