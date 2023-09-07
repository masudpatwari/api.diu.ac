<?php


namespace App\classes;


class DIU_WIFI_With_MAC
{
    /**
     * @return array
     */
    public static function get_macs()
    {
        static  $mac_string = null;

        if ($mac_string){
            return $mac_string;
        }

        $pfsense = new PfSenseFauxApiClient();

        $response = $pfsense->config_get();
        return $mac_string = $response['data']['config']['dhcpd']['opt2']['mac_allow'];

    }


    /**
     * @return int
     */
    public static function mac_address_count()
    {

        /** @var string $mac_string */
        $mac_string = self::get_macs();

        return count(explode(',', $mac_string));

    }

    /**
     * @param $mac_address
     * @return bool
     */
    public static function check_mac_exists($mac_address)
    {

        /** @var string $macs_string */
        $macs_string = self::get_macs();

        return in_array($mac_address, explode(',',$macs_string));
    }

    /**
     * @param $mac_address
     * @return bool
     * @throws \Exception MAC address already exists
     */
    public static function add_mac($mac_address)
    {

        if ( self::check_mac_exists($mac_address) ){

            throw new \Exception('MAC address already exists');

        }

        $mac_string= self::get_macs();

        $data = [
            'dhcpd' => [
                'opt2' => [
                    'mac_allow'=> $mac_string . ',' . $mac_address
                ]
            ]
        ];

        $pfsense = new PfSenseFauxApiClient();
        $pfsense->config_set($data);

        return true;

    }

    /**
     * @param $mac_address
     * @return bool
     * @throws \Exception
     */
    public static function delete_mac($mac_address)
    {

        if ( ! self::check_mac_exists($mac_address) ){

            throw new \Exception('MAC Not exists');

        }

        $mac_string= self::get_macs();

        $mac_address_array = explode(',', $mac_string);

        $key = array_search($mac_address,$mac_address_array);

        if($key!==false){
            unset($mac_address_array[$key]);
        }

        $data = [
            'dhcpd' => [
                'opt2' => [
                    'mac_allow'=> implode(',', $mac_address_array)
                ]
            ]
        ];

        $pfsense = new PfSenseFauxApiClient();
        $pfsense->config_set($data);

        return true;
    }
}