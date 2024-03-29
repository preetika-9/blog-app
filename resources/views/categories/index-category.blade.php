@extends('layout')
@section('main')
    <div>
        <h1>Categories List</h1>
        @include('includes.flash-message')

        @foreach ($categories as $category)
            <div class="item" style="display: flex; justify-content: center; align-item: center">
                <p>{{ $category->name }}</p>
                <div>
                    <a href="{{ route('categories.edit', $category) }}"
                        style="padding: 9px; background: green; color: white; margin-right: 4px">Edit</a>
                </div>
                <form action="{{ route('categories.destroy', $category) }}" method="post">
                    @method('delete')
                    @csrf
                    <input type="submit" value="Delete"
                        style="padding: 3px; background: red; color: white; border: 1px solid red">
                </form>
            </div>
        @endforeach
        <div class="index-categories">
            <a href="{{ route('categories.create') }}">Create Category</a>
        </div>
    </div>
@endsection
