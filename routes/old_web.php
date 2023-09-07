<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->GET('/cache-clear', function () use ($router) {
    Cache::flush();
    return response()->json(['message' => 'Cache Clear Successfully'], 200);
});

$router->GET('/', function () use ($router) {
    return response()->json("Hello ! Welcome to Dhaka International University.");
});

$router->POST('auth/login', ['uses' => 'AuthController@authenticate']);
$router->POST('auth/password/request', ['uses' => 'ForgetPasswordResetController@send_verification_code']);
$router->POST('auth/code/verification', ['uses' => 'ForgetPasswordResetController@verification_code']);
$router->PUT('auth/password/reset', ['uses' => 'ForgetPasswordResetController@password_reset']);

// $router->group(['middleware' => 'CorsMiddleware'], function() use ($router) {
//
// });

$router->POST('student/registration', ['as' => 'students.registration', 'uses' => 'STD\StudentsAuthController@registration']);
$router->POST('student/login', ['as' => 'students.login', 'uses' => 'STD\StudentsAuthController@login']);
$router->POST('student/email_reset', ['as' => 'students.email_reset', 'uses' => 'STD\StudentsAuthController@email_reset']);

$router->POST('student/forgot_password', ['as' => 'students.forgot_password', 'uses' => 'STD\StudentsAuthController@forgot_password']);
$router->PUT('student/reset_password/{token}', ['as' => 'students.update_password', 'uses' => 'STD\StudentsAuthController@update_password']);

$router->POST('student/verification/resend', ['as' => 'students.verification_resend', 'uses' => 'STD\StudentsAuthController@verification_resend']);

$router->GET('student/verify_account/{token}', ['as' => 'students.verify_account', 'uses' => 'STD\StudentsAuthController@verify_account']);
$router->GET('student/verify_token/{token}', ['as' => 'students.verify_token', 'uses' => 'STD\StudentsAuthController@verify_token']);
$router->GET('students/departments', ['as' => 'students.departments', 'uses' => 'STD\DepartmentController@index']);
$router->GET('student_group', ['as' => 'students.student_group', 'uses' => 'STD\DepartmentController@student_group']);

$router->GET('face_to_face_help', ['as' => 'employee_group.face_to_face_help', 'uses' => 'PublicAccessApi\EmployeeController@face_to_face_help']);

$router->GET('student/mails', ['as' => 'students.verify_token', 'uses' => 'VestacpStudentsController@index']);
$router->GET('division', ['as' => 'division', 'uses' => 'DivisionController@index']);
$router->GET('district/{division_id}', ['as' => 'district', 'uses' => 'DiscrictController@index']);
$router->GET('upzila/{district_id}', ['as' => 'upzila', 'uses' => 'UpazilaController@index']);


$router->POST('transcript_verification', ['as' => 'transcript.verification', 'uses' => 'PublicAccessApi\StudentsWebAPIController@transcript_verification']);
$router->GET('transcript/download/{filename}/{token}', ['as' => 'transcript.show', 'uses' => 'PublicAccessApi\StudentsWebAPIController@transcript_download']);

/* for diu.ac */
$router->GET('get_faculty_teachers/{dept_short_code}', ['as' => 'get_faculty_teachers.show', 'uses' => 'PublicAccessApi\ProfileController@get_faculty_teachers']);
$router->GET('get_key_resource_person', ['as' => 'get_key_resource_person', 'uses' => 'PublicAccessApi\ProfileController@get_key_resource_person']);
$router->GET('get_department_chairman/{dept_short_code}', ['as' => 'get_department_chairman.show', 'uses' => 'PublicAccessApi\ProfileController@get_department_chairman']);

$router->GET('tuition_fee', ['as' => 'tuition_fee.all_tuition_fee', 'uses' => 'PublicAccessApi\PublicController@tuition_fee']);
$router->GET('get_all_course_fee', ['as' => 'get_all_course_fee.all_tuition_fee', 'uses' => 'PublicAccessApi\PublicController@get_all_course_fee']);
$router->GET('faculty_tuition_fee/{faculty}', ['as' => 'tuition_fee.faculty_tuition_fee', 'uses' => 'PublicAccessApi\PublicController@faculty_tuition_fee']);

$router->GET('international_tuition_fee', ['as' => 'tuition_fee.international_tuition_fee', 'uses' => 'PublicAccessApi\PublicController@international_tuition_fee']);
$router->GET('international_faculty_tuition_fee/{faculty}', ['as' => 'tuition_fee.international_faculty_tuition_fee', 'uses' => 'PublicAccessApi\PublicController@international_faculty_tuition_fee']);

$router->group(['prefix' => 'public'], function () use ($router) {
    $router->GET('profile/{slug}', ['as' => 'profile', 'uses' => 'PublicAccessApi\ProfileController@slug_profile']);
    $router->GET('employees', ['as' => 'employees', 'uses' => 'PublicAccessApi\EmployeeController@employees']);
    $router->GET('executive', ['as' => 'executive', 'uses' => 'PublicAccessApi\EmployeeController@executive_employees']);
    $router->GET('faculty', ['as' => 'faculty', 'uses' => 'PublicAccessApi\EmployeeController@faculty_employees']);
    $router->GET('officers', ['as' => 'officers', 'uses' => 'PublicAccessApi\EmployeeController@officers_employees']);
    $router->GET('staff', ['as' => 'staff', 'uses' => 'PublicAccessApi\EmployeeController@staff_employees']);
    $router->GET('admission_team', ['as' => 'admission_team', 'uses' => 'PublicAccessApi\EmployeeController@admission_team']);

    $router->GET('get_departments_without_shift', ['as' => 'get_departments_without_shift', 'uses' => 'PublicAccessApi\StudentsWebAPIController@get_departments_array']);
    $router->GET('get_departments', ['as' => 'get_departments', 'uses' => 'PublicAccessApi\StudentsWebAPIController@get_departments']);
    $router->GET('get_batch_id_name/{department_id}', ['as' => 'get_batch_id_name', 'uses' => 'PublicAccessApi\StudentsWebAPIController@get_batch_id_name']);
    $router->GET('check_student/{department_id}/{batch_id}/{reg_code}/{roll_no}/{phone_no}', ['as' => 'check_student', 'uses' => 'PublicAccessApi\StudentsWebAPIController@check_student']);

    $router->GET('get_students_by_batch_id/{batch_id}', ['as' => 'get_students_by_batch_id', 'uses' => 'PublicAccessApi\StudentsWebAPIController@get_students_by_batch_id']);

    $router->POST('/create-student-account', ['as' => 'student_account_wifi_email_create', 'uses' => 'PublicAccessApi\StudentsAccountCreateFromERPController@store']);
    $router->GET('std_account_info/{ora_uid}', ['as' => 'students_website.std_account_info', 'uses' => 'STD\StudentsController@student_account_info']);
    $router->GET('std_account_info_summary/{ora_uid}', ['as' => 'students_website.std_account_info_summary', 'uses' => 'STD\StudentsController@student_account_info_summary']);

    $router->GET('download_regular_admit_card/{ora_uid}', ['as' => 'accounts.download_regular_admit_card', 'uses' => 'STD\RegularAdmitCardController@download_regular_admit_card']);
    $router->GET('get_purpose_pay', ['as' => 'accounts.get_purpose_pay', 'uses' => 'STD\RegularAdmitCardController@getPurposePay']);

    /*
            course fee calculation start
        */
    $router->group(['prefix' => 'admission',], function () use ($router) {
        $router->get('generale-student-program', ['as' => 'admission.generalStudentPrograms', 'uses' => 'Admission\CourseFeeCalculationController@generalStudentPrograms']);
        $router->get('diploma-student-program', ['as' => 'admission.diplomaStudentPrograms', 'uses' => 'Admission\CourseFeeCalculationController@diplomaStudentPrograms']);
        $router->get('course-fee-calculation', ['as' => 'admission.courseFeeCalculationAdmissionSite', 'uses' => 'Admission\CourseFeeCalculationController@courseFeeCalculationAdmissionSite']);
    });
    /*
        course fee calculation end
    */


});

$router->GET('student/public/profile[/{slug_name}]', ['as' => 'students.public_profile', 'uses' => 'STD\StudentsController@public_profile']);
$router->GET('student/public/download_cv/{slug_name}', ['as' => 'students.cv_download', 'uses' => 'STD\StudentsController@profile_download_cv']);

$router->GET('get_students', ['as' => 'students.list', 'uses' => 'STD\StudentsController@index']);
$router->GET('filter-students/{searchKey}', ['as' => 'students.filterList', 'uses' => 'STD\StudentsController@filterList']);
$router->GET('get-student-semester/{student_id}', ['as' => 'students.semesterList', 'uses' => 'STD\StudentsController@semesterList']);
$router->GET('get-student-teacher-course/{student_id}/{semester}', ['as' => 'students.teacherAndCourseLists', 'uses' => 'STD\StudentsController@teacherAndCourseLists']);


