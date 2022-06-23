<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Models\WhatsApp\WhatsAppTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ixudra\Curl\Facades\Curl;


class WhatsAppTemplateController extends Controller
{
    public function store(Request $request)
    {

        $validatedData = $this->validate($request,
            [
                'name' => 'required',
                'message' => 'required',
                'type' => 'required',
            ]
        );

//        $validatedData['type'] = $request->input('type') == 1 ? 'local' : "foreign";
        $validatedData['created_by'] = $request->auth->id ?? null;

        $templateSave = WhatsAppTemplate::insert($validatedData);

        if(!empty($templateSave)){
            return response( 'Template Saved Successfully', 200);
        }

        return response( 'Something Went Wrong', 200);
    }


    public function update(Request $request, $template_id)
    {
        $validatedData = $this->validate($request,
            [
                'name' => 'required',
                'message' => 'required',
                'type' => 'required',
            ]
        );


//        $validatedData['type'] = $request->input('type') == 1 ? 'local' : "foreign";
        $validatedData['updated_by'] = $request->auth->id ?? null;


        $templateUpdate = WhatsAppTemplate::find($template_id);


        if(!empty($templateUpdate)){
            $templateUpdate->update($validatedData);

            return response( 'Template Updated Successfully', 200);
        }


        return response( 'Something Went Wrong', 200);
    }


    public function delete(Request $request, $template_id)
    {
        try {
            $templateSave = WhatsAppTemplate::destroy($template_id);

            return response('Template Deleted Successfully', 200);
        }catch(\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            return response('Something Went Wrong', 200);
        }
    }

}

