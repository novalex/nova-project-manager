@if (
	View::hasSection('nav-top-head') ||
	View::hasSection('nav-top-title') ||
	View::hasSection('nav-top-actions') ||
	! empty( $has_search )
)
	<nav id="nav-top">
		@if ( View::hasSection('nav-top-head') )
			<div id="nav-top-head">
				@yield('nav-top-head')
			</div>
		@endif

		@if ( View::hasSection('nav-top-title') )
			<div id="nav-top-title">
				<span>
					@yield('nav-top-title')
				</span>
			</div>
		@endif

		@if ( ! empty( $has_search ) )
			<div id="nav-top-search">
				<div class="field-clear field-loading">
					<input type="text" name="search" placeholder="{{ __( 'Search...' ) }}">
					<i class="spinner"></i>
					<button class="clear">&times;</button>
				</div>
				<div class="search-results-holder"></div>
			</div>
		@endif

		@if ( View::hasSection('nav-top-actions') )
			<div id="nav-top-actions">
				@yield('nav-top-actions')
			</div>
		@endif
	</nav>
@endif
