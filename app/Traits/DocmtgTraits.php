<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Docmtg;
use Illuminate\Support\Facades\Cache;

trait DocmtgTraits
{
	public function create_doc($to, $subject, $desent_reference, $signatory, $description_of_letter, $created_by_id, $date, $doc_type = 'public', $category = '5 years' )
	{
		$doc = new Docmtg;
        $doc->date = $date;
        $doc->to = $to;
        $doc->subject = $subject;
        $doc->desent_reference = $desent_reference;
        $doc->signatory = $signatory;
        $doc->description_of_letter = $description_of_letter;
        $doc->doc_type = $doc_type;
        $doc->category = $category;
        $doc->created_by = $created_by_id;
        $doc->updated_by = $created_by_id;
        $doc->save();
        return $doc;
	}
}