<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\ExamsManageController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\ObjectionController;
use App\Http\Controllers\SupplementaryExamsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });



// DashBoard (Admin) :
Route::get('dashBoard/home' , [DashBoardController::class , 'index'])->name('dashBoard.home');

Route::get('/fetch/subjects/by/semester', [ExamsManageController::class , 'fetchSubjectsBySemester'])->name('fetch.subjects.by.semester');
Route::get('/fetch/subjects/by/semester/prog/two', [ExamsManageController::class , 'featchSubjectsBySemeterProgTwo'])->name('fetch.subjects.by.semester.prog.two');
Route::get('/fetch/subjects/by/semester/network', [ExamsManageController::class , 'fetchSubjectsBySemesterNetwork'])->name('fetch.subjects.by.semester.net');
Route::get('/fetch/subjects/by/semester/network/two', [ExamsManageController::class , 'fetchSubjectsSemesterNetwork'])->name('fetch.subjects.by.semester.net.two');
Route::get('/fetch/subjects/by/semester/main', [ExamsManageController::class , 'fetchSubjectsBySemesterMain'])->name('fetch.subjects.by.semester.main');
Route::get('/fetch/subjects/by/semester/main/two', [ExamsManageController::class , 'fetchSubjectsSemesterMain'])->name('fetch.subjects.by.semester.main.two');


Route::get('filter/prog/one'  , [StudentController::class , 'filterOneProg'])->name('filter');
Route::get('filter/prog/two'  , [StudentController::class , 'filterTwoProg'])->name('filtertwoprog');
Route::get('filter/net/one'  , [StudentController::class , 'filterOneNet'])->name('filterOneNet');
Route::get('filter/net/two'  , [StudentController::class , 'filterTwoNet'])->name('filterTwoNet');
Route::get('filter/main/one'  , [StudentController::class , 'filterOneMain'])->name('filterOneMain');
Route::get('filter/main/two'  , [StudentController::class , 'filterTwoMain'])->name('filterTwoMain');
Route::get('filter/subject', [SubjectController::class, 'filterSubject'])->name('filtersubject');
Route::get('filter/teacher', [TeacherController::class, 'filterTeacher'])->name('filterteacher');


//  DashBoard   Student 
Route::get('dashBoard/student/department/home/' , [StudentController::class , 'homeStudent'])->name('dashBoard.student.department.home');

Route::get('dashBoard/student/show/{id}' , [StudentController::class , 'show'])->name('dashBoard.student.show');
Route::get('dashBoard/student/year/two/show/{id}' , [StudentController::class , 'showStudentTwo'])->name('dashBoard.showStudentTwostudent_name.show');
Route::get('dashBoard/student/prog/year/one' , [StudentController::class , 'indexStudentOne'])->name('dashBoard.student.year.one');
Route::get('dashBoard/student/prog/year/two' , [StudentController::class , 'indexStudentTwo'])->name('dashBoard.student.year.two');
Route::get('dashBoard/student/network/year/one' , [StudentController::class , 'indexStudentNetworkOne'])->name('dashBoard.student.net.year.one');
Route::get('dashBoard/student/network/year/two' , [StudentController::class , 'indexStudentNetworkTwo'])->name('dashBoard.student.net.year.two');
Route::get('dashBoard/student/maintenance/year/one' , [StudentController::class , 'indexStudentMainOne'])->name('dashBoard.student.maintenance.year.one');
Route::get('dashBoard/student/maintenance/year/two' , [StudentController::class , 'indexStudentMainTwo'])->name('dashBoard.student.maintenance.year.two');
Route::get('dashBoard/student/create' , [StudentController::class , 'create'])->name('dashBoard.student.create');
Route::post('dashBoard/student/store' , [StudentController::class , 'store'])->name('dashBoard.student.store');
Route::get('dashBoard/student/edit/{id}' , [StudentController::class , 'edit'])->name('dashBoard.student.edit');
Route::get('dashBoard/student/year/two/edit/{id}' , [StudentController::class , 'editStudentYearTwo'])->name('dashBoard.studentYearTwo.edit');
Route::put('dashBoard/student/year/two/update/{id}' , [StudentController::class , 'updateStudentTwo'])->name('dashBoard.updateStudentTwo.update');
Route::put('dashBoard/student/update/{id}' , [StudentController::class , 'update'])->name('dashBoard.student.update');
Route::get('dashBoard/student/deleteTrash/{id}' , [StudentController::class , 'deleteTrash'])->name('dashBoard.student.deleteTrash');
Route::get('dashBoard/student/deleteStudentTwo/{id}' , [StudentController::class , 'deleteStudentTwo'])->name('dashBoard.student.deleteStudentTwo');



