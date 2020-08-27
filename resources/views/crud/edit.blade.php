@extends('skote::layouts.master')

@section('title',$crud->getHeading() ?? $entry->{$entry->identifiableAttribute()})

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{!! $crud->getHeading() ?? $entry->{$entry->identifiableAttribute()} !!}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route(config('skote.url.dashboard', 'dashboard'))}}">Панель управления</a></li>
                        @if ($crud->hasAccess('list'))
                            <li class="breadcrumb-item"><a href="{{ url($crud->route) }}">{{ $crud->entity_name_plural }}</a></li>
                        @endif
                        <li class="breadcrumb-item active">{!! $crud->getHeading() ?? $entry->{$entry->identifiableAttribute()} !!}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

<div class="row">
	<div class="{{ $crud->getEditContentClass() }}">
		<!-- Default box -->

		@include('skote::crud.inc.grouped_errors')

		  <form method="post"
		  		action="{{ url($crud->route.'/'.$entry->getKey()) }}"
				@if ($crud->hasUploadFields('update', $entry->getKey()))
				enctype="multipart/form-data"
				@endif
		  		>
		  {!! csrf_field() !!}
		  {!! method_field('PUT') !!}

		  	@if ($crud->model->translationEnabled())
		    <div class="mb-2 text-right">
		    	<!-- Single button -->
				<div class="btn-group">
				  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    {{trans('skote::crud.language')}}: {{ $crud->model->getAvailableLocales()[request()->input('locale')?request()->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
					  	<a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}?locale={{ $key }}">{{ $locale }}</a>
				  	@endforeach
				  </ul>
				</div>
		    </div>
		    @endif
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.skote.crud.form_content'))
		      	@include('vendor.skote.crud.form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
		      @else
		      	@include('skote::crud.form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
		      @endif

            @include('skote::crud.inc.form_save_buttons')
		  </form>
	</div>
</div>
@endsection

