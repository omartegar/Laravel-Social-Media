@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="css/postdetails.css">
@endsection

@section('content')
    <h1>This is the post details</h1>

    <div id='post_container'>
        <header>By : {{ $data->user->name }}</header>
        <div>Post: {{ $data->post_content }}</div>
    </div>

    <div id='comments_container'>
        <header>By: {{ $data->comment->user_id }}</header>
        <div>Comment: {{ $data->comment->comment_body }}</div>
    </div>
@endsection
