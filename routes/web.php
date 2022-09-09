<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// redirect to related routes from the main route
Route::get('/', [\App\Http\Controllers\AuthController::class, "redirect"])->middleware(['AuthOnly']);

// routes before user is not logged in
Route::middleware(['NotAuth'])->group(function () {
    // admin login
    Route::get('/login/admin', [App\Http\Controllers\AuthController::class, "adminLogin"]);
    Route::post('/login/admin', [\App\Http\Controllers\AuthController::class, "postAdminLogin"]);

    // moderator login
    Route::get('/login/moderator', [\App\Http\Controllers\AuthController::class, "moderatorLogin"]);
    Route::post('/login/moderator', [\App\Http\Controllers\AuthController::class, "postModeratorLogin"]);

    // teacher login
    Route::get('/login/teacher', [\App\Http\Controllers\AuthController::class, "teacherLogin"]);
    Route::post('/login/teacher', [\App\Http\Controllers\AuthController::class, "postTeacherLogin"]);

    // student login
    Route::get('/login/student', [\App\Http\Controllers\AuthController::class, "studentLogin"]);
    Route::post('/login/student', [\App\Http\Controllers\AuthController::class, "postStudentLogin"]);

    // moderator register
    Route::get('/register/moderator', [\App\Http\Controllers\AuthController::class, "moderatorRegister"]);
    Route::post('/register/moderator', [\App\Http\Controllers\AuthController::class, "postModeratorRegister"]);

    // teacher register
    Route::get('/register/teacher', [\App\Http\Controllers\AuthController::class, "teacherRegister"]);
    Route::post('/register/teacher', [\App\Http\Controllers\AuthController::class, "postTeacherRegister"]);

    // student register
    Route::get('/register/student', [\App\Http\Controllers\AuthController::class, "studentRegister"]);
    Route::post('/register/student', [\App\Http\Controllers\AuthController::class, "postStudentRegister"]);
});

// routes after user logined
Route::middleware(['AuthOnly'])->group(function () {
    // user logout
    Route::get('/logout', [\App\Http\Controllers\AuthController::class, "logout"]);

    // profile
    Route::get('/profile', [\App\Http\Controllers\AuthController::class, "profile"]);
});

// routes for admin and moderator
Route::prefix('admin-mod')->middleware(['AdminMod'])->group(function () {
    // statistics 
    Route::get('/statistics', [\App\Http\Controllers\AdminMod\AdminModController::class, "statistics"]);

    // moderator approve routes
    Route::get('/approve-moderator', [\App\Http\Controllers\AdminMod\AdminModController::class, "approveModerator"]);
    Route::post('/approve-moderator/approve', [\App\Http\Controllers\AdminMod\AdminModController::class, "postApproveModerator"]);
    Route::post('/approve-moderator/decline', [\App\Http\Controllers\AdminMod\AdminModController::class, "postDeclineModerator"]);

    // teacher approve routes
    Route::get('/approve-teacher', [\App\Http\Controllers\AdminMod\AdminModController::class, "approveTeacher"]);
    Route::post('/approve-teacher/approve', [\App\Http\Controllers\AdminMod\AdminModController::class, "postApproveTeacher"]);
    Route::post('/approve-teacher/decline', [\App\Http\Controllers\AdminMod\AdminModController::class, "postDeclineTeacher"]);

    // student approve routes
    Route::get('/approve-student', [\App\Http\Controllers\AdminMod\AdminModController::class, "approveStudent"]);
    Route::post('/approve-student/approve', [\App\Http\Controllers\AdminMod\AdminModController::class, "postApproveStudent"]);
    Route::post('/approve-student/decline', [\App\Http\Controllers\AdminMod\AdminModController::class, "postDeclineStudent"]);

    // batch routes
    Route::resource('batch', '\App\Http\Controllers\AdminMod\BatchController');

    // subject routes
    Route::get('/subject', [\App\Http\Controllers\AdminMod\SubjectController::class, "subject"]);
    Route::get('/subject/create', [\App\Http\Controllers\AdminMod\SubjectController::class, "createSubject"]);
    Route::post('/subject/create', [\App\Http\Controllers\AdminMod\SubjectController::class, "postCreateSubject"]);
    Route::post('/subject/delete', [\App\Http\Controllers\AdminMod\SubjectController::class, "deleteSubject"]);
    Route::get('/subject/edit/{id}', [\App\Http\Controllers\AdminMod\SubjectController::class, "editSubject"]);
    Route::post('/subject/edit', [\App\Http\Controllers\AdminMod\SubjectController::class, "postEditSubject"]);

    // student batch assign routes
    Route::get('/search-student/assign/batch/{id}', [\App\Http\Controllers\SearchController::class, "assignBatch"]);
    Route::post('/search-student/assign/batch/{id}', [\App\Http\Controllers\SearchController::class, "postAssignBatch"]);

    // student account delete route
    Route::post('/search-student/delete', [\App\Http\Controllers\SearchController::class, "postDeleteStudent"]);

    // teacher account delete route
    Route::post('/search-teacher/delete', [\App\Http\Controllers\SearchController::class, "postDeleteTeacher"]);

    // search moderator accounts route
    Route::get('/search-moderator', [\App\Http\Controllers\SearchController::class, "searchModerator"]);
});

