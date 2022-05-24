<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Docmtg;
use App\Employee;
use App\Traits\DocmtgTraits;

class DocmtgController extends Controller
{
    use DocmtgTraits;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, 
            [
                'doc_type' => ['required', Rule::in(['public','semi-public','private','confidential'])],
                // 'category' => ['required', Rule::in(['Life long','5 years','10 years','Current year only'])],
            ]
        );
        $emp = Employee::with('relDepartment')->find($request->auth->id);

        if ($emp->merit < 3) {
            return respnse()->json('You Have No Permission', 400);
        }

        $docs = Docmtg::where('deleted_by',null);

        $docs->where('doc_mtg_code','like','%/'.$emp->relDepartment->doc_mtg_code.'/%');

        if ( $request->doc_type =='confidential' ) {            
            $ids = array_unique(array_flatten(Employee::subordinate_ids($request->auth->id)));
            $docs->whereIn('created_by', $ids);
        }
        else if ( $request->doc_type =='private') {
            $docs->where('created_by', $request->auth->id);
        }

        return $docs->where('doc_type',$request->doc_type)->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, 
            [
                'department' => ['required', 'max:200'],
                'date' => ['required', 'date'],
                'to' => ['required', 'max:200'],
                'subject' => ['required', 'max:200'],
                'desent_reference' => [ 'max:200'],
                'signatory' => ['required'],
                'description_of_letter' => ['required'],
                'doc_type' => ['required', Rule::in(['public','semi-public','private','confidential'])],
                'category' => ['required', Rule::in(['Life long','5 years','10 years','Current year only'])],
                'doc' => [ 'mimes:doc,docx,pdf,jpg,jpeg,png', 'max:2048'],
            ]
        );

        
        $doc = $this->create_doc($request->to, $request->subject, $request->desent_reference, $request->signatory, $request->description_of_letter, 
            $request->auth->id, $request->date, $request->doc_type , $request->category);

        $id = $doc->id;


        $code = $id . '/' . $request->department .'/DIU/'.date('m').'/' . date('Y');

        $doc->doc_mtg_code = $code;
        $doc->save();

        if ($request->hasFile('doc') && $request->file('doc')->isValid()){
            $file = $request->file('doc');
            $extention = strtolower($file->getClientOriginalExtension());
            $filename = 'doc' . $id . '.' . $extention;
            try {
                $request->file('doc')->move(storage_path('docs'), $filename);                

                $doc->extension = $extention;
                $doc->save();

            } catch (\PDOException $e) {
                $doc->delete();
                return response()->json(['error' => 'Doc saved Failed. May Need Permission'], 400);
            }
        }

        return response()->json(['success' => 'Doc saved successfull.','code'=>$code] , 201);


    }

    public function show($id)
    {
        return Docmtg::find($id);
    }

    public function download($id, $tokenVal)
    {
        if ($id.'00'.$id != $tokenVal) {
            return response()->json('Token Not Valid!', 404);
        }
        $doc = Docmtg::find($id);
        $filename = storage_path('docs') . '/doc' . $id . '.' . $doc->extension;
        if (file_exists($filename)) {
            return response()->download($filename);
        }
        return response()->json('File Not Found!', 404);
    }

    public function edit(Request $request, $id)
    {

    }

    public function update(Request $request, $id)
    {
        
        $this->validate($request, 
            [
                'department' => ['required', 'max:200'],
                'date' => ['required', 'date'],
                'to' => ['required', 'max:200'],
                'subject' => ['required', 'max:200'],
                'desent_reference' => [ 'max:200'],
                'signatory' => ['required'],
                'description_of_letter' => ['required'],
                'doc_type' => ['required', Rule::in(['public','semi-public','private','confidential'])],
                'category' => ['required', Rule::in(['Life long','5 years','10 years','Current year only'])],
                'doc' => [ 'mimes:doc,docx,pdf,jpg,jpeg,png', 'max:2048'],
            ]
        );

        $doc = Docmtg::find($id);

        if( $doc->created_by != $request->auth->id ){
        	return response()->json(['error'=>'You cannot update this doc'], 400);
        }

        $doc->date = $request->date;
        $doc->to = $request->to;
        $doc->subject = $request->subject;
        $doc->desent_reference = $request->desent_reference;
        $doc->signatory = $request->signatory;
        $doc->description_of_letter = $request->description_of_letter;
        $doc->doc_type = $request->doc_type;
        $doc->category = $request->category;
        $doc->updated_at = date("Y-m-d H:i:s");
        $doc->updated_by = $request->auth->id;

		$code_array = explode('/', $doc->doc_mtg_code);
		$code_array[1] = $request->department;// index 1 is department code

        $doc->doc_mtg_code = implode('/', $code_array);
        $doc->save();
        
        if ($request->hasFile('doc') && $request->file('doc')->isValid()){
            $file = $request->file('doc');
            $extention = strtolower($file->getClientOriginalExtension());
            $filename = 'doc' . $id . '.' . $extention;
            try {
            	if (file_exists(storage_path('docs').'/'. $filename)) {
            		unlink(storage_path('docs') .'/'.$filename);
            	}
                $request->file('doc')->move(storage_path('docs'), $filename);                
                $doc->extension = $extention;
                $doc->save();

            } catch (\PDOException $e) {                
                return response()->json(['error' => 'Doc Update Fail.' . $e->getMessage()], 400);
            }

        }

        return response()->json(['success' => 'Doc Updated successfull.','code'=>$doc->doc_mtg_code] , 200);
    }

    public function destroy(Request $request, $id)
    {
        return response()->json(NULL, 404);
    }
}
