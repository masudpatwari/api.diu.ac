@php
    $profile = $pdf_data['profile'];
@endphp
<div style="overflow: hidden;">
    <div style="border: 1px solid #000; width: 1.5in; height: 1.5in; text-align: center; dusplay: table; float: left;">
        <div style="display: table-cell; vertical-align: middle;">
            <p>Applicant's Photograph Measuring</p>
            <p>45mm x 35mm</p>
        </div>
    </div>

    <div style="text-align: center; width: 4.2in; float: left;">
        <img src="{{ storage_path(env('PDF_CSS_STORAGE_PATH')).'/govtLogo.png' }}" width="75" height="75" alt="">
        <p>Government of the People's Republic of Bangladesh</p>
        <p>Department of Immigration & Passports</p>
        <p>Mechine Readable Visa Application From</p>
    </div>
    <div style="width: 1.5in; float: left;">
        <p>D.I.P Form-4(Free of cost)</p>
    </div>
</div>

<ul style="border: 1px solid #000; margin: 0.05in 0; padding: 0.05in 0.05in 0.05in 0.6in;">
    <li>This Form Should Be Filled Up In Capital Letters. Put () In Appropriate Box</li>
    <li>Please Go Through The General Instructions Before Filling Up The Visa Form</li>
    <li>
        <div style="overflow: hidden;">
            <div style="width: 2.2in; float: left;">Name of Office/Bangladesh Mission :</div>
            <div style="padding-left: 2.2in">
                <div style="border-bottom: 1px solid #000; width: 4.3in;  height: 0.23in;"></div>
            </div>
        </div>
    </li>
</ul>

<div style="border: 1px solid #000; margin: 0.05in 0; text-align: center;">
    <p><strong>PERSONAL DETAILS</strong></p>
</div>
@php
$strings = explode(' ', $profile['name']);
$last_name = array_pop($strings);
$first_name = implode(" ", $strings);
@endphp
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 4.2in">
        <div style="width: 1.6in; float: left;">
            01. Full Name :<br> (as in the passport)
        </div>
        <div style="">
            <div style="border: 1px solid #000; width: 2.5in; height: 0.23in;">{{ $first_name }}</div>
            <div style="text-align: center;"><small>First/Given Name (S)</small></div>
        </div>
    </div>
    <div style="overflow: hidden; float: right; width: 2.5in;">
        <div style="">
            <div style="border: 1px solid #000; width: 2.5in; height: 0.23in;">{{ $last_name }}</div>
            <div style="text-align: center;"><small>Last/Surname</small></div>
        </div>
    </div>
</div>


