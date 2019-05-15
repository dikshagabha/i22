<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="#" class="simple-text logo-normal">
      {{ __('TumblDry') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i><img style="width:25px" src="{{ asset('images/icons/dashboard.png') }}"></i>
          <!-- <i class="material-icons">dashboard</i> -->
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'runner' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('manage-runner.index') }}">
          <i><img style="width:25px" src="{{ asset('images/icons/runer.png') }}"></i>
          <!-- <i class="material-icons">dashboard</i> -->
            <p>{{ __('Runner') }}</p>
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'customer' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('manage-customer.index') }}">
          <i><img style="width:25px" src="{{ asset('images/icons/customer.png') }}"></i>
          <!-- <i class="material-icons">dashboard</i> -->
            <p>{{ __('Customer') }}</p>
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'order' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('store.create-order.index') }}">
          <i><img style="width:25px" src="{{ asset('images/icons/order.png') }}"></i>
          <!-- <i class="material-icons">dashboard</i> -->
            <p>{{ __('Order') }}</p>
        </a>
      </li>
      
      
  </div>
</div>