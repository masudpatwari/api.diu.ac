<?php

namespace App\Http\Controllers\DiuLibrary;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DiuLibrary\LibraryHome;


class HomePageController extends Controller
{
    public function index()
    {
        return LibraryHome::first();
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'about' => 'required|string',
            'mission' => 'required|string',
            'vision' => 'required|string',
            'library_hours' => 'required|string',
            'printed_books' => 'required|string',
            'printed_journals' => 'required|string',
            'online_e_books' => 'required|string',
            'online_journals' => 'required|string',
            'file' => 'nullable|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);


        \DB::transaction(function () use ($request) {
            $files = $request->file('file');

            $image_url = $request->image_url ?? '';

            if ($files) {
                $extension = $files->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $files->move(storage_path('images/diuLibrary/home'), $file_name);

                $image_url = env('APP_URL') . "/images/diuLibrary/home/{$file_name}";
            }


            LibraryHome::find($request->id)->update([
                'about' => $request->about,
                'mission' => $request->mission,
                'vision' => $request->vision,
                'library_hours' => $request->library_hours,
                'printed_books' => $request->printed_books,
                'printed_journals' => $request->printed_journals,
                'online_e_books' => $request->online_e_books,
                'image_url' => $image_url,
            ]);
        });

        return response()->json(['message' => 'Home Updated Successfully'], 200);
    }

}
