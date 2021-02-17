@if ($crud->hasAccess('create'))
	<a href="{{ url($crud->route.'/create') }}" class="btn btn-pill btn-info" data-style="zoom-in"><span class="ladda-label"><i class="la la-plus-circle"></i> {{ trans('backpack::crud.add') }} {{ $crud->entity_name }}</span></a>
@endif