//  DashBoard   Teacher

// Route::get('dashBoard/teacher' , [TeacherController::class , 'home'])->name('dashBoard.teacher');
Route::get('dashBoard/teacher/home' , [TeacherController::class , 'index'])->name('dashBoard.teacher.home');
Route::get('dashBoard/teacher/create' , [TeacherController::class , 'create'])->name('dashBoard.teacher.create');
Route::post('dashBoard/teacher/store' , [TeacherController::class , 'store'])->name('dashBoard.teacher.store');
Route::get('dashBoard/teacher/edit/{id}' , [TeacherController::class , 'edit'])->name('dashBoard.teacher.edit');
Route::put('dashBoard/teacher/update/{id}' , [TeacherController::class , 'update'])->name('dashBoard.teacher.update');
Route::put('dashBoard/teacher/destroy/{id}' , [TeacherController::class , 'destroy'])->name('dashBoard.teacher.destroy');




// DashBoard  Subject

Route::get('dashBoard/subject/home' , [SubjectController::class , 'index'])->name('dashBoard.subject.home');
Route::get('dashBoard/subject/create' , [SubjectController::class , 'create'])->name('dashBoard.subject.create');
Route::post('dashBoard/subject/store' , [SubjectController::class , 'store'])->name('dashBoard.subject.store');
Route::get('dashBoard/subject/edit/{id}' , [SubjectController::class , 'edit'])->name('dashBoard.subject.edit');
Route::put('dashBoard/subject/update/{id}' , [SubjectController::class , 'update'])->name('dashBoard.subject.update');
Route::get('dashBoard/subject/destroy/{id}' , [SubjectController::class , 'destroy'])->name('dashBoard.subject.destroy');


// DashBoard specialization

Route::get('dashBoard/specialization/home' , [SpecializationController::class , 'index'])->name('dashBoard.specialization.home');
Route::get('dashBoard/specialization/create' , [SpecializationController::class , 'create'])->name('dashBoard.specialization.create');
Route::post('dashBoard/specialization/store' , [SpecializationController::class , 'store'])->name('dashBoard.specialization.store');
Route::get('dashBoard/specialization/edit/{id}' , [SpecializationController::class , 'edit'])->name('dashBoard.specialization.edit');
Route::put('dashBoard/specialization/update/{id}' , [SpecializationController::class , 'update'])->name('dashBoard.specialization.update');
Route::get('dashBoard/specialization/destroy/{id}' , [SpecializationController::class , 'destroy'])->name('dashBoard.specialization.destroy');


// Exames Manage 
Route::get('dashBoard/exams/manage/home' , [ExamsManageController::class , 'indexExames'])->name('dashBoard.exams.manage.home');
Route::get('dashBoard/exams/manage/create/student/mark/home' , [ExamsManageController::class , 'addMark'])->name('dashBoard.exams.manage.student.mark.home');

