<?php

$router->group(['middleware' => ['token.auth']], function () use ($router) {

    $router->group(['middleware' => ['CommonAccessMiddleware']], function () use ($router) {





        $router->group(['prefix' => 'importSms', 'namespace' => 'ImportSms',], function () use ($router) {
            $router->get('import-message', ['as' => 'importSms.importMessageIndex', 'uses' => 'ImportSmsController@importMessageIndex']);
            $router->get('import-message-done', ['as' => 'importSms.importMessageDone', 'uses' => 'ImportSmsController@importMessageDone']);
            $router->get('import-message-delete', ['as' => 'importSms.importMessageDelete', 'uses' => 'ImportSmsController@importMessageDelete']);
            $router->post('action-status', ['as' => 'importSms.actionStatus', 'uses' => 'ImportSmsController@actionStatus']);
        });

        $router->POST('potential-student-csv-upload', ['as' => 'potentialStudent.store', 'uses' => 'CMS\PotentialStudentController@store']);


        $router->group(['prefix' => 'admission', 'namespace' => 'Admission'], function () use ($router) {

            /** shift api start**/
            $router->GET('shifts', ['as' => 'admissionFetchData.shiftsIndex', 'uses' => 'AdmissionFetchDataController@shiftsIndex']);
            /** shift api end**/

            /** group api start**/
            $router->GET('groups', ['as' => 'admissionFetchData.groupsIndex', 'uses' => 'AdmissionFetchDataController@groupsIndex']);
            /** group api end**/

            $router->GET('religion', ['as' => 'admissionFetchData.religionIndex', 'uses' => 'AdmissionFetchDataController@religionIndex']);

            $router->GET('country', ['as' => 'admissionFetchData.country', 'uses' => 'AdmissionFetchDataController@country']);
            $router->GET('division', ['as' => 'admissionFetchData.division', 'uses' => 'AdmissionFetchDataController@division']);
            $router->GET('district/{division_id}', ['as' => 'admissionFetchData.district', 'uses' => 'AdmissionFetchDataController@district']);
            $router->GET('upazila/{district_id}', ['as' => 'admissionFetchData.upazila', 'uses' => 'AdmissionFetchDataController@upazila']);
            $router->GET('union/{upazila_id}', ['as' => 'admissionFetchData.union', 'uses' => 'AdmissionFetchDataController@union']);

            $router->GET('refereed-by-parent', ['as' => 'admissionFetchData.refereedByParent', 'uses' => 'AdmissionFetchDataController@refereedByParent']);
            $router->GET('refereed-child-by-parent/{parent_id}', ['as' => 'admissionFetchData.refereedChildByParent', 'uses' => 'AdmissionFetchDataController@refereedChildByParent']);

            $router->GET('campus', ['as' => 'admissionFetchData.campus', 'uses' => 'AdmissionFetchDataController@campus']);
            $router->GET('payment-system', ['as' => 'admissionFetchData.paymentSystem', 'uses' => 'AdmissionFetchDataController@paymentSystem']);
            $router->GET('department-wise-inactive-batch/{department_id}', ['as' => 'admissionFetchData.departmentWiseInactiveBatch', 'uses' => 'AdmissionFetchDataController@departmentWiseInactiveBatch']);

            $router->POST('monthly', ['as' => 'monthly.admission', 'uses' => 'AdmissionFetchDataController@monthlyAdmission']);

        });


    });
  



    $router->group(['middleware' => ['LeaveAttendanceMiddleware']], function () use ($router) {
        /*Upcoming student*/
        $router->get('letter-of-admission', ['as' => 'InternationalStudentDoc.letter_of_admission', 'uses' => 'INTL\UpcomingStudentsController@letter_of_admission']);
        $router->get('immigration-latter', ['as' => 'InternationalStudentDoc.immigration_latter', 'uses' => 'INTL\UpcomingStudentsController@immigration_latter']);
        $router->get('passport-receiving-slip', ['as' => 'InternationalStudentDoc.passport_receiving_slip', 'uses' => 'INTL\UpcomingStudentsController@passport_receiving_slip']);
        $router->post('upcoming-student-store', ['as' => 'InternationalStudentDoc.upcoming_student_store', 'uses' => 'INTL\UpcomingStudentsController@upcoming_student_store']);
        $router->get('upcoming-student-fetch/{user_id}', ['as' => 'InternationalStudentDoc.upcoming_student_fetch', 'uses' => 'INTL\UpcomingStudentsController@upcoming_student_fetch']);
        $router->post('upcoming-student-update', ['as' => 'InternationalStudentDoc.upcoming_student_update', 'uses' => 'INTL\UpcomingStudentsController@upcoming_student_update']);

        /*routes for intl students*/
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


        $router->get('get_student_scholarship_eligible', ['as' => 'liaison_bill_student.get_student_scholarship_eligible', 'uses' => 'LiaisonOfficerController@get_student_scholarship_eligible']);
        $router->get('student_scholarship_eligible_store/{id}/{eligible_id}', ['as' => 'liaison_bill_student.student_scholarship_eligible_store', 'uses' => 'LiaisonOfficerController@student_scholarship_eligible_store']);
        $router->get('student_scholarship_eligible_calculate', ['as' => 'liaison_bill_student.student_scholarship_eligible_calculate', 'uses' => 'LiaisonOfficerController@student_scholarship_eligible_calculate']);
        $router->post('student_scholarship_eligible_calculate_store', ['as' => 'liaison_bill_student.student_scholarship_eligible_calculate_store', 'uses' => 'LiaisonOfficerController@student_scholarship_eligible_calculate_store']);
        $router->get('student_scholarship_eligible_fee_calculate/{student_id}', ['as' => 'liaison_bill_student.student_scholarship_eligible_fee_calculate', 'uses' => 'LiaisonOfficerController@student_scholarship_eligible_fee_calculate']);
        $router->get('scholarship_eligible_student_info/{student_id}', ['as' => 'liaison_bill_student.scholarship_eligible_student_info', 'uses' => 'LiaisonOfficerController@scholarship_eligible_student_info']);
        $router->get('student_scholarship_eligible_generate_pdf/{student_id}/{english}/{program}/{chair}', ['as' => 'liaison_bill_student.student_scholarship_eligible_generate_pdf', 'uses' => 'LiaisonOfficerController@student_scholarship_eligible_generate_pdf']);
        $router->get('student_scholarship_eligible_final_posting_qrcode/{start}/{end}', ['as' => 'liaison_bill_student.student_scholarship_eligible_final_posting_qrcode', 'uses' => 'LiaisonOfficerController@student_scholarship_eligible_final_posting_qrcode']);
        $router->get('student_scholarship_eligible_final_posting_qrcode_pdf/{start}/{end}', ['as' => 'liaison_bill_student.student_scholarship_eligible_final_posting_qrcode_pdf', 'uses' => 'LiaisonOfficerController@student_scholarship_eligible_final_posting_qrcode_pdf']);

        $router->get('student_scholarship_eligible_search_final_posting/{id}', ['as' => 'liaison_bill_student.student_scholarship_eligible_search_final_posting', 'uses' => 'LiaisonOfficerController@student_scholarship_eligible_search_final_posting']);
        $router->get('student_scholarship_eligible_store_final_posting/{student_id}', ['as' => 'liaison_bill_student.student_scholarship_eligible_store_final_posting_in_erp', 'uses' => 'LiaisonOfficerController@student_scholarship_eligible_store_final_posting']);


        /** admission in active batch start**/
        $router->group(['prefix' => 'admission', 'namespace' => 'Admission'], function () use ($router) {
            $router->get('admission-in-active-batch', [
                'as' => 'admissionInActiveBatch.index',
                'uses' => 'AdmissionInActiveBatchController@index'
            ]);


            // Admission Form

            $router->get('import-admission-form', [
                'as' => 'admissionForm.import',
                'uses' => 'StockController@index'
            ]);


            $router->get('admission-form-search/{form}', [
                'as' => 'admissionForm.Search',
                'uses' => 'AdmissionFormController@search'
            ]);


            $router->POST('form-sales/{id}', [
                'as' => 'admissionForm.update',
                'uses' => 'AdmissionFormController@update'
            ]);



            $router->get('batch-by-department/{id}', [
                'as' => 'admissionForm.batchByDepartmentId',
                'uses' => 'AdmissionFormController@getBatch'
            ]);



            $router->get('get-admission-form-recieve/{recieve}', [
                'as' => 'admissionForm.print',
                'uses' => 'AdmissionFormController@getPrintRecieve'
            ]);



            // English Book Form



            $router->get('import-english-book-form', [
                'as' => 'englishBookForm.import',
                'uses' => 'StockController@english_book'
            ]);



            $router->get('english-book-form-search/{form}', [
                'as' => 'englishBookForm.search',
                'uses' => 'AdmissionFormController@english_book_search'
            ]);



            $router->POST('english-book-form-sales/{id}', [
                'as' => 'englishBookForm.sale',
                'uses' => 'AdmissionFormController@english_book_update'
            ]);



            $router->get('english-book-form-print/{recieve}', [
                'as' => 'englishBookForm.print',
                'uses' => 'AdmissionFormController@getPrintRecieveEnglishBook'
            ]);



            $router->POST('update-english-book-form', [
                'as' => 'englishBookForm.update',
                'uses' => 'StockController@english_book_create'
            ]);




            $router->get('admission-in-batch', [
                'as' => 'admissionInBatch.index',
                'uses' => 'AdmissionInActiveBatchController@all'
            ]);

            $router->get('admission-in-active-batch-students/{batch_id}', [
                'as' => 'admissionInActiveBatch.studentsList',
                'uses' => 'AdmissionInActiveBatchController@studentsList'
            ]);

            $router->get('admission-in-active-batch-unverified-students/{batch_id}', [
                'as' => 'admissionInActiveBatch.unverifiedStudentsList',
                'uses' => 'AdmissionInActiveBatchController@unverifiedStudentsList'
            ]);

            $router->post('admission-in-active-batch', [
                'as' => 'admissionInActiveBatch.store',
                'uses' => 'AdmissionInActiveBatchController@store'
            ]);

            $router->post('unverified-students-payment-and-reg-code-generate', [
                'as' => 'admissionInActiveBatch.unverifiedStudentsPaymentAndRegCodeGenerate',
                'uses' => 'AdmissionInActiveBatchController@unverifiedStudentsPaymentAndRegCodeGenerate'
            ]);

            $router->post('student-transfer', [
                'as' => 'admissionInActiveBatch.studentTransfer',
                'uses' => 'AdmissionInActiveBatchController@studentTransfer'
            ]);

            //batch create
            $router->get('batch', [
                'as' => 'batch.index',
                'uses' => 'BatchController@index'
            ]);

            $router->post('batch', [
                'as' => 'batch.store',
                'uses' => 'BatchController@store'
            ]);

            $router->get('batch/{id}/edit', [
                'as' => 'batch.edit',
                'uses' => 'BatchController@edit'
            ]);

            $router->put('batch/{id}', [
                'as' => 'batch.update',
                'uses' => 'BatchController@update'
            ]);

            $router->get('student-account-info-print/{student_id}', [
                'as' => 'newStudentAccount.print',
                'uses' => 'NewStudentAccountController@print'
            ]);

            //student-session
            $router->get('student-session', [
                'as' => 'studentSession.index',
                'uses' => 'StudentSessionController@index'
            ]);

            $router->get('student-session/{id}/edit', [
                'as' => 'studentSession.edit',
                'uses' => 'StudentSessionController@edit'
            ]);

            $router->post('student-session', [
                'as' => 'studentSession.store',
                'uses' => 'StudentSessionController@store'
            ]);


            $router->put('student-session/{id}', [
                'as' => 'studentSession.update',
                'uses' => 'StudentSessionController@update'
            ]);

            $router->get('registration-summary', [
                'as' => 'registrationSummary.index',
                'uses' => 'RegistrationSummaryController@index'
            ]);

            $router->post('student-readmission', [
                'as' => 'studentReadmission.store',
                'uses' => 'StudentReadmissionController@store'
            ]);

            $router->get('student-reg-card-status/{department_id}', [
                'as' => 'studentRegCardStatus.index',
                'uses' => 'StudentRegCardStatusController@index'
            ]);

            $router->get('student-reg-card-print/{department_id}', [
                'as' => 'studentRegCardStatus.print',
                'uses' => 'StudentRegCardStatusController@print'
            ]);

            $router->put('student-reg-card-status/{batch_id}', [
                'as' => 'studentRegCardStatus.update',
                'uses' => 'StudentRegCardStatusController@update'
            ]);

            $router->post('student-image-update', [
                'as' => 'studentImage.update',
                'uses' => 'StudentImageController@update'
            ]);

            $router->get('student/{id}', [
                'as' => 'student.show',
                'uses' => 'StudentController@show'
            ]);

            $router->post('student-info-update', [
                'as' => 'student.update',
                'uses' => 'StudentController@update'
            ]);


            $router->get('whats_app_messages', [
                'as' => 'whats_app.index',
                'uses' => 'WhatsAppController@index'
            ]);


            $router->get('load-templates/{type}', [
                'as' => 'whats_app.loadTemplate',
                'uses' => 'WhatsAppController@loadTemplate'
            ]);


            $router->get('get-templates', [
                'as' => 'whats_app.getTemplates',
                'uses' => 'WhatsAppController@getTemplates'
            ]);


            $router->post('store-template', [
                'as' => 'whats_app.templateStore',
                'uses' => 'WhatsAppTemplateController@store'
            ]);


            $router->post('update-template/{id}', [
                'as' => 'whats_app.templateUpdate',
                'uses' => 'WhatsAppTemplateController@update'
            ]);


            $router->post('delete-template/{id}', [
                'as' => 'whats_app.templateDelete',
                'uses' => 'WhatsAppTemplateController@delete'
            ]);


            $router->post('whats_app_messages/send', [
                'as' => 'whats_app.send',
                'uses' => 'App\Http\Controllers\Admission\WhatsApp\WhatsAppController@send'
            ]);

            $router->get('student-search/{slug}', [
                'as' => 'student.update',
                'uses' => 'StudentController@search'
            ]);

            $router->get('student-pending-id-card', [
                'as' => 'studentPendingIdCard.index',
                'uses' => 'StudentPendingIdCardController@index'
            ]);

            $router->post('student-pending-id-card-update', [
                'as' => 'studentPendingIdCard.update',
                'uses' => 'StudentPendingIdCardController@update'
            ]);
        });
        /** admission in active batch end**/


        /** new student account create start**/
        $router->group(['prefix' => 'admission', 'namespace' => 'Admission'], function () use ($router) {
            //see list
            $router->get('student-info-by-reg/{reg_code}', [
                'as' => 'newStudentAccount.show',
                'uses' => 'NewStudentAccountController@show'
            ]);

            //new admission student portal create
            $router->post('student-info-by-reg', [
                'as' => 'newStudentAccount.store',
                'uses' => 'NewStudentAccountController@store'
            ]);

            //after microsoft email create data update for student portal
            $router->post('new-student-microsoft-email-update', [
                'as' => 'newStudentAccount.update',
                'uses' => 'NewStudentAccountController@update'
            ]);

        });
        /** new student account create end**/
    });


    $router->group(['middleware' => ['AdministrationMiddleware']], function () use ($router) {

        // message lists start
        $router->group(['prefix' => 'goip',], function () use ($router) {
            $router->get('receive-message', ['as' => 'goip.receiveMessageIndex', 'uses' => 'GOIP\ReceiveMessageController@receiveMessageIndex']);
            $router->get('receive-message-done', ['as' => 'goip.receiveMessageDone', 'uses' => 'GOIP\ReceiveMessageController@receiveMessageDone']);
            $router->get('receive-message-delete', ['as' => 'goip.receiveMessageDelete', 'uses' => 'GOIP\ReceiveMessageController@receiveMessageDelete']);
            $router->post('action-status', ['as' => 'goip.actionStatus', 'uses' => 'GOIP\ReceiveMessageController@actionStatus']);
        });
        // message lists end

    });
   
});
$router->get('store_new_admision_student_for_scholarship', ['as' => 'liaison_bill_student.store_new_admision_student_for_scholarship', 'uses' => 'LiaisonOfficerController@store_new_admision_student_for_scholarship']);
