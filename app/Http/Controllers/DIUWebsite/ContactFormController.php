<?php

namespace App\Http\Controllers\DIUWebsite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DIUWebsite\WebsiteContactForm;
use App\Http\Resources\DiuWebsite\ContactFormResource;

class ContactFormController extends Controller
{
    public function index()
    {
        return ContactFormResource::collection(WebsiteContactForm::decending()->paginate('200'));
    }

}