Route::get('dashBoard/exams/manage/create/student/mark/programming' , [ExamsManageController::class , 'StudentAddProgrammingExame'])->name('dashBoard.exams.manage.student.mark.create');
// Route::get('dashBoard/exams/manage/create/student/mark/programming' , [ExamsManageController::class , 'StudentAddProgrammingTwoExame'])->name('dashBoard.exams.manage.student.programmingTwo.mark.create');
// Route::post('dashBoard/exams/manage/create/student/mark/programming/store/' , [ExamsManageController::class , 'storeAddMarkProgrammingTwo'])->name('dashBoard.exams.manage.student.mark.programmingtow.store');
Route::post('dashBoard/exams/manage/create/student/mark/programming/store/' , [ExamsManageController::class , 'storeAddMarkProgramming'])->name('dashBoard.exams.manage.student.mark.programming.store');
//  Department NetWork 
Route::get('dashBoard/exams/manage/create/student/mark/network' , [ExamsManageController::class , 'StudentAddNetworkgExame'])->name('dashBoard.exams.manage.student.mark.storeAddMarkNetwork.create');
Route::post('dashBoard/exams/manage/create/student/mark/network/store/' , [ExamsManageController::class , 'storeAddMarkNetwork'])->name('dashBoard.exams.manage.student.mark.storeAddMarkNetwork.store');
Route::get('dashBoard/exams/manage/create/student/mark/deleted/{id}' , [ExamsManageController::class , 'destroy'])->name('dashBoard.exams.manage.student.mark.delete');

Route::get('dashBoard/exams/manage/create/student/mark/maintenance/' , [ExamsManageController::class , 'studentAddMarkMaintans'])->name('dashBoard.exams.manage.student.mark.storeAddMaintenance.create');
Route::post('dashBoard/exams/manage/create/student/mark/maintenance/store/' , [ExamsManageController::class , 'storeAddMarkMaintenance'])->name('dashBoard.exams.manage.student.mark.storeAddMarkMaintenance.store');




// View Mark 
Route::get('dashBoard/exams/manage/view/mark' , [ExamsManageController::class , 'homeMark'])->name('dashBoard.exams.manage.view.mark');


// view programming 
Route::get('dashBoard/exams/manage/view/mark/programming/year/one/' , [ExamsManageController::class , 'viewMarkprogYearOne'])->name('dashBoard.exams.manage.view.mark.programming.year.one');
Route::get('dashBoard/exams/manage/view/mark/programming/year/tow/' , [ExamsManageController::class , 'viewMarkprogYeartwo'])->name('dashBoard.exams.manage.view.mark.programming.year.tow');

// Network
Route::get('dashBoard/exams/manage/view/mark/network/year/one/' , [ExamsManageController::class , 'viewMarknetworkYearone'])->name('dashBoard.exams.manage.view.mark.network.year.one');
Route::get('dashBoard/exams/manage/view/mark/network/year/tow/' , [ExamsManageController::class , 'viewMarnetworkYeartwo'])->name('dashBoard.exams.manage.view.mark.network.year.tow');

// maintn
Route::get('dashBoard/exams/manage/view/mark/maintance/year/one/' , [ExamsManageController::class , 'viewMarkminYearone'])->name('dashBoard.exams.manage.view.mark.manitnace.year.one');
Route::get('dashBoard/exams/manage/view/mark/maintance/year/tow/' , [ExamsManageController::class , 'viewMarkminYeartwo'])->name('dashBoard.exams.manage.view.mark.manitnace.year.tow');