$router->group(['middleware' => ['token.student.auth']], function () use ($router) {

    /*
        STUDENT ATTENDANCE
    */

    $router->GET('student/get-course', ['as' => 'students_website.get-course', 'uses' => 'STD\StudentsiteAttendanceController@getCourse']);
    $router->GET('student/get-course-attendance/{courseId}', ['as' => 'students_website.get-course-attendance', 'uses' => 'STD\StudentsiteAttendanceController@getCourseAttendance']);


    $router->GET('student/profile', ['as' => 'students_website.profile', 'uses' => 'STD\StudentsController@show']);
    $router->GET('student/feedbackCheck', ['as' => 'students_website.feedbackCheck', 'uses' => 'STD\StudentsController@feedbackCheck']);


//    $router->POST('student/profile/personal', ['as' => 'students_website.profile_update', 'uses' => 'STD\StudentsController@profile_update_personal']);

    $router->POST('student/profile/upload_profile_photo', ['as' => 'students_website.cv_upload', 'uses' => 'STD\StudentsController@upload_profile_photo']);
    $router->POST('student/profile/upload_cv', ['as' => 'students_website.cv_upload', 'uses' => 'STD\StudentsController@profile_upload_cv']);

    $router->POST('student/profile/personal', ['as' => 'students_website.profile_update', 'uses' => 'STD\StudentsController@profile_update_personal']);
    $router->GET('student/profile/personal/change-visibility', ['as' => 'students_website.profile_visibility', 'uses' => 'STD\StudentsController@change_profile_visibility']);

    $router->POST('student/profile/social', ['as' => 'students_website.store_social_contact', 'uses' => 'STD\StudentsSocialContactController@store']);
    $router->DELETE('student/profile/social/{id}/delete', ['as' => 'students_website.delete_social_contact', 'uses' => 'STD\StudentsSocialContactController@destroy']);

    $router->POST('student/profile/education', ['as' => 'students_website.store_education_qualification', 'uses' => 'STD\StudentsEducationQualificationContactController@store']);
    $router->DELETE('student/profile/education/{id}/delete', ['as' => 'students_website.delete_education_qualification', 'uses' => 'STD\StudentsEducationQualificationContactController@destroy']);
    $router->POST('student/create_mail_account', ['as' => 'students_website.create_mail_account', 'uses' => 'VestacpStudentsController@store']);

    /* Improvement Routes */
    $router->GET('eligible_for_incourse/{examSchedule}', ['as' => 'students_website.eligible_for_incourse', 'uses' => 'STD\ImprovementController@eligible_for_incourse']);
    $router->GET('eligible_for_final/{examSchedule}', ['as' => 'students_website.eligible_for_final', 'uses' => 'STD\ImprovementController@eligible_for_final']);
    $router->GET('get_current_improvement_exam_schedule', ['as' => 'students_website.get_current_improvement_exam_schedule', 'uses' => 'STD\ImprovementController@get_current_improvement_exam_schedule']);
    $router->GET('get_applied_improvement_exam_schedule', ['as' => 'students_website.get_applied_improvement_exam_schedule', 'uses' => 'STD\ImprovementController@get_applied_improvement_exam_schedule']);
    $router->POST('apply_improvement_request', ['as' => 'students_website.apply_improvement_request', 'uses' => 'STD\ImprovementController@store']);
    $router->POST('cancel_improvement_request', ['as' => 'students_website.cancel_improvement_request', 'uses' => 'STD\ImprovementController@destroy']);
    $router->POST('get_improvement_marksheet_for_student', ['as' => 'students_website.get_improvement_marksheet_for_student', 'uses' => 'STD\ImprovementController@get_improvement_marksheet_for_student']);
    $router->GET('download_application/{currentExamScheduleId}/{type}', ['as' => 'students_website.download_application', 'uses' => 'STD\ImprovementController@application']);

    $router->GET('get_improvement_exam_routine[/{examSheduleId}]', ['as' => 'students_website.get_improvement_exam_routine', 'uses' => 'STD\ImprovementController@getImprovementExamRoutine']);
    $router->GET('get_all_improvement_exam_schedule', ['as' => 'students_website.get_all_improvement_exam_schedule', 'uses' => 'STD\ImprovementController@getImprovementExamSchedule']);


    $router->POST('student/change_mail_account_password', ['as' => 'students_website.change_mail_account_password', 'uses' => 'VestacpStudentsController@change_password']);
    $router->GET('student/delete_mail_account', ['as' => 'students_website.delete_mail_account', 'uses' => 'VestacpStudentsController@destroy']);

    $router->POST('student/create_wifi_account', ['as' => 'students_website.create_wifi_account', 'uses' => 'StudentsLdapController@store']);
    $router->POST('student/change_wifi_account_password', ['as' => 'students_website.change_wifi_account_password', 'uses' => 'StudentsLdapController@change_password']);
    $router->GET('student/delete_wifi_account', ['as' => 'students_website.delete_wifi_account', 'uses' => 'StudentsLdapController@destroy']);

    $router->POST('student/create_wifi_account_with_mac', ['as' => 'students_website.create_wifi_account', 'uses' => 'StudentPfsenseController@store']);
    $router->DELETE('student/delete_wifi_account_with_mac', ['as' => 'students_website.delete_wifi_account', 'uses' => 'StudentPfsenseController@destroy']);


    $router->POST('student/change_password', ['as' => 'students_website.change_password', 'uses' => 'STD\StudentsController@change_password']);
    $router->GET('provisional_result/{ora_uid}', ['as' => 'students_website.provisional_result', 'uses' => 'STD\StudentsController@provisional_result']);
    $router->GET('student_account_info/{ora_uid}', ['as' => 'students_website.student_account_info', 'uses' => 'STD\StudentsController@student_account_info']);
    $router->GET('student_account_info_summary/{ora_uid}', ['as' => 'students_website.student_account_info_summary', 'uses' => 'STD\StudentsController@student_account_info_summary']);
    $router->GET('student_batch_mate/{ora_uid}', ['as' => 'students_website.student_batch_mate', 'uses' => 'STD\StudentsController@student_batch_mate']);


    $router->GET('student-admit-card', ['as' => 'students_website.studentAdmitCard', 'uses' => 'STD\StudentsController@studentAdmitCard']);

    $router->POST('find_material_books', ['as' => 'students_website.material_books_list', 'uses' => 'STD\BookController@find_books']);
    $router->POST('find_material_syllabus', ['as' => 'students_website.material_syllabus_list', 'uses' => 'STD\SyllabusController@find_syllabus']);
    $router->POST('find_material_questions', ['as' => 'students_website.material_questions_list', 'uses' => 'STD\QuestionController@find_questions']);
    $router->POST('find_material_lesson_plans', ['as' => 'students_website.material_lesson_plans_list', 'uses' => 'STD\LessonPlanController@find_lesson_plans']);
    $router->POST('find_material_lecture_sheets', ['as' => 'students_website.material_lecture_sheets_list', 'uses' => 'STD\LectureSheetController@find_lecture_sheets']);

    $router->GET('material/syllabus/{id}/{key}/download', ['as' => 'students_website.material_syllabus_download', 'uses' => 'STD\SyllabusController@download']);
    $router->GET('material/questions/{id}/{key}/download', ['as' => 'students_website.material_questions_download', 'uses' => 'STD\QuestionController@download']);
    $router->GET('material/lesson_plans/{id}/{key}/download', ['as' => 'students_website.material_lesson_plans_download', 'uses' => 'STD\LessonPlanController@download']);
    $router->GET('material/lecture_sheets/{id}/{key}/download', ['as' => 'students_website.material_lecture_sheets_download', 'uses' => 'STD\LectureSheetController@download']);


    // student application form start
    $router->get('student/scholarship-form', ['as' => 'students_website.scholarship_form', 'uses' => 'STD\ApplicationController@scholarship_form']);
    $router->get('student/re-admission-form', ['as' => 'students_website.re_admission_form', 'uses' => 'STD\ApplicationController@re_admission_form']);
    $router->get('student/permission-for-exam-form', ['as' => 'students_website.permission_for_exam_form', 'uses' => 'STD\ApplicationController@permission_for_exam_form']);
    $router->get('student/mid-term-retake-form', ['as' => 'students_website.mid_term_retake_form', 'uses' => 'STD\ApplicationController@mid_term_retake_form']);

    $router->get('student/convocation-form', ['as' => 'students_website.convocation_form', 'uses' => 'STD\ApplicationController@convocation_form']);
    $router->get('student/provisional-certificate-form', ['as' => 'students_website.provisional_certificate_form', 'uses' => 'STD\ApplicationController@provisional_certificate_form']);
    $router->get('student/transcript-mark-certificate-form', ['as' => 'students_website.transcript_mark_certificate_form', 'uses' => 'STD\ApplicationController@transcript_mark_certificate_form']);

    $router->get('student/application-form', ['as' => 'students_website.application_form', 'uses' => 'STD\ApplicationController@application_form']);

    $router->get('student/professional-short-course-form', ['as' => 'students_website.professional_short_course_form', 'uses' => 'STD\ApplicationController@professional_short_course_form']);

    // fetch course lists
    $router->get('student/fetch-course-lists/{s_id}/{semester}', ['as' => 'students_website.fetch_course_lists', 'uses' => 'STD\ApplicationController@fetch_course_lists']);

    $router->POST('student/bank-slip-form', ['as' => 'students_website.bank_deposit_form', 'uses' => 'STD\ApplicationController@bank_deposit_form']);

    $router->get('student/research-internship-project-thesis-form', ['as' => 'students_website.research_internship_project_thesis_form', 'uses' => 'STD\ApplicationController@research_internship_project_thesis_form']);
    // student application form end


    // campus adda start
    $router->POST('student/campus-adda', ['as' => 'campusAdda.store', 'uses' => 'STD\CampusAddaController@store']);
    $router->get('already-registered-check', ['as' => 'campusAdda.already_registered_check', 'uses' => 'STD\CampusAddaController@alreadyRegisteredCheck']);
    // campus adda end

    // photo contest
    $router->POST('student/photo-contest', ['as' => 'photoContest.store', 'uses' => 'STD\PhotoContestController@store']);
    $router->POST('student/photo-contest-update', ['as' => 'photoContest.update', 'uses' => 'STD\PhotoContestController@update']);
    $router->get('student/photo-contest-check', ['as' => 'photoContest.photoContestCheck', 'uses' => 'STD\PhotoContestController@photoContestCheck']);


    // diu-talent-hunt
    $router->get('student/diu-talent-hunt', ['as' => 'talentHunt.index', 'uses' => 'STD\TalentHunttController@index']);
    $router->POST('student/diu-talent-hunt', ['as' => 'talentHunt.store', 'uses' => 'STD\TalentHunttController@store']);


    // support ticket start
    $router->get('student/support-ticket', ['as' => 'supportTicket.index', 'uses' => 'STD\SupportTicketController@index']);
    $router->get('student/support-ticket/{id}', ['as' => 'supportTicket.show', 'uses' => 'STD\SupportTicketController@show']);
    $router->POST('student/support-ticket', ['as' => 'supportTicket.store', 'uses' => 'STD\SupportTicketController@store']);
    $router->POST('student/support-ticket-reply', ['as' => 'supportTicket.reply', 'uses' => 'STD\SupportTicketController@reply']);
    $router->POST('student/support-ticket-status', ['as' => 'supportTicket.status', 'uses' => 'STD\SupportTicketController@status']);
    // support ticket end

    //Feedback api start
    $router->group(['prefix' => 'student', 'namespace' => 'STD\Feedback',], function () use ($router) {
        // staffs service route start
        $router->GET('staffs-service-feedback', ['as' => 'staffsServiceFeedback.index', 'uses' => 'StaffsServiceFeedbackController@index']);
        $router->POST('staffs-service-feedback', ['as' => 'staffsServiceFeedback.store', 'uses' => 'StaffsServiceFeedbackController@store']);
        // staffs service route end

        // teacher service route start
        $router->GET('teacher-service-feedback', ['as' => 'teachersServiceFeedback.index', 'uses' => 'TeachersServiceFeedbackController@index']);
        $router->POST('teacher-service-feedback', ['as' => 'teachersServiceFeedback.store', 'uses' => 'TeachersServiceFeedbackController@store']);
        // teacher service route end

        //feedback-category lists
        $router->GET('teacher-service-feedback-category', ['as' => 'teachersServiceFeedback.category', 'uses' => 'TeachersServiceFeedbackController@category']);


        $router->GET('employee-department', ['as' => 'fetchFeedbackData.employeeDepartment', 'uses' => 'FetchFeedbackDataController@employeeDepartment']);
        $router->GET('department-wise-employee-lists/{departmentId}', ['as' => 'fetchFeedbackData.departmentWiseEmployeeLists', 'uses' => 'FetchFeedbackDataController@departmentWiseEmployeeLists']);

    });
    //Feedback api end


    $router->group(['prefix' => 'student', 'namespace' => 'STD\Microsoft',], function () use ($router) {
        $router->GET('microsoft-student-account-create', ['as' => 'microsoftStudent.store', 'uses' => 'MicrosoftController@store']);
        $router->POST('student-account-update', ['as' => 'microsoftStudent.update', 'uses' => 'MicrosoftController@update']);
    });


});

$router->GET('doc-mtg/download/{id}/{tokenVal}', ['as' => 'student_doc_mtg.download', 'uses' => 'DocmtgController@download']);

