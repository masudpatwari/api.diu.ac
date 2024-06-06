<?php

namespace App\Http\Controllers\DIUWebsite;

use App\Employee;
use App\Models\Convocation\StudentConvocation;
use App\Traits\MetronetSmsTraits;
use Illuminate\Http\Request;
use App\Models\DIUWebsite\Slider;
use App\Models\DIUWebsite\Partner;
use App\Http\Controllers\Controller;
use App\Models\DIUWebsite\Convocation;
use App\Models\DIUWebsite\VitalPerson;
use App\Models\DIUWebsite\Publication;
use App\Models\DIUWebsite\Journal;
use App\Models\DIUWebsite\WebsiteProgram;
use App\Models\DIUWebsite\VitalPersonType;
use App\Models\DIUWebsite\WebsiteProgramIeb;
use App\Models\DIUWebsite\WebsiteContactForm;
use App\Models\DIUWebsite\WebsiteNoticeEvent;
use App\Models\DIUWebsite\WebsiteProgramGallery;
use App\Models\DIUWebsite\WebsiteProgramFaculty;
use App\Http\Resources\DiuWebsite\NoticeResource;
use App\Models\DIUWebsite\WebsiteProgramSyllabus;
use App\Http\Resources\DiuWebsite\ProgramGallery;
use App\Models\DIUWebsite\WebsiteProgramFacility;
use App\Models\DIUWebsite\WebsiteProgramObjective;
use App\Models\DIUWebsite\WebsiteProgramBasicInfo;
use App\Http\Resources\DiuWebsite\ProgramBasicInfo;
use App\Http\Resources\EmployeeShortDetailsResource;
use Illuminate\Support\Facades\Storage;

class DiuAcController extends Controller
{
    use MetronetSmsTraits;

    public function slider()
    {
        return Slider::active()->get();
    }

    public function partners()
    {
        return Partner::active()->get();
    }

    public function publication()
    {
        return Publication::active()->get();
    }
    public function journal()
    {
        return Journal::get();
    }
    public function journalDetails($id)
    {
        return Journal::find($id);
    }

    public function convocations()
    {
        return Convocation::with('convoctionImages')->active()->get();
    }

    public function bookTicket($phone)
    {
        $phone = substr($phone, -11);

        $full_number = '+88' . $phone;

        $user = StudentConvocation::where('contact_no', $full_number)->first();

        if (!$user) {
            return response(['error' => 'Student Not Found'], 400);
        }

//        $convocation_found = \App\Models\Convocation\Convocation::where('convocation_id', $user->id)->first();
        $convocation_found = StudentConvocation::
        where('id', $user->id)
            ->where('confirmed', '<>', null)
            ->first();

        if (isset($convocation_found) && $convocation_found->confirmed == 1) {
            return response(['error' => 'Your response has been saved Already', 'id' => $convocation_found->id], 302);
        }

        if (isset($convocation_found) && $convocation_found->confirmed == 0) {
            return response(['error' => 'Your response has been saved Already', 'id' => $convocation_found->id], 401);
        }

        $otp = rand(1111, 9999);


        $convocation = \App\Models\Convocation\Convocation::updateOrCreate([
            'convocation_id' => $user->id,
            'name' => $user->student_name],
            ['otp' => $otp,
                'timeout' => time() + 180,
            ]);

        $message = "Your DIU Convocation Seat Booking OTP is {$otp}";

        $this->send_sms($phone, $message);

        return response(['success' => 'Student Found', 'convocation' => $user->id], 200);
    }

    public function checkOtp(Request $request)
    {
        $otp = \App\Models\Convocation\Convocation::where('convocation_id', $request->convocation_id)
            ->where('otp', $request->otp)
            ->first();


        if (!$otp) {
            return response(['error' => 'Invalid OTP'], 400);
        }

        if ($otp->timeout > time())
        {
            $user = StudentConvocation::find($request->convocation_id);
            return response(['user' => $user], 200);
        }
        else
        {
            return response(['error' => 'OTP Expired'], 400);
        }
    }

