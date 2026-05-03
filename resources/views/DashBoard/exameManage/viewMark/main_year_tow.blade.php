@extends('layouts.admin.admin')

@section('content')

<style>
    form , .rwo{
        direction: rtl;
    }
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
    }
    .table-container {
        direction: rtl;
        background-color: #fff;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }
    h2, h4 {
        text-align: center;
        margin: 0;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
        font-size: 14px;
    }
    th {
        background-color: #343a40;
        color: #fff;
    }
    td {
        background-color: #fff;
    }
    tr:nth-child(even) td {
        background-color: #f2f2f2;
    }
</style>

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
                <h3 class="fw-bold mb-3">الامتحانات</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="#"><i class="icon-home"></i></a>
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
                        <a href="#">النتائج</a>
                    </li>
                </ul>
            </div>

            <form method="GET" action="{{ route('dashBoard.exams.manage.view.mark.manitnace.year.tow') }}">
                <div class="form-group">
                    <label for="semester">اختر الفصل الدراسي:</label>
                    <select class="form-control" id="semester" name="semester" onchange="this.form.submit()">
                        <option value="">كلا الفصلين</option>
                        <option value="الفصل الاول" {{ $semester == 'الفصل الاول' ? 'selected' : '' }}>الفصل الاول</option>
                        <option value="الفصل الثاني" {{ $semester == 'الفصل الثاني' ? 'selected' : '' }}>الفصل الثاني</option>
                    </select>
                </div>
            </form>

            <button class="mybtnPrint" onclick="window.print()">print</button>

            <div class="row">
                @php
                    $secondYearStudents = $examsnetmin->where('academic_year', 'السنة الثانية');
                    $subjectGroups = $secondYearStudents->groupBy('subject_id');
                    $i = 1;
                @endphp

                @foreach ($subjectGroups as $subject_id => $students)
                    <div class="table-container">
                        <h2>معهد تقنيات الحاسوب</h2>
                        <h4>السنة الثانية قسم هندسة الصيانة</h4>
                        <h4>المادة: {{$subject_id}}</h4>
                        <br>
                        <table>
                            <thead>
                                <tr>
                                    <th>الرقم</th>
                                    <th>اسم الطالب</th>
                                    <th>اعمال ن</th>
                                    <th>اعمال ع</th>
                                    <th>مج اعمال</th>
                                    <th>امتحان ن</th>
                                    <th>امتحان ع</th>
                                    <th>مج امتحان</th>
                                    <th>الدرجة النهائية</th>
                                    <th>النتيجة</th>
                                    <th class="ActionNoneDisplay">الحدث</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    @php
                                        $total_works = $student->degree_n + $student->degree_p;
                                        $total_exam = $student->exam_n + $student->exam_p;
                                        $final_grade = $total_works + $total_exam;
                                        $result = ($total_works < 24 || $final_grade < 60) ? "راسب" : "ناجح";
                                    @endphp
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $student->student->name }}</td>
                                        <td>{{ $student->degree_n }}</td>
                                        <td>{{ $student->degree_p }}</td>
                                        <td>{{ $total_works }}</td>
                                        <td>{{ $student->exam_n }}</td>
                                        <td>{{ $student->exam_p }}</td>
                                        <td>{{ $total_exam }}</td>
                                        <td>{{ $final_grade }}</td>
                                        <td>{{ $result }}</td>
                                        <td class="ActionNoneDisplay">
                                            <a class="btn btn-danger" href="{{ route('dashBoard.exams.manage.student.mark.delete', [$student->id]) }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <a class="btn btn-success" href="{{ route('dashBoard.exams.manage.view.mark.maintenance.year.two.edit', [$student->id]) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@include('layouts.admin.settings')

@endsection
