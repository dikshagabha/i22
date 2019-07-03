@extends('store.layout-new.app')
@section('title', 'Reports')
@section('content')


<vs-row vs-justify="center">
  <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="11">
      <div slot="header">
        <h3>
          Ledger
        </h3>
      </div>
      <div>

       
           <br>
             {{ Form::open(['method' => 'get', 'id' => 'store-search', 'name' => 'serach_form']) }}
                <div class="form-group-inner">
                    <div class="row">
                      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                      </div>
                         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                          {{ Form::text('currentFilter', '', ['class' => 'form-control', 'placeholder' => 'Filter by date', 'maxlength'=>'50', 'id'=>'date']) }}
                         </div>
                         <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                          {{ Form::select('monthFilter', $months, null, ['class' => 'form-control', 'placeholder' => 'Filter by month', 'maxlength'=>'50']) }}
                           
                         </div>
                         <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="1">
                  <vs-button type="gradient" color="success" id="search-button">Filter</vs-button>
                </vs-col>
                 <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="1">
                  <vs-button type="gradient" color="danger"id="reset-button" >Reset</vs-button>
                </vs-col>
                       </div>
                  </div>
                  {{ Form::close() }}
              </div>
              <br>
              <div id="dataList">
                
               @include('store.reports.accounting.ledger.list')
              </div>
        
      </div>
      <div slot="footer">
        
      </div>
    
  </vs-col>
</vs-row>
@endsection
@push('js')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.6/datatables.min.css"/>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css"/>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.6/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
$(document).ready(function(){

   $("#date").flatpickr({enableTime: false,
    defaultDate:moment(),
   });
  var table = $('.dataTable').DataTable({
        dom: 'Bfrtip',
        //"paging":   false,
        "info":     false,
        "order": [[ 1, "desc" ]],
        //"sDom": '<"bottom"i>rt<"">',
          buttons: [
               'excelHtml5'
          ]
      });
  var current_page = $(".pagination").find('.active').text();
  $(document).on("click","#reset-button",function(e) {
      e.preventDefault();
      $('body').waitMe();
      table.destroy();
      //$('#export_csv').removeClass('apply_filter');
      // Reset Search Form fields
      $('#store-search')[0].reset();
      //check current active page
      var current_page = 1;
      // reload the list
      load_listings(location.href+'?page='+current_page);

        $('.dataTable').DataTable({
        dom: 'Bfrtip',
        "order": [[ 1, "desc" ]],
        //"paging":   false,
        "info":     false,
          buttons: [
              'excel'
          ]
      });
      //stopLoader("body");
    });


  
  $(document).on("click","#search-button",function(e) {
      e.preventDefault();
      $('body').waitMe();
      table.destroy();
      //$('#export_csv').addClass('apply_filter');
      //check current active page
      var current_page = $(".pagination").find('.active').text();
      // reload the list
      load_listings(location.href, 'serach_form');
      $('.dataTable').DataTable({
        dom: 'Bfrtip',
        //"paging":   false,
        "info":     false,
        "order": [[ 1, "desc" ]],
          buttons: [
              'excel'
          ]
      })
})

});
</script>

@endpush