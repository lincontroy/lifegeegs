@if ($childrens)
  	<li >  
        @if (isset($childrens->children)) 			
        <li>
            <a  href="{{ url($childrens->href) }}" @if(!empty($childrens->target)) target={{ $childrens->target }} @endif>{{ $childrens->text }} <span class="iconify" data-icon="dashicons:arrow-down-alt2" data-inline="false"></span></a> 
        <ul class="submenu">            
			@foreach($childrens->children as $row)
			 @include('components.menu.child', ['childrens' => $row])
            @endforeach           
        </ul>	
        </li>
        @else
        <a  href="{{ url($childrens->href) }}" @if(!empty($childrens->target)) target={{ $childrens->target }} @endif>{{ $childrens->text }}</a> 
		@endif
	</li>
@endif
