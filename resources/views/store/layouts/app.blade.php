<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')| TumbleDry</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('material') }}/img/favicon.png">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('material') }}/demo/demo.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('css/waitMe.css')}}">
    <link rel="stylesheet" href="{{asset('css/pnotify.custom.min.css')}}">
    </head>
    <style type="text/css">
      .error{
        color: red;
      }

      
.table-modal
{word-break: break-word;}
    </style>
     @yield('css')
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('store.layouts.page_templates.auth')
        @endauth
        @guest()
            @include('store.layouts.page_templates.guest')
        @endguest
     
        <!--   Core JS Files   -->
        <script src="{{ asset('material') }}/js/core/jquery.min.js"></script>
        <script src="{{ asset('material') }}/js/core/popper.min.js"></script>
        <script src="{{ asset('material') }}/js/core/bootstrap-material-design.min.js"></script>
        <script src="{{ asset('material') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
        <!-- Plugin for the momentJs  -->
        <script src="{{ asset('material') }}/js/plugins/moment.min.js"></script>
        <!--  Plugin for Sweet Alert -->
        <script src="{{ asset('material') }}/js/plugins/sweetalert2.js"></script>
        <!-- Forms Validations Plugin -->
        <script src="{{ asset('material') }}/js/plugins/jquery.validate.min.js"></script>
        <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
        <script src="{{ asset('material') }}/js/plugins/jquery.bootstrap-wizard.js"></script>
        <!--    Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
        <script src="{{ asset('material') }}/js/plugins/bootstrap-selectpicker.js"></script>
        <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
        <script src="{{ asset('material') }}/js/plugins/bootstrap-datetimepicker.min.js"></script>
        <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
        <script src="{{ asset('material') }}/js/plugins/jquery.dataTables.min.js"></script>
        <!--    Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
        <script src="{{ asset('material') }}/js/plugins/bootstrap-tagsinput.js"></script>
        <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
        <script src="{{ asset('material') }}/js/plugins/jasny-bootstrap.min.js"></script>
        <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
        <script src="{{ asset('material') }}/js/plugins/fullcalendar.min.js"></script>
        <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
        <script src="{{ asset('material') }}/js/plugins/jquery-jvectormap.js"></script>
        <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
        <script src="{{ asset('material') }}/js/plugins/nouislider.min.js"></script>
        <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
        <!-- Library for adding dinamically elements -->
        <script src="{{ asset('material') }}/js/plugins/arrive.min.js"></script>
        <!--  Google Maps Plugin    -->
        <!-- Chartist JS -->
        <script src="{{ asset('material') }}/js/plugins/chartist.min.js"></script>
        <!--  Notifications Plugin    -->
        <script src="{{ asset('material') }}/js/plugins/bootstrap-notify.js"></script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{ asset('material') }}/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
        <!-- Material Dashboard DEMO methods, don't include it in your project! -->
        <script src="{{ asset('material') }}/demo/demo.js"></script>
        <script src="{{ asset('material') }}/js/settings.js"></script>
        
        <script src="{{asset('js/waitMe.js')}}"></script>
        <script src="{{asset('js/pnotify.custom.min.js')}}"></script>

        <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
        <script>

          $(document).ready(function(){

          var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
            cluster: 'ap2',
            forceTLS: true
          });

         var channel = pusher.subscribe('my-channel');
          channel.bind('notification', function(data) {
              $(".notif-count").text(parseInt($(".notif-count").text())+1);
              $(".dropdown-menu").prepend("<a class='dropdown-item' href='#'>"+data.message+"</a>");

              load_listings(location.href);
              //alert(JSON.stringify(data));
            });

          $(document).click("#navbarDropdownMenuLink", function(e){
            e.preventDefault();
            //$(".notif-count").text(0);
            url = $('#navbarDropdownMenuLink').attr('href');
            console.log(url);
            $.ajax({
                  async: false,
                  type : 'post',
                  url : url,
                 // data : data,
                 // dataType : 'html',
                  success : function(data) {

                    $(".notif-count").text(0);
                  },
                });

            })
          });
         
      </script>

        <script type="text/javascript">
            
            function load_listings(url, filter_form_name) {
                let data = {};
                // check if the element is not specified
                if(typeof filter_form_name !== 'undefined') {
                  data = $("form[name="+filter_form_name+"]").serialize();
                }

                // send the ajax request for the url
                $.ajax({
                  async: false,
                  type : 'get',
                  url : url,
                  data : data,
                  dataType : 'html',
                  success : function(data) {
                    $('body').waitMe('hide');
                    $("#dataList").empty();
                    $("#dataList").html(data);
                  },
                  error : function(response) {
                    error("Unable to fetch the list");
                  }
                });
              }

          function success(message=""){
              PNotify.removeAll() 
              new PNotify({
                title: 'Success!',
                text: message,
                type: 'success'
              });
            }
            
            function error(message){
              PNotify.removeAll() 
              new PNotify({
                title: 'Error!',
                text: message,
                type: 'error'
              });
            }
            $(document).ready(function(){

              $.ajaxSetup({
                headers:{
                  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                },
                error: function(data, status){
                  if(data.status==422){
                    $('body').waitMe('hide');
                    var errors = data.responseJSON;
                    for (var key in errors.errors) {
                      console.log(errors.errors[key][0])
                        $("#"+key+"_error").html(errors.errors[key][0])
                      }
                  }
                  else{
                     $('body').waitMe('hide');
                     if (data.message) {error(data.message);}
                     else {error("Something went wrong")}
                     
                  }
                }
              })

            })
</script>
        </script>
        @stack('js')
    </body>
</html>
