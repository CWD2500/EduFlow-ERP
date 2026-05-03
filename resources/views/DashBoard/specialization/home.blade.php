@extends('layouts.admin.admin')


@section('content')

<?php
    $i = 0;
    $i+=1;
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


                <div class="container">
               
                    <div class="page-inner">
                        <div class="page-header">
                            <h3 class="fw-bold mb-3">  الاختصاصات   </h3>
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
                                    <a href="#">الرئيسية</a>
                                </li>
                            </ul>
                            
                        </div>
                       <div class="row">
                        <div class="col-md-6">
                            <form action="">
                              <input type="search" class="form-control" placeholder="search...">
                            </form>
                          </div>
                        <div class="col-sm-12  col-md-6   " style=" display: flex;flex-direction: row;justify-content: end;">
                            <h1 class="text-right">
                                <a href="{{ route('dashBoard.specialization.create') }}" class="btn btn-outline-primary w-100 "> أنشاء </a>
                                </h1>
                        </div>

                      
                       </div>
                        <div class="row ">
                            <div class="container mt-3">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible bg-success-subtle fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <table class="table">
                                        <thead class="table-dark text-white ">
                                            <tr>
                                                <th scope="col">#</th>
                                             
                                                <th scope="col"> اسم الاختصاص</th>
                                               
                                           
                                                <th scope="col">   الحدث  </th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider" style="color: black;font-size: 20px;font-weight: 800;font-family: 'Times New Roman', Times, serif">
                                            <tr >

                                             @foreach ( $specialization as $item )
                                                 

                                                <td scope="row"> 
                                                    <?php
                                                      echo  $i++;
                                                        
                                                    ?>
                                                </td>
                                                <td > {{ $item->name}} </td>                                                
                                                {{-- <td>{{ $item->created_at->locale('ar')->translatedFormat('l j F Y H:i') }}</td>                                               --}}
                                                <td>
                                                    
                                                    <a href="{{ route('dashBoard.specialization.destroy', [$item->id]) }}" class="btn btn-outline-danger"> <i class="fa fa-trash"></i> </a>
                                                    <a href="{{ route('dashBoard.specialization.edit', [$item->id]) }}" class="btn btn-outline-success"> <i class="fa fa-edit"></i> </a>
                                                </td>
                                            </tr>
                                            @endforeach   
                                         
                                         
                                        </tbody>
                                    </table>
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
