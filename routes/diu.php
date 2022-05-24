<?php

$router->group(['middleware' => ['token.auth']], function () use ($router) {

    $router->group(['middleware' => ['CommonAccessMiddleware']], function () use ($router) {
        /* for diu.ac start for cms **new site** */
        $router->group(['prefix' => 'diu-website', 'namespace' => 'DIUWebsite'], function () use ($router) {

            /* slider start */
            $router->get('slider', ['as' => 'slider.index', 'uses' => 'SliderController@index']);
            $router->post('slider', ['as' => 'slider.store', 'uses' => 'SliderController@store']);
            $router->get('slider/{id}', ['as' => 'slider.edit', 'uses' => 'SliderController@edit']);
            $router->put('slider/{id}', ['as' => 'slider.update', 'uses' => 'SliderController@update']);
            /* slider end */

            /* partner start */
            $router->get('partner', ['as' => 'partner.index', 'uses' => 'PartnerController@index']);
            $router->post('partner', ['as' => 'partner.store', 'uses' => 'PartnerController@store']);
            $router->get('partner/{id}', ['as' => 'partner.edit', 'uses' => 'PartnerController@edit']);
            $router->put('partner/{id}', ['as' => 'partner.update', 'uses' => 'PartnerController@update']);
            /* partner end */

            /* publication start */
            $router->get('publication', ['as' => 'publication.index', 'uses' => 'PublicationController@index']);
            $router->post('publication', ['as' => 'publication.store', 'uses' => 'PublicationController@store']);
            $router->get('publication/{id}', ['as' => 'publication.edit', 'uses' => 'PublicationController@edit']);
            $router->put('publication/{id}', ['as' => 'publication.update', 'uses' => 'PublicationController@update']);
            /* publication end */

            /* newslatter start */
            $router->get('newslatter', ['as' => 'newslatter.index', 'uses' => 'NewsLetterController@index']);
            /* newslatter end */

            /* convocation start */
            $router->get('convocation', ['as' => 'convocation.index', 'uses' => 'ConvocationController@index']);
            $router->post('convocation', ['as' => 'convocation.store', 'uses' => 'ConvocationController@store']);
            $router->get('convocation/{id}', ['as' => 'convocation.edit', 'uses' => 'ConvocationController@edit']);
            $router->put('convocation/{id}', ['as' => 'convocation.update', 'uses' => 'ConvocationController@update']);
            $router->delete('convocation/{id}', ['as' => 'convocation.destroy', 'uses' => 'ConvocationController@destroy']);
            /* convocation end */

            /* vital-person type start */
            $router->get('vital-person-type', ['as' => 'vitalPersonType.index', 'uses' => 'VitalPersonTypeController@index']);
            /* vital-person type end */

            /* vital-person start */
            $router->get('vital-person', ['as' => 'vitalPerson.index', 'uses' => 'VitalPersonController@index']);
            $router->post('vital-person', ['as' => 'vitalPerson.store', 'uses' => 'VitalPersonController@store']);
            $router->get('vital-person/{id}', ['as' => 'vitalPerson.edit', 'uses' => 'VitalPersonController@edit']);
            $router->put('vital-person/{id}', ['as' => 'vitalPerson.update', 'uses' => 'VitalPersonController@update']);
            /* vital-person end */


            /* programs start */
            $router->get('programs', ['as' => 'diuacPrograms.index', 'uses' => 'ProgramsController@index']);
            $router->get('programs/{id}', ['as' => 'diuacPrograms.show', 'uses' => 'ProgramsController@show']);
            $router->post('programs-serial', ['as' => 'diuacPrograms.programsSerial', 'uses' => 'ProgramsController@programsSerial']);
            /* programs end */


            /* programs start */
            $router->get('programs-data/{website_program_id}', ['as' => 'diuacProgramsData.show', 'uses' => 'ProgramsDataController@show']);
            $router->post('programs-data', ['as' => 'diuacProgramsData.store', 'uses' => 'ProgramsDataController@store']);
            $router->get('faculty-members', ['as' => 'diuacProgramsData.facultyMembers', 'uses' => 'ProgramsDataController@facultyMembers']);


            $router->get('objectives/{website_program_id}', ['as' => 'diuacObjectives.index', 'uses' => 'ObjectivesController@index']);
            $router->post('objectives', ['as' => 'diuacObjectives.store', 'uses' => 'ObjectivesController@store']);
            $router->get('objective/{id}', ['as' => 'diuacObjectives.edit', 'uses' => 'ObjectivesController@edit']);
            $router->put('objective/{id}', ['as' => 'diuacObjectives.update', 'uses' => 'ObjectivesController@update']);
            $router->delete('objective/{id}', ['as' => 'diuacObjectives.destroy', 'uses' => 'ObjectivesController@destroy']);


            $router->get('facilities/{website_program_id}', ['as' => 'diuacFacilities.index', 'uses' => 'FacilitiesController@index']);
            $router->post('facilities', ['as' => 'diuacFacilities.store', 'uses' => 'FacilitiesController@store']);
            $router->get('facility/{id}', ['as' => 'diuacFacilities.edit', 'uses' => 'FacilitiesController@edit']);
            $router->put('facility/{id}', ['as' => 'diuacFacilities.update', 'uses' => 'FacilitiesController@update']);
            $router->delete('facility/{id}', ['as' => 'diuacFacilities.destroy', 'uses' => 'FacilitiesController@destroy']);


            $router->get('galleries/{website_program_id}', ['as' => 'diuacGallery.index', 'uses' => 'GalleryController@index']);
            $router->post('gallery', ['as' => 'diuacGallery.store', 'uses' => 'GalleryController@store']);
            $router->get('gallery/{id}', ['as' => 'diuacGallery.edit', 'uses' => 'GalleryController@edit']);
            $router->put('gallery/{id}', ['as' => 'diuacGallery.update', 'uses' => 'GalleryController@update']);
            $router->delete('gallery/{id}', ['as' => 'diuacGallery.destroy', 'uses' => 'GalleryController@destroy']);

            $router->get('syllabuses/{website_program_id}', ['as' => 'diuacSyllabus.index', 'uses' => 'SyllabusController@index']);
            $router->post('syllabus', ['as' => 'diuacSyllabus.store', 'uses' => 'SyllabusController@store']);
            $router->get('syllabus/{id}', ['as' => 'diuacSyllabus.edit', 'uses' => 'SyllabusController@edit']);
            $router->put('syllabus/{id}', ['as' => 'diuacSyllabus.update', 'uses' => 'SyllabusController@update']);
            $router->delete('syllabus/{id}', ['as' => 'diuacSyllabus.destroy', 'uses' => 'SyllabusController@destroy']);

            //faculty
            $router->get('faculty/{website_program_id}', ['as' => 'diuacFaculty.show', 'uses' => 'FacultyController@show']);
            $router->post('faculty', ['as' => 'diuacFaculty.store', 'uses' => 'FacultyController@store']);

            //faculty
            $router->get('ieb-membership/{website_program_id}', ['as' => 'diuacIeb.show', 'uses' => 'IebController@show']);
            $router->post('ieb-membership', ['as' => 'diuacIeb.store', 'uses' => 'IebController@store']);

            /* programs end */


            /* newslatter start */
            $router->get('contact-form', ['as' => 'contactForm.index', 'uses' => 'ContactFormController@index']);
            /* newslatter end */

            $router->get('notice-event', ['as' => 'diuacNoticeEvent.index', 'uses' => 'NoticeEventController@index']);
            $router->post('notice-event', ['as' => 'diuacNoticeEvent.store', 'uses' => 'NoticeEventController@store']);
            $router->get('notice-event/{id}', ['as' => 'diuacNoticeEvent.edit', 'uses' => 'NoticeEventController@edit']);
            $router->put('notice-event/{id}', ['as' => 'diuacNoticeEvent.update', 'uses' => 'NoticeEventController@update']);
            $router->delete('notice-event/{id}', ['as' => 'diuacNoticeEvent.destroy', 'uses' => 'NoticeEventController@destroy']);

            //files-upload
            $router->get('file-upload', ['as' => 'diuacFileUpload.index', 'uses' => 'FileUploadController@index']);
            $router->post('file-upload', ['as' => 'diuacFileUpload.store', 'uses' => 'FileUploadController@store']);
            //files-upload

        });
        /* for diu.ac end for cms **new site** */
    });

});

