<?php

namespace App\Http\Controllers\DIUWebsite;

use App\Http\Resources\DiuWebsite\NewsletterResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DIUWebsite\Newsletter;

class NewsLetterController extends Controller
{
    public function index()
    {
        return NewsletterResource::collection(Newsletter::decending()->paginate('200'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:newsletters',
        ]);

        Newsletter::create($request->all());
        return response()->json(['message' => 'Newsletter Created Successfully'], 200);
    }

}
