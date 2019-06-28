@extends('layouts.app')
@section('title', 'Manage Plans')
@section('content')

<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card card-stats">
          <div class="row">
            <div class="col-md-9">
            </div>
            <div class="col-md-3">
              <a href="{{route('admin-manage-plans.create')}}"><button class="btn btn-danger">Add New Plan</button></a>
            </div>
          </div>
            <br>
             <div class="">
                {{ Form::open(['method' => 'get', 'id' => 'store-search', 'name' => 'serach_form']) }}
                <div class="form-group-inner">
                    <div class="row">
                      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                      </div>
                         <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                          {{ Form::text('search', '', ['class' => 'form-control', 'placeholder' => 'Search by Name', 'maxlength'=>'50']) }}
                         </div>
                        <!--  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                          {{ Form::select('sort_type', ['' => 'Select Status', '1' => 'Active', '0' => 'Inactive'], null, ['class' => 'form-control', 'id' => 'sort_type']) }}
                           
                         </div> -->
                         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                          <button type="submit" id="search-button" class="btn btn-success margin-bottom-20">Filter</button>
                        <button type="submit" id="reset-button" class="btn btn-danger margin-bottom-20">Reset</button>
                         </div>
                       </div>
                  </div>
                  {{ Form::close() }}
              </div>
            <br>
              <div id="dataList">
                
               @include('admin.manage-plans.list')
              </div>
            </div>

          <!-- </div> -->
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
@push('js')
<script src="{{asset('js/bootbox.js')}}"></script>
<script>
$(document).ready(function(){

  $(document).on('click', '#delete', function(e){
    e.preventDefault();
          bootbox.confirm({
          title: "Confirm",
          message: "Do you want to delete the Plan? This cannot be undone.",
          buttons: {
              cancel: {
                  label: '<i class="fa fa-times"></i> Cancel'
              },
              confirm: {
                  label: '<i class="fa fa-check"></i> Confirm'
              }
          },
          callback: function (result) {
              if(result){
                $('body').waitMe();


                $.ajax({
                  url: $('#delete').attr('href'),
                  type:"post",
                  data:{
                    '_method':"delete", '_token':$('#delete').data('token')
                  },
                  headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content'),
                    'method':'delete'
                  },
                  success: function(){
                    $('body').waitMe("hide");
                    if($('#dataList tr').length<=2)
                    {
                    var current_page = $(".pagination").find('.active').text()-1;
                    
                    load_listings(location.href+'?page='+current_page);
                    }

                    else
                    {
                    
                    var current_page = $(".pagination").find('.active').text();
                    load_listings(location.href+'?page='+current_page, 'serach_form');
                    }
                  },
                })
              }
          }
      });

  })


  $(document).on('click', '.status', function(e){
    e.preventDefault();
    current = $(this);
    if (current.data('status')==1) 
    {
      message = "Are you sure you want to activate this user?"
    }
    else{
      message = "Are you sure you want to inactivate this user?"
    }
          bootbox.confirm({
          title: "Confirm",
          message: message,
          buttons: {
              cancel: {
                  label: '<i class="fa fa-times"></i> Cancel'
              },
              confirm: {
                  label: '<i class="fa fa-check"></i> Confirm'
              }
          },
          callback: function (result) {
              if(result){
                $('body').waitMe();


                $.ajax({
                  url: current.attr('href'),
                  type:"post",
                  data:{
                    'status':current.data('status')
                  },
                  success: function(){
                    $('body').waitMe("hide");
                    
                    var current_page = $(".pagination").find('.active').text();
                    console.log(location.href+'?page='+current_page);
                    load_listings(location.href+'?page='+current_page, 'serach_form');
                    //window.location.reload()
                  },
                })
              }
          }
      });
  })
// Ajax base Pagination
    $(document).on("click",".pagination li a",function(e) {
      e.preventDefault();
      load_listings($(this).attr('href'));
    });

     $(document).on("click","#reset-button",function(e) {
      e.preventDefault();
      $('body').waitMe();
      //$('#export_csv').removeClass('apply_filter');
      // Reset Search Form fields
      $('#store-search')[0].reset();
      //check current active page
      var current_page = 1;
      // reload the list
      load_listings(location.href+'?page='+current_page);
      //stopLoader("body");
    });

  // Search by name
    $(document).on("click","#search-button",function(e) {
      e.preventDefault();
      $('body').waitMe();
      //$('#export_csv').addClass('apply_filter');
      //check current active page
      var current_page = $(".pagination").find('.active').text();
      // reload the list
      load_listings(location.href, 'serach_form');
      //stopLoader("body");
    });

})
</script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=2&libraries=places&callback=initMap"
        async defer></script> -->

@endpush
