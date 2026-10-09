@extends('layouts.app')

@section('title', 'Daftar Post')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Daftar Post</h1>
    </div>

    {{-- Bonus: pencarian --}}
    <form method="GET" action="{{ route('posts.index') }}" class="input-group mb-4">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control"
               placeholder="Cari judul atau isi...">
        <button class="btn btn-primary">Cari</button>
        @if (request('q'))
            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Reset</a>
        @endif
    </form>

    <div class="row g-4">
        @forelse ($posts as $post)
            <div class="col-md-6 col-lg-4">
                <x-card :title="$post->title">
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                             class="img-fluid rounded mb-3">
                    @endif
                    <p class="mb-0 text-muted">{{ \Illuminate\Support\Str::limit($post->body, 110) }}</p>

                    <x-slot:footer>
                        <div class="d-flex gap-2 align-items-center">
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-primary">Lihat</a>
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-warning">Edit</a>

                            <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus post ini?')" class="ms-auto">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </div>
                    </x-slot:footer>
                </x-card>
            </div>
        @empty
            <div class="col-12">
                <x-alert type="info">Belum ada post{{ request('q') ? ' untuk pencarian ini' : '' }}.</x-alert>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
@endsection
