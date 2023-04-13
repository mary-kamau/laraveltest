@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-body">
               @foreach ($tags as $tag )
                  <h1>{{ $tag->name }}</h1>
                  <ul>
                    @foreach ( $tag->posts as $post )
                      <li>{{ $post->title }}</li>
                    @endforeach
                  </ul>
                @endforeach
             </div>
        </div>
    </div>
</div>