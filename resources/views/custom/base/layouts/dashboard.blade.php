@extends(backpack_view('blank'))

@section('before_content_widgets')
    <div class="row">
        @include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('section', 'before_content')->toArray() ])
    </div>
@endsection