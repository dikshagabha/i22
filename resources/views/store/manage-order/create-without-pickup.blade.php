@extends('store.layout-new.app')
@section('title', 'Create order')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chosen/bootstrap-chosen.css') }}">
<link rel="stylesheet" href="{{ asset('css/jquery.typeahead.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />

<link rel="stylesheet" href="{{ asset('css/jquery.dm-uploader.min.css') }}">

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href=" https://printjs-4de6.kxcdn.com/print.min.css">
<style type="text/css">
  .table td {
  text-align: center;   
}
</style>
@endsection
@section('content')
<vs-row vs-justify="center">
  <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="11">
      <ol class="breadcrumb">
          <li class="breadcrumb-item active">Create Order</li>
         
          <li class="breadcrumb-item">Payment</li>
          
      </ol>
    
    <div slot="header">
        <h3>
          Create Order
        </h3>
      </div>
      <div>
        <vs-row vs-justify="center">
         <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="11">
          <a href="{{route('store.create-order.index')}}">
              <vs-button  type="gradient" color="danger" icon="arrow_back"></vs-button>    
          </a>
          <br>
          {{Form::open(['url'=> route('store.create-order'), "id"=>"addFrenchise", 'enctype'=>"multipart/form-data"])}}   
              @csrf
          @include('store.manage-order.form-without-pickup')
           </vs-col>
          <div class="ItemsAdded">
          </div>
          {{Form::close()}}
          <br>     
     
      <br>

      </vs-row>
    </div>
  </vs-col>
</vs-row>
<div id="addressModal" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title">Add Address</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div id="addressForm">
             @include('store.addAddressForm')
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_new_address" data-url="{{route('store.postAddSessionAddress') }}">Save</button>
      </div>
    </div>

  </div>
</div>
<div id="selectAddressModal" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title">Select Address</h4>

         <button type="button" class="btn btn-warning" id="add_address"><i class="fa fa-plus"></i> </button>
      </div>
      <div class="modal-body">
        <div id="selectAddressForm">
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="select_new_address">Save</button>
      </div>
    </div>

  </div>
</div>
<div id="detailsmodal" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Order Details</h4>
      </div>
      <div class="modal-body">
        <div id="detailsbody">
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@endsection

@push('js')
<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
<script src="{{asset('js/jquery.typeahead.min.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<script src="{{ asset('js/jquery.dm-uploader.min.js') }}"></script>

