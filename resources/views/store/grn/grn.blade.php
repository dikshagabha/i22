@php
$i = 1;
@endphp

@foreach($orders as $order)
<div class="row">
	<table class="table table-borderless" frame="box" width="192px" height="192px">
	<tr>
		<th col-span=3>ORDER{{$order->order->id}}</th>
	</tr>
	<tr>
		<td col-span=3>{{$order->order->customer_name}}</td>
	</tr>
	<tr>
		<td col-span=2>{{$order->service_name}}</td>
		<td >{{$i}}/{{$orders->count()}}</td>
	</tr>	
	@if($order->itemimage->count())
	<tr>
		@foreach($order->itemimage as $item)
			<td>
				{{$item->addons->name}}
			</td>
		@endforeach
	</tr>
	@endif

	<tr>
		<td col-span=3>{{$order->item}}</td>
	</tr>
	</table>
</div>
<br>
@php
$i++;
@endphp

@endforeach