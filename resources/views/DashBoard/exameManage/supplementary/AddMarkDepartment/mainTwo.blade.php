@extends('layouts.admin.admin')

@section('content')
    <!-- Sidebar -->
    @include('layouts.admin.Sidebar')
    <!-- End Sidebar -->

<?php
    $academic_year = ['السنة الاولى', 'السنة الثانية'];
    $Supplementary_course = ['الدورة التكميلية'];
?>

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
                    <h3 class="fw-bold mb-3">الامتحانات</h3>
                    <ul class="breadcrumbs mb-3">
                        <li class="nav-home">
                            <a href="{{ route('dashBoard.addMarkSupplement.manage') }}">
                                <i class="icon-home"></i>
                            </a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">الامتحانات</a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashBoard.addMarkSupplementDepMain.manage') }}"> قسم الصيانة  </a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                   
                        <li class="nav-item">
                            <a href="#">  السنة الثانية  </a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">   علامات التكميلي  </a>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title"> قسم الانشاء </div>
                            </div>

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible bg-success-subtle fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible bg-danger-subtle fade show" role="alert">
                                    {{ session('error') }}
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

                            <form action="{{ route('dashBoard.storeAddMarkMainTwo.manage.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group mb-3">
                                                <p for="student" class="form-label" style="font-size: 20px">اسم الطالب</p>
                                                <select class="form-control" id="searchable_select" name="student_id" style="width: 100%;">
                                                    @foreach ($studentsWithFailedSubjects as $studentId => $data)
                                                        <option value="{{ $studentId }}">{{ $data['student']->name }} : ({{ $studentId }}) الرقم الجامعي</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group mb-3">
                                                <p for="subject_id" class="form-label" style="font-size: 20px">المادة الدراسية</p>
                                                <select class="form-control" id="subject_id" name="subject_id" required>
                                                    @foreach ($studentsWithFailedSubjects as $studentId => $data)
                                                        @foreach ($data['failed_subjects'] as $subject)
                                                            <option value="{{ $subject->subject_id }}">{{ $subject->subject_id }}</option>
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group mb-3">
                                                <p for="exam_date" class="form-label" style="font-size: 20px">درجة اعمال نظري</p>
                                                <input type="number" class="form-control" name="degree_n" min="0" max="20" id="decimal_number"
                                                    step="0.01" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group mb-3">
                                                <p for="exam_date" class="form-label" style="font-size: 20px">درجة اعمال العملي</p>
                                                <input type="number" class="form-control" name="degree_p" min="0" max="20" id="decimal_number"
                                                    step="0.01" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group mb-3">
                                                <p for="exam_date" class="form-label" style="font-size: 20px">امتحان نظري</p>
                                                <input type="number" class="form-control" name="exam_n" min="0" max="30" id="decimal_number"
                                                    step="0.01" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group mb-3">
                                                <p for="exam_date" class="form-label" style="font-size: 20px">امتحان العملي</p>
                                                <input type="number" class="form-control" name="exam_p" min="0" max="30" id="decimal_number"
                                                    step="0.01" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="mybtn w-100">انشاء</button>
                                        </div>

                                        <a href="{{ route('dashBoard.addMarkSupplementDepMain.manage') }}" class="mt-2">
                                            <button type="button" class="mybtnBack mt-3 w-100">
                                                العودة
                                            </button>
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
    

    
    <!-- Custom template | don't include it in your project! -->
    @include('layouts.admin.settings')
    <!-- End Custom template -->
@endsection

