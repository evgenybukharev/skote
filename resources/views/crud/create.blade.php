@extends('skote::layouts.master')

@section('title',$crud->getHeading() ?? trans('skote::crud.add') )

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{!! $crud->getHeading() ?? trans('skote::crud.add') !!}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route(config('skote.url.dashboard', 'dashboard'))}}">Панель управления</a></li>
                        @if ($crud->hasAccess('list'))
                            <li class="breadcrumb-item"><a href="{{ url($crud->route) }}">{{ $crud->entity_name_plural }}</a></li>
                        @endif
                        <li class="breadcrumb-item active">{!! $crud->getHeading() ?? trans('skote::crud.add') !!}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

<div class="row">
	<div class="{{ $crud->getCreateContentClass() }}">
		<!-- Default box -->

		@include('skote::crud.inc.grouped_errors')

		  <form method="post"
		  		action="{{ url($crud->route) }}"
				@if ($crud->hasUploadFields('create'))
				enctype="multipart/form-data"
				@endif
		  		>
			  {!! csrf_field() !!}
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.skote.crud.form_content'))
		      	@include('vendor.skote.crud.form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
		      @else
		      	@include('skote::crud.form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
		      @endif

	          @include('skote::crud.inc.form_save_buttons')
		  </form>
	</div>
</div>

@endsection

