@extends('layout')
@section('head')
    {{-- https://cdn.ckeditor.com/    yeha bata link leko ho hai  --}}
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
@endsection

@section('main')
    <main class="container " style="background: #fff">
        <section id="contact-us">
            <h1 style="padding-top: 50px">Create New Category!</h1>
            {{-- success message --}}
            @if (session('status'))
                <p style="color:green; padding-button: 10px;" class="text-center">{{ session('status') }}</p>
            @endif
            <form action="{{ route('categories.store') }}" method="post"> {{-- to deal with file enctype multipart is imp --}}
                @csrf
                {{-- title --}}
                <label for="name"><span>Name</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" />
                @error('name')
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
