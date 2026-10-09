<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // GET /posts  (+ pencarian ?q=...  + pagination)
    public function index(Request $request)
    {
        $posts = Post::query()
            ->when($request->q, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%")
                      ->orWhere('body', 'like', "%{$keyword}%");
                });
            })
            ->latest()
            ->paginate(6)
            ->withQueryString(); // supaya ?q= tidak hilang saat pindah halaman

        return view('posts.index', compact('posts'));
    }

    // GET /posts/create
    public function create()
    {
        return view('posts.create');
    }

    // POST /posts
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        try {
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('posts', 'public');
            }

            Post::create($data);

            return redirect()->route('posts.index')
                ->with('success', 'Post berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return back()->withInput()
                ->with('error', 'Gagal menyimpan post: ' . $e->getMessage());
        }
    }

    // GET /posts/{post}  -> Route Model Binding: Laravel otomatis Post::findOrFail($id)
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    // GET /posts/{post}/edit
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    // PUT/PATCH /posts/{post}
    public function update(Request $request, Post $post)
    {
        $data = $request->validate($this->rules());

        try {
            if ($request->hasFile('image')) {
                if ($post->image) {
                    Storage::disk('public')->delete($post->image); // hapus gambar lama
                }
                $data['image'] = $request->file('image')->store('posts', 'public');
            }

            $post->update($data);

            return redirect()->route('posts.show', $post)
                ->with('success', 'Post berhasil diperbarui!');
        } catch (\Throwable $e) {
            return back()->withInput()
                ->with('error', 'Gagal memperbarui post: ' . $e->getMessage());
        }
    }

    // DELETE /posts/{post}  -> soft delete (data tetap ada di DB, deleted_at terisi)
    public function destroy(Post $post)
    {
        try {
            $post->delete();

            return redirect()->route('posts.index')
                ->with('success', 'Post berhasil dihapus!');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus post: ' . $e->getMessage());
        }
    }

    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:150'],
            'body'  => ['required', 'string', 'min:20'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
