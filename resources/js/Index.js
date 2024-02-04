import {APP_URL} from './Config'
import loader from './Loader'
import {inputPhone} from './InputPhone'
const to_hotel = document.getElementById('hotel')
const spiner_to_hotel = document.getElementById('spiner_to_hotel')
const to_hotel_id = document.getElementById('to_hotel_id')
import flatpickr from "flatpickr";
$(to_hotel).autocomplete({
	minLength: 3,
	appendTo: '#wrap-hotel',
  source: function(request, response) {
  	spiner_to_hotel.classList.remove('d-none')
    $.ajax({
      url: APP_URL+'search-hotels/'+request.term,
      dataType:'json',
      success: function(jsonResponse) {
      	spiner_to_hotel.classList.add('d-none')
      	return response(jsonResponse.data)
      }
    });
  },
  close: function( event, ui ) {
  	if (to_hotel_id.value.length == 0) {
  		to_hotel.value = ''
  	}
  },
  search: function( event, ui ) {
    to_hotel_id.value = ''
  },
  focus: function( event, ui ) {
    to_hotel.value =  ui.item.label
    return false;
  },
  select: function( event, ui ) {
    this.value = ui.item.label;
    to_hotel_id.value = ui.item.id
    return false;
  },
  response: function(event, ui) {
		if (!ui.content.length) {
		  var noResult = { value:"",label:"No results found" };
		  ui.content.push(noResult);
		}
	}
})
$('#booking_form').validate({
  submitHandler: function(form) {
    loader.open()
    $.ajax({
      url: $(form).attr('action'),
      method:"post",
      dataType:"json",
      data:$(form).serialize()
    })
    .then(data => {
      console.log(data);
      window.location = data.url
    })
    .catch((XMLHttpRequest, textStatus, errorThrown) => {
      loader.close()
      console.log('errorThrown', errorThrown);
    })
  },
  validClass: 'is-valid',
  ignore: '.ignore',
  errorClass: 'is-invalid',
  errorPlacement: function(error, element) {
    if (element.attr('name') == 'to_hotel_id') {
      element.parent().find('#hotel').addClass('is-invalid')
    }
    //element.addClass('is-invalid')
  }
  //validClass: 'is-valid',
})
const arrivalDateTime  = flatpickr('#arrival_date', {
  enableTime: true,
  dateFormat: "Y-m-d H:i",
  disableMobile: "true"
});
const eleInputPhone = inputPhone('customer_phone', {
  initCountry:'mx'
})
eleInputPhone.addEventListener('on-select-country', (e) => {
  //document.getElementById('dial_code').value = e.detail.dialCode
  document.getElementById('country').value = e.detail.iso2
})
eleInputPhone.setCountry('mx')