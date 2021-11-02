@if(!empty($menus))
	@foreach ($menus as $row) 
		@if (isset($row->children)) 
		<li>
            <a href="#">{{ $row->text }} <span class="iconify" data-icon="dashicons:arrow-down-alt2" data-inline="false"></span></a>
			
			<ul class="submenu">
			 @foreach($row->children as $childrens)
			 @include('components.menu.child', ['childrens' => $childrens])
			 @endforeach
			</ul>
		</li>
		@else
		<li>
			<a href="{{ url($row->href) }}" @if(!empty($row->target)) target="{{ $row->target }}" @endif>{{ $row->text }}</a>
		</li>
		@endif			
	@endforeach
@endif

