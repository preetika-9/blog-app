@extends('layout')
@section('head')
    {{-- https://cdn.ckeditor.com/    yeha bata link leko ho hai  --}}
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
@endsection

@section('main')
    <main class="container " style="background: #fff">
        <section id="contact-us">
            <h1 style="padding-top: 50px">Edit Category!</h1>
            {{-- success message --}}
            @if (session('status'))
                <p style="color:green; padding-button: 10px;" class="text-center">{{ session('status') }}</p>
            @endif
            <form action="{{ route('categories.update', $category) }}" method="post"> {{-- to deal with file enctype multipart is imp --}}
                @method('put')
                @csrf
                {{-- title --}}
                <label for="name"><span>Name</span></label>
                <input type="text" id="name" name="name" value="{{ $category->name }}" />
                @error('name')
                    <p style="color: red; margin-bottom: 10px">{{ $message }}</p>
                @enderror

                {{-- button --}}
                <input type="submit" value="Submit" />
            </form>

            <div class="create-categories" style="padding-bottom: 10px">
                <a href="{{ route('categories.index') }}">Categories List</a>
            </div>
        </section>
    </main>
@endsection
