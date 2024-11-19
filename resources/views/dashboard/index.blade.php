@extends('layouts.dashboard.app')
@section('header__title', __('home.Dashboard'))
@section('header__icon', 'fa-solid fa-house')

@section('main')
<div class="container">
    <h1 class="my-4 text-center">City Statistics Dashboard</h1>

    {{-- Filters Card --}}
    <div class="card ">
        <div class="bg-primary text-white text-center">
            <h5 class=" text-white pt-2">Filter by State and City</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard') }}">

                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label for="start_date" class="form-label">Start Date:</label>
                        <input type="date" id="start_date" name="start_date" class="form-control"
                            value="{{ $start_date->toDateString() }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="end_date" class="form-label">End Date:</label>
                        <input type="date" id="end_date" name="end_date" class="form-control"
                            value="{{ $end_date->toDateString() }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="state_id" class="form-label">State</label>
                        <select name="state_id" id="state_id" class="form-control">
                            <option value="">Select State</option>
                            @foreach(App\Models\State::all() as $state)
                            <option value="{{ $state->id }}" {{ request('state_id')==$state->id ? 'selected' : '' }}>
                                {{ $state->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="city" class="form-label">City</label>
                        <select name="city" id="city" class="form-control">
                            <option value="">Select City</option>
                            @if(request('state_id'))
                            @php
                            $cities = App\Models\City::where('state_id', request('state_id'))
                            ->select('name') // Select relevant fields
                            ->groupBy('name') // Group by city name
                            ->distinct() // Ensure unique values
                            ->get();
                            @endphp
                            @foreach($cities as $city)
                            <option value="{{ $city->name }}" {{ request('city')==$city->name ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ms-2">Filter</button>
            </form>
        </div>
    </div>

    {{-- Statistics Card --}}
    <div class="card mt-2">
        <div class="card-body">
            @if($cityStatistics->isEmpty())
            <p class="text-center text-muted">No data available</p>
            @else
            <div class="table-responsive text-nowrap px-4">
                <table class="table" id="myTable">
                    <thead class="table-light">
                        <tr>
                            <th>State</th>
                            <th>Avg PM2.5</th>
                            <th>Avg PM10</th>
                            <th>Avg NO</th>
                            <th>Avg NO2</th>
                            <th>Avg SO2</th>
                            <th>Avg CO</th>
                            <th>Avg Temperature</th>
                            <th>Avg CO2</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cityStatistics as $stat)
                        <tr>
                            <td>{{ $stat->state->name ?? 'Unknown State' }}</td>
                            <td>{{ number_format($stat->avg_pm25, 2) }}</td>
                            <td>{{ number_format($stat->avg_pm10, 2) }}</td>
                            <td>{{ number_format($stat->avg_no, 2) }}</td>
                            <td>{{ number_format($stat->avg_no2, 2) }}</td>
                            <td>{{ number_format($stat->avg_so2, 2) }}</td>
                            <td>{{ number_format($stat->avg_co, 2) }}</td>
                            <td>{{ number_format($stat->avg_temp, 2) }}</td>
                            <td>{{ number_format($stat->avg_co2, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    <div class="card mt-2 p-2" style=" border-radius: 10px;">
        <div class="row">
            <!-- Chart Card -->
            <div class="col-lg-9 col-md-12 mb-3">
                <div class="card-body"
                    style="background: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <h5 class="card-title text-primary" style="font-weight: bold;">{{ __('Air Quality Data') }}</h5>
                    <canvas id="airQualityChart"></canvas>
                </div>
            </div>
            <!-- Map Card -->
            <div class="col-lg-3 col-md-12 mb-3">
                <div class="card-body"
                    style="background: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <iframe class="rounded-top" style="width: 100%; height: 500px; margin-bottom: -6px; border: 0;"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4606108.157943049!2d89.2242367!3d26.3498651!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x374e69d4b6c49dc1%3A0x9c25f4af0d42084a!2sAssam!5e0!3m2!1sen!2sin!4v1694259649153!5m2!1sen!2sin"
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>



</div>
@endsection

@section('scripts-dashboard')
<link href="{{ asset('asset/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stateSelect = document.getElementById('state_id');
        const citySelect = document.getElementById('city');

        stateSelect.addEventListener('change', function () {
            const stateId = this.value;

            // Clear current city options
            citySelect.innerHTML = '<option value="">Select City</option>';

            if (stateId) {
                // Fetch cities for the selected state
                fetch(`/api/cities?state_id=${stateId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.name;
                            option.textContent = city.name;
                            citySelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching cities:', error);
                    });
            }
        });
    });
</script>

<script>
    // Get the data passed from the controller
    const labels = @json($data->pluck("from_date"));  // X-axis labels
    const datasets = [
        {
            label: 'PM2.5 (ug/m3)',
            data: @json($data->pluck("pm25")),
            borderColor: 'rgb(75, 192, 192)',
            fill: false,
            tension: 0.1
        },
        {
            label: 'PM10 (ug/m3)',
            data: @json($data->pluck("pm10")),
            borderColor: 'rgb(255, 99, 132)',
            fill: false,
            tension: 0.1
        },
        {
            label: 'NO (ug/m3)',
            data: @json($data->pluck("No")),
            borderColor: 'rgb(54, 162, 235)',
            fill: false,
            tension: 0.1
        },
        {
            label: 'NO2 (ug/m3)',
            data: @json($data->pluck("No2")),
            borderColor: 'rgb(255, 206, 86)',
            fill: false,
            tension: 0.1
        },
        {
            label: 'NOx (ug/m3)',
            data: @json($data->pluck("NOx")),
            borderColor: '#000',
            fill: false,
            tension: 0.1
        },
        {
            label: 'NH3 (ug/m3)',
            data: @json($data->pluck("NH3")),
            borderColor: 'rgb(255, 0, 0)',
            fill: false,
            tension: 0.1
        },
        {
            label: 'So2 (ug/m3)',
            data: @json($data->pluck("So2")),
            borderColor: 'rgb(0, 255, 0)',
            fill: false,
            tension: 0.1
        },
        {
            label: 'CO (ug/m3)',
            data: @json($data->pluck("CO")),
            borderColor: 'rgb(0, 0, 255)',
            fill: false,
            tension: 0.1
        },
        {
            label: 'AT (ug/m3)',
            data: @json($data->pluck("AT")),
            borderColor: '#795548',
            fill: false,
            tension: 0.1
        },
        {
            label: 'Temp (ug/m3)',
            data: @json($data->pluck("Temp")),
            borderColor: '#607d8b',
            fill: false,
            tension: 0.1
        },
        {
            label: 'CO2 (ug/m3)',
            data: @json($data->pluck("CO2")),
            borderColor: '#FF5722 ',
            fill: false,
            tension: 0.1
        },
        {
            label: 'CH4 (ug/m3)',
            data: @json($data->pluck("CH4")),
            borderColor: '#cddc39 ',
            fill: false,
            tension: 0.1
        },
    ];

    // Create the chart
    const ctx = document.getElementById('airQualityChart').getContext('2d');
    const airQualityChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Concentration (ug/m3)'
                    },
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
