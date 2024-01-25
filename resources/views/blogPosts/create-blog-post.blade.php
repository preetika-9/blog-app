@extends('layout')
@section('head')
    {{-- https://cdn.ckeditor.com/    yeha bata link leko ho hai  --}}
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
@endsection

@section('main')
    <main class="container " style="background: #fff">
        <section id="contact-us">
            <h1 style="padding-top: 50px">Create New Post</h1>
            {{-- success message --}}
            @if (session('status'))
                <p style="color:green; padding-button: 10px;" class="text-center">{{ session('status') }}</p>
            @endif
            <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data"> {{-- to deal with file enctype multipart is imp --}}
                @csrf
                {{-- title --}}
                <label for="title"><span>Title</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" />
                @error('title')
                    <p style="color: red; margin-bottom: 10px">{{ $message }}</p>
                @enderror

                {{-- image --}}
                <label for="image"><span>Image</span></label>
                <input type="file" id="image" name="image" />
                @error('image')
                    <p style="color: red; margin-bottom: 10px">{{ $message }}</p>
                @enderror

                {{-- body --}}
                <label for="body"><span>Body</span></label>
                <textarea id="body" name="body">{{ old('body') }}</textarea>
                @error('body')
                    <p style="color: red; margin-bottom: 10px">{{ $message }}</p>
                @enderror

                {{-- button --}}
                <input type="submit" value="Submit" />
            </form>
        </section>
    </main>
@endsection

@section('script')
    <script>
        CKEDITOR.replace('body');
    </script>
@endsection