<script>

 
$(document).ready(function(){ 
  
  $("#service").chosen();
  $('[data-fancybox="fancy"]').fancybox();
  var path = "{{ route('store.get-items') }}";  
  $( "#item" ).autocomplete({
      source: function( request, response ) {
          $.ajax({
              dataType: "json",
              type : 'get',
              url: path,
              data:{'query': request.term , 'service':$('#service').val()},
              success: function(data) {
                  $('input.suggest-user').removeClass('ui-autocomplete-loading'); 
                  response(data);
              },
              error: function(data) {
                  $('input.suggest-user').removeClass('ui-autocomplete-loading');  
              }
          });
      },
      minLength: 2,
  });
  $(document).on("change", ".addOn", function(e){
      e.preventDefault();
      $(".error").html(""); 
      console.log(current.data('url'));
      current = $(this);   
      $.ajax({
        url: current.data('url'),
        type:'post',
        data: $('#addonForm'+current.data('id')+' :input').serializeArray(),
        cache: false,
        success: function(data){
          success(data.message);
          $(".ItemsAdded").html(data.view);
          $('body').waitMe('hide');
        }
      })
    })

   $(document).on("change", ".upload_image", function(e){
      e.preventDefault();
      $(".error").html(""); 
      current = $(this);
      i = current.data('id');
      var data = new FormData();
      data.append('id', current.data('id'));
      $.each(current.prop('files'), function(i, file) {
         data.append('files[]', file)
      });
      $.ajax({
        url: current.data('url'),
        type:'post',
        data: data,
        contentType: false,
        processData: false,
        success: function(data){
          success(data.message);
          $(".ItemsAdded").html(data.view);
          $('body').waitMe('hide');
        },
        error: function(data){
          error("Invalid File");
          $('body').waitMe('hide');
        }
      })
    })

  $(document).on('focusout', '#phone_order', function(e){
    
      e.preventDefault(); 
      $(".error").html("")
      $('body').waitMe(); 
      
      $.ajax({
        url: $('#search-user').data('url'),
        type:'post',
        data: {'phone_number':$('#phone_order').val()},
        success: function(data){
          success(data.message);
          if (data.customer) 
          {
              $('#name_order').val(data.customer['name']).prop('readonly', true);
            $('#email_order').val(data.customer['email']).prop('readonly', true);
            $('#phone_number').val(data.customer['phone_number']).prop('readonly', true);
            $("#service").val(data.service).trigger("chosen:updated");
              $('#address_order').text(data.customer.address);
              $("#customer_id").val(data.customer.id);
              $("#address_id").val(data.customer.address_id);
              if (data.address) {
                $('#address_order').text(data.address.address);
                $("#address_id").val(data.address.id);
             }
             $(".customer-details").attr('href', data.customer_details);
             $(".customer-details-div").show();
             $(".select").show();
             $(".add").hide();
              
          }
          $('body').waitMe('hide');
        },
        error: function(data){

           if (data.status==422) {
            $('body').waitMe('hide');
                    var errors = data.responseJSON;
                    for (var key in errors.errors) {
                      console.log(errors.errors[key][0])
                        $("#"+key+"_error").html(errors.errors[key][0])
                      }
          }else{
            $(".customer-details-div").hide();
            $(".select").hide();
            $(".add").show();
            $("#service").val('').trigger("chosen:updated");
            $('#name_order').val('').prop('readonly', false);
            $('#email_order').val('').prop('readonly', false);
            $('#phone_number').prop('readonly', false);
            $('#address_order').text('');
            $("#customer_id").val("");
            $("#address_id").val("");
             $('body').waitMe('hide');
           }
        }

      })
  })

  $(document).on('click', '.customer-details', function(e){
    e.preventDefault();
    current=$(this);
    $.ajax({
      url:current.attr('href'),
      success:function (data) {
        $('#detailsbody').html(data);
        $('#detailsmodal').modal('show');
      }
    })

  })

  $(document).on('click', '#search-user', function(e){
      e.preventDefault(); 
      $(".error").html("")
      $('body').waitMe(); 
      
      $.ajax({
        url: $('#search-user').data('url'),
        type:'post',
        data: {'phone_number':$('#phone_order').val()},
        success: function(data){
          success(data.message);
          if (data.customer) 
          {
              $('#name_order').val(data.customer['name']).prop('readonly', true);
            $('#email_order').val(data.customer['email']).prop('readonly', true);
            $('#phone_number').val(data.customer['phone_number']).prop('readonly', true);

              $('#address_order').text(data.customer.address);
              $("#customer_id").val(data.customer.id);
              $("#address_id").val(data.customer.address_id);
              if (data.address) {
                $('#address_order').text(data.address.address);
                $("#address_id").val(data.address.id);
             }

             $(".select").show();
             $(".add").hide();
              
          }
          $('body').waitMe('hide');
        },
        error: function(data){

           if (data.status==422) {
            $('body').waitMe('hide');
                    var errors = data.responseJSON;
                    for (var key in errors.errors) {
                      console.log(errors.errors[key][0])
                        $("#"+key+"_error").html(errors.errors[key][0])
                      }
          }else{
            error(data.responseJSON.message);
            $(".select").hide();
            $(".add").show();
            $('#name_order').val('').prop('readonly', false);
            $('#email_order').val('').prop('readonly', false);
            $('#phone_number').val('').prop('readonly', false);
            $('#address_order').text('');
            $("#customer_id").val("");
            $("#address_id").val("");
             $('body').waitMe('hide');
           }
        }

      })
    })

  $(document).on("click", "#add_address", function(e){
      e.preventDefault();
      $("#selectAddressModal").modal('hide');
      $('#addressModal').modal('show');
      //$('#formAddress')[0].reset();
    })

   $(document).on("click", "#select_address", function(e){
      e.preventDefault();
      current = $(this);

       $.ajax({
        url: current.data('url'),
        type:'get',
        data: {'user_id' : $('#customer_id').val()},     
        success: function(data){
          $('#selectAddressForm').html(data.view);
          $("#selectAddressModal").modal('show');
          $('body').waitMe('hide');
        }
    })
    })

   $(document).on("click", ".address", function(e){
      e.preventDefault();
      current = $(this);

      $('#address_id').val(current.data('id'));

      $('#address_order').text(current.data('value'));

       $("#selectAddressModal").modal('hide');
    })



  
   $(document).on("click", "#add_address", function(e){
      e.preventDefault();
      $("#selectAddressModal").modal('hide');
      $('#addressModal').modal('show');
      //$('#formAddress')[0].reset();
    })

   $(document).on("change", "#service", function(e){
      e.preventDefault();
      $('body').waitMe();
      current = $(this);
      $.ajax({
        url:current.data('url'),
        data:{'id':current.val()},
        type:'post',
        success: function(data){
        //success(data.message);
        $('#select_box').html(data.view);
        $(".ItemsAdded").html('');
        if (data.form_type==1 || data.form_type==2) {
          $( "#item" ).autocomplete({
                  source: function( request, response ) {
                      $.ajax({
                          dataType: "json",
                          type : 'Get',
                          url: path,
                          data:{'query': request.term , 'service':$('#service').val()},
                          success: function(data) {
                              $('input.suggest-user').removeClass('ui-autocomplete-loading'); 
                              response(data);
                          },
                          error: function(data) {
                              $('input.suggest-user').removeClass('ui-autocomplete-loading');  
                          }
                      });
                  },
                  minLength: 2,
              });
        }
              

        $('body').waitMe('hide');
      }
      });
    })

 
  $(document).on('click', '#add_frenchise', function(e){
    e.preventDefault();
    $('body').waitMe();

    var data = $('#addFrenchise').serializeArray();
    //var data = new FormData(form);
    
    $(".error").html("");
    $.ajax({
      url: $('#addFrenchise').attr('url'),
      type:'post',
      data: data, 
      success: function(data){
        success(data.message);
        window.location = data.redirectTo;
        $('body').windowaitMe('hide');
      }
    })
  
  })

  $(document).on('click', '#add_item', function(e){
    e.preventDefault();
    $('body').waitMe();
    
    $.ajax({
      url:$("#add_item").attr('href'),
      data:{'service':$('#service').val(), 'item':$('#item').val(), 'customer':$('#customer_id').val(),
              'name':$('#name_order').val(), 'phone':$('#phone_order').val()},
      type:'post',
      success:function(data) {
        $(".ItemsAdded").html(data.view);
      }
    })
    //$("#addressModal").modal('show');
    
    $('body').waitMe('hide');
  })

  $('#addressModal').on('shown.bs.modal', function (e) {
    $('#formAddress')[0].reset();
  })
  $(document).on("click", "#add_new_address", function(e){
    e.preventDefault();
    var form = $('#addressForm :input').serializeArray();
    // /var data = new FormData(form);
    form.push({'name':'user_id', 'value': $('#customer_id').val()});
    
    $(".error").html("");    
    $.ajax({
      url: $('#add_new_address').data('url'),
      type:'post',
      data: form,
       
      success: function(data){
        success(data.message);
        if (data.data) 
        {
          for (var key in data.data) {
              $("#"+key+'_order').text(data.data[key]);
          }
        }
        $('#address_id').val(data.data.address_id);
        $("#addressModal").modal('hide');
        $('body').waitMe('hide');
      }
    })
  })

  $(document).on("click", ".deleteItemBtn", function(e){
    e.preventDefault();
    $(".error").html(""); 
    current = $(this);   
    $.ajax({
      url: current.attr('action'),
      type:'post',
      data: {'data-id':current.data('id')},
      cache: false,
      success: function(data){
        success(data.message);
        $(".ItemsAdded").html(data.view);
        $('body').waitMe('hide');
      }
    })
  })

  // $(".quantity").change(function(e) {
  //     e.preventDefault();
  //     $(".error").html(""); 
  //     current = $(this);   
  //     $.ajax({
  //       url: current.data('url'),
  //       type:'post',
  //       data: {'data-id': current.data('id'), 'quantity':$('.quantityVal_'+current.data('id')).val(), 
  //                 'service':current.data('service'), 
  //               'add':current.data('add')},
  //       cache: false,
  //       success: function(data){
  //         success(data.message);
  //         $(".ItemsAdded").html(data.view);
  //         $('body').waitMe('hide');
  //       }
  //     })
  //   });

  $(document).on("change", ".quantity", function(e){
    e.preventDefault();
    $(".error").html(""); 
    if ($(this).val().length === 0) return
    current = $(this);   
    $.ajax({
      url: current.data('url'),
      type:'post',
      data: {'data-id': current.data('id'), 'quantity':$('.quantityVal_'+current.data('id')).val(), 
                'service':current.data('service'), 
              'add':current.data('add')},
      cache: false,
      success: function(data){
        success(data.message);
        $(".ItemsAdded").html(data.view);
        $('body').waitMe('hide');
      }
    })
  })

  $(document).on("click", ".weight", function(e){
    e.preventDefault();
    $(".error").html(""); 
    current = $(this);   
    $.ajax({
      url: current.data('url'),
      type:'post',
      data: {'data-id': current.data('id'), 'weight':$('.weight_input').val()},
      cache: false,
      success: function(data){
        success(data.message);
        $(".ItemsAdded").html(data.view);
        $('body').waitMe('hide');
      }
    })
  })

  $(document).on("click", "#couponBtn", function(e){
    e.preventDefault();
    $(".error").html(""); 
    current = $(this);   
    $.ajax({
      url: current.data('url'),
      type:'post',
      data: {'coupon': $("#coupon").val()},
      cache: false,
      success: function(data){
        success(data.message);
        $(".ItemsAdded").html(data.view);
        $('body').waitMe('hide');
      }
    })
  })

  $(document).on("click", "#discountBtn", function(e){
    e.preventDefault();
    $(".error").html(""); 
    current = $(this);   
    $.ajax({
      url: current.data('url'),
      type:'post',
      data: {'discount': $("#discount").val()},
      cache: false,
      success: function(data){
        success(data.message);
        $(".ItemsAdded").html(data.view);
        $('body').waitMe('hide');
      }
    })
  });
});

