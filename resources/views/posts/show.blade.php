@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <x-card :title="$post->title">
        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                 class="img-fluid rounded mb-3">
        @endif

        <p class="text-muted small">Dibuat {{ $post->created_at->format('d M Y H:i') }}</p>
        <div style="white-space: pre-line">{{ $post->body }}</div>

        <x-slot:footer>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
            <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning btn-sm">Edit</a>
        </x-slot:footer>
    </x-card>
@endsection
