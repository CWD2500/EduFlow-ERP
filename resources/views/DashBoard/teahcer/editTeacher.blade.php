@extends('layouts.admin.admin')

@section('content')

<?php  
   $semesters = ["الفصل الثاني", "الفصل الاول"];
   $subject_yeare = ["السنة الثانية", "السنة الاولى"];
   $subject_sep = ["عملي", "نظري"];
?>

@include('layouts.admin.Sidebar')

<div class="main-panel">
    <div class="main-header">
        <div class="main-header-logo">
            @include('layouts.admin.headerLogo')
        </div>
        @include('layouts.admin.navbar')
    </div>

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">المدرسين</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('dashBoard.teacher.home') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashBoard.teacher.home') }}">المدرسين</a>
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
                            <div class="card-title">قسم التعديل</div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dashBoard.teacher.update', [$teacher->id]) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="specialization" style="font-size: 20px">الاختصاص</label>
                                            <select class="form-control" name="specializations_id" id="specialization" required>
                                                <option value="">اختر الاختصاص</option>
                                                @foreach ($specializations_student as $specialization)
                                                    <option value="{{ $specialization->name }}" {{ $specialization->name == $teacher->specializations_id ? 'selected' : '' }}>
                                                        {{ $specialization->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name" style="font-size: 20px">الاسم المهندس</label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $teacher->name }}" required />
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="semester" value="{{ $semesters[0] }}" id="flexRadioDefault1" {{ $teacher->semester == $semesters[0] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                الفصل الثاني
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="semester" value="{{ $semesters[1] }}" id="flexRadioDefault2" {{ $teacher->semester == $semesters[1] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                الفصل الاول
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="subject_sep" value="{{ $subject_sep[0] }}" id="flexRadioDefault4" {{ $teacher->subject_sep == $subject_sep[0] ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexRadioDefault4">
                                                    عملي 
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="subject_sep" value="{{ $subject_sep[1] }}" id="flexRadioDefault5" {{ $teacher->subject_sep == $subject_sep[1] ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexRadioDefault5">
                                                    نظري
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="subject_yeare" value="{{ $subject_yeare[0] }}" id="flexRadioDefault7" {{ $teacher->subject_yeare == $subject_yeare[0] ? 'checked' : '' }}  >
                                                <label class="form-check-label" for="flexRadioDefault7">
                                                   السنة الثانية
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="subject_yeare" value="{{ $subject_yeare[1] }}" id="flexRadioDefault6" {{ $teacher->subject_yeare == $subject_yeare[1] ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexRadioDefault6">
                                                   السنة الاولى
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="subjects_programming" style="font-size: 20px">مواد البرمجة</label>
                                                <select class="form-select" name="subjects_programming[]" id="subjects_programming" multiple aria-label="Multiple select example">
                                                    @foreach ($subject_teacher->whereIn('id', $subject_programming) as $subject)
                                                        <option value="{{ $subject->id }}" {{ in_array($subject->id, $teacher_subjects) ? 'selected' : '' }}>{{ $subject->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="subjects_networking" style="font-size: 20px">مواد الشبكات</label>
                                                <select class="form-select" name="subjects_networking[]" id="subjects_networking" multiple aria-label="Multiple select example">
                                                    @foreach ($subject_teacher->whereIn('id', $subject_networking) as $subject)
                                                        <option value="{{ $subject->id }}" {{ in_array($subject->id, $teacher_subjects) ? 'selected' : '' }}>{{ $subject->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="subjects_main" style="font-size: 20px">مواد الصيانة</label>
                                                <select class="form-select" name="subjects_main[]" id="subjects_main" multiple aria-label="Multiple select example">
                                                    @foreach ($subject_teacher->whereIn('id', $subject_main) as $subject)
                                                        <option value="{{ $subject->id }}" {{ in_array($subject->id, $teacher_subjects) ? 'selected' : '' }}>{{ $subject->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                
                                <div class="form-group">
                                    <button type="submit" class="mybtn w-100">تحديث</button>
                                    <a href="{{ route('dashBoard.teacher.home') }}" class="mt-2">
                                        <button type="button" class="mybtnBack mt-3 w-100">صفحة المدرسين</button>
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

@include('layouts.admin.settings')

@endsection
