@php
    $profile = $pdf_data['profile'];
@endphp
<div style="text-align: center; margin-bottom: 0.2in;">
    <h3>Dhaka International University</h3>
    <h1 style="margin: 0.1in 0;">VISA EXTENTION</h1>
    <h4>(Form-2)</h4>
    <h4>(To be filled by the applicant)</h4>
</div>
<div style="margin-bottom: 0.2in;">
    <p>Reference :</p>
    <p>Subject : Personal Information</p>
    <p style="padding-left: 0.3in">Please find the information furnished here under for your ready reference.p</p>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="width: 0.8in; float: left">a | Name</div>
    <div style="float: left;">
        <div style="border: 1px solid #000; height: 0.3in;">{{ $profile->relUser->name }}</div>
    </div>
</div>
<div style="overflow: hidden;">
    <div style="overflow: hidden; float: left; width: 3.3in;">
        <div style="width: 0.6in; float: left">b | Sex</div>
        <div style="float: left;">
            <div style="border: 1px solid #000; text-align: center; float: left; width: 0.8in; height: 0.3in;">Male</div>
            <div style="border: 1px solid #000; text-align: center; float: left; width: 0.8in; height: 0.3in;">Female</div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.3in;">
        <div style="width: 2in; float: left">Name of the company/firm</div>
        <div style="float: left;">
            <div style="border: 1px solid #000; height: 0.3in;"></div>
        </div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.5in;">
    <p>c |</p>
    <table>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Nationality</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ $profile->present_nationality }}</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Nationality, Occupation & Passport no of spouse:</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Place of Birth</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ $profile->place_of_birth }}</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Date of Birth</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ db2d($profile['dob']) }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Country of Birth</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ $profile->country_of_birth }}</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">ID in applicant's country</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Passport number</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ $profile->passport_no }}</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Passport issue date</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ db2d($profile['date_of_issue']) }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Passport validity date</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ db2d($profile->date_of_expire) }}</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Passport issuing authority</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Visa number</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ $profile->last_visa_no }}</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Visa issue date</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ db2d($profile->visa_date_of_issue) }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Visa category</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ $profile->visa_category }}</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Visa validity date</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ db2d($profile->visa_date_of_expire) }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Duration of stay in Bangladesh according to visa status</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Place of visa issue form</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ $profile->visa_place_of_issue }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Visa issuing authority</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Date of application for visa extension</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Land phone number</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ $profile->bd_telephone }}</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">e-mail address</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ $profile->relUser->email }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Cell phone number</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ $profile->bd_mobile }}</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Date of first arrival in Bangladesh</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ db2d($profile->date_of_arrival_bd) }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Name of the Immigration checkpoint while arriving first time in Bangladesh</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Date of last visit in Bangladesh</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;">{{ db2d($profile->date_of_last_visit_bd) }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Name of the Immigration checkpoint while arriving last time in Bangladesh</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Date of enrolment in Foreigners Registration office</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Do you process any work permit ?</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Number & duration of work permit</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Validity date of work permit</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Please mention the date, if you have applied for and extension of your work permit</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Do you pay tax to Bangladesh Government ?</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Does your office activity have any affilation with the offices of Bangladesh government ?</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">Are you engaged with any other occupation in Bangladesh ?</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in; padding: 0.05in;">If applicant engaged with other job then clarify of that</td>
            <td style="border: 1px solid #000; width: 1.8in; height: 0.4in;"></td>
        </tr>
    </table>
</div>

<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="width: 2.5in; float: left">1 | Resident address in Bangladesh</div>
    <div style="float: left;">
        <div style="border: 1px solid #000; height: 0.3in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="float: left;">
        <div style="border: 1px solid #000; height: 0.3in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="width: 1.6in; float: left">2 | Address in abroad</div>
    <div style="float: left;">
        <div style="border: 1px solid #000; height: 0.3in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="float: left;">
        <div style="border: 1px solid #000; height: 0.3in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="width: 1.9in; float: left">3 | Reason of visa extension</div>
    <div style="float: left;">
        <div style="border: 1px solid #000; height: 0.3in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="float: left;">
        <div style="border: 1px solid #000; height: 0.3in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="width: 2.2in; float: left">4 | Sponsor's name and address</div>
    <div style="float: left;">
        <div style="border: 1px solid #000; height: 0.3in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="float: left;">
        <div style="border: 1px solid #000; height: 0.3in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="float: left;">
        <div style="border: 1px solid #000; height: 0.3in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="width: 2.85in; float: left">5 | Your designation in your office (if any)</div>
    <div style="float: left;">
        <div style="border: 1px solid #000; height: 0.3in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="width: 3.4in; float: left">6 | Educational qualification and institution's nan</div>
    <div style="float: left;">
        <div style="border: 1px solid #000; height: 0.3in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="width: 2.4in; float: left">7 | Travel record for the last 3 year</div>
    <div style="float: left;">
        <div style="border: 1px solid #000; height: 0.3in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="float: left;">
        <div style="border: 1px solid #000; height: 0.3in;"></div>
    </div>
</div>
<div style="margin-bottom:0.5in;">
    8 | In case of the Bangladesh national's spouse or dependent, Copy of the birth certificate or national certificate of the Bangladesh national.
</div>

<div style="margin-bottom:0.1in;">
    9 | Is your spouse(s) residing with you in Bangladesh ? If yes please furnish:
</div>

<div style="overflow: hidden; margin-bottom:0.5in;">
    <table>
        <tr>
            <td style="border: 1px solid #000; width: 0.5in; text-align: center;">SL.<br>No</td>
            <td style="border: 1px solid #000; width: 3in; text-align: center;">Name</td>
            <td style="border: 1px solid #000; width: 1.85in; text-align: center;">Passport Number</td>
            <td style="border: 1px solid #000; width: 1.85in; text-align: center;">Relation with you</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 0.5in; height: 0.3in;"></td>
            <td style="border: 1px solid #000; width: 3in; height: 0.3in;"></td>
            <td style="border: 1px solid #000; width: 1.85in; height: 0.3in;"></td>
            <td style="border: 1px solid #000; width: 1.85in; height: 0.3in;"></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 0.5in; height: 0.3in;"></td>
            <td style="border: 1px solid #000; width: 3in; height: 0.3in;"></td>
            <td style="border: 1px solid #000; width: 1.85in; height: 0.3in;"></td>
            <td style="border: 1px solid #000; width: 1.85in; height: 0.3in;"></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; width: 0.5in; height: 0.3in;"></td>
            <td style="border: 1px solid #000; width: 3in; height: 0.3in;"></td>
            <td style="border: 1px solid #000; width: 1.85in; height: 0.3in;"></td>
            <td style="border: 1px solid #000; width: 1.85in; height: 0.3in;"></td>
        </tr>
    </table>
</div>

<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="padding-left: 4in; float: left">Name : </div>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="padding-left: 4in; float: left">Sign : </div>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="padding-left: 4in; float: left">Date : </div>
</div>
