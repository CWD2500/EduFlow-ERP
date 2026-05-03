@extends('layouts.admin.admin')

@section('content')

<?php  
   $gender = ["ذكر", "أنثى"];
   $num = ["الأولى", "الثانية"];
?>

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
                    <h3 class="fw-bold mb-3">تعديل الطالب</h3>
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
                            <a href="#">الطلاب</a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">تعديل</a>
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
                                <form action="{{ route('dashBoard.student.update', [$student->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="specialization" style="font-size: 20px">الاختصاص</label>
                                                <select class="form-control" name="specializations_id" id="specialization" required>
                                                    <option value="">اختر الاختصاص</option>
                                                    @foreach ($specializations_student as $specialization)
                                                            <option value="{{ $specialization }}" {{$student->specializations_id == $specialization ? 'selected':''  }}>{{ $specialization }} </option>
                                                    
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="name" style="font-size: 20px">الاسم</p>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="أدخل الاسم..." value="{{ $student->name }}" required />
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="student_id" style="font-size: 20px;">الرقم الجامعي</p>
                                                <input type="text" class="form-control" name="student_id" id="student_id" placeholder="أدخل الرقم الجامعي..." required />
                                            </div>
                                        </div> --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="ratio" style="font-size: 20px">النسبة</p>
                                                <input type="text" class="form-control" name="ratio" id="ratio" placeholder="أدخل النسبة..." value="{{ $student->ratio }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="father" style="font-size: 20px">اسم الأب</p>
                                                <input type="text" class="form-control" name="father" id="father" placeholder="أدخل اسم الأب..." value="{{ $student->father }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="father_job" style="font-size: 20px">وظيفة الأب</p>
                                                <input type="text" class="form-control" name="father_job" id="father_job" placeholder="أدخل وظيفة الأب..." value="{{ $student->father_job }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="mother" style="font-size: 20px">اسم الأم</p>
                                                <input type="text" class="form-control" name="mother" id="mother" placeholder="أدخل اسم الأم..." value="{{ $student->mother }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="place_and_number_of_registration" style="font-size: 20px">مكان ورقم التسجيل</p>
                                                <input type="text" class="form-control" name="place_and_number_of_registration" id="place_and_number_of_registration" placeholder="أدخل مكان ورقم التسجيل..." value="{{ $student->place_and_number_of_registration }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="place_of_birth" style="font-size: 20px">مكان الميلاد</p>
                                                <input type="text" class="form-control" name="place_of_birth" id="place_of_birth" placeholder="أدخل مكان الميلاد..." value="{{ $student->place_of_birth }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="place_Get_the_certificate" style="font-size: 20px">مكان الحصول على الشهادة</p>
                                                <input type="text" class="form-control" name="place_Get_the_certificate" id="place_Get_the_certificate" placeholder="أدخل مكان الحصول على الشهادة..." value="{{ $student->place_Get_the_certificate }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="total" style="font-size: 20px">المجموع</p>
                                                <input type="number" class="form-control" min="0"  max="100" name="total" id="total" placeholder="أدخل المجموع..." value="{{ $student->total }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="religion" style="font-size: 20px">الديانة</p>
                                                <input type="text" class="form-control" name="religion" id="religion" placeholder="أدخل الديانة..." value="{{ $student->religion }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="city" style="font-size: 20px">المدينة</p>
                                                <input type="text" class="form-control" name="city" id="city" placeholder="أدخل المدينة..." value="{{ $student->city }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="gender" style="font-size: 20px">الجنس</p>
                                                <select class="form-control" name="gender" id="gender" required>
                                                    <option value="">اختر الجنس</option>
                                                    @foreach ($gender as $g)
                                                        <option value="{{ $g }}" {{ $student->gender == $g ? 'selected' : '' }}>{{ $g }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="language" style="font-size: 20px">اللغة</p>
                                                <input type="text" class="form-control" name="language" id="language" placeholder="أدخل اللغة..." value="{{ $student->language }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="exam_session" style="font-size: 20px">الدورة الامتحانية</p>
                                                <select class="form-control" name="exam_session" id="exam_session" required>
                                                    <option value="">اختر الدورة الامتحانية</option>
                                                    @foreach ($num as $n)
                                                        <option value="{{ $n }}" {{ $student->exam_session == $n ? 'selected' : '' }}>{{ $n }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="teacher" style="font-size: 20px">المدرسة</p>
                                                <input type="text" class="form-control" name="teacher" id="teacher" placeholder="أدخل اسم المدرس..." value="{{ $student->teacher }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="family" style="font-size: 20px">الأسرة</p>
                                                <input type="text" class="form-control" name="family" id="family" placeholder="أدخل الأسرة..." value="{{ $student->family }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="recruitment_division" style="font-size: 20px">شعبة التجنيد</p>
                                                <input type="text" class="form-control" name="recruitment_division" id="recruitment_division" placeholder="أدخل شعبة التجنيد..." value="{{ $student->recruitment_division }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="national_number" style="font-size: 20px">الرقم الوطني</p>
                                                <input type="text" class="form-control" name="national_number" id="national_number" placeholder="أدخل الرقم الوطني..." value="{{ $student->national_number }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="date_of_birth" style="font-size: 20px">تاريخ الميلاد</p>
                                                <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $student->date_of_birth }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="mobile_phone_number" style="font-size: 20px">رقم الجوال</p>
                                                <input type="text" class="form-control" name="mobile_phone_number" id="mobile_phone_number" placeholder="أدخل رقم الجوال..." value="{{ $student->mobile_phone_number }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="landline_number" style="font-size: 20px">رقم الهاتف الأرضي</p>
                                                <input type="text" class="form-control" name="landline_number" id="landline_number" placeholder="أدخل رقم الهاتف الأرضي..." value="{{ $student->landline_number }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="detailed_address" style="font-size: 20px">العنوان التفصيلي</p>
                                                <input type="text" class="form-control" name="detailed_address" id="detailed_address" placeholder="أدخل العنوان التفصيلي..." value="{{ $student->detailed_address }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="date_of_registration" style="font-size: 20px">تاريخ التسجيل</p>
                                                <input type="date" class="form-control" name="date_of_registration" id="date_of_registration" value="{{ $student->date_of_registration }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p for="detailed_address" style="font-size: 20px">العنوان التفصيلي</p>
                                                <input type="text" class="form-control" name="detailed_address" id="detailed_address" placeholder="أدخل العنوان التفصيلي..." value="{{ $student->detailed_address }}" required />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="mybtn w-100">تحديث</button>
                                        <a href="{{ route('dashBoard.student.department.home') }}" class="mt-2">
                                            <button type="button" class="mybtnBack mt-3 w-100">
                                                العودة لصفحة الطلاب
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
