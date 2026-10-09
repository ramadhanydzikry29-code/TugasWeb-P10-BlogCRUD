{{-- Dipakai bersama oleh create & edit. Variabel $post bisa null (saat create). --}}

<div class="mb-3">
    <label for="title" class="form-label">Judul</label>
    <input type="text" id="title" name="title"
           value="{{ old('title', $post?->title) }}"
           class="form-control @error('title') is-invalid @enderror">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="body" class="form-label">Isi</label>
    <textarea id="body" name="body" rows="6"
              class="form-control @error('body') is-invalid @enderror">{{ old('body', $post?->body) }}</textarea>
    @error('body')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="image" class="form-label">Gambar (opsional, maks 2 MB)</label>
    <input type="file" id="image" name="image"
           class="form-control @error('image') is-invalid @enderror">
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if ($post?->image)
        <img src="{{ asset('storage/' . $post->image) }}" class="img-thumbnail mt-2" style="max-height:120px" alt="">
    @endif
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('posts.index') }}" class="btn btn-secondary">Batal</a>
