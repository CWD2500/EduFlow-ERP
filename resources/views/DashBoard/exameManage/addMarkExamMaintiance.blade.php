@extends('layouts.admin.admin')

@section('content')
    @include('layouts.admin.Sidebar')

    <style>
        form {
            direction: rtl;
        }
    </style>

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
                        <li class="nav-home"><a href="{{ route('dashBoard.exams.manage.home') }}"><i class="icon-home"></i></a></li>
                        <li class="separator"><i class="icon-arrow-right"></i></li>
                        <li class="nav-item"><a href="#">الامتحانات</a></li>
                        <li class="separator"><i class="icon-arrow-right"></i></li>
                        <li class="nav-item"><a href="{{ route('dashBoard.exams.manage.view.main') }}">قسم الصيانة</a></li>
                        <li class="separator"><i class="icon-arrow-right"></i></li>
                        <li class="nav-item"><a href="#">السنة الاولى</a></li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">قسم البرمجة</div>
                            </div>

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible bg-success-subtle fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('successprg'))
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

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <strong>{{ $error }}</strong>
                                    </div>
                                @endforeach
                            @endif

                            <form action="{{ route('dashBoard.exams.manage.student.mark.storeAddMarkMaintenance.store') }}" method="POST">
                                @csrf
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
                                                <label for="student_id" class="form-label" style="font-size: 20px">اسم الطالب</label>
                                                <select class="form-control" id="student_id" name="student_id" style="width: 100%;">
                                                    @foreach ($students as $item)
                                                        <option value="{{ $item->student_id }}">{{ $item->name }} : ({{ $item->student_id }}) الرقم الجامعي</option>
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
                                                <label for="degree_n" class="form-label" style="font-size: 20px">درجة اعمال نظري</label>
                                                <input type="number" class="form-control" name="degree_n" min="0" max="20" step="0.01" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group mb-3">
                                                <label for="degree_p" class="form-label" style="font-size: 20px">درجة اعمال عملي</label>
                                                <input type="number" class="form-control" name="degree_p" min="0" max="20" step="0.01" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group mb-3">
                                                <label for="exam_n" class="form-label" style="font-size: 20px">امتحان نظري</label>
                                                <input type="number" class="form-control" name="exam_n" min="0" max="30" step="0.01" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group mb-3">
                                                <label for="exam_p" class="form-label" style="font-size: 20px">امتحان عملي</label>
                                                <input type="number" class="form-control" name="exam_p" min="0" max="30" step="0.01" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="mybtn w-100">انشاء</button>
                                        </div>

                                        <a href="{{ route('dashBoard.exams.manage.view.main') }}" class="mt-2">
                                            <button type="button" class="mybtnBack mt-3 w-100">العودة</button>
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
                        response.forEach(function(item) {
                            options += '<option value="' + item.name + '">' + item.name + '</option>';
                        });
                        $('#subject_id').html(options);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            $('#semester').change(function() {
                var semester = $(this).val();
                loadSubjects(semester);
            });

            var defaultSemester = $('#semester').val();
            loadSubjects(defaultSemester);

            $('#student_id').select2({
                placeholder: 'اختر طالبًا',
                allowClear: true
            });
        });
    </script>

    @include('layouts.admin.settings')
@endsection
