<?php

namespace App\Http\Controllers\DiuLibraryWebsite;

use App\Http\Resources\LibraryTeamResource;
use App\Models\DiuLibrary\LibraryAboutAndServices;
use App\Models\DiuLibrary\LibraryContactForm;
use App\Models\DiuLibrary\LibraryDocument;
use App\Models\DiuLibrary\LibraryGallery;
use App\Models\DiuLibrary\LibraryHome;
use App\Models\DiuLibrary\LibraryTeamMember;
use App\Models\DiuLibrary\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DiuLibraryController extends Controller
{
    public function slider()
    {
        return Slider::active()->get();
    }

    public function home()
    {
        return LibraryHome::first();
    }

    public function gallery()
    {
        return LibraryGallery::all();
    }

    public function aboutService($type)
    {
        return LibraryAboutAndServices::whereType($type)->get();
    }

    public function teamMember()
    {
        return LibraryTeamResource::collection(LibraryTeamMember::with('employee', 'employee.relDesignation', 'employee.relDepartment')->get());
    }

    public function documents()
    {
        return LibraryDocument::all();
    }

    public function contactForm(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'subject' => 'required|string|max:200',
            'email' => 'required|email|max:50',
            'message' => 'required|string',
        ]);

        LibraryContactForm::create($request->all());

        return response()->json(['message' => 'Message Send Successfully'], 201);
    }

}
