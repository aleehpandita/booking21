@php
	use Carbon\Carbon;
@endphp
@extends('layout')

@section('title', __('reservation.title'))
@section('navbar_style', 'bg-dark')
@section('content')
<section class="section">
	<div class="container mt-4">
		<div class="card mb-3 border-0 shadow rounded-3">
			<div class="card-body">
        <h2 class="highlighted" >Hi <?php  echo ucwords(strtolower($r->data->customer_name)) ?>!</h2>
				
	      <h5 class="fw-light">Your reservation with ID <strong><?php  echo $r->data->reservation_id ?></strong> is <strong class="text-success">confirmed</strong>.</h5>

			</div>
		</div>

		<div class="card mb-3 border-0 shadow rounded-3">
			<div class="card-body">
				<h5 class="card-title">Reservation Details</h5>
				<p class="m-0"><span class="form-label m-0 text-secondary">From:</span> <?php echo ucwords(strtolower($r->data->hotel_from_name)) ?></p>
				<p class="m-0"><span class="form-label m-0 text-secondary">To:</span> <?php echo ucwords(strtolower($r->data->hotel_to_name)) ?></p>
				<p class="m-0"><span class="form-label m-0 text-secondary">Passengers:</span> <?php echo ucwords(strtolower($r->data->pax)) ?></p>
				<p class="m-0"><span class="form-label m-0 text-secondary">Service:</span> <?php echo ucwords(strtolower($r->data->vehicle)) ?> </p>
				<p class="m-0"><span class="form-label m-0 text-secondary">Type:</span> <?php echo ucwords(strtolower(str_replace('_', ' ', $r->data->service_type))) ?></p>
				
					<p class="m-0"><span class="form-label m-0 text-secondary">{{ __('reservation.arrivalDateTime') }}</span> {{ Carbon::createFromFormat('Y-m-d H:i:s', $r->data->arrival_date)->translatedFormat('D M Y H:i') }}</p>
					<p class="m-0"><span class="form-label m-0 text-secondary">{{ __('reservation.arrivalAirline') }}</span> {{ $r->data->arrival_airline }}</p>
					<p class="m-0"><span class="form-label m-0 text-secondary">{{ __('reservation.arrivalFlight') }}</span> {{ $r->data->arrival_flight }}</p>
					{{-- <p class="m-0"><span class="form-label m-0 text-secondary">{{ __('reservation.arrivalTerminal') }}</span> {{ $r->data->arrivalTerminal }}</p> --}}
				
				<p class="fs-5 text-success"><span class="small text-secondary">Total</span> {{ number_format($r->data->total, 2) }}{{ isset($r->data->currency) ? $r->data->currency : app('CURRENCY')->value }}</p>
			</div>
		</div>
	</div>
</section>
@endsection
