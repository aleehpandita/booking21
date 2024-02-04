import './bootstrap';
import '../sass/app.scss'; 
import 'jquery-ui/dist/jquery-ui';
import 'jquery-validation';

import * as bootstrap from 'bootstrap'

import './Index.js'

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
import.meta.glob([
  '../images/**'
]);