// Edit Exames Manage
Route::get('dashBoard/exams/manage/view/mark/programming/year/one/edit/{id}' , [ExamsManageController::class , 'EditAllMarkStudentProgOne'])->name('dashBoard.exams.manage.view.mark.programming.year.one.edit');
Route::put('dashBoard/exams/manage/view/mark/programming/year/one/update/{id}' , [ExamsManageController::class , 'updateProgrammingYearOne'])->name('dashBoard.exams.manage.view.mark.programming.year.one.update');
// Network One
Route::get('dashBoard/exams/manage/view/mark/network/year/one/edit/{id}' , [ExamsManageController::class , 'EditAllMarkStudentNetworkOne'])->name('dashBoard.exams.manage.view.mark.network.year.one.edit');
Route::put('dashBoard/exams/manage/view/mark/network/year/tow/update/{id}' , [ExamsManageController::class , 'updateNetWorkYearOne'])->name('dashBoard.exams.manage.view.mark.network.year.one.update');
// main One
Route::get('dashBoard/exams/manage/view/mark/maintenance/year/one/edit/{id}' , [ExamsManageController::class , 'EditAllMarkStudentMainOne'])->name('dashBoard.exams.manage.view.mark.EditAllMarkStudentMainOne.year.one.edit');
Route::put('dashBoard/exams/manage/view/mark/maintenance/year/two/update/s/{id}' , [ExamsManageController::class , 'updateMainYearOne'])->name('dashBoard.exams.manage.view.mark.EditAllMarkStudentMainOne.year.one.update');



//  Programming Two
Route::get('dashBoard/exams/manage/view/mark/programming/year/two/edit/{id}' , [ExamsManageController::class , 'EditAllMarkStudentProgTwo'])->name('dashBoard.exams.manage.view.mark.programming.year.two.edit');
Route::put('dashBoard/exams/manage/view/mark/programming/year/two/update/{id}' , [ExamsManageController::class , 'updateProgrammingYearTwo'])->name('dashBoard.exams.manage.view.mark.programming.year.two.update');
//  Network Two
Route::get('dashBoard/exams/manage/view/mark/network/year/two/edit/{id}' , [ExamsManageController::class , 'EditAllMarkStudentNetworkTwo'])->name('dashBoard.exams.manage.view.mark.network.year.two.edit');
Route::put('dashBoard/exams/manage/view/mark/network/year/two/update/{id}' , [ExamsManageController::class , 'updateNetworkYearTwo'])->name('dashBoard.exams.manage.view.mark.network.year.two.update');
//  Maintenance Two
Route::get('dashBoard/exams/manage/view/mark/maintenance/year/two/edit/{id}' , [ExamsManageController::class , 'EditAllMarkStudentMainTwo'])->name('dashBoard.exams.manage.view.mark.maintenance.year.two.edit');
Route::put('dashBoard/exams/manage/view/mark/maintenance/year/two/update/{id}' , [ExamsManageController::class , 'updateMainYearTwo'])->name('dashBoard.exams.manage.view.mark.maintenance.year.two.update');







// View All Categories
Route::get('dashBoard/exams/manage/view/programming/year/one/' , [ExamsManageController::class , 'viewprogramming'])->name('dashBoard.exams.manage.view.programming.year.one');
Route::get('dashBoard/exams/manage/view/programming/year/two/create/' , [ExamsManageController::class , 'createStudentTwoProg'])->name('dashBoard.exams.manage.view.programming.year.two.create');
Route::post('dashBoard/exams/manage/view/programming/year/two/store/' , [ExamsManageController::class , 'storeStudentTwoMarkProg'])->name('dashBoard.exams.manage.view.programming.year.two.store');

Route::get('dashBoard/exams/manage/view/network/' , [ExamsManageController::class , 'viewNetwork'])->name('dashBoard.exams.manage.view.network');
Route::get('dashBoard/exams/manage/view/network/year/two/create/' , [ExamsManageController::class , 'createStudentTwoNet'])->name('dashBoard.exams.manage.view.network.year.two.create');
Route::post('dashBoard/exams/manage/view/network/year/two/store/' , [ExamsManageController::class , 'storeStudentTwoNet'])->name('dashBoard.exams.manage.view.network.year.two.store');

