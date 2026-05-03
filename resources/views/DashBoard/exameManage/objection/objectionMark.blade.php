@extends('layouts.admin.admin')

@section('content')

<?php $i = 1; ?>

<style>
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
                        <a href="{{ route('dashBoard.exams.manage.home') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashBoard.exams.objection.home') }}">الاعتراضات</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">النتائج</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="table-container">
                    <br>
                    <table>
                        <thead>
                            <tr>
                                <th>الرقم</th>
                                <th>الرقم الجامعي</th>
                                <th>المادة الدراسية</th>
                                <th>اسم الطالب</th>
                                <th>اعمال ن</th>
                                <th>اعمال ع</th>
                                <th>مج اعمال</th>
                                <th>امتحان ن</th>
                                <th>امتحان ع</th>
                                <th>مج امتحان</th>
                                <th>الدرجة النهائية</th>
                                <th>النتيجة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($objection)
                                @php
                                    $total_works = $objection->exam->degree_n + $objection->exam->degree_p;
                                    $total_exam = $objection->exam->exam_n + $objection->exam->exam_p;
                                    $final_grade = $total_works + $total_exam;
                                    $result = ($total_works < 24 || $final_grade < 60) ? "راسب" : "ناجح";
                                @endphp
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $objection->student->student_id ?? 'N/A' }}</td>
                                    <td>{{ $objection->subject_id ?? 'N/A' }}</td>
                                    <td>{{ $objection->student->name ?? 'N/A' }}</td>
                                    <td>{{ $objection->exam->degree_n ?? 'N/A' }}</td>
                                    <td>{{ $objection->exam->degree_p ?? 'N/A' }}</td>
                                    <td>{{ ($objection->exam->degree_n ?? 0) + ($objection->exam->degree_p ?? 0) }}</td>
                                    <td>{{ $objection->exam->exam_n ?? 'N/A' }}</td>
                                    <td>{{ $objection->exam->exam_p ?? 'N/A' }}</td>
                                    <td>{{ ($objection->exam->exam_n ?? 0) + ($objection->exam->exam_p ?? 0) }}</td>
                                    <td>{{ $final_grade }}</td>
                                    <td>{{ $result }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="12">No objection found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.admin.settings')

@endsection
