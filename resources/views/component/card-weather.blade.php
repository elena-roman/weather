<!--weather card-->
<div class="card card-weather">
    <div class="card-body">
        @if (Auth::check())
        <form method="POST" action="{{ route('location.destroy', ['location' => $forecast->getLocationId()]) }}"
              style="position: absolute;right: 1.81rem;">
            @csrf
            <input type="hidden" name="_method" value="delete" />
            <button type="submit"
               class="btn btn-danger btn-fw" >Remove</button>
        </form>
        @endif

        <div class="weather-date-location">
            <h3>{{ \Carbon\Carbon::now('UTC')->dayName }}</h3>
            <p class="text-gray">
                <span class="weather-date">{{ \Carbon\Carbon::now('UTC')->format('d M, Y') }}</span>
                <span class="weather-location">{{ $forecast->getCity() }}, {{ $forecast->getCountry() }}</span>
            </p>
        </div>
        <div class="weather-data d-flex">
            <div class="mr-auto">
                <h4 class="display-3">
                    {{ $forecast->getDegrees() }}
                    <span class="symbol">&deg;</span>C</h4>
                <p>{{ $forecast->getDescription() }}</p>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="d-flex weakly-weather">
            @foreach($forecast->getNextDaysForecast() as $day => $nextDaysForecast)
                <div class="weakly-weather-item">
                    <p class="mb-0">
                        {{ $day }}
                    </p>
                    <i class="mdi mdi-weather-cloudy"></i>
                    <p class="mb-0">
                        {{ $nextDaysForecast->first()['temp'] }}°
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!--weather card ends-->