@if($items)
@php
$i=1;
@endphp
<hr>
<div class="row">
  	<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">	
		<table class="table table-borderless table-dark ">
			<thead>
				<td width="40%"><h3>Item</h3></td>
				<td colspan="2" width="20%"><h3>Quantity</h3></td>
				<td><h3>Action</h3></td>
			</thead>
			<tbody>
			@foreach($items as $item)
 				<tr>
					<td width="50%"><strong>{{$item['item']}}</strong>
						<br> Price:
						@if($item['price'])
							{{$item['price']}} Rs
						@else
							N/A
						@endif


					</td>					
						<td width="10%">
						<input type="text" name="quantity" class="form-control quantityVal_{{$i}} " 
						style="color: white;" value="{{$item['quantity']}}" 
						>
						</td>
						<td>
						<button type="button" class="btn btn-link quantity" data-url = "{{route('store.quantityItemSession')}}" data-id='{{$i}}'
						data-id="{{$i}}">
						<i class="fa fa-refresh "></i>
						</button>
						</td>

					
					<td>				
					<button type="button" class="btn btn-danger deleteItemBtn" action = "{{route('store.deleteItemSession')}}" data-id="{{$i}}"><i class="fa fa-trash"></i></button>
					</td>
				</tr>
			</tbody>
		@php
		$i++;
		@endphp
		@endforeach
		</table>
			<span class="error" id="quantity_error"></span>
	</div>
	<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
		<table class="table table-borderless table-dark">
			<thead>
				<td width="50%"><h4>Item</h4></td>
				<td width="50%"><h4>Price</h4></td>
			</thead>
			@foreach($items as $item)
				<tr>
					<td width="50%"><strong>{{$item['item']}}</strong></td>
					<td width="10%">@if($item['estimated_price'])
										{{$item['estimated_price']}} Rs
									@else
										N/A
									@endif
					</td>
				</tr>

			@endforeach

			<tr>
				<td>
					CGST (9%)
				</td>
				<td>
					{{ $price_data['cgst'] }}
				</td>
			</tr>
			<tr>
				<td>
					GST (9%)
				</td>
				<td>
					{{ $price_data['gst'] }}
				</td>
			</tr>

			<!-- <tr>
				<td>
					Total Price
				</td>
				<td>
					@if($price_data['total_price'] !=0)
						{{$price_data['total_price']}} Rs
					@else
						N/A
					@endif
				</td>
			</tr> -->
			
		</table>

		<div class="row">

			<div class="col-lg-3 col-md-3 col-sm-3">
				Coupon
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4">
				<input type="text" name="coupon" id="coupon" class="form-control" value="{{$coupon_discount['coupon']}}">
				<span class="error" id="coupon_error"></span>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2">
				<button type="button" class="btn btn-danger" data-url="{{route('store.couponItemSession')}}" id="couponBtn">Apply</button>
			</div>
	        
	     </div>

	     <div class="row">
	     	<div class="col-md-4 col-sm-4 col-lg-4">
	     		<strong>Total Price</strong>
	     	</div>
	     	<div class="col-md-5 col-sm-5 col-lg-5 pull-left">
	     		<strong>@if($price_data['total_price'] !=0)
						{{$price_data['total_price']}} Rs
					@else
						N/A
					@endif
				</strong>
	     	</div>
	     </div>

	     <div class="row">
	     	<div class="col-lg-8 col-md-8 col-sm-8">
				<button type="button" class="btn btn-warning" id="add_frenchise">Create Order</button>
			</div>	        
	     </div>
		
		

		
	</div>
</div>
@else

@endif