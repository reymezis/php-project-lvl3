@extends('layouts.app')

@section('content')
    <div class="text-center">
        <img src="{{URL::asset('/images/seo.jpeg')}}" class="d-block mx-auto mb-4" width="50%">
        <h1 class="display-5 fw-bold">Проверьте сайт на SEO пригодность</h1>
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-6">
                {{Form::open(['url' => route('urls.store'), 'method' => 'POST' ,'class' => 'row row-cols-lg-auto align-items-center'])}}
                <div class="card-body row no-gutters align-items-center">
                <div class="col">
                    {{Form::input('text', 'url[name]', null, ['class' => 'form-control form-control-lg form-control-borderless',
                                    'placeholder' => 'https://ru.wikipedia.org'
                                    ]) }}
                </div>
                <div class="col-auto pl-2">
                    {{Form::input('submit', 'name', 'Проверить', ['class' => 'btn btn-lg btn-primary']) }}
                </div>
                {{Form::close()}}
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger col-auto">
                        {{ $errors->first() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
