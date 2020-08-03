@extends('layouts.app')

@section('content')
    <calendar :calendars="{{ $calendars }}"></calendar>
@endsection
