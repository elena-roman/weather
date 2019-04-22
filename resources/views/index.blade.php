@section('content')

    <div class="row">
    @foreach($forecasts as $forecast)
        <div class="col-lg-6 grid-margin stretch-card">
            @component('component.card-weather',  ['forecast' => $forecast])@endcomponent
        </div>
    @endforeach
    </div>

@endsection