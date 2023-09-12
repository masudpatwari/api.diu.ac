<?php

$router->group(['middleware' => ['token.auth']], function () use ($router) {

    $router->group(['middleware' => ['CommonAccessMiddleware']], function () use ($router) {
        /* for diu library start for cms */
        $router->group(['prefix' => 'diu-library', 'namespace' => 'DiuLibrary'], function () use ($router) {

            /* slider start */
            $router->get('slider', ['as' => 'DiuLibrarySlider.index', 'uses' => 'SliderController@index']);
            $router->post('slider', ['as' => 'DiuLibrarySlider.store', 'uses' => 'SliderController@store']);
            $router->get('slider/{id}', ['as' => 'DiuLibrarySlider.edit', 'uses' => 'SliderController@edit']);
            $router->put('slider/{id}', ['as' => 'DiuLibrarySlider.update', 'uses' => 'SliderController@update']);
            $router->delete('slider/{id}', ['as' => 'DiuLibrarySlider.destroy', 'uses' => 'SliderController@destroy']);
            /* slider end */

            /* about-and-services start */
            $router->get('about-and-services', ['as' => 'DiuLibraryAboutAndServices.index', 'uses' => 'AboutAndServicesController@index']);
            $router->post('about-and-services', ['as' => 'DiuLibraryAboutAndServices.store', 'uses' => 'AboutAndServicesController@store']);
            $router->get('about-and-services/{id}', ['as' => 'DiuLibraryAboutAndServices.edit', 'uses' => 'AboutAndServicesController@edit']);
            $router->put('about-and-services/{id}', ['as' => 'DiuLibraryAboutAndServices.update', 'uses' => 'AboutAndServicesController@update']);
            $router->delete('about-and-services/{id}', ['as' => 'DiuLibraryAboutAndServices.destroy', 'uses' => 'AboutAndServicesController@destroy']);
            /* about-and-services end */


            /* gallery start */
            $router->get('gallery', ['as' => 'DiuLibraryGallery.index', 'uses' => 'GalleryController@index']);
            $router->post('gallery', ['as' => 'DiuLibraryGallery.store', 'uses' => 'GalleryController@store']);
            $router->get('gallery/{id}', ['as' => 'DiuLibraryGallery.edit', 'uses' => 'GalleryController@edit']);
            $router->put('gallery/{id}', ['as' => 'DiuLibraryGallery.update', 'uses' => 'GalleryController@update']);
            $router->delete('gallery/{id}', ['as' => 'DiuLibraryGallery.destroy', 'uses' => 'GalleryController@destroy']);
            /* gallery end */

            /* document start */
            $router->get('document', ['as' => 'DiuLibraryDocument.index', 'uses' => 'DocumentController@index']);
            $router->post('document', ['as' => 'DiuLibraryDocument.store', 'uses' => 'DocumentController@store']);
            $router->get('document/{id}', ['as' => 'DiuLibraryDocument.edit', 'uses' => 'DocumentController@edit']);
            $router->put('document/{id}', ['as' => 'DiuLibraryDocument.update', 'uses' => 'DocumentController@update']);
            $router->delete('document/{id}', ['as' => 'DiuLibraryDocument.destroy', 'uses' => 'DocumentController@destroy']);
            /* document end */


            /* team member start */
            $router->get('team-member', ['as' => 'DiuLibraryTeamMember.index', 'uses' => 'TeamMemberController@index']);
            $router->post('team-member', ['as' => 'DiuLibraryDTeamMember.store', 'uses' => 'TeamMemberController@store']);
            $router->delete('team-member/{id}', ['as' => 'DiuLibraryTeamMember.destroy', 'uses' => 'TeamMemberController@destroy']);
            /* team member end */

            /* home page start */
            $router->get('home-page', ['as' => 'DiuLibraryHomePage.index', 'uses' => 'HomePageController@index']);
            $router->post('home-page', ['as' => 'DiuLibraryHomePage.store', 'uses' => 'HomePageController@store']);
            /* home page end */


        });
        /* for diu library end for cms */
    });

});

/* for library public start **new site** */
$router->group(['prefix' => 'public-diu-library-website', 'namespace' => 'DIULibraryWebsite'], function () use ($router) {
    $router->get('slider', ['as' => '[diuLibrary.slider', 'uses' => 'DiuLibraryController@slider']);
    $router->get('home', ['as' => '[diuLibrary.home', 'uses' => 'DiuLibraryController@home']);
    $router->get('about-service/{type}', ['as' => '[diuLibrary.aboutService', 'uses' => 'DiuLibraryController@aboutService']);
    $router->get('gallery', ['as' => '[diuLibrary.gallery', 'uses' => 'DiuLibraryController@gallery']);
    $router->get('team-member', ['as' => '[diuLibrary.teamMember', 'uses' => 'DiuLibraryController@teamMember']);
    $router->get('documents', ['as' => '[diuLibrary.documents', 'uses' => 'DiuLibraryController@documents']);
    $router->post('contact-form', ['as' => '[diuLibrary.contactForm', 'uses' => 'DiuLibraryController@contactForm']);
});
/* for library public end **new site** */