Route::get('dashBoard/exams/manage/view/maintince/' , [ExamsManageController::class , 'viewMain'])->name('dashBoard.exams.manage.view.main');
Route::get('dashBoard/exams/manage/view/maintance/year/two/create/' , [ExamsManageController::class , 'createStudentTwoMani'])->name('dashBoard.exams.manage.view.main.year.two.create');
Route::post('dashBoard/exams/manage/view/maintance/year/two/store/' , [ExamsManageController::class , 'storeStudentTwoMain'])->name('dashBoard.exams.manage.view.main.year.two.store');


// Objections Mark Student 
Route::get('/dashBoard/exams/objection/home/' , [ObjectionController::class , 'index'])->name('dashBoard.exams.objection.home');
Route::get('/dashBoard/exams/objection/show/mark/{id}' , [ObjectionController::class , 'show'])->name('dashBoard.exams.objection.show');
Route::get('/dashBoard/exams/objection/show/mark/delete/{id}' , [ObjectionController::class , 'destroy'])->name('dashBoard.exams.objection.delete');
Route::post('/submit-objection', [ObjectionController::class, 'store'])->name('submit-objection');


Route::get('/notifications', [ObjectionController::class, 'notificationsShow'])->name('notifications');
Route::get('/objections/confirm/delete/{id}', [ObjectionController::class, 'notificaitonObjection'])->name('objection.notification.delete');




// Mark All as Department 
Route::get('dashBoard/mark/manage/' , [ExamsManageController::class , 'programmingOne'])->name('dashBoard.mark.manage');
Route::get('dashBoard/mark/manage/network/' , [ExamsManageController::class , 'NetworkOne'])->name('dashBoard.mark.manage');
Route::get('dashBoard/mark/manage/main/' , [ExamsManageController::class , 'MainOne'])->name('dashBoard.mark.manage.main');


// ==================================================================================
// Public Page Site 
Route::get('/' , [homeController::class , 'home'])->name('home');
Route::get('mark' , [homeController::class , 'login'])->name('login');




// نظام التكميلي
Route::get('dashBoard/supplementary/manage/' , [SupplementaryExamsController::class , 'index'])->name('dashBoard.supplementary.manage');
Route::get('dashBoard/supplementary/add/mark/supplement/manage/' , [SupplementaryExamsController::class , 'addMarkSupplement'])->name('dashBoard.addMarkSupplement.manage');
Route::get('dashBoard/supplementary/add/mark/supplement/manage/programming/' , [SupplementaryExamsController::class , 'addMarkSupplementDepProg'])->name('dashBoard.addMarkSupplementDepProg.manage');
Route::get('dashBoard/supplementary/add/mark/supplement/manage/network/' , [SupplementaryExamsController::class , 'addMarkSupplementDepNetwork'])->name('dashBoard.addMarkSupplementDepNetwork.manage');
Route::get('dashBoard/supplementary/add/mark/supplement/manage/maintenance/' , [SupplementaryExamsController::class , 'addMarkSupplementDepMain'])->name('dashBoard.addMarkSupplementDepMain.manage');


// One
Route::get('dashBoard/supplementary/add/mark/supplement/manage/programming/one/' , [SupplementaryExamsController::class , 'addMarkSupplementDepProgrammingOne'])->name('dashBoard.addMarkSupplementDepProgrammingOne.manage');
Route::post('dashBoard/supplementary/add/mark/supplement/manage/programming/one/store/' , [SupplementaryExamsController::class , 'storeAddMarkProgrammingOne'])->name('dashBoard.addMarkSupplementDepProgrammingOne.manage.store');
// Two
Route::get('dashBoard/supplementary/add/mark/supplement/manage/programming/two/' , [SupplementaryExamsController::class , 'addMarkSupplementDepProgrammingTwo'])->name('dashBoard.addMarkSupplementDepProgrammingTwo.manage');
Route::post('dashBoard/supplementary/add/mark/supplement/manage/programming/two/store/' , [SupplementaryExamsController::class , 'storeAddMarkProgrammingTwo'])->name('dashBoard.addMarkSupplementDepProgrammingTwo.manage.store');