var map;
function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {    
    zoom: 8
  });
  if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        var marker = new google.maps.Marker({
            position: pos,
            map: map,
            draggable:true,
          });

        map.setCenter(pos);
        google.maps.event.addListener(marker, 'dragend', function (evt) {
           geocodePosition(marker.getPosition());
        });
      });


  }
  function geocodePosition(pos) 
  {
     geocoder = new google.maps.Geocoder();
     geocoder.geocode
      ({
          latLng: pos
      }, 
      function(results, status) 
      {
          if (status == google.maps.GeocoderStatus.OK) 
          {

              $('#address').val(results[0].formatted_address);
              if (results[0].address_components[2]) 
              {
                $('#city').val(results[0].address_components[2].long_name);
              }
               if (results[0].address_components[4]) {
                $('#state').val(results[0].address_components[4].long_name);
               }
               address = results[0].address_components;
               zipcode = address[address.length - 1].long_name;
               $('#pin').val(zipcode);
              $('#latitude').val(results[0].geometry.location.lat());
              $('#longitude').val(results[0].geometry.location.lng());
          } 
          else 
          {
              console.log('Cannot determine address at this location.'+status);
          }
      }
      );
  }
}
$('#addressModal').on('shown.bs.modal', function () {
    data = google.maps.event.trigger(map, "resize");
  });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('MAPS_EMBED_KEY')}}&libraries=places&callback=initMap"
        async defer></script>
@endpush
