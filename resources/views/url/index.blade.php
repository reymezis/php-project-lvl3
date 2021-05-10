@extends('layouts.app')

@section('content')
    @if (Session::has('status'))
        <div class="alert alert-success ">
            {{ session('status') }}
        </div>
    @endif
    <h1>Сайты</h1>
    @unless ($urls->isEmpty())
        <ol>
            @foreach($urls as $url)
                <li>
                    <h2><a href="{{ route('urls.show', $url->id) }}">{{$url->name}}</a></h2>
                </li>
            @endforeach
        </ol>

    @endunless
@endsection