// outes for admins, moderators and teachers
Route::prefix('admin-mod-teacher')->middleware(['AdminModTeacher'])->group(function () {
    // search student
    Route::get('/search-student', [\App\Http\Controllers\SearchController::class, "searchStudent"]);

    // search teacher
    Route::get('/search-teacher', [\App\Http\Controllers\SearchController::class, "searchTeacher"]);
});

// routes only for admins
Route::prefix('admin')->middleware(['AdminOnly'])->group(function () {
    Route::post('/search-moderator/delete', [\App\Http\Controllers\SearchController::class, "postDeleteModerator"]);
});

// routes only for teacher and students
Route::prefix('teacher-student')->middleware(['TeacherStudent'])->group(function () {
    // subject of teacher or student
    Route::get('/your-subjects', [\App\Http\Controllers\TeacherStudent\SubjectController::class, "yourSubjects"]);
    Route::post('/your-subjects', [\App\Http\Controllers\TeacherStudent\SubjectController::class, "postYourSubjects"]);
    Route::get('/your-subjects/view/{id}', [\App\Http\Controllers\TeacherStudent\SubjectController::class, "viewSubject"]);
});

// routes only for teachers
Route::prefix('teacher')->middleware(['TeacherOnly'])->group(function () {
    // edit zoom info of the subject
    Route::get('/edit-zoom-info/{id}', [\App\Http\Controllers\Teacher\SubjectController::class, "editZoomInfo"]);
    Route::post('/edit-zoom-info', [\App\Http\Controllers\Teacher\SubjectController::class, "postEditZoomInfo"]);

    // section reoutes
    Route::get('/create-section/{id}', [\App\Http\Controllers\Teacher\SectionController::class, "createSection"]);
    Route::post('/create-section', [\App\Http\Controllers\Teacher\SectionController::class, "postCreateSection"]);
    Route::get('/edit-section/{id}', [\App\Http\Controllers\Teacher\SectionController::class, "editSection"]);
    Route::post('/edit-section', [\App\Http\Controllers\Teacher\SectionController::class, "postEditSection"]);
    Route::post('/delete-section', [\App\Http\Controllers\Teacher\SectionController::class, "postDeleteSection"]);

    // files of the section
    Route::get('/add-file/{id}', [\App\Http\Controllers\Teacher\SectionController::class, "addFile"]);
    Route::post('/add-file', [\App\Http\Controllers\Teacher\SectionController::class, "postAddFile"]);
    Route::post('/delete-file', [\App\Http\Controllers\Teacher\SectionController::class, "postDeleteFile"]);

    // forms of the subject routes
    Route::get('/create-form/{id}', [\App\Http\Controllers\Teacher\FormController::class, "createForm"]);
    Route::post('/create-form', [\App\Http\Controllers\Teacher\FormController::class, "postCreateForm"]);
    Route::get('/edit-form/{id}', [\App\Http\Controllers\Teacher\FormController::class, "editForm"]);
    Route::post('/edit-form', [\App\Http\Controllers\Teacher\FormController::class, "postEditForm"]);
    Route::get('/view-form/{id}', [\App\Http\Controllers\Teacher\FormController::class, "viewForm"]);
    Route::post('/delete-form', [\App\Http\Controllers\Teacher\FormController::class, "deleteForm"]);
});

// routes only for student
Route::prefix('student')->middleware(['StudentOnly'])->group(function () {
    // upload files to form route
    Route::get('/create-upload/{id}', [\App\Http\Controllers\Student\UploadController::class, "upload"]);
});
