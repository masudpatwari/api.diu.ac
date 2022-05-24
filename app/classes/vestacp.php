<?php
namespace App\classes;

/**
 * vestacp
 */
class vestacp
{
  // Server credentials
  public $vst_hostname ;
  public $vst_username ;
  public $vst_password ;
  public $vst_returncode;
  // user domain
  public $email_domain;


  function __construct( $vst_hostname, $vst_username, $vst_password, $vst_returncode, $email_domain)
  {
    $this->vst_hostname = $vst_hostname;
    $this->vst_username = $vst_username;
    $this->vst_password = $vst_password;
    $this->vst_returncode = $vst_returncode;
    $this->email_domain = $email_domain;
  }

  public function add_account($email_id, $password, $name){

    $postvars = array(

        'user' => $this->vst_username,
        'password' => $this->vst_password,
        'returncode' => $this->vst_returncode,
        'cmd' => 'v-add-mail-account',

        'arg1' => 'admin', // username
        'arg2' => $this->email_domain, // domain
        'arg3' => explode('@',trim($email_id))[0], // Account
        'arg4' => $password,// PASSWORD
        'arg5' => 250, // quota
        'arg6' => trim($name)
    );

    return $this->curl_action($postvars);

  }

  public function change_password($email_id, $password)
  {
    $postvars = array(
        'user' => $this->vst_username,
        'password' => $this->vst_password,
        'returncode' => $this->vst_returncode,

        'cmd' => 'v-change-mail-account-password',
        'arg1' => 'admin',
        'arg2' => $this->email_domain,
        'arg3' => explode('@',trim($email_id))[0],
        'arg4' => $password,
    );

    return $this->curl_action($postvars);
  }

  public function delete_account($email_id)
  {
    $postvars = array(
        'user' => $this->vst_username,
        'password' => $this->vst_password,
        'returncode' => $this->vst_returncode,

        'cmd' => 'v-delete-mail-account',
        'arg1' => 'admin',
        'arg2' => $this->email_domain,
        'arg3' => explode('@',trim($email_id))[0],
        'arg4' => '',
    );

    return $this->curl_action($postvars);
  }


  public function suspend_mail_account($email_id)
  {
    $postvars = array(
        'user' => $this->vst_username,
        'password' => $this->vst_password,
        'returncode' => $this->vst_returncode,

        'cmd' => 'v-suspend-mail-account',
        'arg1' => 'admin',
        'arg2' => $this->email_domain,
        'arg3' => explode('@',trim($email_id))[0],
        'arg4' => '',
    );

    return $this->curl_action($postvars);
  }

  public function unsuspend_mail_account($email_id)
  {
    $postvars = array(
        'user' => $this->vst_username,
        'password' => $this->vst_password,
        'returncode' => $this->vst_returncode,

        'cmd' => 'v-unsuspend-mail-account',
        'arg1' => 'admin',
        'arg2' => $this->email_domain,
        'arg3' => explode('@',trim($email_id))[0],
        'arg4' => '',
    );

    return $this->curl_action($postvars);
  }


  public function list_of_mail_accounts_id(){
      $userlistText = $this->raw_list_of_account();
      // return($userlistText);
      $line = explode("\n", $userlistText );
      $account_list = [];
      for ($i=2; $i < count($line) ; $i++) {
          $account_id = explode(" ",$line[$i])[0];
          if(strlen(trim($account_id)))
          $account_list[]= $account_id;
      }
      return $account_list;
  }

  private function raw_list_of_account()
  {
    $postvars = array(
        'user' => $this->vst_username,
        'password' => $this->vst_password,
        // 'returncode' => $this->vst_returncode,

        'cmd' => 'v-list-mail-accounts',
        'arg1' => $this->vst_username,
        'arg2' => $this->email_domain,
    );

    return $this->curl_action($postvars);
  }

  public function curl_action(array $postvars )
  {

    $postdata = http_build_query($postvars);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://' . $this->vst_hostname . ':8083/api/');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
    $answer = curl_exec($curl);
    return $answer;
  }

}
