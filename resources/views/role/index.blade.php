@extends('dynamicACL::layout')

@section('tab_title')
	{{__('dynamicACL::roles.list_title')}}
@endsection

@section('content')
<div class="row">
    <div class="col-1"></div>
	<div class="col-10">
		<div class="card">
			<div class="card-header" style="background: white; color: #212529;">
				<h3 class="card-title">{{__('dynamicACL::roles.list_title')}}</h3>

				<div class="card-tools">
					@if(auth()->user()->hasPermission('admin.roles.create'))
					<a href="{{ route('admin.roles.create') }}" role="button"
						class="btn btn-success btn-sm btn-rounded">{{__('dynamicACL::roles.create_role')}}</a>
					@endif
				</div>
			</div>
			<!-- /.card-header -->
			<div class="card-body table-responsive p-0">
				<table class="table table-hover">
					<tr>
						<th>{{__('dynamicACL::roles.role_name')}}</th>
						<th>{{__('dynamicACL::roles.users_count')}}</th>
						<th></th>
					</tr>
					@foreach($roles as $role)
					<tr>
						<td>{{ $role->name }}</td>
						<td>{{ $role->getUsersCount() }}</td>
						<td>
							@if (! $role->is_super_admin())
							<div class="btn-group" role="group" aria-label="Basic mixed styles example" dir="ltr">
								<a href="{{ route('admin.roles.delete',$role->id)}}" class="btn btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('dynamicACL::roles.common.delete')}}">❌</a>
								<a href="{{ route('admin.roles.edit', $role->id)}}" class="btn btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('dynamicACL::roles.common.edit')}}">📝</a>
							</div>
							@endif
						</td>
					</tr>
					@endforeach
				</table>
				{{ $roles->render() }}
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	</div>
</div><!-- /.row -->
@endsection
