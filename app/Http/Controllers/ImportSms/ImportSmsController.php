<?php

namespace App\Http\Controllers\ImportSms;

use Illuminate\Http\Request;
use App\Models\BulkSms\ImportedSms;
use App\Http\Controllers\Controller;
use App\Http\Resources\ImportedSmsResource;

class ImportSmsController extends Controller
{
    public function importMessageIndex()
    {
        $importedSms = ImportedSms::OrderDesc()->whereNull('action_status')->paginate(50);
        return ImportedSmsResource::collection($importedSms);
    }

    public function importMessageDone()
    {
        $importedSms = ImportedSms::OrderDesc()->whereActionStatus('done')->paginate(50);
        return ImportedSmsResource::collection($importedSms);
    }

    public function importMessageDelete()
    {
        $importedSms = ImportedSms::OrderDesc()->whereActionStatus('delete')->paginate(50);
        return ImportedSmsResource::collection($importedSms);
    }

    public function actionStatus(Request $request)
    {
        $this->validate($request, [
            'actionStatus' => 'required|in:done,delete',
            'id' => 'required|integer',
        ]);

        $importedSms = ImportedSms::find($request->id);
        $importedSms->action_status = $request->actionStatus;
        $importedSms->created_by = $request->auth->id ?? '0';
        $importedSms->save();
        return response()->json(['msg' => 'Action Status Change Successfully'], 200);
    }
}
