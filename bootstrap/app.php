<?php


date_default_timezone_set('Asia/Dhaka');

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(dirname(__DIR__)))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->register(Illuminate\Mail\MailServiceProvider::class);

$app->withFacades();

$app->withEloquent();

$app->configure('logging');

$app->configure('database');

$app->configure('mail');


$app->alias('mailer', Illuminate\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\MailQueue::class);
$app->alias('Curl', Ixudra\Curl\Facades\Curl::class);
$app->alias('QRCode', LaravelQRCode\Facades\QRCode::class);
$app->alias('QrCode', SimpleSoftwareIO\QrCode\Facades\QrCode::class);

//class_alias('Ixudra\Curl\Facades\Curl', 'Curl');

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

$app->routeMiddleware([
    'token.auth' => App\Http\Middleware\TokenAuthMiddleware::class,
    'token.student.auth' => App\Http\Middleware\TokenStudentAuthMiddleware::class,
    // 'CorsMiddleware' => App\Http\Middleware\CorsMiddleware::class,
//    'CorsMiddleware' => 	Vluzrmos\LumenCors\CorsMiddleware::class,
    'CommonAccessMiddleware' => App\Http\Middleware\CommonAccessMiddleware::class,
    'HostelAccessMiddleware' => App\Http\Middleware\HostelAccessMiddleware::class,
    'LeaveAttendanceMiddleware' => App\Http\Middleware\LeaveAttendanceMiddleware::class,
    'AdministrationMiddleware' => App\Http\Middleware\AdministrationMiddleware::class,
    'SupperUserMiddleware' => App\Http\Middleware\SupperUserMiddleware::class,
    'RmsMiddleware' => App\Http\Middleware\RmsMiddleware::class,
    'STDMiddleware' => App\Http\Middleware\STDMiddleware::class,
    'Bank' => App\Http\Middleware\BankMiddleware::class,

]);
$app->middleware([
	// 'Vluzrmos\LumenCors\CorsMiddleware'

]);
/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);
$app->register(App\Providers\CorsProvider::class);
$app->register(Appzcoder\LumenRoutesList\RoutesCommandServiceProvider::class);
$app->register(Vluzrmos\Tinker\TinkerServiceProvider::class);
$app->register(Ixudra\Curl\CurlServiceProvider::class);
$app->register(LaravelQRCode\Providers\QRCodeServiceProvider::class);
$app->register(SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class);


/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
    require __DIR__.'/../routes/tcrc.php';
    require __DIR__.'/../routes/iqac.php';
    require __DIR__.'/../routes/diu.php';
    require __DIR__.'/../routes/library.php';
    require __DIR__.'/../routes/admission.php';
});

return $app;
