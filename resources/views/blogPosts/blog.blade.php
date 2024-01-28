@extends('layout')

@section('main')
    <main class="container">
        <h2 class="header-title">All Blog Posts</h2>
        @include('includes.flash-message')
        <div class="searchbar">
            <form action="">
                <input type="text" placeholder="Search..." name="search" />

                <button type="submit">
                    <i class="fa fa-search"></i>
                </button>

            </form>
        </div>
        <div class="categories">
            <ul>

                @foreach ($categories as $category)
                    <li><a href="">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>
        <section class="cards-blog latest-blog">

            @forelse ($posts as $post)
                <div class="card-blog-content">
                    @auth
                        @if (auth()->user()->id === $post->user->id)
                            <div class="post-buttons" style="display: flex;padding-bottom: 10px">
                                <a href="{{ route('blog.edit', $post) }}"
                                    style="padding: 9px; background: green; color: white; margin-right: 4px">Edit</a>
                                <form action="{{ route('blog.destroy', $post) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" value="Delete"
                                        style="padding: 10px; background: red; color: white; border: 1px solid red" />
                                </form>
                            </div>
                        @endif
                    @endauth
                    <img src="{{ asset($post->imagePath) }}" alt="" />
                    <p>
                        {{ $post->created_at->diffForHumans() }}
                        <span>{{ $post->user->name }}</span>
                    </p>
                    <h4>
                        <a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
                    </h4>
                </div>
            @empty
                <p style="text-align:center">Sorry, currently there is no blog post related to that search</p>
            @endforelse


        </section>
        <!-- pagination -->
        {{-- <div class="pagination" id="pagination">
            <a href="">&laquo;</a>
            <a class="active" href="">1</a>
            <a href="">2</a>
            <a href="">3</a>
            <a href="">4</a>
            <a href="">5</a>
            <a href="">&raquo;</a>
        </div> --}}
        {{ $posts->links() }}
        <br />

    </main>
@endsection
