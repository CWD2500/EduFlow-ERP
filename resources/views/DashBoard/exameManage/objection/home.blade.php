@extends('layouts.admin.admin')

@section('content')

<?php 
    $i =1;
?>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
    }
    .table-container {
        background-color: #fff;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
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
        background-color: #000000;
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
        <div class="container mt-3">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible bg-success-subtle fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
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
                        <a href="#"> الاعترضات  </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">الرئيسية</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>الرقم</th>
                                <th>الرقم الجامعي</th>
                                <th>الاختصاص</th>
                                <th>اسم الطالب</th>
                                <th>المادة الدراسية</th>
                                <th>السنة الدراسية</th>
                                {{-- <th>الفصل الدراسي</th> --}}
                                <th>الحدث</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($objections as $item)
                                @if (!$item->is_hidden)
                                    @if ($item->exam) {{-- التحقق من وجود المادة --}}
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item->student_id }}</td>
                                            <td>{{ $item->student->specializations_id }}</td>
                                            <td>{{ $item->student->name }}</td>
                                            <td>{{ $item->subject_id }}</td>
                                            <td>{{ $item->exam->academic_year }}</td>
                                            {{-- <td>{{ $item->exam->semester }}</td> --}}
                                            <td>
                                                <a href="{{ route('objection.notification.delete', [$item->id]) }}" class="btn btn-outline-success">تأكيد الطلب</a>
                                                <a href="{{ route('dashBoard.exams.objection.show', [$item->id]) }}" class="btn btn-outline-warning">اظهار النتائج</a>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="7">المادة المرتبطة بهذا الاعتراض لم تعد موجودة.
                                                <a href="{{ route('dashBoard.exams.objection.delete', [$item->id]) }}" class="btn btn-outline-warning">
                                                    <i class="fa fa-trash"></i> 
                                                       </a>
                                            </td>
                                       
                                         
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.admin.settings')

@endsection
