<?php

namespace App\Http\Controllers\Pbx;

use App\Models\GOIP\GoipSend;
use Illuminate\Http\Request;
use App\Models\PBX\SmsSendResponse;
use App\Models\PBX\Sends;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;


class CampaignWiseSmsReportController extends Controller
{
    public function campaignWiseReport($campaign_id)
    {

        $this->sendSmsDataStore();

        $smsSendResponse = SmsSendResponse::with('send')->orderBy('id','desc')->wherePbxCampaignId($campaign_id)->get();
        $alreadyTotalSend = SmsSendResponse::with('send')->whereHas('send')->wherePbxCampaignId($campaign_id)->get();

        $totalFail = [];
        foreach ($alreadyTotalSend as $row) {

            if (($row->send->error_no == null || $row->send->error_no != null) && $row->send->over == '0') {
                $totalFail[] = [
                    'id' => $row->id,
                    'over' => $row->send->over,
                    'error_no' => $row->send->error_no,
                ];
            }
        }


        $data = [
            'smsSendResponse' => $smsSendResponse,
            'sendFail' => count($totalFail),
            'alreadyTotalSend' => count($alreadyTotalSend),
        ];

        return $data;
    }

    public function campaignWiseErrorReport($campaign_id)
    {

        $alreadyTotalSend = SmsSendResponse::with('send')->orderBy('id','desc')->whereHas('send')->wherePbxCampaignId($campaign_id)->get();

        $totalFail = [];
        foreach ($alreadyTotalSend as $row) {

            if (($row->send->error_no == null || $row->send->error_no != null) && $row->send->over == '0') {
                $totalFail[] = $row;
            }

        }

        return $totalFail;


        /*$rows = SmsSendResponse::with('send', 'send.providers')->wherePbxCampaignId($campaign_id)->get();
        $error_data = $rows->where('send.error_no', '<>', null);

        $data = [];
        foreach ($error_data as $row) {
            $data[] = $row;
        }
        return $data;*/

    }

    public function campaignWiseErrorReportDownload($campaign_id)
    {
        $alreadyTotalSend = SmsSendResponse::with('send')->orderBy('id','desc')->whereHas('send')->wherePbxCampaignId($campaign_id)->get();

        $data = [];
        foreach ($alreadyTotalSend as $row) {
            if (($row->send->error_no == null || $row->send->error_no != null) && $row->send->over == '0') {
                $data[] = [
                    'mobile_number' => $row['mobilenumber'],
                    'time' => $row['send']['time'] ?? '',
                    'status' => $row['send']['error_no'] ?? '',
                    'provider' => $row['send']['provider'] ?? '',
                ];
            }
        }

        $selected_array = array('Mobile Number', 'Time', 'Status', 'Provider');

        $Filename = 'error.csv';
        header('Content-Type: text/csv; charset=utf-8');
        Header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename=' . $Filename . '');

        $output = fopen('php://output', 'w');
        fputcsv($output, $selected_array);
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        fclose($output);

    }

    public static function sendSmsDataStore()
    {
        $goipSend = GoipSend::max('id') ?? 0;
        $send = Sends::with('providers')->where('id', '>', $goipSend)->get();
        $inserData = [];
        foreach ($send as $row) {
            $inserData[] = [
                'id' => $row->id,
                'time' => $row->time,
                'userid' => $row->userid,
                'messageid' => $row->messageid,
                'goipid' => $row->goipid,
                'provider' => $row->providers->prov ?? '',
                'telnum' => $row->telnum,
                'recvlev' => $row->recvlev,
                'recvid' => $row->recvid,
                'over' => $row->over,
                'error_no' => $row->error_no,
                'msg' => $row->msg,
                'received' => $row->received,
                'sms_no' => $row->sms_no,
                'total' => $row->total,
                'sending_line' => $row->sending_line,
            ];

        }

        foreach (array_chunk($inserData,2000) as $t)  
        {
             GoipSend::insert($t);
        }
        
    }
}
