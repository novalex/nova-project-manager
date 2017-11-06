@if ( session('status') )
    <div class="alert -{{ session('status') }}">
        <ul>
        	@if ( is_array( session('message') ) )
	        	@foreach ( session('message') as $message )
	        		<li>{!! $message !!}</li>
	        	@endforeach
	        @else
	        	<li>{!! session('message') !!}</li>
	        @endif
        </ul>
    </div>
@endif