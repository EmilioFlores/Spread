@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default text-center">
				<div class="panel-heading">{{$post->title}}</div>

				<div class="panel-body">
					<div class="col-lg-12"><p>{{$post->content}}</p></div>	
				</div>
			</div>
		</div>
	</div>
</div>
@endsection