<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="width: 1.6in; float: left;">02. Permanent Address :</div>
    <div style="">
        <div style="border-bottom: 1px solid #000; width: 5.6in; height: 0.23in;">{{ $profile['permanent_address'] }}</div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in">
    <div style="padding-left: 1.6in">
        <div style="border-bottom: 1px solid #000; width: 5.6in; height: 0.23in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in">
    <div style="padding-left: 1.6in">
        <div style="overflow: hidden;">
            <div style="overflow: hidden; float: left; width: 2.6in;">
                <div style="width: 0.8in; float: left;">Contact No :</div>
                <div style="">
                    <div style="border-bottom: 1px solid #000; width: 1.69in; height: 0.23in;">{{ $profile['permanent_mobile'] }}</div>
                </div>
            </div>
            <div style="overflow: hidden; float: left; width: 3in;">
                <div style="width: 0.5in; float: left;">E-mail :</div>
                <div style="">
                    <div style="border-bottom: 1px solid #000; width: 2.49in; height: 0.23in;">{{ $profile['email'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>


<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="width: 1.7in; float: left;">03. Address in Bangladesh :</div>
    <div style="">
        <div style="border-bottom: 1px solid #000; width: 5.5in; height: 0.23in;">{{ $profile['present_address'] }}</div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in">
    <div style="padding-left: 1.6in">
        <div style="border-bottom: 1px solid #000; width: 5.58in; height: 0.23in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in">
    <div style="padding-left: 1.6in">
        <div style="overflow: hidden;">
            <div style="overflow: hidden; float: left; width: 2.6in;">
                <div style="width: 0.8in; float: left;">Contact No :</div>
                <div style="">
                    <div style="border-bottom: 1px solid #000; width: 1.69in; height: 0.23in;">{{ $profile['present_mobile'] }}</div>
                </div>
            </div>
            <div style="overflow: hidden; float: left; width: 3in;">
                <div style="width: 0.5in; float: left;">E-mail :</div>
                <div style="">
                    <div style="border-bottom: 1px solid #000; width: 2.49in; height: 0.23in;">{{ $profile['email'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>


<div style="overflow: hidden; margin-bottom:0.05in">
    <div style="overflow: hidden; float: left; width: 3.5in;">
        <div style="width: 1.2in; float: left;">04. Date of Birth :</div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.24in;">{{ db2d($profile['dob']) }}</div>
            <div style="text-align: center;"><small></small></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 0.6in; float: left;">05. Sex :</div>
        <div style="">
            <div style="overflow: hidden;">
                <div style="overflow: hidden; float: left; width: 0.8in;">
                    <div style="width: 0.4in; float: left;">Male</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;">
                            @if($profile['sex'] == 'male')
                            <img style="margin-left: 0.03in" src="{{ storage_path(env('PDF_CSS_STORAGE_PATH')).'/checked.png' }}" alt="">
                            @endif
                        </div>
                    </div>
                </div>
                <div style="overflow: hidden; float: left; width: 0.8in;">
                    <div style="width: 0.5in; float: left;">Female</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;">
                            @if($profile['sex'] == 'female')
                                <img style="margin-left: 0.03in" src="{{ storage_path(env('PDF_CSS_STORAGE_PATH')).'/checked.png' }}" alt="">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 3.6in">
        <div style="width: 1.5in; float: left;">06. Place of Birth :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.23in;">{{ $profile['place_of_birth'] }}</div>
        </div>
    </div>
    <div style="overflow: hidden; float: right; width: 3.6in;">
        <div style="width: 1.5in; float: left;">07. Present Nationality :</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 2in; height: 0.23in;">{{ $profile['nationality'] }}</div>
        </div>
    </div>
</div>


<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 3.6in">
        <div style="width: 1.5in; float: left;">08. Nationality at Birth :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.23in;">{{ $profile['country_of_birth'] }}</div>
        </div>
    </div>
    <div style="overflow: hidden; float: right; width: 3.6in;">
        <div style="width: 1.4in; float: left;">09. Occupation :</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 2in; height: 0.23in;"></div>
        </div>
    </div>
</div>



<div style="overflow: hidden; margin-bottom:0.05in">
    <div style="overflow: hidden; float: left; width: 7.8in;">
        <div style="width: 1.5in; float: left;">10. Marital Status :</div>
        <div style="">
            <div style="overflow: hidden;">
                <div style="overflow: hidden; float: left; width: 1.4in;">
                    <div style="width: 0.7in; float: left;">Unmarried</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;">
                            @if($profile['marital_status'] == 'unmarried')
                                <img style="margin-left: 0.03in" src="{{ storage_path(env('PDF_CSS_STORAGE_PATH')).'/checked.png' }}" alt="">
                            @endif
                        </div>
                    </div>
                </div>
                <div style="overflow: hidden; float: left; width: 1.4in;">
                    <div style="width: 0.7in; float: left;">Married</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;">
                            @if($profile['marital_status'] == 'married')
                                <img style="margin-left: 0.03in" src="{{ storage_path(env('PDF_CSS_STORAGE_PATH')).'/checked.png' }}" alt="">
                            @endif
                        </div>
                    </div>
                </div>
                <div style="overflow: hidden; float: left; width: 1.5in;">
                    <div style="width: 1in; float: left;">Widower/Widow</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;">
                            @if($profile['marital_status'] == 'widower')
                                <img style="margin-left: 0.03in" src="{{ storage_path(env('PDF_CSS_STORAGE_PATH')).'/checked.png' }}" alt="">
                            @endif
                        </div>
                    </div>
                </div>
                <div style="overflow: hidden; float: left; width: 1.4in;">
                    <div style="width: 0.7in; float: left;">Divorced</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;">
                            @if($profile['marital_status'] == 'divorced')
                                <img style="margin-left: 0.03in" src="{{ storage_path(env('PDF_CSS_STORAGE_PATH')).'/checked.png' }}" alt="">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div style="border: 1px solid #000; margin: 0.1in 0; text-align: center;">
    <p><strong>TRAVEL DOCUMENTS DETAILS</strong></p>
</div>

<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 3.6in">
        <div style="width: 1.5in; float: left;">11. Passport No :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.23in;">{{ $profile['passport_no'] }}</div>
        </div>
    </div>
    <div style="overflow: hidden; float: right; width: 3.6in;">
        <div style="width: 1.3in; float: left;">12. Type of Passport :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.23in;">{{ $profile['type_of_passport'] }}</div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 7.3in">
        <div style="width: 1.5in; float: left;">13. Place of Issue :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.23in;">{{ $profile['place_of_issue'] }}</div>
        </div>
    </div>
</div>


<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 1.5in; float: left;">14. Date of Issue :</div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.23in;">{{ db2d($profile['date_of_issue']) }}</div>
            <div style="text-align: center;"><small>DD/MM/YY</small></div>
        </div>
    </div>
    <div style="overflow: hidden; float: right; width: 3.6in;">
        <div style="width: 1.2in; float: left;">15. Date of Expiry :</div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.23in;">{{ db2d($profile['date_of_expire']) }}</div>
            <div style="text-align: center;"><small>DD/MM/YY</small></div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 7.3in;">
        <div style="width: 2.2in; float: left;">16. Date of last visit to Bangladesh :</div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.23in;">{{ db2d($profile['date_of_last_visit_bd']) }}</div>
            <div style="text-align: center;"><small>DD/MM/YY</small></div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 3.6in">
        <div style="width: 1.5in; float: left;">17. Last Visa No :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.23in;">{{ $profile['last_visa_no'] }}</div>
        </div>
    </div>
    <div style="overflow: hidden; float: right; width: 3.6in;">
        <div style="width: 1.1in; float: left;">18. Date of Issue :</div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.23in;">{{ db2d($profile['visa_date_of_issue']) }}</div>
            <div style="text-align: center;"><small>DD/MM/YY</small></div>
        </div>
    </div>
</div>


<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 3.6in">
        <div style="width: 1.5in; float: left;">19. Place of Issue :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.23in;">{{ $profile['visa_place_of_issue'] }}</div>
        </div>
    </div>
    <div style="overflow: hidden; float: right; width: 3.6in;">
        <div style="width: 1.2in; float: left;">20. Date of Expiry :</div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.23in;">{{ db2d($profile['visa_date_of_expire']) }}</div>
            <div style="text-align: center;"><small>DD/MM/YY</small></div>
        </div>
    </div>
</div>


<div style="border: 1px solid #000; margin: 0.1in 0; text-align: center;">
    <p><strong>PAYMENT DETAILS</strong></p>
</div>


<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="width: 2.1in; float: left;">21. Name of the Bank and Branch :</div>
    <div style="">
        <div style="border-bottom: 1px solid #000; width: 5.1in; height: 0.23in;"></div>
    </div>
</div>


<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="width: 2.6in; float: left;">22. Cheque/Bank Transfer/Chalan/Scroll No :</div>
    <div style="">
        <div style="border-bottom: 1px solid #000; width: 4.6in; height: 0.23in;"></div>
    </div>
</div>


<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 4in">
        <div style="width: 1.4in; float: left;">23. Amount deposited :<br>(Taka/US$)</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: right; width: 2.65in;">
        <div style="width: 0.6in; float: left;">24. Date :</div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.23in;"></div>
            <div style="text-align: center;"><small>DD/MM/YY</small></div>
        </div>
    </div>
</div>



<div style="border: 1px solid #000; margin: 0.1in 0; text-align: center;">
    <p><strong>NEW VISA</strong></p>
</div>

<div style="overflow: hidden; margin-bottom:0.05in">
    <div style="overflow: hidden; float: left; width: 7.3in;">
        <div style="width: 1.5in; float: left;">25. Purpose of Visit :</div>
        <div style="">
            <div style="overflow: hidden;">
                <div style="overflow: hidden; float: left; width: 0.9in; margin-bottom:0.07in;">
                    <div style="width: 0.6in; float: right;">Tourism</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                    </div>
                </div>
                <div style="overflow: hidden; float: left; width: 1.2in; margin-bottom:0.07in;">
                    <div style="width: 0.9in; float: right;">Empliyment</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                    </div>
                </div>
                <div style="overflow: hidden; float: left; width: 0.9in; margin-bottom:0.07in;">
                    <div style="width: 0.6in; float: right;">Business</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                    </div>
                </div>
                <div style="overflow: hidden; float: left; width: 1in; margin-bottom:0.07in;">
                    <div style="width: 0.7in; float: right;">Official</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                    </div>
                </div>
                <div style="overflow: hidden; float: left; width: 1in; margin-bottom:0.07in;">
                    <div style="width: 0.7in; float: right;">Diplomatic</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                    </div>
                </div>
                <div style="overflow: hidden; float: left; width: 1in; margin-bottom:0.07in;">
                    <div style="width: 0.7in; float: right;">Study</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                    </div>
                </div>
                <div style="overflow: hidden; float: left; width: 1in; margin-bottom:0.07in;">
                    <div style="width: 0.7in; float: right;">Investment</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                    </div>
                </div>
                <div style="overflow: hidden; float: left; width: 1in; margin-bottom:0.07in;">
                    <div style="width: 0.7in; float: right;">Transit</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                    </div>
                </div>
                <div style="overflow: hidden; float: left; width: 2in; margin-bottom:0.07in;">
                    <div style="width: 0.5in; float: left;">Others</div>
                    <div style="width: 1.5in;">
                        <div style="border-bottom: 1px solid #000; width: 1.4in; height: 0.23in;"></div>
                        <div style="text-align: center;"><small>(Please Specify)</small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 7.3in">
        <div style="width: 2.7in; float: left;">26. Duration of Proposed Stay in Bangladesh :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.23in;">STUDY</div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 7.3in">
        <div style="width: 2.7in; float: left;">27. Tentative Date of Arrival in Bangladesh :</div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.23in;">{{ date('d-m-Y', strtotime(date('Y-m-d'). ' + 15 days')) }}</div>
            <div style="text-align: center;"><small>DD/MM/YY</small></div>
        </div>
    </div>
</div>


<div style="overflow: hidden; margin-bottom:0.05in">
    <div style="overflow: hidden; float: left; width: 7.3in;">
        <div style="width: 2.5in; float: left;">28. Intended Number of Entries :</div>
        <div style="">
            <div style="overflow: hidden;">
                <div style="overflow: hidden; float: left; width: 1.4in;">
                    <div style="width: 0.45in; float: left;">Single</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                    </div>
                </div>
                <div style="overflow: hidden; float: left; width: 1.4in;">
                    <div style="width: 0.6in; float: left;">Re Entry</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                    </div>
                </div>
                <div style="overflow: hidden; float: left; width: 1.5in;">
                    <div style="width: 0.6in; float: left;">Multiple</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div style="border: 1px solid #000; margin: 0.1in 0; text-align: center;">
    <p><strong>EXTENSION OF VISA</strong></p>
</div>

<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="width: 3.1in; float: left;">29. Name of Father/Mother/Spouse/Other(Relation) :</div>
    <div style="">
        <div style="border-bottom: 1px solid #000; width: 4.15in; height: 0.23in;">
            @if(!empty($profile['father_name']))
                {{ $profile['father_name'] }}
            @else
                @if(!empty($profile['mother_name']))
                    {{ $profile['mother_name'] }}
                @else
                    @if(!empty($profile['spouse_name']))
                        {{ $profile['spouse_name'] }}
                    @else

                    @endif
                @endif
            @endif
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.05in">
    <div style="overflow: hidden; float: left; width: 3.3in;">
        <div style="width: 1.2in; float: left;">30. Date of Arrival :<br>in Bangladesh</div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.23in;">{{ db2d($profile['date_of_arrival_bd']) }}</div>
            <div style="text-align: center;"><small>DD/MM/YY</small></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 1.91in;">
        <div style="width: 0.8in; float: left;">31. Visa No :</div>
        <div style="width: 1in;">
            <div style="border-bottom: 1px solid #000; width: 1in; height: 0.23in;">{{ $profile['last_visa_no'] }}</div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 2in;">
        <div style="width: 1in; float: left;">32. Type of Visa :</div>
        <div style="width: 1in;">
            <div style="border-bottom: 1px solid #000; width: 1in; height: 0.23in;">{{ $profile['visa_category'] }}</div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 1.1in; float: left;">33. Date of Issue :</div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.23in;">{{ db2d($profile['visa_date_of_issue']) }}</div>
            <div style="text-align: center;"><small>DD/MM/YY</small></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 1.2in; float: left;">34. Date of Expiry :</div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.23in;">{{ db2d($profile['visa_date_of_expire']) }}</div>
            <div style="text-align: center;"><small>DD/MM/YY</small></div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 7.3in">
        <div style="width: 2.2in; float: left;">35. Place of Issue :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.23in;">{{ $profile['visa_place_of_issue'] }}</div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 7.3in">
        <div style="width: 2.2in; float: left;">36. Purpose of Extension of Visa :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.23in;">STUDY</div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 7.3in">
        <div style="width: 2.2in; float: left;">36. Duration of Purposed Extension :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.23in;">4 Years</div>
        </div>
    </div>
</div>


<div style="overflow: hidden; margin-bottom:0.05in">
    <div style="overflow: hidden; float: left; width: 7.3in;">
        <div style="width: 2.5in; float: left;">38. Intended Number of Entries :</div>
        <div style="">
            <div style="overflow: hidden;">
                <div style="overflow: hidden; float: left; width: 1.4in;">
                    <div style="width: 0.45in; float: left;">Single</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                    </div>
                </div>
                <div style="overflow: hidden; float: left; width: 1.4in;">
                    <div style="width: 0.6in; float: left;">Re Entry</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                    </div>
                </div>
                <div style="overflow: hidden; float: left; width: 1.5in;">
                    <div style="width: 0.6in; float: left;">Multiple</div>
                    <div style="">
                        <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="border: 1px solid #000; margin: 0.1in 0; text-align: center;">
    <p><strong>NO VISA REQUIRED FOR TRAVEL TO BANGLADESH</strong></p>
</div>


<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 3.6in">
        <div style="width: 1.5in; float: left;">39 Father's name :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: right; width: 3.1in;">
        <div style="width: 1in; float: left;">Nationality :</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 2in; height: 0.23in;"></div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 3.6in">
        <div style="width: 1.5in; float: left;">40 Mother's name :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: right; width: 3.1in;">
        <div style="width: 1in; float: left;">Nationality :</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 2in; height: 0.23in;"></div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 3.6in">
        <div style="width: 1.5in; float: left;">41 Spouse's name :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: right; width: 3.1in;">
        <div style="width: 1in; float: left;">Nationality :</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 2in; height: 0.23in;"></div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 4.1in;">
        <div style="width: 2.1in; float: left;">42. Date of Arrival in Bangladesh :</div>
        <div style="width: 1.8in;">
            <div style="border-bottom: 1px solid #000; width: 1.8in; height: 0.23in;"></div>
            <div style="text-align: center;"><small>DD/MM/YY</small></div>
        </div>
    </div>
    <div style="overflow: hidden; float: right; width: 3.1in">
        <div style="width: 1in; float: left;">43. Visa No :</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 2in; height: 0.3in;"></div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 1.1in; float: left;">44. Date of Issue :</div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.23in;"></div>
            <div style="text-align: center;"><small>DD/MM/YY</small></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 1.2in; float: left;">45. Date of Expiry :</div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.23in;"></div>
            <div style="text-align: center;"><small>DD/MM/YY</small></div>
        </div>
    </div>
</div>


<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 3.6in">
        <div style="width: 1.5in; float: left;">46. Place of Issue :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: right; width: 3.6in;">
        <div style="width: 1.4in; float: left;">47. Type of Visa :</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 2in; height: 0.23in;"></div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 7.3in;">
        <div style="width: 3.2in; float: left;">48. Reason For Proposed NVR :</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 4in; height: 0.23in;"></div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 7.3in">
        <div style="width: 3.1in; float: left;">49. Amount of Investment (For Investor) :</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 4in; height: 0.23in;"></div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="width: 2.3in; float: left;">50. Name and Address of Company :</div>
    <div style="">
        <div style="border-bottom: 1px solid #000; width: 4.95in; height: 0.23in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in">
    <div style="padding-left: 2.3in">
        <div style="border-bottom: 1px solid #000; width: 4.95in; height: 0.23in;"></div>
    </div>
</div>

<div style="border: 1px solid #000; margin: 0.1in 0; text-align: center;">
    <p><strong>TRANSITION ARRIVAL VISA</strong></p>
</div>

<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 4in;">
        <div style="width: 2in; float: left;">51. Date of Arrival in Bangladesh :</div>
        <div style="">
            <div style="border-bottom: 1px solid #000; width: 1.8in; height: 0.23in;"></div>
            <div style="text-align: center;"><small>DD/MM/YY</small></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.2in;">
        <div style="width: 1.6in; float: left;">52. Name of check post :</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 1.5in; height: 0.23in;"></div>
        </div>
    </div>
</div>


<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 4.8in;">
        <div style="width: 3.3in; float: left;">53. Travelled by (Vessel's/Flight/Vehicle Name & No) :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 1.2in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 2.4in;">
        <div style="width: 0.8in; float: left;">54. From :</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 1.3in; height: 0.23in;"></div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.07in;">
    <div style="overflow: hidden; float: left; width: 3.8in;">
        <div style="width: 2.2in; float: left;">55. Purpose of Visit to Bangladesh :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 1.5in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.4in;">
        <div style="width: 2in; float: left;">56. Duration of Proposed Stay :</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 1in; height: 0.23in;"></div>
        </div>
    </div>
</div>



<div style="border: 1px solid #000; margin: 0.1in 0; text-align: center;">
    <p><strong>CHECK LIST</strong></p>
</div>


<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 3in; float: left;">Recommendation from concern Ministry/Authority</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 2in; float: left; padding-left: 0.4in">Marriage Certificate</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 3in; float: left;">Security Clearance/Security Certificate</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 2in; float: left; padding-left: 0.4in">Birth Certificate</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 3in; float: left;">Father's/Husband's/Mother's Visa Copy</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 2in; float: left; padding-left: 0.4in">Work Permit</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 3in; float: left;">Passport copy, Last Visa & Last Arrival Page</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 2in; float: left; padding-left: 0.4in">Affidavit</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 3in; float: left;">Father's/Husband's/Mother's Passport Copy</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 2in; float: left; padding-left: 0.4in">Photo</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 3in; float: left;">N.O.C from Sri Lankan High Commission</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 2.5in; float: left; padding-left: 0.4in">Income Tax Certificate of the Company</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 3in; float: left;">Bi-Latcral Agreement/Multilateral Agreement</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 2in; float: left; padding-left: 0.4in">TIN</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 3in; float: left;">Trade license of the sponsoring Company</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 2in; float: left; padding-left: 0.4in">TIN certificate of the company</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <div style="overflow: hidden; float: left; width: 1.4in;">
        <div style="width: 0.8in; float: left;">Payment Slip</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 2.2in;">
        <div style="width: 1.4in; float: left; padding-left: 0.2in">Over stay payment Slip</div>
        <div style="">
            <div style="border: 1px solid #000; float: right; width: 0.4in; height: 0.23in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 0.5in; float: left; padding-left: 0.4in">Others</div>
        <div style="">
            <div style="border-bottom: 1px solid #000; width: 2.7in; height: 0.23in;"></div>
        </div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.1in;">
    <p>I, hereby, declare that statement given above is true and will not request to refund my paid visa fee even if my application is declined.</p>
</div>

<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 5.2in;">
        <div style="width: 0.4in; float: left;">Place</div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.23in;"></div>
        </div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 5.2in;">
        <div style="width: 0.4in; float: left;">Date</div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.23in;"></div>
            <div style="text-align: center;"><small>DD/MM/YY</small></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 2in;">
        <div style="width: 0.4in; float: left;"></div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.23in;"></div>
            <div style="text-align: center;"><strong>Signature</strong></div>
        </div>
    </div>
</div>

<div style="border: 1px solid #000; margin: 0.1in 0; text-align: center;">
    <p><strong>POLICE VERIFICATION</strong></p>
</div>

<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 4in">
        <div style="width: 1.5in; float: left; padding: 0.05in 0;">Memo No :</div>
        <div style="">
            <div style="border: 1px solid #000; width: 2in; height: 0.4in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.2in;">
        <div style="width: 1.1in; float: left;">Date :</div>
        <div style="width: 2in;">
            <div style="border-bottom: 1px solid #000; width: 2in; height: 0.23in;"></div>
            <div style="text-align: center;"><small>DD/MM/YY</small></div>
        </div>
    </div>
</div>


<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="overflow: hidden; float: left; width: 5.5in">
        <div style="width: 1.6in; float: left; padding: 0.1in 0;">Information's are found</div>
        <div style="">
            <div style="border: 1px solid #000; width: 1in; height: 0.23in; text-align: center; padding: 0.05in 0;">Correct</div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 1in;">
        <div style="width: 0; float: left;"></div>
        <div style="">
            <div style="border: 1px solid #000; width: 1in; height: 0.23in; text-align: center; padding: 0.05in 0;">Incorrect</div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="width: 1.6in; float: left;">If not correct : Reasons :</div>
    <div style="">
        <div style="border-bottom: 1px solid #000; width: 5.6in; height: 0.3in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in">
    <div style="width: 1.6in; float: left;"></div>
    <div style="">
        <div style="border-bottom: 1px solid #000; width: 5.6in; height: 0.3in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.9in">
    <div style="width: 1.6in; float: left;"></div>
    <div style="">
        <div style="border-bottom: 1px solid #000; width: 5.6in; height: 0.3in;"></div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.08in;">
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 3.6in;">
            <div style="text-align: left;">Signature and Seal of Inquiry Officer</div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 3.6in;">
            <div style="text-align: right;">Signature and Seal of Issuing Officer</div>
        </div>
    </div>
</div>



<div style="border: 1px solid #000; margin: 0.1in 0; text-align: center;">
    <p><strong>FOR OFFICIAL USE</strong></p>
</div>
<div style="margin: 0 0.2in; padding: 0.05in; border: 1px solid #000;">
    <div style="overflow: hidden; margin-bottom:0.05in;">
        <div style="overflow: hidden; float: left; width: 1.8in">
            <div style="width:0.9in; float: left;">Reference No :</div>
            <div style="">
                <div style="border-bottom: 1px solid #000; width: 0.8in; height: 0.23in;"></div>
            </div>
        </div>
        <div style="overflow: hidden; float: left; width: 1.3in">
            <div style="width: 0.4in; float: left;">Date :</div>
            <div style="">
                <div style="border-bottom: 1px solid #000; width: 0.8in; height: 0.23in;"></div>
            </div>
        </div>
        <div style="overflow: hidden; float: left; width: 3.6in;">
            <div style="width: 1in; float: left;">Amount of Fee :</div>
            <div style="">
                <div style="border-bottom: 1px solid #000; width: 2.6in; height: 0.23in;"></div>
            </div>
        </div>
    </div>

    <div style="overflow: hidden; margin-bottom:0.05in;">
        <div style="overflow: hidden; float: left; width: 1.8in">
            <div style="width:0.9in; float: left;">Visa No :</div>
            <div style="">
                <div style="border-bottom: 1px solid #000; width: 0.8in; height: 0.23in;"></div>
            </div>
        </div>
        <div style="overflow: hidden; float: left; width: 1.3in">
            <div style="width: 0.4in; float: left;">Date :</div>
            <div style="">
                <div style="border-bottom: 1px solid #000; width: 0.8in; height: 0.23in;"></div>
            </div>
        </div>
        <div style="overflow: hidden; float: left; width: 3.6in;">
            <div style="width: 1in; float: left;">Amount of Fee :</div>
            <div style="">
                <div style="border-bottom: 1px solid #000; width: 2.6in; height: 0.23in;"></div>
            </div>
        </div>
    </div>

    <div style="overflow: hidden; margin-bottom:0.8in">
        <div style="overflow: hidden; float: left; width: 7.8in;">
            <div style="width: 1.5in; float: left;">Number of Entries :</div>
            <div style="">
                <div style="overflow: hidden;">
                    <div style="overflow: hidden; float: left; width: 0.9in; margin-bottom:0.05in;">
                        <div style="width: 0.6in; float: right;">Extension</div>
                        <div style="">
                            <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                        </div>
                    </div>
                    <div style="overflow: hidden; float: left; width: 0.9in; margin-bottom:0.05in;">
                        <div style="width: 0.6in; float: right;">Re-Entry</div>
                        <div style="">
                            <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                        </div>
                    </div>
                    <div style="overflow: hidden; float: left; width: 0.9in; margin-bottom:0.05in;">
                        <div style="width: 0.6in; float: right;">Multiple</div>
                        <div style="">
                            <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                        </div>
                    </div>
                    <div style="overflow: hidden; float: left; width: 1.6in; margin-bottom:0.05in;">
                        <div style="width: 0.5in; float: right;">Entries</div>
                        <div style="">
                            <div style="border-bottom: 1px solid #000; width: 1in; height: 0.23in;"></div>
                        </div>
                    </div>
                    <div style="overflow: hidden; float: left; width: 0.9in; margin-bottom:0.05in;">
                        <div style="width: 0.6in; float: right;">NVR</div>
                        <div style="">
                            <div style="border: 1px solid #000; width: 0.24in; height: 0.23in;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="overflow: hidden; margin-bottom:0.05in;">
        <div style="overflow: hidden; float: left; width: 3.6in;">
            <div style="width: 3.6in;">
                <div style="text-align: left;">Recipient's Signature<br>Date :</div>
            </div>
        </div>
        <div style="overflow: hidden; float: right; width: 1.5in;">
            <div style="width: 3.6in;">
                <div style="text-align: center;">Authorized Signature<br>Date & Seal</div>
            </div>
        </div>
    </div>
</div>


<p style="text-align: center; margin: 0;">
    <strong style="border-bottom: 1px solid #000; margin-bottom: 0.02in;">General Instructions</strong>
</p>
<ol style="margin: 0; padding: 0.05in 0.05in 0.05in 0.2in;">
    <li>Attacg a colour photograph (45mm x 35mm) with glue at the to left corner of the form. photograph has to be white background</li>
    <li>Personal details, Travel Deocument details, Payment details (as applicable) must be filled up.</li>
    <li>Apply according to your necessity and fill up the required option of New visa/ Extention of visa/ Transit permit/ On arrival visa/ No Visa Required (N.V.R)</li>
    <li>Apply with essential documents, otherwise, the application would not be received for consideration.</li>
    <li>Use Tick mark () in the check Box</li>
    <li>Deposit the visa fee (if applicable) to the respective bank counter and attach payment receipt on the top of the application from.</li>
    <li>Receive delivery slip after the submission of application form and check the content of the delivery slip before going out from the visa office.</li>
    <li>Paid of visa fee is non-refundable. </li>
    <li>Lodge your passport as per tentative call date for getting visa.</li>
    <li>Reissuance of visa sticker due to applicant’s mistake needs to be paid again as per payment list. </li>
    <li>In some cases, Visa call  date subjects to police  verification Report/  Security Clearance  from
        MOHA/ Work Permit  from BOI/BEPZA/ N.G.O/ Bureau/ Recommendation  from Ministry Or
        organizations concerned, </li>
    <li>The authority’s decision regarding visa is final.</li>
</ol>
