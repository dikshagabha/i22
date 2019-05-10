
@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;
@endphp
 @if($users->count())

      <table class="table table-striped dataTable">
          <thead>
            <tr>
              <th>S No</th>
              <th>Customer Email</th>
              <th>Store Email</th>
	      <th> Service </th>
            </tr>
          </thead>
          <tbody>

      @foreach($users as $user)
            <tr>
              <td>
                {{$i}}
              </td>
              <td>
                <a href="{{route('getcustomerdetails', $user->customer_id)}}" id="getCustomer">
                {{$user->customer_email}}</a>
                
              </td>
              <td>
                 <a href="{{route('getcustomerdetails', $user->store_id)}}" id="getCustomer">
                  {{$user->store_email}}</a>
                
              </td>
		            <td>
                  {{$user->service_name}}
                </td>

            </tr>
            @php
            $i++;
            @endphp
            @endforeach
          </tbody>
      </table>

      {{$users->links()}}
      @else
      No Records Found
      @endif