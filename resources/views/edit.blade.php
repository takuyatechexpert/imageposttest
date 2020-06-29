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

    {{Form::open(['url' => route('post.update', ['id'=> $post->id]), 'files' => true])}}
      @csrf
      {{Form::file('file', ['class'=>'date'])}}
      {{Form::text('title', $post->title, ['placeholder' => 'temp'])}}
      {{Form::text('content', $post->content, ['placeholder' => 'temp'])}}
      {{Form::submit('Send', ['class'=>'submit'])}}
    {{Form::close()}}
</main>
@endsection