    public function convocationUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'present_address' => 'nullable|string|max:200',
            'permanent_address' => 'nullable|string|max:200',
            'nationality' => 'nullable',
            'contact_no' => 'nullable|string|max:15',
            'email_address' => 'nullable|email|max:100',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg|max:1048'
        ]);

        $info = $request->only('present_address', 'permanent_address', 'nationality', 'contact_no', 'email_address');

        $convocation = StudentConvocation::find($id);

        if (isset($request->image_url)) {
            $image = $request->image_url;
            $image_name = "{$id}." . $image->getClientOriginalExtension();
            Storage::disk('attendance_info')->putFileAs('/', $image, $image_name);
            $image_path = $image_name;

            $info['image_url'] = $image_path;
        }

        try {
            $convocation->update($info);

            return response(['user' => $convocation], 200);
        } catch (\Exception $exception) {
            return response(['user' => $convocation], 400);
        }
    }

    public function convocationConfirmation($id, $confirm)
    {
        $convocation = StudentConvocation::find($id);

        $convocation->update([
            'confirmed' => ($confirm == 'true') ? 1 : 0
        ]);
    }

    public function keyResourcePersons()
    {
        return VitalPersonType::with('vitalPersons')->whereSlug('key-resource-persons')->active()->first();
    }

    public function diuGoverningBodies()
    {
        $vitalPersonType = VitalPersonType::with('vitalPersons')
            ->where('slug', '!=', 'key-resource-persons')
            ->active()
            ->orderBy('serial_no')
            ->get();

//        return
        $vitalPerson = VitalPerson::active()->oldest('rank')->get();

        $data = [
            'vitalPersonType' => $vitalPersonType,
            'vitalPerson' => $vitalPerson
        ];

        return $data;
    }

    public function programs()
    {
        $data = [
            'data' => WebsiteProgram::active()->orderPosition()->get()
        ];

        return $data;
    }

    public function departmentBasicInfo($slug)
    {
        $websiteProgram = WebsiteProgram::whereSlug($slug)->first();

        if (!$websiteProgram) {
            return response()->json(['message' => 'no data found'], 401);
        }

        $websiteProgramBasicInfo = WebsiteProgramBasicInfo::with('employee', 'employee.relDesignation')
            ->whereWebsiteProgramId($websiteProgram->id)
            ->first();


        if (!$websiteProgramBasicInfo) {
            return response()->json(['message' => 'no data found'], 401);
        }

        $programBasicInfo = new ProgramBasicInfo($websiteProgramBasicInfo);

        return $programBasicInfo;
    }

    public function departmentObjectives($slug)
    {
        $websiteProgram = WebsiteProgram::whereSlug($slug)->first();

        if (!$websiteProgram) {
            return response()->json(['message' => 'no data found'], 401);
        }

        $websiteProgramBasicInfo = WebsiteProgramObjective::whereWebsiteProgramId($websiteProgram->id)
            ->get();

        if (!$websiteProgramBasicInfo) {
            return response()->json(['message' => 'no data found'], 401);
        }

        return $websiteProgramBasicInfo;
    }

    public function departmentFacilities($slug)
    {
        $websiteProgram = WebsiteProgram::whereSlug($slug)->first();

        if (!$websiteProgram) {
            return response()->json(['message' => 'no data found'], 401);
        }

        $websiteProgramBasicInfo = WebsiteProgramFacility::whereWebsiteProgramId($websiteProgram->id)
            ->get();

        if (!$websiteProgramBasicInfo) {
            return response()->json(['message' => 'no data found'], 401);
        }

        return $websiteProgramBasicInfo;
    }

    public function departmentGallery($slug)
    {
        $websiteProgram = WebsiteProgram::whereSlug($slug)->first();

        if (!$websiteProgram) {
            return response()->json(['message' => 'no data found'], 401);
        }

        $websiteProgramGallery = WebsiteProgramGallery::whereWebsiteProgramId($websiteProgram->id)
            ->paginate('20');

        if (!$websiteProgramGallery) {
            return response()->json(['message' => 'no data found'], 401);
        }

        return ProgramGallery::collection($websiteProgramGallery);
    }

    public function departmentSyllabus($slug)
    {
        $websiteProgram = WebsiteProgram::whereSlug($slug)->first();

        if (!$websiteProgram) {
            return response()->json(['message' => 'no data found'], 401);
        }

        $websiteProgramSyllabus = WebsiteProgramSyllabus::whereWebsiteProgramId($websiteProgram->id)
            ->get();

        if (!$websiteProgramSyllabus) {
            return response()->json(['message' => 'no data found'], 401);
        }

        return $websiteProgramSyllabus;
    }

    public function departmentFacultyMember($slug)
    {
        $websiteProgram = WebsiteProgram::whereSlug($slug)->first();

        if (!$websiteProgram) {
            return response()->json(['message' => 'no data found'], 401);
        }

         $websiteProgramFaculty = WebsiteProgramFaculty::whereWebsiteProgramId($websiteProgram->id)->first();

        if (!$websiteProgramFaculty) {
            return response()->json(['message' => 'no data found'], 401);
        }

        $employees = Employee::with(['relDepartment', 'relDesignation'])
            ->whereIn('shortPosition_id', $websiteProgramFaculty->short_position_ids)
            ->whereActivestatus(1)
            ->orderBy('merit', 'DESC')
            ->get();

        if (!empty($employees)) {
            return EmployeeShortDetailsResource::collection($employees);
        }

        return response()->json(['message' => 'no data found'], 401);
    }

    public function departmentIebMembership($slug)
    {
        $websiteProgram = WebsiteProgram::whereSlug($slug)->first();

        if (!$websiteProgram) {
            return response()->json(['message' => 'no data found'], 401);
        }

        $websiteProgramIebMembership = WebsiteProgramIeb::whereWebsiteProgramId($websiteProgram->id)->active()
            ->first();

        if (!$websiteProgramIebMembership) {
            return response()->json(['message' => 'no data found'], 401);
        }

        return $websiteProgramIebMembership;
    }

    public function contactForm(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:200',
            'last_name' => 'required|string|max:200',
            'email' => 'required|email|max:100|unique:website_contact_forms',
            'subject' => 'required|string|max:300',
            'message' => 'required|string|max:800',
        ]);

        WebsiteContactForm::create($request->all());
        return response()->json(['message' => 'Form Submitted Successfully'], 200);
    }
    public function notice(){
        // return WebsiteNoticeEvent::get();
        return NoticeResource::collection(WebsiteNoticeEvent::with('noticeFiles')
        ->latest()
        ->active()
        ->paginate(40)
    );
    }

    public function noticeEvent(Request $request)
    {
        return NoticeResource::collection(WebsiteNoticeEvent::with('noticeFiles')
            ->latest()
            ->active()
            ->whereType(trim($request->type))
            ->paginate(100)
        );
    }

    public function noticeDetails($slug)
    {

        $websiteNotice = WebsiteNoticeEvent::with('noticeFiles')->active()->whereSlug(urldecode($slug))->first();

        if (!$websiteNotice) {
            return response()->json(['message' => 'data not found'], 400);
        }
        return new NoticeResource($websiteNotice);
    }

}
