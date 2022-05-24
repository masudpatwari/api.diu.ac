<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OC Immigration</title>

    <style>

        @page {
            margin-top: 2in;
            margin-bottom: 0.8in;
            margin-left: 1in;
            margin-right: 1in;
        }

        body {
            font-family: 'nikosh', sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            border: 1px solid #000;
            font-size: 18px !important;
            padding: 1px 2px;
        }

        .b-none {
            border-top: 2px solid #fff;
            border-bottom: 2px solid #fff;
            border-left: 2px solid #fff;
            border-right: 2px solid #fff;
        }

        .bb-none {
            border-bottom: 2px solid #fff;
        }
        .w-20{
            width: 20%;
        }
        .w-5{
            width: 5%;
        }
        .f-14{
            font-size: 14px!important;
        }

        .reference{
            position: absolute;
            top: 12%;
            left: 22%;
            transform: translate(50%, -50%);
        }

        .reference_date{
            position: absolute;
            top: 12%;
            right: 8%;
            transform: translate(50%, -50%);
        }

    </style>
</head>
<body>

<p class="reference">{{ $doc->doc_mtg_code?? '' }}</p>
<p class="reference_date">{{ $doc->date ?? '' }}</p>

<table class="b-none">
    <tr>
        <td class="bb-none">প্রতি</td>
    </tr>

    <tr>
        <td class="bb-none">ওসি ইমিগ্রেশন</td>
    </tr>

    <tr>
        <td class="bb-none">হযরত শাহজালাল আর্ন্তজাতিক বিমান বন্দর, ঢাকা।</td>
    </tr>

    <tr>
        <td style="padding-top: 20px;">বিষয়ঃ ঢাকা ইন্টারন্যাশনাল ইউনিভার্সিটি তে পড়ালেখার জন্য আগত বিদেশি ছাত্র/ছাত্রীকে গ্রহন  প্রসঙ্গে </td>
    </tr>
</table>

<table class="b-none">
    <tr>
        <td class="bb-none" style="padding: 10px 0;">জনাব,</td>
    </tr>

    <tr>
        <td class="bb-none">
            আমি স্বাক্ষরকারী-ছাত্র/ছাত্রীর নামঃ <b>{{ $foreignStudent->relUser->name ?? 'N/A' }}</b> কে
            <b>{{ $foreignStudent->father_nationality ?? 'N/A' }}</b> হতে আগত বিদেশী নাগরিক পাসপোর্ট নং <b>{{ $foreignStudent->passport_no ?? 'N/A' }}</b>
            জাতীয়তাঃ <b>{{ $foreignStudent->father_nationality ?? 'N/A' }}</b> অদ্য <b>{{ \Carbon\Carbon::now()->format('d-m-Y')  }}</b> তারিখে গ্রহন করলাম। সে ঢাকায় হাউজ নং <b>01</b> , রোড
            নং <b>04</b> , সেকশন
            নং <b>Block-F</b> , থানা <b>Banani</b> , জেলা <b>Dhaka</b> , এ অবস্থান করবেন। তিনি
            বাংলাদেশে ঢাকা ইন্টারন্যাশনাল ইউনিভার্সিটিতে (স্টুডেন্ট ভিসায়) পড়া লেখার জন্য এসেছেন। তিনি বাংলাদেশে অবস্থান
            কালীন আইন বর্হিভূত কোন কর্মকান্ডের সাথে জড়িত হলে কিংবা তার আচার-আচরন সন্দেহ জনক মনে হলে নিকটস্থ থানাকে অবহিত
            করবো।
        </td>
    </tr>

    <tr>
        <td class="bb-none">আন্তরিক ধন্যবাদসহ । </d>
    </tr>

    <tr>
        <td style="padding: 20px 0;">আপনার বিশ্বস্ত,</td>
    </tr>
</table>

<table class="b-none">
    <tr>
        <td class="b-none w-20">নাম</td>
        <td class="b-none w-5">:</td>
        <td class="b-none f-14"> <b>Kamal Sarker</b> </td>
    </tr>

    <tr>
        <td class="b-none">পদবী</td>
        <td class="b-none">:</td>
        <td class="b-none f-14"> <b>Assistant Registrar</b> </td>
    </tr>

    <tr>
        <td class="b-none">প্রতিষ্ঠানের নাম</td>
        <td class="b-none">:</td>
        <td class="b-none f-14"> <b>Dhaka International University</b> </td>
    </tr>

    <tr>
        <td class="b-none">মোবাইল নম্বর</td>
        <td class="b-none">:</td>
        <td class="b-none f-14"> <b>+8801611348346</b> </td>
    </tr>
</table>

</body>
</html>