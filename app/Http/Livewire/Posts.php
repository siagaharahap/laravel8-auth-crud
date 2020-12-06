<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class Posts extends Component
{
    public $posts;
    public $postId,$judul,$deskripsi;
    public $isOpen = 0;


    public function render()
    {
        $this->posts = Post::all();
        return view('livewire.posts');
    }

    public function showModal()
    {
        $this->isOpen=true;
    }

    public function hideModal()
    {
        $this->isOpen=false;
    }

    public function store()
    {
        $this->validate(
            [
                'judul' => 'required',
                'deskripsi' => 'required',
            ]
            );

        Post::updateOrCreate(['id' => $this->postId], [
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi
        ]);

        $this->hideModal();

        session()->flash('info', $this->postId ? 'Data Berhasil Diubah' : 'Data Berhasil Ditambahkan');

        $this->postId = '';
        $this->judul = '';
        $this->deskripsi = '';
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->postId = $id;
        $this->judul = $post->judul;
        $this->deskripsi = $post->deskripsi;

        $this->showModal();
    }

    public function delete($id)
    {
        Post::find($id)->delete();
    }
}