/* for diu.ac public start **new site** */
$router->group(['prefix' => 'public-diu-website', 'namespace' => 'DIUWebsite'], function () use ($router) {
    $router->get('programs', ['as' => '[diuAc.index', 'uses' => 'DiuAcController@programs']);
    $router->get('sliders', ['as' => 'diuAc.slider', 'uses' => 'DiuAcController@slider']);
    $router->get('notice-event', ['as' => 'diuAc.noticeEvent', 'uses' => 'DiuAcController@noticeEvent']);
    $router->get('notice/{slug}', ['as' => 'diuAc.noticeDetails', 'uses' => 'DiuAcController@noticeDetails']);
    $router->get('partners', ['as' => 'diuAc.partners', 'uses' => 'DiuAcController@partners']);
    $router->get('publication', ['as' => 'diuAc.publication', 'uses' => 'DiuAcController@publication']);
    $router->get('convocations', ['as' => 'diuAc.convocations', 'uses' => 'DiuAcController@convocations']);
    $router->get('department-basic-info/{slug}', ['as' => 'diuAc.departmentBasicInfo', 'uses' => 'DiuAcController@departmentBasicInfo']);
    $router->get('department-objectives/{slug}', ['as' => 'diuAc.departmentObjectives', 'uses' => 'DiuAcController@departmentObjectives']);
    $router->get('department-facilities/{slug}', ['as' => 'diuAc.departmentFacilities', 'uses' => 'DiuAcController@departmentFacilities']);
    $router->get('department-gallery/{slug}', ['as' => 'diuAc.departmentGallery', 'uses' => 'DiuAcController@departmentGallery']);
    $router->get('department-syllabus/{slug}', ['as' => 'diuAc.departmentSyllabus', 'uses' => 'DiuAcController@departmentSyllabus']);
    $router->get('department-faculty-member/{slug}', ['as' => 'diuAc.departmentFacultyMember', 'uses' => 'DiuAcController@departmentFacultyMember']);
    $router->get('department-ieb-membership/{slug}', ['as' => 'diuAc.departmentIebMembership', 'uses' => 'DiuAcController@departmentIebMembership']);

    $router->get('key-resource-persons', ['as' => 'diuAc.keyResourcePersons', 'uses' => 'DiuAcController@keyResourcePersons']);
    $router->get('diu-governing-bodies', ['as' => 'diuAc.diuGoverningBodies', 'uses' => 'DiuAcController@diuGoverningBodies']);

    //NewsLetter create
    $router->post('newslatter', ['as' => 'newslatter.store', 'uses' => 'NewsLetterController@store']);
    //contact form create
    $router->post('contact-form', ['as' => 'diuAc.contactForm', 'uses' => 'DiuAcController@contactForm']);



});
/* for diu.ac public end **new site** */

