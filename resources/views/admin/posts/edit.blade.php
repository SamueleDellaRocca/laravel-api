@extends('layouts.app')

@section('pagetitle')
    Edita Post
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('admin.posts.update', $post->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <div class="form-group mb-4">
                <label for="title">Titolo</label>
                <input type="text" class="form-control mb-2" id="title" name="title" placeholder="Titolo"
                    value="{{ old('title', $post->title) }}">
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>



            <div class="form-group mb-4">
                <label for="slug">Slug</label>
                <input type="text" class="form-control mb-2" id="slug" name="slug" placeholder="Slug"
                    value="{{ old('slug', $post->slug) }}">
                @error('slug')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>



            <div class="input-group mb-3">
                <select class="custom-select input-group-text w-100 text-start" id="category_id" name="category_id">
                    <option selected>Scegli una categoria</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id == old('category_id', $post->category->id)) selected @endif>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="post_image" class="form-label">Post image</label>
                <input class="form-control" type="file" id="post_image" name="post_image" accept="image/*">
                @error('post_image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <img src="{{ asset('storage/' . $post->post_image) }}" alt="" class="img-fluid">


            <div class="mb-3">
                <fieldset>
                    <legend>Tags</legend>
                    <div class="d-flex gap-5">
                        @foreach ($tags as $tag)
                            <div>
                                <input type="checkbox" name="tags[]" id="tag-{{ $tag->id }}"
                                    value="{{ $tag->id }}" @if (in_array($tag->id, old('tags', $post->tags->pluck('id')->all()))) checked @endif>
                                <label for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </fieldset>
            </div>



            <div class="form-group mb-4">
                <label for="content">Content</label>
                <textarea class="form-control mb-2" id="content" name="content" placeholder="Content"
                    rows="5">{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
