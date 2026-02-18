@extends('layouts.standardpage')
@section('content')
    <livewire:book-read  book_id="{{ $slug }}" />
@endsection