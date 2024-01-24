@extends('layout')
@section('head')
    {{-- https://cdn.ckeditor.com/    yeha bata link leko ho hai  --}}
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
@endsection

@section('main')
    <main class="container " style="background: #fff">
        <section id="contact-us">
            <h1 style="padding-top: 50px">Create New Post</h1>
            <form action="" method="">
                {{-- title --}}
                <label for="title"><span>Title</span></label>
                <input type="text" id="title" name="title" />

                {{-- image --}}
                <label for="image"><span>Image</span></label>
                <input type="file" id="image" name="image" />

                {{-- body --}}
                <label for="body"><span>Body</span></label>
                <textarea id="body" name="body"></textarea>

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
