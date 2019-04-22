@section('content')
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Location Form</h4>
                            <form class="forms-sample" method="POST" onclick="destroy()"
                                  action="{{ action('Dashboard\LocationController:@store', ['location' => $location->id]) }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="countryInput" class="col-sm-3 col-form-label">Country</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="country_alpha2code" id="countryInput">
                                            @foreach($countries as $alpha2code => $country)
                                            <option value="{{ $alpha2code }}">{{ $country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cityInput" class="col-sm-3 col-form-label">City</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="city" id="cityInput" placeholder="City">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection