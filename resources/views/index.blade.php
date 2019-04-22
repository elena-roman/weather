@section('content')

    @foreach($forecasts as $forecast)
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                @component('component.card-weather',  ['forecast' => $forecast])@endcomponent
            </div>
        </div>
    @endforeach

@endsection