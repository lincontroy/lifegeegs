@extends('layouts.backend.app')

@section('title','Role Create')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Role Create'])
@endsection

@section('content')
<div class="row">
	<div class="col-lg-9">      
		<div class="card">
			<div class="card-body">
				<h4>{{ __('Add Role') }}</h4>
				<form method="post" action="{{ route('admin.role.store') }}" class="basicform_with_reset">
					@csrf
					<div class="pt-20">
						<div class="form-group">
							<label for="name">{{ __('Role Name') }}</label>
							<input type="text" required class="form-control" name="name" placeholder="Enter role name">
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input checkAll" id="selectAll">
									<label class="custom-control-label checkAll" for="selectAll">{{ __('Permissions') }}</label>
								</div>
								<hr>
								@php $i = 1; @endphp
								@foreach ($permission_groups as $group)
									<div class="row">
										<div class="col-3">
											<div class="form-check">
												<input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->group_name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)">
												<label class="form-check-label" for="checkPermission">{{ $group->group_name }}</label>
											</div>
										</div>
										<div class="col-9 role-{{ $i }}-management-checkbox">
											@php
												$permissions = App\Models\User::getpermissionsByGroupName($group->group_name);
												$j = 1;
											@endphp
											@foreach ($permissions as $permission)
												<div class="form-check">
									
													<input type="checkbox" class="form-check-input" name="permissions[]" id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
													<label class="form-check-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
												</div>
												@php  $j++; @endphp
											@endforeach
											<br>
										</div>
									</div>
									@php  $i++; @endphp
								@endforeach
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
	<div class="col-lg-3">
		<div class="single-area">
			<div class="card">
				<div class="card-body">
					<div class="btn-publish">
						<button type="submit" class="btn btn-primary col-12 basicbtn"><i class="fa fa-save"></i> {{ __('Save') }}</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection

@push('js')
<script src="{{ asset('backend/admin/assets/js/roles.js') }}"></script>
@endpush