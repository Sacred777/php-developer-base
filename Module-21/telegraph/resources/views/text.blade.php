<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Telegtaph</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        ul {
            list-style: none;
        }

        li {
            position: relative;
        }

        .delete-form {
            position: absolute;
            bottom: 12px;
            left: 100px;
        }

    </style>
</head>
<body class="">
<div class="container">
    <h1 class="mb-3">The Telegraph posts</h1>

    <section class="section mb-5">
        <h2>New post</h2>
        <form action="/" method="post">
            @csrf
            <div class="form-group">
                <label class="d-block">
                    Author
                    <input class="form-control" type="text" name="author">
                </label>
            </div>
            <div class="form-group">
                <label class="d-block">
                    Title
                    <input class="form-control" type="text" name="title">
                </label>
            </div>
            <div class="form-group">
                <label class="d-block">
                    Text
                    <textarea class="form-control" type="text" name="text"></textarea>
                </label>
            </div>
            <input class="btn btn-primary" type="submit" value="Add post">

        </form>
    </section>

    <section class="section">
        <h2>All posts</h2>
        <ul class="list-group">
            @foreach($posts as $post)
                <li class="list-group-item">
                    <h3>Post #:{{$post->id}}</h3>
                    <form class="form" method="POST" action="/">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <label class="form-group col-md-6">
                                Title:
                                <input class="form-control" type="text" name="title" value='{{$post->title}}'>
                            </label>
                            <label class="form-group col-md-6">
                                Text:
                                <textarea class="form-control" type="text" name="text">{{$post->text}}</textarea>
                            </label>
                        </div>
                        <div class="form-row">
                            <label class="form-group col-md-6">
                                Author:
                                <input class="form-control" type="text" name="author" value='{{$post->author}}'>
                            </label>
                            <label class="form-group col-md-6">
                                Published:
                                <input class="form-control" type="text" name="created_at" value='{{$post->created_at}}'
                                       readonly>
                            </label>
                        </div>
                        <input type="hidden" name='id' value='{{$post->id}}'>
                        <input class="btn btn-success" type="submit" value="Edit">
                    </form>
                    <form class="delete-form" action="/" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name='id' value='{{$post->id}}'>
                        <input class="btn btn-danger" type="submit" value="Delete">
                    </form>
                </li>
            @endforeach
        </ul>
    </section>
</div>
</body>
</html>
