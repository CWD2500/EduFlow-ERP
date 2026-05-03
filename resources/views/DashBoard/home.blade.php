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
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4" >
          <div>
            <h2 class="fw-bold mb-3 text-primary">لوحة التحكم</h2>
            <h6 class="op-7 mb-2">موقع لإدارة الامتحانات </h6>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-primary bubble-shadow-small"
                    >
                    <i class="fas fa-clipboard-list"></i>
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-5">
                    <div class="numbers">
                      <p class="card-category text-bold text-dark " style="font-size: 18px"> مجموع الامتحانات</p>
                      <h4 class="card-title">{{$count_exame_manage}}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-info bubble-shadow-small"
                    >
                      <i class="fas fa-user-graduate"></i>
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-5">
                    <div class="numbers">
                      <p class="card-category text-dark" style="font-size: 18px">إجمالي الطلاب</p>
                      <h4 class="card-title">{{$count_student}}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-info bubble-shadow-small"
                    >
                    <i class="fas fa-user-tie"></i>

                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-5">
                    <div class="numbers">
                      <p class="card-category text-center" style="font-size: 18px" >  إجمالي المدرسين  </p>
                      <h4 class="card-title">{{$count_teacher}}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


        




          
          <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-success bubble-shadow-small"
                    >
                    <i class="fas  fa-check"></i>

                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-5">
                    <div class="numbers">
                      <p class="card-category text-center" style="font-size: 18px" >الطلاب الناجحون</p>
                      <h4 class="card-title">{{$count_successful_students}}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
     


          <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-danger bubble-shadow-small"
                    >
                    <i class="fas fa-times-circle"></i>
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-5">
                    <div class="numbers">
                      <p class="card-category text-center" style="font-size: 18px" > الطلاب الراسبون </p>
                      <h4 class="card-title">{{$count_failed_students}}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
     

          <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-warning bubble-shadow-small"
                    >
                    <i class="fas  fa-clock"></i>
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-5">
                    <div class="numbers">
                      <p class="card-category text-center" style="font-size: 18px" >    الاعتراضات    </p>
                      <h4 class="card-title">{{$objection_count}}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>



          <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-primary bubble-shadow-small"
                    >
                    <i class="fas fa-book-open"></i>
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-5">
                    <div class="numbers">
                      <p class="card-category text-center" style="font-size: 18px" >  المواد الدراسية </p>
                      <h4 class="card-title">{{$count_subject}}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>



          <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-primary bubble-shadow-small"
                    >
                    <i class="fas fa-laptop-code"></i>
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-5">
                    <div class="numbers">
                      <p class="card-category text-center" style="font-size: 18px" >   اجمالي البرمجة </p>
                      <h4 class="card-title">{{$count_student_prog}}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
          <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-primary bubble-shadow-small"
                    >
                    <i class="fas fa-server"></i>
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-5">
                    <div class="numbers">
                      <p class="card-category text-center" style="font-size: 18px" >   اجمالي الشبكات </p>
                      <h4 class="card-title">{{$count_student_net}}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-primary bubble-shadow-small"
                    >
                    <i class="fas fa-wrench"></i>
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-5">
                    <div class="numbers">
                      <p class="card-category text-center" style="font-size: 18px" >   اجمالي الصيانة </p>
                      <h4 class="card-title">{{$count_student_main}}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          



     
      

        </div>
        
        
              
        <div class="col-md-12">
          <div class="card mb-3">
              <div class="card-header">
                 نسب النجاح والرسوب
              </div>
              <div class="card-body">
                  <canvas id="performanceChart"></canvas>
              </div>
          </div>
      </div>
      


  
      </div>
    </div>

   
  </div>

  <!-- Custom template | don't include it in your project! -->
  @include('layouts.admin.settings')
  <!-- End Custom template -->



  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

 
<script>
    var ctx = document.getElementById('performanceChart').getContext('2d');
    var performanceChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['برمجة - سنة أولى', 'برمجة - سنة ثانية', 'شبكات - سنة أولى', 'شبكات - سنة ثانية', 'صيانة - سنة أولى', 'صيانة - سنة ثانية'],
            datasets: [
                {
                    label: 'نسبة النجاح (%)',
                    data: [
                        {{ $success_percentages['programming']['year1'] }},
                        {{ $success_percentages['programming']['year2'] }},
                        {{ $success_percentages['networking']['year1'] }},
                        {{ $success_percentages['networking']['year2'] }},
                        {{ $success_percentages['maintenance']['year1'] }},
                        {{ $success_percentages['maintenance']['year2'] }},
                    ],
                    backgroundColor: '#28a745'
                },
                {
                    label: 'نسبة الرسوب (%)',
                    data: [
                        {{ $fail_percentages['programming']['year1'] }},
                        {{ $fail_percentages['programming']['year2'] }},
                        {{ $fail_percentages['networking']['year1'] }},
                        {{ $fail_percentages['networking']['year2'] }},
                        {{ $fail_percentages['maintenance']['year1'] }},
                        {{ $fail_percentages['maintenance']['year2'] }},
                    ],
                    backgroundColor: '#dc3545'
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
</script>



@endsection