<?php
namespace App\Http\Controllers;
use App\Api\Api;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;


class WebController extends Controller
{
  public function __construct()
  {
    $this->api = new \App\Api\Api();
  }
  public function index()
  {
    return view('index');
  }
  public function searchHotels($query)
  {
    //echo $query;exit;
    return response()->json($this->api->searchHotels($query));
  }
  public function createReservation(Request $rq)
  {
    //dump($rq->all());
    /*"access_token":"02f9f00854871b49521061e4ad9f3393f868b3c9",
    "destinationCode":"ct",
    "site_id":"1",*/
    $data = [
      "services_id" => "2",
      "from_id" => "1551",
      "hotels_id" => $rq->get('to_hotel_id'),
      "vendedor" => "1",
      "status" => "confirmed",
      "service_type" => "arrival",
      "payment_type" => "CH",
      "customer_name" => $rq->get('customer_name'),
      "arrival_date" => $rq->get('arrival_date'),
      "arrival_airline" => $rq->get('arrival_airline'),
      "arrival_flight" => $rq->get('arrival_flight'),
      "pax" => $rq->get('pax'),
      "total" => $rq->get('total'),
      "currency" => $rq->get('currency'),
      "contact_email" => $rq->get('customer_email'),
      "contact_phone" => $rq->get('customer_phone'),
      "contact_country" => $rq->get('country'),
      "special_request" => $rq->get('special_request'),
    ];
    /*"creation_date":"2017-10-05 12:00:00",
    "departure_date":"",
    "departure_airline":"",
    "departure_flight":"",
    "pickup_time":"",*/
    $data = $this->api->saveReservation21($data);
    //dd($data);
    return response()->json([
      'url' => route('show-reservation', ['id' => $data->data->reservation_id]),
      //'data' => $data
    ]);
  }
  public function showReservation($id)
  {
    // code...
    $r = $this->api->getReservation21($id);
    //dd($r);
    return view('reservation', compact('r'));
  }
}