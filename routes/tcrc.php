<?php

$router->group(['middleware' => ['token.auth']], function () use ($router) {

    $router->group(['middleware' => ['CommonAccessMiddleware']], function () use ($router) {
        $router->group(['prefix' => 'diu-tcrc', 'namespace' => 'DIUTCRC'], function () use ($router) {
            /* slider start */
            $router->get('slider', ['as' => 'slider.index', 'uses' => 'SliderController@index']);
            $router->post('slider', ['as' => 'slider.store', 'uses' => 'SliderController@store']);
            $router->get('slider/{id}', ['as' => 'slider.edit', 'uses' => 'SliderController@edit']);
            $router->put('slider/{id}', ['as' => 'slider.update', 'uses' => 'SliderController@update']);
            $router->delete('slider/{id}', ['as' => 'slider.destroy', 'uses' => 'SliderController@destroy']);
            /* slider end */

            /* partner start */
            $router->get('partner', ['as' => 'partner.index', 'uses' => 'PartnerController@index']);
            $router->post('partner', ['as' => 'partner.store', 'uses' => 'PartnerController@store']);
            $router->get('partner/{id}', ['as' => 'partner.edit', 'uses' => 'PartnerController@edit']);
            $router->put('partner/{id}', ['as' => 'partner.update', 'uses' => 'PartnerController@update']);
            $router->delete('partner/{id}', ['as' => 'partner.destroy', 'uses' => 'PartnerController@destroy']);
            /* partner end */

            /* research-and-publications start */
            $router->get('research-and-publications', ['as' => 'researchAndPublications.index', 'uses' => 'ResearchAndPublicationsController@index']);
            $router->post('research-and-publications', ['as' => 'researchAndPublications.store', 'uses' => 'ResearchAndPublicationsController@store']);
            $router->get('research-and-publications/{id}', ['as' => 'researchAndPublications.edit', 'uses' => 'ResearchAndPublicationsController@edit']);
            $router->put('research-and-publications/{id}', ['as' => 'researchAndPublications.update', 'uses' => 'ResearchAndPublicationsController@update']);
            $router->delete('research-and-publications/{id}', ['as' => 'researchAndPublications.destroy', 'uses' => 'ResearchAndPublicationsController@destroy']);
            /* research-and-publications end */

            /* news-activities start */
            $router->get('news-activities', ['as' => 'newsActivities.index', 'uses' => 'NewsActivitiesController@index']);
            $router->post('news-activities', ['as' => 'newsActivities.store', 'uses' => 'NewsActivitiesController@store']);
            $router->get('news-activities/{id}', ['as' => 'newsActivities.edit', 'uses' => 'NewsActivitiesController@edit']);
            $router->put('news-activities/{id}', ['as' => 'newsActivities.update', 'uses' => 'NewsActivitiesController@update']);
            $router->delete('news-activities/{id}', ['as' => 'newsActivities.destroy', 'uses' => 'NewsActivitiesController@destroy']);
            /* news-activities end */

            /* photos start */
            $router->get('photos', ['as' => 'photos.index', 'uses' => 'PhotosController@index']);
            $router->post('photos', ['as' => 'photos.store', 'uses' => 'PhotosController@store']);
            $router->get('photos/{id}', ['as' => 'photos.edit', 'uses' => 'PhotosController@edit']);
            $router->put('photos/{id}', ['as' => 'photos.update', 'uses' => 'PhotosController@update']);
            $router->delete('photos/{id}', ['as' => 'photos.destroy', 'uses' => 'PhotosController@destroy']);
            /* photos end */

            /* video start */
            $router->get('video', ['as' => 'video.index', 'uses' => 'VideoController@index']);
            $router->post('video', ['as' => 'video.store', 'uses' => 'VideoController@store']);
            $router->get('video/{id}', ['as' => 'video.edit', 'uses' => 'VideoController@edit']);
            $router->put('video/{id}', ['as' => 'video.update', 'uses' => 'VideoController@update']);
            $router->delete('video/{id}', ['as' => 'video.destroy', 'uses' => 'VideoController@destroy']);
            /* video end */

            /* national start */
            $router->get('national', ['as' => 'national.index', 'uses' => 'NationalController@index']);
            $router->post('national', ['as' => 'national.store', 'uses' => 'NationalController@store']);
            $router->get('national/{id}', ['as' => 'national.edit', 'uses' => 'NationalController@edit']);
            $router->put('national/{id}', ['as' => 'national.update', 'uses' => 'NationalController@update']);
            $router->delete('national/{id}', ['as' => 'national.destroy', 'uses' => 'NationalController@destroy']);
            /* national end */


            $router->put('setting/{id}', ['as' => 'setting.update', 'uses' => 'SettingController@update']);
            $router->get('team', ['as' => 'setting.teamIndex', 'uses' => 'SettingController@teamIndex']);
            $router->post('team', ['as' => 'setting.teamStore', 'uses' => 'SettingController@teamStore']);
            $router->delete('team/{id}', ['as' => 'setting.teamDestroy', 'uses' => 'SettingController@teamDestroy']);
        });
    });

});


/* for tcrc public start */
$router->group(['prefix' => 'public-diu-trc-website', 'namespace' => 'DIUTCRC'], function () use ($router) {

    $router->get('slider', ['as' => '[diuTcrc.slider', 'uses' => 'DiuTcrcController@slider']);

    $router->get('news-activities/{type}', ['as' => '[diuTcrc.newsActivities', 'uses' => 'DiuTcrcController@newsActivities']);

    $router->get('news-activity/{id}', ['as' => '[diuTcrc.newsActivity', 'uses' => 'DiuTcrcController@newsActivity']);

    $router->get('setting', ['as' => '[diuTcrc.setting', 'uses' => 'DiuTcrcController@setting']);
    $router->get('videos', ['as' => '[diuTcrc.video', 'uses' => 'DiuTcrcController@video']);
    $router->get('photos', ['as' => '[diuTcrc.photos', 'uses' => 'DiuTcrcController@photos']);

    $router->get('research-publication/{type}', ['as' => '[diuTcrc.researchPublication', 'uses' => 'DiuTcrcController@researchPublication']);

    $router->get('teams/{type}', ['as' => '[diuTcrc.teams', 'uses' => 'DiuTcrcController@teams']);

    $router->get('partner', ['as' => '[diuTcrc.partner', 'uses' => 'DiuTcrcController@partner']);

    $router->get('national/{type}', ['as' => '[diuTcrc.national', 'uses' => 'DiuTcrcController@national']);
});
/* for tcrc public end */