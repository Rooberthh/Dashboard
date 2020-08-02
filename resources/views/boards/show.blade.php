@extends('layouts.app')

@section('content')
    <show-board :board="{{ $board }}"></show-board>
@endsection
