<?php

namespace App\Http\Controllers\SwitchControl;

use App\Models\SwitchControl\RealyIp;
use App\Models\SwitchControl\RelayIpChannel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SwitchControlController extends Controller
{

    public function etharnetRealyIndex()
    {
        return RealyIp::with('realyIpDetails')->get();
    }

    public function etharnetRealyStore(Request $request)
    {
        $this->validate($request, [
            'ip_address' => 'required|ip|unique:relay_ips',
            'channelDetails.*.channelNumber' => 'required|string',
            'channelDetails.*.channelName' => 'required|string',
            'channelDetails.*.channelPort' => 'required|integer',
        ]);

        try {

            \DB::transaction(function () use ($request) {

                $realyIp = RealyIp::create([
                    'ip_address' => $request->ip_address,
                    'created_by' => $request->auth->id,
                ]);

                $data = [];
                $channelDetails = $request->channelDetails;
                foreach ($channelDetails as $channelDetail) {
                    $data[] = [
                        'relay_ip_id' => $realyIp->id,
                        'channel_number' => $channelDetail['channelNumber'],
                        'channel_name' => $channelDetail['channelName'],
                        'channel_port' => $channelDetail['channelPort']
                    ];
                }
                RelayIpChannel::insert($data);

            });

            return response()->json(['message' => 'Created successfully'], 200);

        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['message' => 'Something went to wrong'], 401);
        }

    }

    public function etharnetRealyChannelUpdate(Request $request)
    {
//        dump(\Log::info(print_r($request->all(), true)));

        $this->validate($request, [
            'ip_address_id' => 'required|integer',
            'ip_address' => 'required|ip',
            'channel_id' => 'required|integer',
            'channel_port' => 'required|integer',
        ]);

        try {
            \DB::transaction(function () use ($request) {
                $relayIpChannel = RelayIpChannel::where([
                    'id' => $request->channel_id,
                    'relay_ip_id' => $request->ip_address_id,
                ])->first();

                if ($relayIpChannel) {

                    if ($request->channel_port > 19) {
                        $relayIpChannel->channel_port = $request->channel_port - 10;
                    } else {
                        $relayIpChannel->channel_port = $request->channel_port + 10;
                    }

                    $relayIpChannel->update();

                    $fp = fsockopen($request->ip_address, 6722, $errno, $errstr, 30);
                    fwrite($fp, $relayIpChannel->channel_port);

                }

            });

            return response()->json(['message' => 'updated successfully'], 200);

        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 401);
        }


    }
}
