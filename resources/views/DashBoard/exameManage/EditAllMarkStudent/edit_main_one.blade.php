@extends('layouts.admin.admin')

@section('content')
    @include('layouts.admin.Sidebar')

    <?php
        $academic_year =['السنة الاولى' ,  'السنة الثانية'];
        $Supplementary_course =['الدورة التكميلية' ];
    ?>

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
                    <h3 class="fw-bold mb-3">الامتحانات</h3>
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
                            <a href="#">الامتحانات</a>
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
                                <div class="card-title"> قسم التعديل </div>
                            </div>
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible bg-success-subtle fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-success alert-dismissible bg-danger-subtle fade show" role="alert">
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

                            <form action="{{ route('dashBoard.exams.manage.view.mark.EditAllMarkStudentMainOne.year.one.update', [$exame_edit->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12">
                                            <div class="form-group mb-3">
                                                <label for="semester">الفصل</label>
                                                <select class="form-control" id="semester" name="semester" required>
                                                    <option value="الفصل الاول">الفصل الاول</option>
                                                    <option value="الفصل الثاني">الفصل الثاني</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group mb-3">
                                                <p for="student" class="form-label" style="font-size: 20px">اسم الطالب</p>
                                                <select class="form-control" id="searchable_select" name="student_id" style="width: 100%;">
                                                    @foreach ($student as $item)
                                             
                                                    <option value="{{ $item->student_id }}" {{ $item->student_id == $exame_edit->student_id ? 'selected' : '' }} >
                                                        {{ $item->name }} : ({{ $item->student_id }})  الرقم الجامعي </option>    
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group mb-3">
                                                <label for="subject_id">المادة الدراسية</label>
                                                <select class="form-control" id="subject_id" name="subject_id" required>
                                                    <!-- الخيارات ستتم إضافتها تلقائيًا باستخدام JavaScript -->
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group mb-3">
                                                <p for="exam_date" class="form-label" style="font-size: 20px">درجة اعمال نظري</p>
                                                <input type="number" class="form-control" name="degree_n" min="0" max="20" id="decimal_number" step="0.01" value="{{$exame_edit->degree_n}}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group mb-3">
                                                <p for="exam_date" class="form-label" style="font-size: 20px">درجة اعمال العملي</p>
                                                <input type="number" class="form-control" name="degree_p" min="0" max="20" id="decimal_number" step="0.01" value="{{$exame_edit->degree_p}}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group mb-3">
                                                <p for="exam_date" class="form-label" style="font-size: 20px">امتحان نظري</p>
                                                <input type="number" class="form-control" name="exam_n" min="0" max="30" id="decimal_number" step="0.01" value="{{$exame_edit->exam_n}}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group mb-3">
                                                <p for="exam_date" class="form-label" style="font-size: 20px">امتحان العملي</p>
                                                <input type="number" class="form-control" name="exam_p" value="{{$exame_edit->exam_p}}" min="0" max="30" id="decimal_number" step="0.01" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="mybtn w-100">انشاء</button>
                                        </div>

                                        <a href="{{ route('dashBoard.exams.manage.view.mark.programming.year.one') }}" class="mt-2">
                                            <button type="button" class="mybtnBack mt-3 w-100">صفحة الامتحانات</button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#semester').change(function() {
                var semester = $(this).val();
                loadSubjects(semester);
            });

            function loadSubjects(semester) {
                $.ajax({
                    url: "{{ route('fetch.subjects.by.semester.main') }}",
                    method: 'GET',
                    data: {
                        semester: semester,
                        year: 'السنة الاولى',
                        specialization_id: 'قسم الصيانة'
                    },
                    success: function(response) {
                        var options = '<option value="">اختر المادة</option>';
                        var selectedSubjectId = "{{ $exame_edit->subject_id }}";

                        response.forEach(function(item) {
                            var selected = item.name == selectedSubjectId ? 'selected' : '';
                            options += '<option value="' + item.name + '" ' + selected + '>' + item.name + '</option>';
                        });
                        $('#subject_id').html(options);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            var defaultSemester = $('#semester').val();
            loadSubjects(defaultSemester);
        });
    </script>
    @include('layouts.admin.settings')
@endsection