// One
Route::get('dashBoard/supplementary/add/mark/supplement/manage/network/one/' , [SupplementaryExamsController::class , 'addMarkSupplementDepNetworkOne'])->name('dashBoard.addMarkSupplementDepNetworkOne.manage');
Route::post('dashBoard/supplementary/add/mark/supplement/manage/network/one/store/' , [SupplementaryExamsController::class , 'storeAddMarkNetworkOne'])->name('dashBoard.addMarkSupplementDepNetworkOne.manage.store');


// Two
Route::get('dashBoard/supplementary/add/mark/supplement/manage/network/two/' , [SupplementaryExamsController::class , 'addMarkSupplementDepNetworkTwo'])->name('dashBoard.addMarkSupplementDepNetworkTwo.manage');
Route::post('dashBoard/supplementary/add/mark/supplement/manage/network/two/store/' , [SupplementaryExamsController::class , 'storeAddMarkNetworkTwo'])->name('dashBoard.addMarkSupplementDepNetworkTwo.manage.store');



// One
Route::get('dashBoard/supplementary/add/mark/supplement/manage/maintenance/one/' , [SupplementaryExamsController::class , 'addMarkSupplementDepMainOne'])->name('dashBoard.addMarkSupplementDepMainOne.manage');
Route::post('dashBoard/supplementary/add/mark/supplement/manage/maintenance/one/store/' , [SupplementaryExamsController::class , 'storeAddMarkMainOne'])->name('dashBoard.storeAddMarkMainOne.manage.store');

// Two
Route::get('dashBoard/supplementary/add/mark/supplement/manage/maintenance/two/' , [SupplementaryExamsController::class , 'addMarkSupplementDepMainTwo'])->name('dashBoard.addMarkSupplementDepMainTwo.manage');
Route::post('dashBoard/supplementary/add/mark/supplement/manage/maintenance/two/store/' , [SupplementaryExamsController::class , 'storeAddMarkMainOne'])->name('dashBoard.storeAddMarkMainTwo.manage.store');


// View All Mark (Student) Supplement
Route::get('dashBoard/supplementary/supplement/manage/all/mark/supplement/' , [SupplementaryExamsController::class , 'allMarkSupplement'])->name('dashBoard.allMarkSupplement.manage');
Route::get('dashBoard/supplementary/supplement/manage/all/mark/supplement/programming/one/' , [SupplementaryExamsController::class , 'viewMarkSupplementprogYearOne'])->name('dashBoard.viewMarkSupplementprogYearOne.manage');
Route::get('dashBoard/supplementary/supplement/manage/all/mark/supplement/programming/two/' , [SupplementaryExamsController::class , 'viewMarkSupplementprogYearTwo'])->name('dashBoard.viewMarkSupplementprogYearTwo.manage');
Route::get('dashBoard/supplementary/supplement/manage/all/mark/supplement/network/one/' , [SupplementaryExamsController::class , 'viewMarkSupplementNetworkYearOne'])->name('dashBoard.viewMarkSupplementNetworkYearOne.manage');
Route::get('dashBoard/supplementary/supplement/manage/all/mark/supplement/network/two/' , [SupplementaryExamsController::class , 'viewMarkSupplementNetworkYearTwo'])->name('dashBoard.viewMarkSupplementNetworkYearTwo.manage');
Route::get('dashBoard/supplementary/supplement/manage/all/mark/supplement/maintenance/one/',[SupplementaryExamsController::class , 'viewMarkSupplementMainYearOne'])->name('dashBoard.viewMarkSupplementMainYearOne.manage');
Route::get('dashBoard/supplementary/supplement/manage/all/mark/supplement/maintenance/two/' , [SupplementaryExamsController::class , 'viewMarkSupplementMainYearTwo'])->name('dashBoard.viewMarkSupplementMainYearTwo.manage');
