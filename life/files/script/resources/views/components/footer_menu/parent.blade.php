@if(!empty($menus))

<div class="footer-menu-title">
	<h4>{{ $menus['name'] ?? '' }}</h4>
</div>
<div class="footer-menu-content">
	<nav>
		<ul>
			@foreach ($menus['data'] ?? [] as $row) 
			@if (isset($row->children)) 
			<li>
				<a href="#">{{ $row->text }} <span class="iconify" data-icon="dashicons:arrow-down-alt2" data-inline="false"></span></a>

				<ul class="sub">
					@foreach($row->children as $childrens)
					@include('components.footer_menu.child', ['childrens' => $childrens])
					@endforeach
				</ul>
			</li>
			@else
			<li>
				<a href="{{ url($row->href) }}" @if(!empty($row->target)) target="{{ $row->target }}" @endif>{{ $row->text }}</a>
			</li>
			@endif
			@endforeach
		</ul>
	</nav>
</div>
@endif
