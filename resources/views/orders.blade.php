@extends('app')

@section('content')
<!-- 
@foreach ($orders as $order)
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default text-center">
				<div class="panel-heading">{{$order->name}}</div>

				<div class="panel-body">
					<div class="col-lg-12"><p>Cafe:{{$order->personalization()->option}}</p></div>	
					<div class="col-lg-12"><p>Tamano:{{$order->personalization()->size}}</p></div>	
					<div class="col-lg-12"><p>Leche:{{$order->personalization()->milk}}</p></div>	
					<div class="col-lg-12"><p>Espuma(cafes calientes):{{$order->personalization()->foam}}</p></div>	
					@foreach ($order->personalization()->personalizationToppings as $topping)
					<div class="col-lg-12"><p>topping:{{$topping->name }} {{$topping->amount }}</p></div>	
					@endforeach
					@foreach ($order->personalization()->personalizationSyrups as $syrup)
					<div class="col-lg-12"><p>topping:{{$syrup->name }} {{$syrup->amount }}</p></div>	
					@endforeach
					@foreach ($order->personalization()->personalizationShots as $shot)
					<div class="col-lg-12"><p>topping:{{$shot->name }} {{$shot->amount }}</p></div>	
					@endforeach
					<div class="col-lg-12"><p>Total:{{$order->total}}</p></div>	

				</div>
			</div>
		</div>
	</div>
</div>
@endforeach -->
@endsection