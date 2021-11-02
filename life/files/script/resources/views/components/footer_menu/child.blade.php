@if ($childrens)
  	<li >  
        @if (isset($childrens->children)) 			
        <li>
            <a  href="{{ url($childrens->href) }}" @if(!empty($childrens->target)) target={{ $childrens->target }} @endif>{{ $childrens->text }}</a> 
        <ul class="sub">            
			@foreach($childrens->children as $row)
			 @include('components.footer_menu.child', ['childrens' => $row])
            @endforeach           
        </ul>	
        </li>
        @else
        <a  href="{{ url($childrens->href) }}" @if(!empty($childrens->target)) target={{ $childrens->target }} @endif>{{ $childrens->text }}</a> 
		@endif
	</li>
@endif
