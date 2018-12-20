@if (
	View::hasSection('nav-top-head') ||
	View::hasSection('nav-top-title') ||
	View::hasSection('nav-top-actions')
)
	<nav id="nav-top">
		@if ( View::hasSection('nav-top-head') )
			<div id="nav-top-head">
				@yield('nav-top-head')
			</div>
		@endif

		@if ( View::hasSection('nav-top-title') )
			<div id="nav-top-title">
				@yield('nav-top-title')
			</div>
		@endif

		@if ( View::hasSection('nav-top-actions') )
			<div id="nav-top-actions">
				@yield('nav-top-actions')
			</div>
		@endif
	</nav>
@endif