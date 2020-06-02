@extends('layouts.app')

@section('content')

<main class="admin__main container">
  <div class="admin__main__title">
    New Post
  </div>

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
      </div>
    @endif

  <form method="POST" action="{{route("post.store")}}" class="admin__main__form" enctype="multipart/form-data">
    {{-- enctype="multipart/form-data"の記述が重要だった
    これがないと画像がアップロードできない --}}
    @csrf
    {{-- fileのnameがcontroller側で重要になる --}}
    <input type="file" name="file" class="admin__main__form--file">
    <input type="text" name="title" class="admin__main__form--title" placeholder="タイトルを入力してください">
    <input type="text" name="content" class="admin__main__form--content" placeholder="タイトルを入力してください">
    <input type="submit" value="Send" class="admin__main__form--submit">
  </form>

  <div>
    <h2>
      Post List
    </h2>
    <ul>
      @foreach($posts as $post)
      <li><img src="{{asset('storage/' . $post->image)}}" alt="投稿画像" width="200px"></li>
      <li>{{$post->title}}</li>
      <li>{{$post->content}}</li>
      <li><button class="btn btn-info">Edit</button></li>
      @endforeach
    </ul>
  </div>
</main>
@endsection