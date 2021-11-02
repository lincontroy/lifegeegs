@extends('layouts.backend.app')

@section('title','Admin Lists')

@section('content')
<div class="card">
	<div class="card-body">
		<div class="row mb-30">
			<div class="col-lg-6">
				<h4>{{ __('Admin') }}</h4>
			</div>
			<div class="col-lg-6">
			</div>
		</div>
		<br>
		<div class="card-action-filter">
			<form method="post" id="basicform" action="{{ route('admin.admins.destroy') }}">
				@csrf
				<div class="row">
					<div class="col-lg-6">
						<div class="d-flex">
							<div class="single-filter">
								<div class="form-group">
									<select class="form-control selectric" name="status">
                                        <option disabled selected>{{ __('Select Action') }}</option>
										<option value="1">{{ __('Active') }}</option>
										<option value="0">{{ __('Deactivate') }}</option>
										<option value="delete">{{ __('Delete Permanently') }}</option>
									</select>
								</div>
                            </div>
                            @can('admin.edit')
							<div class="single-filter">
								<button type="submit" class="btn btn-primary btn-lg ml-2">{{ __('Apply') }}</button>
                            </div>
                            @endcan
						</div>
					</div>
					<div class="col-lg-6">
						@can('admin.create')
						<div class="add-new-btn">
							<a href="{{ route('admin.admin.create') }}" class="btn btn-primary float-right">{{ __('Add New') }}</a>
						</div>
						@endcan
					</div>
				</div>
			</div>
			<div class="table-responsive custom-table">
				<table class="table">
					<thead>
						<tr>
							<th>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input checkAll" id="selectAll">
									<label class="custom-control-label checkAll" for="selectAll"></label>
								</div>
							</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Role') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $row)
						<tr>
							<td>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="ids[]" class="custom-control-input" id="customCheck{{ $row->id }}" value="{{ $row->id }}">
									<label class="custom-control-label" for="customCheck{{ $row->id }}"></label>
								</div>
							</td>
							<td>
                                {{ $row->name }}
                                @can('admin.edit')
								<div class="hover">
									<a href="{{ route('admin.admin.edit',$row->id) }}">{{ __('Edit') }}</a>									
                                </div>
                                @endcan
                            </td>
                            <td>
                               {{ $row->email }}                               
							</td>
                            <td>
                               {{ $row->phone }}                               
							</td>
                            <td>
                            @if($row->status==1)
                            <span class="badge badge-success">{{ __('Active') }}</span>
                            @else
                            <span class="badge badge-danger">{{ __('Deactive') }}</span>
                            @endif
                            </td>
							<td>
								@foreach($row->roles as $r) <span class="badge badge-primary">{{ $r->name }}</span> @endforeach
							</td>
						</tr>
						@endforeach
					</tbody>
				</form>
			</table>
		</div>
	</div>
</div>
@endsection