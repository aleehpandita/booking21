@extends('layout')
 
@section('title', __('home.title'))
@section('content')
<div class="container-lg pt-5">
	<div class="row">
		<div class="col-md-5 mb-4">
			<div class="sticky-top" style="top:80px">
				<div class="card border-0 shadow-sm rounded-3 overflow-hidden">
		  		<div class="card-body pb-0">
		  			<h5 class="card-title mb-3 d-flex align-items-center text-primary"> Booking-summary </h5>
		  			<div class="border-bottom boder-secondary-subtle mb-3">
	        		<p class="m-0 fw-semibold">Arrival</p>
		  			</div>
		  			<div class="border-bottom boder-secondary-subtle mb-3">
		  				<span class="form-label d-block m-0 text-secondary">Service</span>
	        		<p class="m-0 fw-semibold">Van (Standar private)</p>
		  			</div>
						<img class="w-100" src="https://www.feraltar.com/imghttps/van.png" alt="Van">
		  		</div>
		  	</div>
		  </div>
		</div>
		<div class="col-md-7">
			<div class="card border-0 shadow-sm">
			  <div class="card-body">
			    <h5 class="card-title">Ingrese reservacion</h5>
			    <form id="booking_form" class="row" action="{{route('create-reservation')}}">
					  <div id="wrap-hotel" class=" col-12 mb-3 position-relative">
					    <label for="hotel" class="form-label">Hotel</label>
					    <input type="text" class="form-control" id="hotel" aria-describedby="emailHelp">
					    <div id="hotelHelp" class="form-text">Seleccione un hotel del listado.</div>
					    <div id="spiner_to_hotel" class="spinner-grow spinner-grow-sm text-primary position-absolute d-none" role="status" style="top: 42px;right:20px;">
							  <span class="visually-hidden">Loading...</span>
							</div>
							<input class="d-none" type="text" id="to_hotel_id" name="to_hotel_id" required value="">
					  </div>
					  <div class="col-md-9 mb-3">
					    <label for="customer_name" class="form-label">Customer name</label>
					    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
					  </div>
					  <div class="col-md-3 mb-3">
					    <label for="pax" class="form-label">Pax</label>
					    <input type="number" class="form-control" id="pax" name="pax" min="1" required>
					  </div>
					  <div class="col-md-6 mb-3">
					    <label for="customer_email" class="form-label">Email</label>
					    <input type="email" class="form-control" id="customer_email" name="customer_email" required>
					  </div>
					  <div class="col-md-6 mb-3">
					    <label for="customer_phone" class="form-label">Phone</label>
					    <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
					    <input type="hidden" id="country" name="country">
					  </div>
					  
					  <div class="col-md-4 mb-3">
					    <label for="arrival_airline" class="form-label">Arrival Airline</label>
					    <input type="text" class="form-control" id="arrival_airline" name="arrival_airline" required>
					  </div>
					  <div class="col-md-4 mb-3">
					    <label for="arrival_flight" class="form-label">Arrival flight</label>
					    <input type="text" class="form-control" id="arrival_flight" name="arrival_flight" required>
					  </div>
					  <div class="col-md-4 mb-3">
					    <label for="arrival_date" class="form-label">Arrival date</label>
					    <input type="text" class="form-control" id="arrival_date" name="arrival_date" required>
					  </div>
					  <div class="col-md-12 mb-3">
						  <label for="special_request" class="form-label">Special request</label>
						  <textarea class="form-control" id="special_request" name="special_request" rows="3"></textarea>
						</div>
						<div class="col-md-6 mb-3">
					    <label for="total" class="form-label">Total</label>
					    <input type="number" class="form-control" id="total" name="total" required>
					  </div>
						<div class="col-md-3 mb-3">
						  <label for="currency" class="form-label">Currency</label>
							<select class="form-select" id="currency" name="currency" required>
							  <option value="" selected>Select</option>
							  <option value="mxn">MXN</option>
							  <option value="usd">USD</option>
							</select>
					  </div>
					  <input type="hidden" id="services_id" value="2">{{-- standar private (van) --}}
					  {{-- <img src="https://www.feraltar.com/imghttps/van.png" alt="Van"> --}}
					  <button type="submit" class="btn btn-primary">Submit</button>
					</form>
			  </div>
			</div>
		</div>
		
	</div>
</div>
@endsection