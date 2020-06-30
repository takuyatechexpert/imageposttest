<?php

namespace App\Http\Controllers;

// Intervention Imageを使う為に2つ追加した
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::all();
        return view('index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        ini_set('memory_limit', '256M');
        //
        $post = new Post;
        $filename = $request->file('file');
        // $image = $filename->store('public')
        
        // パターン1
        // $filename = $request->file('file');
        // $name = basename($filename . '.jpeg');
        // basename()はpath情報をカットしてファイル名だけにしてくれるイメージ
        // Image::make($filename)->resize(300, 300)->save( public_path('/images/' . $name ) );
        // public_pathはpublicディレクトリに保存する本当はstorageディレクトリに保存したい
        // データベースにはファイル名を入れる
        // $post->image = $name;
        
        // パターン2
        // よく分からないがこれでresizeできるresize(横, 縦)
        // Image::makeは画像をキャッチできる
        $image = Image::make($filename)
        ->resize(1000, null, function ($constraint) {
        $constraint->aspectRatio();
        });
        // ファイル名の設定
        $name = $image->basename . '.jpeg';

        // storage::dixkについて公式ドキュメントを見ると初期はlocalでpathはstorage/app
        // シンボルリンクを貼って保存したい場所はstorage/app/publicに保存したい
        // その為に 'public' を指定する事した
        // $image->encode()で画像情報を取得できた
        Storage::disk('public')->put($name, $image->encode());

        $post->image = $name;
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();

        return redirect()->route('post.index')->with('success', '投稿が完了しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::find($id);
        return view('edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        //
        $post = Post::find($id);
        $filename = $request->file->store('public');

        $post->image = basename($filename);
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->update();

        return redirect()->route('post.index')->with('success', '更新が完了しました');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
