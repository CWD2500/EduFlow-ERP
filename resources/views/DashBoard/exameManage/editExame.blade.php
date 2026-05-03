@extends('layouts.admin.admin')

@section('content')
    <!-- Sidebar -->
    @include('layouts.admin.Sidebar')
    <!-- End Sidebar -->

    <div class="main-panel">
        <div class="main-header">
            <div class="main-header-logo">
                <!-- Logo Header -->
                @include('layouts.admin.headerLogo')
                <!-- End Logo Header -->
            </div>
            <!-- Navbar Header -->
            @include('layouts.admin.navbar')
            <!-- End Navbar -->
        </div>

        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <h3 class="fw-bold mb-3">المواد الدراسية </h3>
                    <ul class="breadcrumbs mb-3">
                        <li class="nav-home">
                            <a href="#">
                                <i class="icon-home"></i>
                            </a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">المواد الدراسية </a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">التعديل</a>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">قسم التعديل</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="container mt-3">
                                        @if (session('success'))
                                            <div class="alert alert-success alert-dismissible bg-success-subtle fade show" role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif

                                        @if ($errors->count() > 0)
                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <strong>{{ $error }}</strong>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <form action="{{ route('dashBoard.subject.update', $subject->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-md-6 col-lg-12">
                                            <div class="form-group">
                                                <p for="name" style="font-size: 20px">اسم المادة الدراسية</p>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="أدخل الاسم..." value="{{ $subject->name }}" required />
                                            </div>

                                            <div class="form-group mb-3">
                                                <p for="description" class="form-label" style="font-size: 20px">وصف المادة الدراسية</p>
                                                <textarea class="form-control" id="description" name="description" rows="3" cols="8" required>{{ $subject->description }}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="mybtn w-100">تحديث</button>
                                                <a href="{{ route('dashBoard.subject.home') }}" class="mt-2">
                                                    <button type="button" class="mybtnBack mt-3 w-100">صفحة المواد الدراسية</button>
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom template | don't include it in your project! -->
    @include('layouts.admin.settings')
    <!-- End Custom template -->
@endsection
