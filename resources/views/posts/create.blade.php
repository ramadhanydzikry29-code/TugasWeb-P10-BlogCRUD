@extends('layouts.app')

@section('title', 'Tambah Post')

@section('content')
    <h1 class="h3 mb-3">Tambah Post</h1>

    <x-card>
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('posts._form', ['post' => null])
        </form>
    </x-card>
@endsection
