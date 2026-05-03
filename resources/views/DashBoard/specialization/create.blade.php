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
                    <h3 class="fw-bold mb-3">  الاخصتاصات </h3>
                    <ul class="breadcrumbs mb-3">
                        <li class="nav-home">
                            <a href="{{ route('dashBoard.specialization.home') }}">
                                <i class="icon-home"></i>
                            </a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashBoard.specialization.home') }}">  الاختصاصات </a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">الإنشاء</a>
                        </li>
                    </ul>
                </div>
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">قسم الإنشاء</div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('dashBoard.specialization.store') }}" method="POST" >
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <p for="name" style="font-size: 20px">الاسم</p>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="أدخل  الاسم الاختصاص..." required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="mybtn w-100">إنشاء</button>
                                        <a href="{{ route('dashBoard.specialization.home') }}" class="mt-2">
                                            <button type="button" class="mybtnBack mt-3 w-100">
                                                 العودة صفحة الاختصاص
                                            </button>
                                        </a>
                                    </div>
                                </form>
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
