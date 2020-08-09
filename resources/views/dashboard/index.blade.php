@extends('admin.layouts.master')

@section('title') Панель управления @endsection

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Панель управления</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Добро пожаловать в ВсеЗаймы</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-soft-primary">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">С возвращением!</h5>
                                <p><?=date('d.m.Y')?></p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="assets/admin/images/profile-img.png" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="avatar-md profile-user-wid mb-4">
                                <img src="assets/vendor/skote/images/users/avatar-1.jpg" alt=""
                                     class="img-thumbnail rounded-circle">
                            </div>

                        </div>

                        <div class="col-sm-8">
                            <div class="pt-4 text-right">
                                <h5 class="font-size-15 text-truncate">{{Auth::user()->name}}</h5>
                                <p class="text-muted mb-0 text-truncate">Администратор</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Слова</p>
                                    <h4 class="mb-0">0</h4>
                                </div>

                                <div
                                    class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                                        <span class="avatar-title">
                                                                <i class="bx bx-copy-alt font-size-24"></i>
                                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">На модерации</p>
                                    <h4 class="mb-0">0</h4>
                                </div>

                                <div
                                    class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                        <span
                                                            class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-archive-in font-size-24"></i>
                                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Категории</p>
                                    <h4 class="mb-0">0</h4>
                                </div>

                                <div
                                    class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                        <span
                                                            class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>
    <!-- end row -->
@endsection

@section('script')

@endsection