$router->group(['middleware' => ['token.auth']], function () use ($router) {

    $router->group(['middleware' => ['CommonAccessMiddleware']], function () use ($router) {


        // other form verification start (mobile apps)
        $router->get('cms/other-form-verification/{key}', ['as' => 'other-form-download.otherFormVerification', 'uses' => 'Accounts\OthersFormDownloadController@otherFormVerification']);
        $router->post('cms/other-form-verification-status-change', ['as' => 'other-form-download.otherFormVerificationStatusChange', 'uses' => 'Accounts\OthersFormDownloadController@otherFormVerificationStatusChange']);
        // other form verification end (mobile apps)


        // other form verification start (mobile apps)
        $router->get('cms/application/other-form-verification/{formNo}', ['as' => 'applicationOtherFormVerification.show', 'uses' => 'CMS\Application\ApplicationController@show']);
        $router->put('cms/application/other-form-verification/{id}', ['as' => 'applicationOtherFormVerification.update', 'uses' => 'CMS\Application\ApplicationController@update']);
        // other form verification end (mobile apps)


        // convocation start
        $router->group(['prefix' => 'convocation', 'namespace' => 'Convocation'], function () use ($router) {
            $router->get('index', ['as' => 'convocation.index', 'uses' => 'ConvocationController@index']);
            $router->get('student-infos/{student_id}', ['as' => 'convocation.studentInfos', 'uses' => 'ConvocationController@studentInfos']);
            $router->post('convocation-student-data', ['as' => 'convocation.studentDataStore', 'uses' => 'ConvocationController@studentDataStore']);
        });
        // convocation end


//        pbx user password start
        $router->group(['prefix' => 'pbx',], function () use ($router) {
            $router->get('user-index', ['as' => 'pbx.userIndex', 'uses' => 'Pbx\PbxUsersPasswordController@userIndex']);
            $router->post('user-update-password', ['as' => 'pbx.userUpdatePassword', 'uses' => 'Pbx\PbxUsersPasswordController@userUpdatePassword']);
        });
//        pbx user password end


        $router->group(['prefix' => 'phone-call',], function () use ($router) {
            $router->GET('index', ['as' => 'phoneCall.index', 'uses' => 'PhoneCall\PhoneCallController@index']);
//            $router->GET('search/{response_key}', ['as' => 'phoneCall.search', 'uses' => 'PhoneCall\PhoneCallController@search']);
//            $router->POST('store', ['as' => 'phoneCall.store', 'uses' => 'PhoneCall\PhoneCallController@store']);
        });

        $router->POST('voice-blast-upload-CSV-File', ['as' => 'voiceBlast.voiceBlastUploadCSVFile', 'uses' => 'PhoneCall\VoiceBlastController@voiceBlastUploadCSVFile']);


        /**
         *           BLOG
         *           ===
         *   1. create blog user
         */

        $router->GET('blog/users/', ['as' => 'blog.user_list', 'uses' => 'BlogUserController@index']);
        $router->POST('blog/users/', ['as' => 'blog.create_blog_author', 'uses' => 'BlogUserController@store']);

        $router->GET('blog/posts/', ['as' => 'blog.blog_posts', 'uses' => 'BlogPostController@index']);

        // WIFI
        $router->GET('wifi/account_list', ['as' => 'wifi.Account_List', 'uses' => 'LdapController@index']);
        $router->GET('wifi/get_username[/{id}]', ['as' => 'wifi.get_username', 'uses' => 'LdapController@get_username']);
        $router->POST('wifi/create', ['as' => 'wifi.Account_create', 'uses' => 'LdapController@store']);
        $router->DELETE('wifi/delete[/{user_id}]', ['as' => 'wifi.Account_delete', 'uses' => 'LdapController@destroy']);
        $router->PUT('wifi/change_passowrd[/{user_id}]', ['as' => 'wifi.change_passowrd', 'uses' => 'LdapController@change_password']);
        $router->POST('wifi/search', ['as' => 'wifi.search', 'uses' => 'LdapController@search']);
        $router->GET('wifi/user_count', ['as' => 'wifi.users_count', 'uses' => 'LdapController@user_count']);
        $router->POST('wifi/check_username_existence', ['as' => 'wifi.check_username_existence', 'uses' => 'LdapController@check_username_existence']);

        // WIFI WITH MacStudentAttendanceController
        $router->GET('wifi-with-mac/account_list', ['as' => 'wifiWithMac.Account_List', 'uses' => 'PfsenseController@index']);
        $router->GET('wifi-with-mac/my-account_list', ['as' => 'wifiWithMac.Account_List', 'uses' => 'PfsenseController@my_account_list']);
        $router->POST('wifi-with-mac/create', ['as' => 'wifiWithMac.Account_create', 'uses' => 'PfsenseController@store']);
        $router->DELETE('wifi-with-mac/delete/{wifiWithMac_id}[/{user_id}]', ['as' => 'wifiWithMac.Account_delete', 'uses' => 'PfsenseController@destroy']);
        $router->POST('wifi-with-mac/search', ['as' => 'wifiWithMac.search', 'uses' => 'PfsenseController@search']);
        $router->GET('wifi-with-mac/user_count', ['as' => 'wifiWithMac.users_count', 'uses' => 'PfsenseController@user_count']);

        // MAIL
        $router->GET('mail/account_list', ['as' => 'mail.Account_List', 'uses' => 'VestacpController@index']);
        $router->POST('mail/create', ['as' => 'mail.Account_create', 'uses' => 'VestacpController@store']);
        $router->DELETE('mail/delete/{emailId}', ['as' => 'mail.Account_delete', 'uses' => 'VestacpController@destroy']);
        $router->PUT('mail/change_passowrd[/{user_id}]', ['as' => 'mail.change_passowrd', 'uses' => 'VestacpController@change_password']);
        $router->GET('mail/user_count', ['as' => 'mail.users_count', 'uses' => 'VestacpController@user_count']);
        $router->POST('mail/check_username_existence', ['as' => 'mail.check_username_existence', 'uses' => 'VestacpController@check_username_existence']);

        // MAIL FOR STUDENTS
        $router->GET('student/mail/account_list', ['as' => 'student_mail.account_list', 'uses' => 'VestacpStudentsController@index']);

        $router->GET('profile', ['as' => 'profile', 'uses' => 'ProfileController@show']);
        $router->PUT('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);

        $router->GET('profile-rating', ['as' => 'profile.rating', 'uses' => 'ProfileController@rating']);
        $router->GET('profile/profile-rating-details', ['as' => 'profile.ratingDetails', 'uses' => 'ProfileController@ratingDetails']);
        $router->GET('profile/profile-ratting-count', ['as' => 'profile.rattingCount', 'uses' => 'ProfileController@rattingCount']);

        $router->GET('profile/rating-category', ['as' => 'profile.ratingCategory', 'uses' => 'ProfileController@ratingCategory']);

        $router->GET('profile/skill-tips', ['as' => 'profile.skillTips', 'uses' => 'ProfileController@skillTips']);

        $router->GET('profile/ticket-assign-notification', ['as' => 'profile.ticketAssignNotification', 'uses' => 'ProfileController@ticketAssignNotification']);

        $router->POST('profile/image-upload', ['as' => 'profile.photo_upload', 'uses' => 'EmployeeController@profile_image_upload']);
        $router->POST('profile/signature-card-photo-upload', ['as' => 'profile.signature_card_photo_upload', 'uses' => 'EmployeeController@signature_card_photo_upload']);


        $router->GET('academic_qualifications', ['as' => 'profile.academic_qualifications', 'uses' => 'AcademicQualificationsController@index']);
        $router->GET('academic_qualifications/{id}/edit', ['as' => 'profile.academic_qualifications_edit', 'uses' => 'AcademicQualificationsController@edit']);
        $router->POST('academic_qualifications', ['as' => 'profile.academic_qualifications', 'uses' => 'AcademicQualificationsController@store']);
        $router->PUT('academic_qualifications/{id}', ['as' => 'profile.academic_qualifications', 'uses' => 'AcademicQualificationsController@update']);
        $router->DELETE('academic_qualifications/{id}', ['as' => 'profile.academic_qualifications', 'uses' => 'AcademicQualificationsController@destroy']);

        $router->GET('training_experience', ['as' => 'profile.training_experience', 'uses' => 'TrainingExperiencesController@index']);
        $router->GET('training_experience/{id}/edit', ['as' => 'profile.training_experience', 'uses' => 'TrainingExperiencesController@edit']);
        $router->POST('training_experience', ['as' => 'profile.training_experience', 'uses' => 'TrainingExperiencesController@store']);
        $router->PUT('training_experience/{id}', ['as' => 'profile.training_experience', 'uses' => 'TrainingExperiencesController@update']);
        $router->DELETE('training_experience/{id}', ['as' => 'profile.training_experience', 'uses' => 'TrainingExperiencesController@destroy']);

        $router->GET('area_of_skills', ['as' => 'profile.area_of_skills', 'uses' => 'AreaOfSkillsController@index']);
        $router->GET('area_of_skills/{id}/edit', ['as' => 'profile.area_of_skills', 'uses' => 'AreaOfSkillsController@edit']);
        $router->POST('area_of_skills', ['as' => 'profile.area_of_skills', 'uses' => 'AreaOfSkillsController@store']);
        $router->PUT('area_of_skills/{id}', ['as' => 'profile.area_of_skills', 'uses' => 'AreaOfSkillsController@update']);
        $router->DELETE('area_of_skills/{id}', ['as' => 'profile.area_of_skills', 'uses' => 'AreaOfSkillsController@destroy']);

        $router->GET('publications', ['as' => 'profile.publications', 'uses' => 'PublicationsController@index']);
        $router->GET('publications/{id}/edit', ['as' => 'profile.publications', 'uses' => 'PublicationsController@edit']);
        $router->POST('publications', ['as' => 'profile.publications', 'uses' => 'PublicationsController@store']);
        $router->PUT('publications/{id}', ['as' => 'profile.publications', 'uses' => 'PublicationsController@update']);
        $router->DELETE('publications/{id}', ['as' => 'profile.publications', 'uses' => 'PublicationsController@destroy']);

        $router->GET('awards', ['as' => 'profile.awards', 'uses' => 'AwardScholarshipsController@index']);
        $router->GET('awards/{id}/edit', ['as' => 'profile.awards', 'uses' => 'AwardScholarshipsController@edit']);
        $router->POST('awards', ['as' => 'profile.awards', 'uses' => 'AwardScholarshipsController@store']);
        $router->PUT('awards/{id}', ['as' => 'profile.awards', 'uses' => 'AwardScholarshipsController@update']);
        $router->DELETE('awards/{id}', ['as' => 'profile.awards', 'uses' => 'AwardScholarshipsController@destroy']);

        $router->GET('expart_on', ['as' => 'profile.expart_on', 'uses' => 'ExpartOnController@index']);
        $router->GET('expart_on/{id}/edit', ['as' => 'profile.expart_on', 'uses' => 'ExpartOnController@edit']);
        $router->POST('expart_on', ['as' => 'profile.expart_on', 'uses' => 'ExpartOnController@store']);
        $router->PUT('expart_on/{id}', ['as' => 'profile.expart_on', 'uses' => 'ExpartOnController@update']);
        $router->DELETE('expart_on/{id}', ['as' => 'profile.expart_on', 'uses' => 'ExpartOnController@destroy']);

        $router->GET('socials', ['as' => 'profile.socials', 'uses' => 'SocialContactsController@index']);
        $router->GET('socials/{id}/edit', ['as' => 'profile.socials', 'uses' => 'SocialContactsController@edit']);
        $router->POST('socials', ['as' => 'profile.socials', 'uses' => 'SocialContactsController@store']);
        $router->PUT('socials/{id}', ['as' => 'profile.socials', 'uses' => 'SocialContactsController@update']);
        $router->DELETE('socials/{id}', ['as' => 'profile.socials', 'uses' => 'SocialContactsController@destroy']);

        $router->GET('employment', ['as' => 'profile.employment', 'uses' => 'PreviousEmploymentsController@index']);
        $router->GET('employment/{id}/edit', ['as' => 'profile.employment', 'uses' => 'PreviousEmploymentsController@edit']);
        $router->POST('employment', ['as' => 'profile.employment', 'uses' => 'PreviousEmploymentsController@store']);
        $router->PUT('employment/{id}', ['as' => 'profile.employment', 'uses' => 'PreviousEmploymentsController@update']);
        $router->DELETE('employment/{id}', ['as' => 'profile.employment', 'uses' => 'PreviousEmploymentsController@destroy']);

        $router->GET('counseling_hour', ['as' => 'profile.counseling_hour', 'uses' => 'CounsellingHoursController@index']);
        $router->GET('counseling_hour/{id}/edit', ['as' => 'profile.counseling_hour', 'uses' => 'CounsellingHoursController@edit']);
        $router->POST('counseling_hour', ['as' => 'profile.counseling_hour', 'uses' => 'CounsellingHoursController@store']);
        $router->PUT('counseling_hour/{id}', ['as' => 'profile.counseling_hour', 'uses' => 'CounsellingHoursController@update']);
        $router->DELETE('counseling_hour/{id}', ['as' => 'profile.counseling_hour', 'uses' => 'CounsellingHoursController@destroy']);

        $router->GET('profile-gallery', ['as' => 'profile.gallery', 'uses' => 'ProfileGalleryController@index']);
        $router->post('profile-gallery', ['as' => 'profile.galleryStore', 'uses' => 'ProfileGalleryController@store']);
        $router->DELETE('profile-gallery/{id}', ['as' => 'profile.galleryDestroy', 'uses' => 'ProfileGalleryController@destroy']);

        $router->GET('memberships', ['as' => 'profile.memberships', 'uses' => 'MemberShipsController@index']);
        $router->GET('memberships/{id}/edit', ['as' => 'profile.memberships', 'uses' => 'MemberShipsController@edit']);
        $router->POST('memberships', ['as' => 'profile.memberships', 'uses' => 'MemberShipsController@store']);
        $router->PUT('memberships/{id}', ['as' => 'profile.memberships', 'uses' => 'MemberShipsController@update']);
        $router->DELETE('memberships/{id}', ['as' => 'profile.memberships', 'uses' => 'MemberShipsController@destroy']);

        $router->GET('departments', ['as' => 'department.list', 'uses' => 'DepartmentController@index']);
        $router->GET('departments/{id}', ['as' => 'department.full_view', 'uses' => 'DepartmentController@show']);

        $router->GET('designations', ['as' => 'designation.list', 'uses' => 'DesignationController@index']);
        $router->GET('designations/{id}', ['as' => 'designation.full_view', 'uses' => 'DesignationController@show']);

        $router->GET('short_positions', ['as' => 'short_position.list', 'uses' => 'ShortPositionController@index']);
        /*
         * BadRouteException
         * trashed route here because GET method is conflict, static route and dynamic route.
        */
        $router->GET('short_positions/trashed', ['as' => 'short_position.trashed_list', 'uses' => 'ShortPositionController@trashed']);
        $router->GET('short_positions/{id}', ['as' => 'short_position.full_view', 'uses' => 'ShortPositionController@show']);


        $router->GET('employees', ['as' => 'employee.list', 'uses' => 'EmployeeController@index']);
        $router->GET('employees/released', ['as' => 'employee.Released_list', 'uses' => 'EmployeeController@Released_list']);
        $router->GET('employees/{id}', ['as' => 'emoloyee.full_view', 'uses' => 'EmployeeController@show']);

        $router->GET('campus', ['as' => 'campus.list', 'uses' => 'CampusController@index']);

        $router->POST('change_password', ['as' => 'change_password.self', 'uses' => 'EmployeeController@chnage_password']);
        $router->GET('office_times/{employee_id}', ['as' => 'employee_office_times_full_view', 'uses' => 'OfficeTimeController@show']);

        $router->POST('find_signature', ['as' => 'signature.find', 'uses' => 'EmployeeController@find_signature']);

        $router->GET('superordinate', ['as' => 'superordinate_list', 'uses' => 'LeaveController@superordinate']);
        $router->GET('subordinate', ['as' => 'subordinate_list', 'uses' => 'LeaveController@subordinate']);
        $router->GET('coordinate', ['as' => 'coordinate_list', 'uses' => 'LeaveController@coordinate']);

        // student download form start
        $router->group(['prefix' => 'cms/student'], function () use ($router) {

            $router->get('fetch-course-lists/{student_id}/{semester}', ['as' => 'cms.fetch_course_lists', 'uses' => 'CmsApplicationControllerForStudent@fetch_course_lists']);

            $router->get('scholarship-form', ['as' => 'cms.scholarship_form', 'uses' => 'CmsApplicationControllerForStudent@scholarship_form']);
            $router->get('re-admission-form', ['as' => 'cms.re_admission_form', 'uses' => 'CmsApplicationControllerForStudent@re_admission_form']);
            $router->get('provisional-certificate-form', ['as' => 'cms.provisional_certificate_form', 'uses' => 'CmsApplicationControllerForStudent@provisional_certificate_form']);
            $router->get('transcript-mark-certificate-form', ['as' => 'cms.transcript_mark_certificate_form', 'uses' => 'CmsApplicationControllerForStudent@transcript_mark_certificate_form']);

            $router->get('application-certificate-form', ['as' => 'cms.application_certificate_form', 'uses' => 'CmsApplicationControllerForStudent@application_certificate_form']);

            $router->get('professional-short-course-form', ['as' => 'cms.professional_short_course_form', 'uses' => 'CmsApplicationControllerForStudent@professional_short_course_form']);
            $router->get('permission-for-exam-form', ['as' => 'cms.permission_for_exam_form', 'uses' => 'CmsApplicationControllerForStudent@permission_for_exam_form']);
            $router->get('mid-term-retake-form', ['as' => 'cms.mid_term_retake_form', 'uses' => 'CmsApplicationControllerForStudent@mid_term_retake_form']);
            $router->get('convocation-form', ['as' => 'cms.convocation_form', 'uses' => 'CmsApplicationControllerForStudent@convocation_form']);
            $router->get('research-internship-project-thesis-form', ['as' => 'cms.research_internship_project_thesis_form', 'uses' => 'CmsApplicationControllerForStudent@research_internship_project_thesis_form']);

        });

        $router->get('bank-slip', ['uses' => 'BankSlipController@index', 'as' => 'bank-slip.index']);
        $router->POST('bank-slip', ['uses' => 'BankSlipController@store', 'as' => 'bank-slip.store']);
        // student download form end


        // campus-adda start
        $router->get('campus-adda', ['as' => 'campusAdda.index', 'uses' => 'CMS\CampusAddaController@index']);
        $router->get('campus-adda/member-list/{campus_adda_id}', ['as' => 'campusAdda.memberLists', 'uses' => 'CMS\CampusAddaController@memberLists']);
        // campus-adda end


        // photo contest start
        $router->get('student/photo-contest', ['as' => 'photoContest.index', 'uses' => 'CMS\PhotoContestController@index']);
        // photo contest end

        // diu-talent-hunt start
        $router->get('cms/student/diu-talent-hunt', ['as' => 'diuTalentHunt.index', 'uses' => 'CMS\DiuTalentHuntController@index']);
        // diu-talent-hunt end

        // email marketing start
        $router->group(['prefix' => 'admission', 'namespace' => 'CMS',], function () use ($router) {

            $router->get('email', ['as' => 'email.index', 'uses' => 'EmailController@index']);
            $router->post('email', ['as' => 'email.store', 'uses' => 'EmailController@store']);
            $router->get('email-edit/{id}', ['as' => 'email.edit', 'uses' => 'EmailController@edit']);
            $router->put('email-update/{id}', ['as' => 'email.update', 'uses' => 'EmailController@update']);


            $router->get('active-email-provider', ['as' => 'email.activeEmailProvider', 'uses' => 'EmailController@activeEmailProvider']);

            $router->post('email-send', ['as' => 'email.send', 'uses' => 'EmailController@send']);

        });
        // email marketing end


        //support ticket start

        $router->group(['prefix' => 'it-support', 'namespace' => 'ItSupport',], function () use ($router) {
            $router->get('support-ticket', ['as' => 'supportTicket.index', 'uses' => 'SupportTicketController@index']);
            $router->post('support-ticket', ['as' => 'supportTicket.store', 'uses' => 'SupportTicketController@store']);
            $router->get('support-ticket/{id}', ['as' => 'supportTicket.show', 'uses' => 'SupportTicketController@show']);
            $router->post('support-ticket-reply', ['as' => 'supportTicket.reply', 'uses' => 'SupportTicketController@reply']);
            $router->post('support-ticket-status', ['as' => 'supportTicketAction.supportTicketStatus', 'uses' => 'SupportTicketController@supportTicketStatus']);
        });

        //employee support ticket action start
        $router->group(['prefix' => 'it-support', 'namespace' => 'ItSupport',], function () use ($router) {
            $router->get('all-support-ticket', ['as' => 'supportTicketAction.index', 'uses' => 'SupportTicketActionController@index']);

            $router->get('all-support-ticket/{id}', ['as' => 'supportTicketAction.show', 'uses' => 'SupportTicketActionController@show']);

            $router->get('assign-support-ticket/{id}', ['as' => 'supportTicketAction.assignShow', 'uses' => 'SupportTicketActionController@assignShow']);

            $router->post('all-support-ticket-reply', ['as' => 'supportTicketAction.reply', 'uses' => 'SupportTicketActionController@reply']);
            $router->post('request-for-permission', ['as' => 'supportTicketAction.requestForPermission', 'uses' => 'SupportTicketActionController@requestForPermission']);
            $router->post('all-support-ticket-status', ['as' => 'supportTicketAction.supportTicketStatus', 'uses' => 'SupportTicketActionController@supportTicketStatus']);
            $router->post('support-ticket-assign', ['as' => 'supportTicketAction.supportTicketAssign', 'uses' => 'SupportTicketActionController@supportTicketAssign']);
            //assign route
            $router->get('assign-support-ticket', ['as' => 'supportTicketAction.assignIndex', 'uses' => 'SupportTicketActionController@assignIndex']);
            //employee lists
            $router->get('all-employee-lists', ['as' => 'supportTicketAction.employeeLists', 'uses' => 'SupportTicketActionController@employeeLists']);
        });
        //employee support ticket action end

        //support ticket end

        //student support ticket action start
        $router->group(['prefix' => 'it-support/student', 'namespace' => 'STD',], function () use ($router) {
            $router->get('all-support-ticket', ['as' => 'studentSupportTicketAction.index', 'uses' => 'SupportTicketActionController@index']);
            $router->get('all-support-ticket/{id}', ['as' => 'studentSupportTicketAction.show', 'uses' => 'SupportTicketActionController@show']);
            $router->post('all-support-ticket-reply', ['as' => 'studentSupportTicketAction.reply', 'uses' => 'SupportTicketActionController@reply']);
            $router->post('all-support-ticket-status', ['as' => 'studentSupportTicketAction.supportTicketStatus', 'uses' => 'SupportTicketActionController@supportTicketStatus']);
            $router->post('support-ticket-assign', ['as' => 'studentSupportTicketAction.supportTicketAssign', 'uses' => 'SupportTicketActionController@supportTicketAssign']);
            $router->get('assign-all-support-ticket', ['as' => 'studentSupportTicketAction.studentAssignIndex', 'uses' => 'SupportTicketActionController@studentAssignIndex']);
            $router->get('assign-support-ticket-show/{id}', ['as' => 'studentSupportTicketAction.studentAssignShow', 'uses' => 'SupportTicketActionController@studentAssignShow']);
            $router->post('request-for-permission', ['as' => 'studentSupportTicketAction.requestForPermission', 'uses' => 'SupportTicketActionController@requestForPermission']);
        });
        //student support ticket action end


        //switch-control start
        $router->group(['prefix' => 'switch-control', 'namespace' => 'SwitchControl',], function () use ($router) {
            $router->get('etharnet-realy', ['as' => 'switchControl.etharnetRealyIndex', 'uses' => 'SwitchControlController@etharnetRealyIndex']);
            $router->post('etharnet-realy', ['as' => 'switchControl.etharnetRealyStore', 'uses' => 'SwitchControlController@etharnetRealyStore']);

            $router->post('etharnet-realy-channel-update', ['as' => 'switchControl.etharnetRealyChannelUpdate', 'uses' => 'SwitchControlController@etharnetRealyChannelUpdate']);
        });
        //switch-control end


        /*
            course fee calculation start
        */
        $router->group(['prefix' => 'admission',], function () use ($router) {
            $router->get('generale-student-program', ['as' => 'admission.generalStudentPrograms', 'uses' => 'Admission\CourseFeeCalculationController@generalStudentPrograms']);
            $router->get('diploma-student-program', ['as' => 'admission.diplomaStudentPrograms', 'uses' => 'Admission\CourseFeeCalculationController@diplomaStudentPrograms']);
            $router->get('course-fee-calculation', ['as' => 'admission.courseFeeCalculation', 'uses' => 'Admission\CourseFeeCalculationController@courseFeeCalculation']);
        });
        /*
            course fee calculation end
        */


        $router->group(['prefix' => 'employee', 'namespace' => 'CMS',], function () use ($router) {
            $router->GET('microsoft-employee-account-token', ['as' => 'microsoftEmployee.index', 'uses' => 'MicrosoftController@index']);
        });

    });

    $router->group(['middleware' => ['LeaveAttendanceMiddleware']], function () use ($router) {

        /*
            Upcoming student
        */
        $router->get('letter-of-admission', ['as' => 'InternationalStudentDoc.letter_of_admission', 'uses' => 'INTL\UpcomingStudentsController@letter_of_admission']);
        $router->get('immigration-latter', ['as' => 'InternationalStudentDoc.immigration_latter', 'uses' => 'INTL\UpcomingStudentsController@immigration_latter']);
        $router->get('passport-receiving-slip', ['as' => 'InternationalStudentDoc.passport_receiving_slip', 'uses' => 'INTL\UpcomingStudentsController@passport_receiving_slip']);
        $router->post('upcoming-student-store', ['as' => 'InternationalStudentDoc.upcoming_student_store', 'uses' => 'INTL\UpcomingStudentsController@upcoming_student_store']);
        $router->get('upcoming-student-fetch/{user_id}', ['as' => 'InternationalStudentDoc.upcoming_student_fetch', 'uses' => 'INTL\UpcomingStudentsController@upcoming_student_fetch']);
        $router->post('upcoming-student-update', ['as' => 'InternationalStudentDoc.upcoming_student_update', 'uses' => 'INTL\UpcomingStudentsController@upcoming_student_update']);

        /*
            routes for intl students
        */
        $router->group(['prefix' => 'intl'], function () use ($router) {

            $router->GET('all-student-list', ['as' => 'internationalStudent.all-student-list', 'uses' => 'INTL\IntlStudentsController@studentListAll']);
            $router->POST('upload-files', ['as' => 'internationalStudentDoc.upload-files', 'uses' => 'INTL\IntlStudentsDocController@uploadFiles']);
            $router->GET('get-all-files/{userId}', ['as' => 'internationalStudentDoc.get-all-files', 'uses' => 'INTL\IntlStudentsDocController@getAllFiles']);
            $router->DELETE('file/{userId}/{id}', ['as' => 'internationalStudentDoc.delete-file', 'uses' => 'INTL\IntlStudentsDocController@removeFile']);
            $router->GET('student-info/{userId}', ['as' => 'internationalStudent.studnet-info-detail', 'uses' => 'INTL\IntlStudentsController@studnetInfoDetail']);


            $router->GET('upcoming-student-list', ['as' => 'internationalStudent.upcoming-student-list', 'uses' => 'INTL\IntlStudentsController@upcomingStudentListAll']);
            $router->GET('att-report', ['as' => 'internationalStudent.not-attain', 'uses' => 'INTL\IntlStudentsController@index']);
            $router->GET('students/{foreign_student_id}', ['as' => 'internationalStudent.student-list', 'uses' => 'INTL\IntlStudentsController@show']);
            $router->GET('students-list', ['as' => 'internationalStudent.student-list', 'uses' => 'INTL\IntlStudentsController@studentList']);
            $router->GET('visa-expire-report', ['as' => 'internationalStudent.visaExpireReport', 'uses' => 'INTL\IntlStudentsController@visaExpireReport']);
            $router->put('update-visa-date', ['as' => 'internationalStudent.updateVisaDate', 'uses' => 'INTL\IntlStudentsController@updateVisaDate']);

            $router->put('applied-for-visa/{student_id}', ['as' => 'internationalStudent.applidForVisa', 'uses' => 'INTL\IntlStudentsController@applidForVisa']);

            $router->get('student-list-for-applied-for-visa', ['as' => 'internationalStudent.studentListForAppliedForVisa', 'uses' => 'INTL\IntlStudentsController@studentListForAppliedForVisa']);

            $router->get('student-list-csv-download', ['as' => 'internationalStudent.studentListForCSVDownload', 'uses' => 'INTL\IntlStudentsController@studentListForCSVDownload']);


            $router->get('search-student-by-regcode', ['as' => 'internationalStudent.UearchStudentByRegcode', 'uses' => 'INTL\DocumentsController@searchStudentByRegcode']);
            $router->get('doc-name-list', ['as' => 'internationalStudent.DocListOfAStudent', 'uses' => 'INTL\DocumentsController@docNameList']);
            $router->get('pdf-doc/{filename}/{studentRmsId}', ['as' => 'internationalStudent.pdfDoc', 'uses' => 'INTL\DocumentsController@pdfDoc']);
            /*
                student Dump url
            */
            $router->put('make-student-dump', ['as' => 'internationalStudent.makeStudnetDump', 'uses' => 'INTL\DumpStudentController@update']);
            $router->get('dump-student-list', ['as' => 'internationalStudent.dumpStudentList', 'uses' => 'INTL\DumpStudentController@index']);
            $router->put('make-student-undump/{studentId}', ['as' => 'internationalStudent.makeStudentUndump', 'uses' => 'INTL\DumpStudentController@makeStudentUndump']);
            /*
                Meet url
            */
            $router->post('meet', ['as' => 'international_Student_Meeting.save', 'uses' => 'INTL\MeetController@store']);
            $router->get('meet/{student_id}', ['as' => 'international_Student_Meeting.show', 'uses' => 'INTL\MeetController@show']);


        });


        $router->POST('doc-mtg', ['as' => 'student_doc_mtg.save_new', 'uses' => 'DocmtgController@store']);
        $router->POST('doc-mtg-edit/{id}', ['as' => 'student_doc_mtg.update', 'uses' => 'DocmtgController@update']);
        $router->GET('doc-mtg', ['as' => 'student_doc_mtg.list', 'uses' => 'DocmtgController@index']);

        $router->GET('doc-mtg/{id}', ['as' => 'student_doc_mtg.show', 'uses' => 'DocmtgController@show']);


        $router->POST('liaison_officer/search', ['as' => 'liaison_officer.search', 'uses' => 'LiaisonOfficerController@index']);
        $router->POST('liaison_officer', ['as' => 'liaison_officer.store', 'uses' => 'LiaisonOfficerController@store']);
        $router->GET('liaison_officer/{id}/edit', ['as' => 'liaison_officer.edit', 'uses' => 'LiaisonOfficerController@edit']);
        $router->PUT('liaison_officer/{id}', ['as' => 'liaison_officer.update', 'uses' => 'LiaisonOfficerController@update']);
        $router->POST('liaison_officer/send_to_all', ['as' => 'liaison_officer.store', 'uses' => 'LiaisonOfficerController@send_to_all']);
        $router->POST('liaison_officer/send_to_custom', ['as' => 'liaison_officer.store', 'uses' => 'LiaisonOfficerController@send_to_custom']);
        $router->DELETE('liaison_officer/delete/{id}', ['as' => 'liaison_officer.delete', 'uses' => 'LiaisonOfficerController@destroy']);

        $router->GET('liaison_officer/bill_index', ['as' => 'liaison_officer.bill_index', 'uses' => 'LiaisonOfficerController@bill_index']);
        $router->GET('liaison_officer/print_bill_form/{studentId}', ['as' => 'liaison_officer.print_bill_form', 'uses' => 'LiaisonOfficerController@print_bill_form']);
        $router->GET('liaison_officer/bill_print_done/{studentId}/{type}/{personId}', ['as' => 'liaison_officer.bill_print_done', 'uses' => 'LiaisonOfficerController@bill_print_done']);

        $router->GET('liaison_student/bill_index', ['as' => 'liaison_student.bill_index', 'uses' => 'LiaisonOfficerController@student_bill_index']);
        $router->GET('liaison_student/print_scholarship_form/{studentId}', ['as' => 'liaison_student.print_bill_form', 'uses' => 'LiaisonOfficerController@print_scholarship_form']);
        $router->GET('liaison_student/bill_print_done/{studentId}/{type}/{personId}', ['as' => 'liaison_student.bill_print_done', 'uses' => 'LiaisonOfficerController@bill_print_done']);

        $router->GET('liaison_bill', ['as' => 'liaison_bill.birll_report', 'uses' => 'LiaisonOfficerController@billOnStudentAdmission']);

        /*
         * Student scholarship as liaison officer
         * */
        $router->post('student-scholarship-as-Liaison-officer', ['as' => 'liaison_bill_student.saveStudentScholarshipAsLiaisonOfficer', 'uses' => 'LiaisonOfficerController@saveStudentScholarshipAsLiaisonOfficer']);
        $router->get('student_scholarship_not_posted_in_erp', ['as' => 'liaison_bill_student.student_scholarship_not_posted_in_erp', 'uses' => 'LiaisonOfficerController@student_scholarship_not_posted_in_erp']);
        $router->get('student_scholarship_posted_in_erp', ['as' => 'liaison_bill_student.student_scholarship_posted_in_erp', 'uses' => 'LiaisonOfficerController@student_scholarship_posted_in_erp']);


        $router->GET('holidays', ['as' => 'holiday.list', 'uses' => 'HolidayController@index']);
        $router->GET('holidays/trashed', ['as' => 'holiday.trashed_list', 'uses' => 'HolidayController@trashed']);
        $router->GET('holidays/{id}', ['as' => 'holiday.full_view', 'uses' => 'HolidayController@show']);
        $router->POST('holidays', ['as' => 'holiday.save', 'uses' => 'HolidayController@store']);
        $router->PUT('holidays/{id}/restore', ['as' => 'holiday.restore', 'uses' => 'HolidayController@restore']);
        $router->PUT('holidays/{id}', ['as' => 'holiday.update', 'uses' => 'HolidayController@update']);
        $router->DELETE('holidays/{id}', ['as' => 'holiday.trash', 'uses' => 'HolidayController@delete']);

        $router->POST('leave', ['as' => 'leave_application.save', 'uses' => 'LeaveController@store']);
        $router->GET('leave/{id}', ['as' => 'leave_application.full_view', 'uses' => 'LeaveController@show']);
        $router->GET('leave/{id}/edit', ['as' => 'leave_application.edit_view', 'uses' => 'LeaveController@edit']);
        $router->PUT('leave/{id}', ['as' => 'leave_application.update_save', 'uses' => 'LeaveController@update']);
        $router->PUT('leave/{id}/comment', ['as' => 'leave_application.comment_save', 'uses' => 'LeaveController@comment']);
        $router->GET('leaves/review[/{employee_id}]', ['as' => 'leave_application.yearly_review', 'uses' => 'LeaveController@yearly_review']);

        $router->GET('leaves/pending', ['as' => 'leave_application.pending_on_others_status_list', 'uses' => 'LeaveStatusController@pending']);
        $router->GET('leaves/approval', ['as' => 'leave_application.waiting_for_approval_list', 'uses' => 'LeaveStatusController@approval']);
        $router->GET('leaves/approved', ['as' => 'leave_application.approved_list', 'uses' => 'LeaveStatusController@approved']);
        $router->GET('leaves/deny_by_others', ['as' => 'leave_application.deny_by_other_list', 'uses' => 'LeaveStatusController@deny_by_others']);
        $router->GET('leaves/self_deny', ['as' => 'leave_application.self_deny_list', 'uses' => 'LeaveStatusController@self_deny']);
        $router->GET('leaves/withdraw', ['as' => 'leave_application.withdraw_list', 'uses' => 'LeaveStatusController@withdraw']);
        $router->PUT('leaves/approved/{id}', ['as' => 'leave_application.forowardOrApprove_update', 'uses' => 'LeaveStatusController@approved_update']);
        $router->PUT('leaves/deny_by_others/{id}', ['as' => 'leave_application.denyByOther_update', 'uses' => 'LeaveStatusController@deny_by_others_update']);
        $router->PUT('leaves/self_deny/{id}', ['as' => 'leave_application.selfDenied_update', 'uses' => 'LeaveStatusController@self_deny_update']);
        $router->PUT('leaves/withdraw/{id}', ['as' => 'leave_application.withdraw_update', 'uses' => 'LeaveStatusController@withdraw_update']);

        $router->POST('attendance_report_personal', ['as' => 'attendance_report.personal', 'uses' => 'AttendanceReportController@personal']);
        $router->POST('attendance_report_employee', ['as' => 'attendance_report.employee', 'uses' => 'AttendanceReportController@employee']);
        $router->POST('salary-report-sort-settings', ['as' => 'attendance_report.salaryReportSortSettings', 'uses' => 'AttendanceReportController@salaryReportSortSettings']);
        $router->GET('salary_report', ['as' => 'salary.report', 'uses' => 'SalaryReportController@index']);
        $router->GET('leave_review_report', ['as' => 'salary.leave_review_report', 'uses' => 'SalaryReportController@leave_review_report']);
        $router->GET('salaryreportable_employee_ids', ['as' => 'salary.get_salary_reportable_employee_ids', 'uses' => 'SalaryReportController@getEmployeeIDsForSalaryReport']);

        $router->GET('switchoffday/approved[/{user_id}]', ['as' => 'switchoffday.show_approved_switchoffday', 'uses' => 'SwitchOffDaysController@show_approved_switchoffday']);
        $router->GET('switchoffday/deleted[/{user_id}]', ['as' => 'switchoffday.show_deleted_switchoffday', 'uses' => 'SwitchOffDaysController@show_deleted_switchoffday']);
        $router->GET('switchoffday/pending[/{user_id}]', ['as' => 'switchoffday.show_pending_switchoffday', 'uses' => 'SwitchOffDaysController@show_pending_switchoffday']);
        $router->POST('switchoffday/{id}/approve', ['as' => 'switchoffday.list', 'uses' => 'SwitchOffDaysController@approve']);
        $router->GET('switchoffday', ['as' => 'switchoffday.list', 'uses' => 'SwitchOffDaysController@index']);
        $router->GET('switchoffday/{id}/edit', ['as' => 'switchoffday.view_for_edit', 'uses' => 'SwitchOffDaysController@edit']);
        $router->GET('switchoffday/{id}', ['as' => 'switchoffday.view', 'uses' => 'SwitchOffDaysController@show']);
        $router->POST('switchoffday', ['as' => 'switchoffday.list', 'uses' => 'SwitchOffDaysController@store']);
        $router->PUT('switchoffday/{id}', ['as' => 'switchoffday.update', 'uses' => 'SwitchOffDaysController@update']);
        $router->DELETE('switchoffday/{id}', ['as' => 'switchoffday.delete', 'uses' => 'SwitchOffDaysController@destroy']);

        /**
         * mobile-payment
         */
        $router->GET('mobile-payment/unverified-list', ['as' => 'mobilePayment.unverified-list', 'uses' => 'MobilePaymentController@index']);
        $router->GET('mobile-payment/verified-list', ['as' => 'mobilePayment.verified-list', 'uses' => 'MobilePaymentController@verified']);
        $router->GET('mobile-payment/manual-input', ['as' => 'mobilePayment.manual-input', 'uses' => 'MobilePaymentController@manualInput']);
        $router->POST('mobile-payment/upload-csv-file', ['as' => 'mobilePayment.upload_CSV_File', 'uses' => 'MobilePaymentController@mobilePaymentCSVFileUpload']);
        $router->GET('mobile-payment/verify-payment/{id}', ['as' => 'mobilePayment.verify-payment', 'uses' => 'MobilePaymentController@verifyPayment']);
        $router->GET('covid-accounts-report/{batch_id}', ['as' => 'covid-accounts-report.report', 'uses' => 'MobilePaymentController@covidAccountsReport']);
        $router->GET('covid-discount', ['as' => 'covid-accounts-report.discount', 'uses' => 'MobilePaymentController@covidDiscount']);


        $router->GET('eligible-students-for-exam/{batch_id}', ['as' => 'eligible-students-for-exam.report', 'uses' => 'MobilePaymentController@eligibleStudentsForExam']);

        // form apply url start & accounts other form and pdf

        $router->post('cms/other-form-download', ['as' => 'other-form-download.store', 'uses' => 'Accounts\OthersFormDownloadController@store']);
        $router->post('cms/application-form-download', ['as' => 'other-form-download.application', 'uses' => 'Accounts\OthersFormDownloadController@application']);
        $router->post('cms/report-form-download', ['as' => 'other-form-download.report', 'uses' => 'Accounts\OthersFormDownloadController@report']);
        $router->post('cms/bank-slip-form-download', ['as' => 'other-form-download.bankSlip', 'uses' => 'Accounts\OthersFormDownloadController@bankSlip']);
        // accounts other form convocation pdf
        $router->post('cms/other-form-download-for-convocation', ['as' => 'other-form-download.storeConvocation', 'uses' => 'Accounts\OthersFormDownloadController@storeConvocation']);
        // accounts other form research pdf
        $router->post('cms/other-form-download-for-research', ['as' => 'other-form-download.storeResearch', 'uses' => 'Accounts\OthersFormDownloadController@storeResearch']);
        // accounts other form mid term retake examination pdf
        $router->post('cms/other-form-download-for-mid-term-retake-examination-form', ['as' => 'other-form-download.storeMidTermRetakeExaminationForm', 'uses' => 'Accounts\OthersFormDownloadController@storeMidTermRetakeExaminationForm']);

        // form apply url end & accounts other form and pdf

        // uploaded transcript start
        $router->get('cms/other-form-download', ['as' => 'other-form-download.index', 'uses' => 'Accounts\OthersFormDownloadController@index']);
        $router->put('cms/final-application-form-download/{id}', ['as' => 'other-form-download.finalApplicationFormDownload', 'uses' => 'Accounts\OthersFormDownloadController@finalApplicationFormDownload']);
        $router->get('cms/application-form-uploaded', ['as' => 'other-form-download.formUploadedIndex', 'uses' => 'Accounts\OthersFormDownloadController@formUploadedIndex']);
        $router->put('cms/application-form-uploaded/{id}', ['as' => 'other-form-download.formUploaded', 'uses' => 'Accounts\OthersFormDownloadController@formUploaded']);
        $router->get('cms/application-form-not-uploaded', ['as' => 'other-form-download.formNotUploaded', 'uses' => 'Accounts\OthersFormDownloadController@formNotUploaded']);

        $router->get('cms/other-transcript-form-download', ['as' => 'other-form-download.transcript', 'uses' => 'Accounts\OthersFormDownloadController@transcript']);
        $router->put('cms/other-transcript-form-upload/{id}', ['as' => 'other-form-download.transcriptFormUpload', 'uses' => 'Accounts\OthersFormDownloadController@transcriptFormUpload']);
        // uploaded transcript end

        //test transcript
        $router->put('cms/transcript-application-form-download/{id}', ['as' => 'other-form-download.transcriptApplicationFormDownload', 'uses' => 'Accounts\OthersFormDownloadController@transcriptApplicationFormDownload']);
    });

    $router->group(['middleware' => ['AdministrationMiddleware']], function () use ($router) {


        /*
            vice chairman's transcript part
        */
        $router->POST('students/transcript/find-by-reg-code', ['as' => 'cms_transcript_update.find-by-reg-code', 'uses' => 'STD\StudentTranscriptController@findByRegCode']);
        $router->GET('students/transcript/find-id/{id}', ['as' => 'cms_transcript_update.find-by-id', 'uses' => 'STD\StudentTranscriptController@findById']);
        $router->POST('students/transcript/update-by-vice-chairman/{id}', ['as' => 'cms_transcript_update.update-by-vice-chairman', 'uses' => 'STD\StudentTranscriptController@updateByViceChairman']);
        $router->DELETE('students/transcript/delete-by-vice-chairman/{id}', ['as' => 'cms_transcript_update.delete-by-vice-chairman', 'uses' => 'STD\StudentTranscriptController@deleteById']);


        $router->GET('departments/{id}/edit', ['as' => 'department.view_for_edit', 'uses' => 'DepartmentController@edit']);
        $router->POST('departments', ['as' => 'department.save', 'uses' => 'DepartmentController@store']);
        $router->PUT('departments/{id}', ['as' => 'department.update', 'uses' => 'DepartmentController@update']);

        $router->GET('designations/{id}/edit', ['as' => 'designation.view_for_edit', 'uses' => 'DesignationController@edit']);
        $router->POST('designations', ['as' => 'designation.save', 'uses' => 'DesignationController@store']);
        $router->PUT('designations/{id}', ['as' => 'designation.update', 'uses' => 'DesignationController@update']);

        $router->GET('short_positions/{id}/edit', ['as' => 'short_position.view_for_edit', 'uses' => 'ShortPositionController@edit']);
        $router->POST('short_positions', ['as' => 'short_position.save', 'uses' => 'ShortPositionController@store']);
        $router->PUT('short_positions/{id}/restore', ['as' => 'short_position.restore_trashed_data', 'uses' => 'ShortPositionController@restore']);
        $router->PUT('short_positions/{id}', ['as' => 'short_position.update', 'uses' => 'ShortPositionController@update']);
        $router->DELETE('short_positions/{id}', ['as' => 'short_position.trash', 'uses' => 'ShortPositionController@delete']);

        $router->GET('employees/{id}/edit', ['as' => 'employee.view_for_edit', 'uses' => 'EmployeeController@edit']);
        $router->POST('employees', ['as' => 'employee.save', 'uses' => 'EmployeeController@store']);
        $router->POST('new-store', ['as' => 'employee.newStore', 'uses' => 'EmployeeController@newStore']);
        $router->PUT('employees/{id}', ['as' => 'employee.update', 'uses' => 'EmployeeController@update']);
        $router->POST('office_times', ['as' => 'employee.office_time_save', 'uses' => 'OfficeTimeController@store']);
        $router->GET('office_times/{employee_id}/edit', ['as' => 'employee.office_times_edit_view', 'uses' => 'OfficeTimeController@edit']);
        $router->POST('profile/update-snc-and-profile-image', ['as' => 'employee.update-snc-and-profile-image', 'uses' => 'EmployeeController@updateSNCnProfileImage']);
        $router->POST('settings/change_password', ['as' => 'employee.change_password', 'uses' => 'SystemSettingsController@change_password']);
        $router->POST('employee/change-official-email', ['as' => 'employee.changeOfficialEmail', 'uses' => 'EmployeeController@changeOfficialEmail']);
        $router->POST('employee/release', ['as' => 'employee.release', 'uses' => 'EmployeeController@releaseEmployee']);
        $router->POST('employee/reactive-employee', ['as' => 'employee.ReactiveEmployee', 'uses' => 'EmployeeController@reactiveEmployee']);

        $router->GET('role', ['as' => 'role.list', 'uses' => 'RoleController@index']);
        $router->GET('role/trashed', ['as' => 'role.trashed_list', 'uses' => 'RoleController@trashed']);
        $router->GET('role/{id}', ['as' => 'role.full_view', 'uses' => 'RoleController@show']);
        $router->GET('role/{id}/edit', ['as' => 'role.view_for_edit', 'uses' => 'RoleController@edit']);
        $router->POST('role', ['as' => 'role.save', 'uses' => 'RoleController@store']);
        $router->PUT('role/{id}/restore', ['as' => 'role.restore_trashed_data', 'uses' => 'RoleController@restore']);
        $router->PUT('role/{id}', ['as' => 'role.update', 'uses' => 'RoleController@update']);
        $router->DELETE('role/{id}', ['as' => 'role.trash', 'uses' => 'RoleController@delete']);

        $router->GET('permissions', ['as' => 'permission.permissions', 'uses' => 'AccessControlController@permissions']);

        $router->POST('assign_role', ['as' => 'permission.assign_role', 'uses' => 'AccessControlController@assign_role']);
        $router->POST('assign_employee_role', ['as' => 'permission.assign_employee_role', 'uses' => 'AccessControlController@assign_employee_role']);
        $router->POST('assign_permission', ['as' => 'permission.assign_permission', 'uses' => 'AccessControlController@assign_permission']);

        $router->GET('employee_group', ['as' => 'employee_group.list', 'uses' => 'EmployeeGroupController@index']);
        $router->GET('employee_group/{id}/edit', ['as' => 'employee_group.view_for_edit', 'uses' => 'EmployeeGroupController@edit']);
        $router->POST('employee_group', ['as' => 'employee_group.save', 'uses' => 'EmployeeGroupController@store']);
        $router->PUT('employee_group/{id}', ['as' => 'employee_group.update', 'uses' => 'EmployeeGroupController@update']);


        $router->GET('faculties', ['as' => 'faculties.list', 'uses' => 'FacultiesController@index']);
        $router->POST('faculties', ['as' => 'faculties.save', 'uses' => 'FacultiesController@store']);
        $router->GET('faculties/{id}/edit', ['as' => 'faculties.view_for_edit', 'uses' => 'FacultiesController@edit']);
        $router->PUT('faculties/{id}', ['as' => 'faculties.update', 'uses' => 'FacultiesController@update']);

        $router->GET('programs', ['as' => 'programs.list', 'uses' => 'ProgramController@index']);
        $router->POST('programs', ['as' => 'programs.save', 'uses' => 'ProgramController@store']);
        $router->GET('programs/{id}/edit', ['as' => 'programs.view_for_edit', 'uses' => 'ProgramController@edit']);
        $router->GET('programs/{id}/show', ['as' => 'programs.view_for_show', 'uses' => 'ProgramController@show']);
        $router->PUT('programs/{id}', ['as' => 'programs.update', 'uses' => 'ProgramController@update']);

        $router->GET('liaison-programs', ['as' => 'liaison-programs.list', 'uses' => 'LiaisonProgramsController@index']);
        $router->GET('liaison-programs/{id}/edit', ['as' => 'liaison-programs.view_for_edit', 'uses' => 'LiaisonProgramsController@edit']);
        $router->PUT('liaison-programs/{id}', ['as' => 'liaison-programs.update', 'uses' => 'LiaisonProgramsController@update']);


        $router->group(['prefix' => 'job',], function () use ($router) {
            $router->GET('job-report', ['as' => 'job.jobReport', 'uses' => 'Job\JobController@jobReport']);
            $router->GET('provider-report', ['as' => 'job.providerReport', 'uses' => 'Job\JobController@providerReport']);
        });


        $router->group(['prefix' => 'pbx',], function () use ($router) {
            $router->GET('active-provider-list', ['as' => 'pbx.active-provider-list', 'uses' => 'Pbx\PbxProviderController@getActiveProvider']);
            $router->GET('inactive-provider-list', ['as' => 'pbx.inactive-provider-list', 'uses' => 'Pbx\PbxProviderController@getInActiveProvider']);
            $router->GET('all-provider-list', ['as' => 'pbx.all-provider-list', 'uses' => 'Pbx\PbxProviderController@getAllProvider']);
            $router->post('provider-status-change', ['as' => 'pbx.provider-status-change', 'uses' => 'Pbx\PbxProviderController@providerStatusChange']);

            $router->post('send-sms-to-students', ['as' => 'pbx.send-sms-to-students', 'uses' => 'Pbx\SendMsgController@sendSmsToStudents']);
        });

        $router->group(['prefix' => 'goip',], function () use ($router) {
            $router->get('receive-message', ['as' => 'goip.receiveMessageIndex', 'uses' => 'GOIP\ReceiveMessageController@receiveMessageIndex']);
            $router->get('receive-message-done', ['as' => 'goip.receiveMessageDone', 'uses' => 'GOIP\ReceiveMessageController@receiveMessageDone']);
            $router->get('receive-message-delete', ['as' => 'goip.receiveMessageDelete', 'uses' => 'GOIP\ReceiveMessageController@receiveMessageDelete']);
            $router->post('action-status', ['as' => 'goip.actionStatus', 'uses' => 'GOIP\ReceiveMessageController@actionStatus']);
        });
    });

    $router->group(['middleware' => ['SupperUserMiddleware']], function () use ($router) {
        $router->GET('settings', ['as' => 'system_setting.list', 'uses' => 'SystemSettingsController@index']);
        $router->GET('settings/trashed', ['as' => 'system_setting.trashed_list', 'uses' => 'SystemSettingsController@trashed']);
        $router->GET('settings/{id}', ['as' => 'system_setting.full_view', 'uses' => 'SystemSettingsController@show']);
        $router->GET('settings/{id}/edit', ['as' => 'system_setting.view_for_edit', 'uses' => 'SystemSettingsController@edit']);
        $router->POST('settings', ['as' => 'system_setting.save', 'uses' => 'SystemSettingsController@store']);
        $router->PUT('settings/{id}/restore', ['as' => 'system_setting.restore_trashed_data', 'uses' => 'SystemSettingsController@restore']);
        $router->PUT('settings/{id}', ['as' => 'system_setting.update', 'uses' => 'SystemSettingsController@update']);
        $router->DELETE('settings/{id}', ['as' => 'system_setting.trash', 'uses' => 'SystemSettingsController@delete']);

        $router->GET('settings/student-report/{reg_code}', ['as' => 'system_setting.studentReport', 'uses' => 'Setting\StudentReportController@studentReport']);


        //Statistics module start
        $router->group(['prefix' => 'statistics', 'namespace' => 'Statistics',], function () use ($router) {

            $router->get('student-purpose-statistics', ['as' => 'statistics.studentPurposeStatistics', 'uses' => 'StatisticsReportController@studentPurposeStatistics']);

            // staff feedback report start
            $router->get('employee-lists', ['as' => 'statistics.employeeLists', 'uses' => 'StatisticsReportController@employeeLists']);

            $router->get('employee-feedback-details/{employeeId}', ['as' => 'statistics.employeeFeedbackDetails', 'uses' => 'StatisticsReportController@employeeFeedbackDetails']);

            $router->get('staffs-feedback-report/{employeeId}', ['as' => 'statistics.staffsFeedbackShortDetails', 'uses' => 'StatisticsReportController@staffsFeedbackShortDetails']);

            $router->get('staff-rating-category', ['as' => 'statistics.staffRatingCategory', 'uses' => 'StatisticsReportController@staffRatingCategory']);
            $router->get('category-wise-staff-rating-point', ['as' => 'statistics.categoryWiseStaffRatingPoint', 'uses' => 'StatisticsReportController@categoryWiseStaffRatingPoint']);
            // staff feedback report end

            // teacher feedback report start
            $router->get('teacher-feedback-report', ['as' => 'statistics.teacherFeedbackReport', 'uses' => 'StatisticsReportController@teacherFeedbackReport']);

            $router->get('teacher-lists', ['as' => 'statistics.teacherLists', 'uses' => 'StatisticsReportController@teacherLists']);
            $router->get('teacher-feedback-short-details/{rmsTeacherID}', ['as' => 'statistics.teacherFeedbackShortDetails', 'uses' => 'StatisticsReportController@teacherFeedbackShortDetails']);
            $router->get('teacher-feedback-report/{rmsTeacherID}', ['as' => 'statistics.teacherFeedbackReportShow', 'uses' => 'StatisticsReportController@teacherFeedbackReportShow']);

            $router->get('teacher-rating-category', ['as' => 'statistics.teacherRatingCategory', 'uses' => 'StatisticsReportController@teacherRatingCategory']);

            $router->get('category-wise-teacher-rating-point', ['as' => 'statistics.categoryWiseTeacherRatingPoint', 'uses' => 'StatisticsReportController@categoryWiseTeacherRatingPoint']);
            // teacher feedback report end

        });
        //Statistics module end


    });

    $router->group(['middleware' => 'RmsMiddleware'], function () use ($router) {

        $router->group(['prefix' => 'rms'], function () use ($router) {
            $router->POST('cms-sync-to-rms', ['as' => 'rms.sync_user_by_id', 'uses' => 'rms\EmployeeController@cmsSyncToRms']);
            /**
             * bellow are active but not used. :)
             */

            /*
                $router->GET('users', ['as' => 'RMS.show_user_list','uses' => 'rms\EmployeeController@index']);
                $router->GET('locked-users', ['as' => 'RMS.show_locked_user_list','uses' => 'rms\EmployeeController@lockedUsers']);
                $router->GET('employee-exists-in-rms[/{cmsEmpId}]', ['as' => 'RMS.show_CMS_user_list_who_are_exists_in_RMS','uses' => 'rms\EmployeeController@employeeExistsInRms']);
                $router->GET('employee-not-exists-in-rms', ['as' => 'RMS.show_CMS_user_list_not_exists_in_RMS','uses' => 'rms\EmployeeController@employeeNotInRms']);
                $router->GET('lock-employee[/{rmsEmployeeId}]', ['as' => 'RMS.set_lock_an_employee','uses' => 'rms\EmployeeController@lockEmployee']);
                $router->GET('unlock-employee[/{rmsEmployeeId}]', ['as' => 'RMS.set_unlock_an_employee','uses' => 'rms\EmployeeController@unlockEmployee']);
            //*/
        });
    });

    $router->group(['middleware' => 'STDMiddleware'], function () use ($router) {


        $router->POST('student/search-by-regcode', ['as' => 'cms_student_module.search_by_reg_code', 'uses' => 'STD\StudentsController@search_by_reg_code']);
        $router->POST('student/change-current-email', ['as' => 'cms_student_module.change_current_email', 'uses' => 'STD\StudentsController@change_current_email']);

        // STUDENT IMPROVEMENT
        $router->GET('get_current_improvement_exam_schedule_for_cms', ['as' => 'cms_student_module.get_current_improvement_exam_schedule_for_cms', 'uses' => 'STD\CMSStudentImprovementController@get_current_improvement_exam_schedule_for_cms']);
        $router->POST('get_student_for_payment', ['as' => 'cms_student_module.get_student_for_payment', 'uses' => 'STD\CMSStudentImprovementController@get_student_for_payment']);
        $router->GET('get_banks', ['as' => 'cms_student_module.get_banks', 'uses' => 'STD\CMSStudentImprovementController@get_banks']);
        $router->POST('make_improvement_payment_complete', ['as' => 'cms_student_module.make_improvement_payment_complete', 'uses' => 'STD\CMSStudentImprovementController@make_improvement_payment_complete']);

        $router->POST('make_regular_payments', ['as' => 'take_payment.make_regular_payments', 'uses' => 'STD\RegularAdmitCardController@make_regular_payments']);

        $router->POST('get_courses_for_improvement_apply', ['as' => 'cms_student_module.get_courses_for_improvement_apply', 'uses' => 'STD\CMSStudentImprovementController@get_courses_for_improvement_apply']);
        $router->POST('apply_student_improvement_request', ['as' => 'cms_student_module.apply_student_improvement_request', 'uses' => 'STD\CMSStudentImprovementController@store']);
        $router->GET('download_student_admit_card/{reg_code}/{ies_id}/{type}', ['as' => 'cms_student_module.download_admit_card', 'uses' => 'STD\CMSStudentImprovementController@download_improvement_admit_card']);
        $router->POST('cancel_student_improvement_request', ['as' => 'cms_student_module.cancel_student_improvement_request', 'uses' => 'STD\CMSStudentImprovementController@destroy']);
        $router->GET('download_student_application/{reg_code}/{currentExamScheduleId}/{type}', ['as' => 'cms_student_module.download_application', 'uses' => 'STD\CMSStudentImprovementController@application']);

        $router->PUT('update-students-actual-fee-and-number-of-semester', ['as' => 'cms_student_module.students_actual_fee_and_no_of_semester', 'uses' => 'STD\StudentsController@update_students_actual_fee']);
        $router->PUT('update-ct-students-actual-fee-and-semester-n-paymenet-from-semseter', ['as' => 'cms_student_module.ct_students_actual_fee_no_of_semester_etc', 'uses' => 'STD\StudentsController@update_ct_students_actual_fee']);
        $router->PUT('apply-extra-fee-on-students', ['as' => 'cms_student_module.apply-extra-fee-on-students', 'uses' => 'STD\StudentsController@applyExtraFeeOnStudents']);

        $router->GET('students', ['as' => 'cms_student_module.students_list', 'uses' => 'STD\StudentsController@index']);
        $router->POST('mailtostudents', ['as' => 'cms_student_module.send_email_to_students', 'uses' => 'MailController@store']);

        $router->GET('students/material/syllabus', ['as' => 'cms_student_module.material_syllabus_list', 'uses' => 'STD\SyllabusController@index']);
        $router->GET('students/material/syllabus/{id}/edit', ['as' => 'cms_student_module.material_syllabus_view_for_edit', 'uses' => 'STD\SyllabusController@edit']);
        $router->POST('students/material/syllabus', ['as' => 'cms_student_module.material_syllabus_save', 'uses' => 'STD\SyllabusController@store']);
        $router->PUT('students/material/syllabus/{id}', ['as' => 'cms_student_module.material_syllabus_update', 'uses' => 'STD\SyllabusController@update']);
        $router->DELETE('students/material/syllabus/{id}', ['as' => 'cms_student_module.material_syllabus_trash', 'uses' => 'STD\SyllabusController@destroy']);
        $router->GET('students/material/syllabus/{id}/{key}/download', ['as' => 'cms_student_module.material_syllabus_download', 'uses' => 'STD\SyllabusController@download']);

        $router->GET('students/material/questions', ['as' => 'cms_student_module.material_questions_list', 'uses' => 'STD\QuestionController@index']);
        $router->GET('students/material/questions/{id}/edit', ['as' => 'cms_student_module.material_questions_view_for_edit', 'uses' => 'STD\QuestionController@edit']);
        $router->POST('students/material/questions', ['as' => 'cms_student_module.material_questions_save', 'uses' => 'STD\QuestionController@store']);
        $router->PUT('students/material/questions/{id}', ['as' => 'cms_student_module.material_questions_update', 'uses' => 'STD\QuestionController@update']);
        $router->DELETE('students/material/questions/{id}', ['as' => 'cms_student_module.material_questions_trash', 'uses' => 'STD\QuestionController@destroy']);
        $router->GET('students/material/questions/{id}/{key}/download', ['as' => 'cms_student_module.material_questions_download', 'uses' => 'STD\QuestionController@download']);

        $router->GET('students/material/lesson_plans', ['as' => 'cms_student_module.material_lesson_plans_list', 'uses' => 'STD\LessonPlanController@index']);
        $router->GET('students/material/lesson_plans/{id}/edit', ['as' => 'cms_student_module.material_lesson_plans_view_for_edit', 'uses' => 'STD\LessonPlanController@edit']);
        $router->POST('students/material/lesson_plans', ['as' => 'cms_student_module.material_lesson_plans_save', 'uses' => 'STD\LessonPlanController@store']);
        $router->PUT('students/material/lesson_plans/{id}', ['as' => 'cms_student_module.material_lesson_plans_update', 'uses' => 'STD\LessonPlanController@update']);
        $router->DELETE('students/material/lesson_plans/{id}', ['as' => 'cms_student_module.material_lesson_plans_trash', 'uses' => 'STD\LessonPlanController@destroy']);
        $router->GET('students/material/lesson_plans/{id}/{key}/download', ['as' => 'cms_student_module.material_lesson_plans_download', 'uses' => 'STD\LessonPlanController@download']);

        $router->GET('students/material/lecture_sheets', ['as' => 'cms_student_module.material_lecture_sheets_list', 'uses' => 'STD\LectureSheetController@index']);
        $router->GET('students/material/lecture_sheets/{id}/edit', ['as' => 'cms_student_module.material_lecture_sheets_view_for_edit', 'uses' => 'STD\LectureSheetController@edit']);
        $router->POST('students/material/lecture_sheets', ['as' => 'cms_student_module.material_lecture_sheets_save', 'uses' => 'STD\LectureSheetController@store']);
        $router->PUT('students/material/lecture_sheets/{id}', ['as' => 'cms_student_module.material_lecture_sheets_update', 'uses' => 'STD\LectureSheetController@update']);
        $router->DELETE('students/material/lecture_sheets/{id}', ['as' => 'cms_student_module.material_lecture_sheets_trash', 'uses' => 'STD\LectureSheetController@destroy']);
        $router->GET('students/material/lecture_sheets/{id}/{key}/download', ['as' => 'cms_student_module.material_lecture_sheets_download', 'uses' => 'STD\LectureSheetController@download']);

        /**
         * transcript api urls
         */

        $router->GET('students/transcript/unverified_list', ['as' => 'cms_transcript.transcript_unverified_list', 'uses' => 'STD\StudentTranscriptController@unverified_list']);
        $router->put('students/transcript/verify/{id}', ['as' => 'cms_transcript.transcript_verify', 'uses' => 'STD\StudentTranscriptController@verify']);

        $router->GET('students/transcript/departments', ['as' => 'cms_transcript.transcript_departments_list', 'uses' => 'STD\StudentTranscriptController@transcript_department']);
        $router->POST('students/transcript/upload', ['as' => 'cms_transcript.transcript_save', 'uses' => 'STD\StudentTranscriptController@store']);
        $router->POST('students/transcript/upload_temp', ['as' => 'cms_transcript.transcript_temp_upload', 'uses' => 'STD\StudentTranscriptController@store_temp']);
        $router->POST('students/transcript/find', ['as' => 'cms_transcript.transcript_find', 'uses' => 'STD\StudentTranscriptController@index']);
        $router->GET('students/transcript/{id}/edit', ['as' => 'cms_transcript.transcript_for_edit', 'uses' => 'STD\StudentTranscriptController@edit']);
        $router->POST('students/transcript/upload/{id}', ['as' => 'cms_transcript.transcript_update', 'uses' => 'STD\StudentTranscriptController@update']);
        $router->DELETE('students/transcript/delete/{id}', ['as' => 'cms_transcript.temporary_delete', 'uses' => 'STD\StudentTranscriptController@delete']);
        $router->GET('students/transcript/trashed', ['as' => 'cms_transcript.transcript_trashed_list', 'uses' => 'STD\StudentTranscriptController@trashed']);
        $router->POST('students/transcript/restore/{id}', ['as' => 'cms_transcript.transcript_restore', 'uses' => 'STD\StudentTranscriptController@restore']);
        $router->DELETE('students/transcript/destroy/{id}', ['as' => 'cms_transcript.transcript_delete_parmanent', 'uses' => 'STD\StudentTranscriptController@destroy']);

        $router->GET('get_attendance_departments', ['as' => 'cms_student_attendance.get_attendance_departments', 'uses' => 'STD\StudentAttendanceController@get_attendance_departments']);
        $router->GET('get_attendance_batch/{department_id}', ['as' => 'cms_student_attendance.get_attendance_batch', 'uses' => 'STD\StudentAttendanceController@get_attendance_batch']);
        $router->GET('get_attendance_course/{batch_id}', ['as' => 'cms_student_attendance.get_attendance_course', 'uses' => 'STD\StudentAttendanceController@get_attendance_course']);

        $router->GET('attendance_departments', ['as' => 'cms_student_attendance.departments_list', 'uses' => 'STD\StudentAttendanceController@attendance_departments']);
        $router->GET('attendance_students/{department_id}/{batch_id}', ['as' => 'cms_student_attendance.students_list', 'uses' => 'STD\StudentAttendanceController@attendance_students']);
        $router->POST('attendance_students/{department_id}/{batch_id}/{semester}/{course_id}', ['as' => 'cms_student_attendance.store', 'uses' => 'STD\StudentAttendanceController@store']);

        $router->POST('check_attendance/{department_id}/{batch_id}/{semester}/{course_id}', ['as' => 'cms_student_attendance.check_attendance', 'uses' => 'STD\StudentAttendanceController@check_attendance']);

        $router->POST('attendance_reports', ['as' => 'cms_student_attendance.attendance_reports', 'uses' => 'STD\StudentAttendanceController@attendance_reports']);


        $router->GET('get_spcial_admit_card/{ora_uid}', ['as' => 'take_payment.get_spcial_admit_card', 'uses' => 'STD\RegularAdmitCardController@get_spcial_admit_card']);
        $router->GET('download_spcial_admit_card/{ora_uid}[/{remove_ids}]', ['as' => 'take_payment.download_spcial_admit_card', 'uses' => 'STD\RegularAdmitCardController@download_spcial_admit_card']);

        $router->get('get-student-by-regcode-part/{txid}/{regcodepart}', [
            'as' => 'mobile_banking.searchStudent', 'uses' => 'rms\MobilebankingController@getStudentByRegcodePartial']);

        $router->get('get-student-by-regcode-part-for-manual-input/{regcodepart}', [
            'as' => 'mobile_banking.searchStudentForMaualInput', 'uses' => 'rms\MobilebankingController@getStudentByRegcodePartialForManualInput']);

        $router->post('mobile-banking/manual-entry', ['as' => 'mobile_banking.save', 'uses' => 'rms\MobilebankingController@store']);
        $router->post('mobile-banking/verify-payment/{stdId}/{mobileBaningRowId}', ['as' => 'mobile_banking.save', 'uses' => 'rms\MobilebankingController@verifyPayment']);
        $router->delete('mobile-banking/{mobileBaningRowId}', ['as' => 'mobile_banking.delete', 'uses' => 'rms\MobilebankingController@deleteMobilepayment']);

    });

});


$router->get('show_urls_with_routename_middleware', function () {
    return getAllRouteNameAsArray();
});


$router->group(['prefix' => 'bank', 'middleware' => ['Bank']], function () use ($router) {
//    $router->GET('students', ['as' => 'exim.getStudents', 'uses' => 'STD\BankController@getStudents']);
    $router->POST('students', ['as' => 'exim.getStudentDetail', 'uses' => 'STD\BankController@getStudentDetail']);

});


$router->group(['prefix' => 'phone-call',], function () use ($router) {
    $router->GET('search/{response_key}', ['as' => 'phoneCall.search', 'uses' => 'PhoneCall\PhoneCallController@search']);
    $router->POST('store', ['as' => 'phoneCall.store', 'uses' => 'PhoneCall\PhoneCallController@store']);
});

$router->group(['prefix' => 'pbx',], function () use ($router) {
    $router->GET('campaign-lists', ['as' => 'pbx.campaign', 'uses' => 'Pbx\CampaignController@index']);
    $router->GET('campaign-wise-report/{campaign_id}', ['as' => 'pbx.campaignWiseReport', 'uses' => 'Pbx\CampaignWiseSmsReportController@campaignWiseReport']);
    $router->GET('campaign-wise-error-report/{campaign_id}', ['as' => 'pbx.campaignWiseErrorReport', 'uses' => 'Pbx\CampaignWiseSmsReportController@campaignWiseErrorReport']);
    $router->GET('campaign-wise-error-report-download/{campaign_id}', ['as' => 'pbx.campaignWiseErrorReportDownload', 'uses' => 'Pbx\CampaignWiseSmsReportController@campaignWiseErrorReportDownload']);
});

$router->group(['prefix' => 'importSms', 'namespace' => 'ImportSms',], function () use ($router) {
    $router->get('import-message', ['as' => 'importSms.importMessageIndex', 'uses' => 'ImportSmsController@importMessageIndex']);
    $router->get('import-message-done', ['as' => 'importSms.importMessageDone', 'uses' => 'ImportSmsController@importMessageDone']);
    $router->get('import-message-delete', ['as' => 'importSms.importMessageDelete', 'uses' => 'ImportSmsController@importMessageDelete']);
    $router->post('action-status', ['as' => 'importSms.actionStatus', 'uses' => 'ImportSmsController@actionStatus']);
});

$router->POST('potential-student-csv-upload', ['as' => 'potentialStudent.store', 'uses' => 'CMS\PotentialStudentController@store']);


//employee support ticket permission start *** route not change
$router->group(['prefix' => 'it-support', 'namespace' => 'ItSupport',], function () use ($router) {
    $router->get('get-permission', ['as' => 'supportTicketAction.getPermission', 'uses' => 'SupportTicketActionController@getPermission']);
});
//employee support ticket permission end

//student support ticket permission start *** route not change
$router->group(['prefix' => 'it-support/student', 'namespace' => 'STD',], function () use ($router) {
    $router->get('get-permission', ['as' => 'studentSupportTicketAction.getPermission', 'uses' => 'SupportTicketActionController@getPermission']);
});
//student support ticket permission end


$router->group(['prefix' => 'bapi', 'namespace' => 'koha',], function () use ($router) {

    $router->get('index', ['as' => 'koha.index', 'uses' => 'KohaController@index']);

});
