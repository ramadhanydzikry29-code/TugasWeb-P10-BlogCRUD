@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <h1 class="h3 mb-3">Edit Post</h1>

    <x-card>
        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('posts._form', ['post' => $post])
        </form>
    </x-card>
@endsection
