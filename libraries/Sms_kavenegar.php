<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sms_kavenegar extends App_sms
{
    private $from;
    private $api_key;

    public function __construct()
    {
        parent::__construct();

        $this->from = $this->get_option('kavenegar', 'from');
        $this->api_key = $this->get_option('kavenegar', 'api_key');

        $this->add_gateway('kavenegar', [
            'name'    => 'کاوه نگار',
            'info'    => "<p>ارسال کلیه پیامک‌های سیستم از طریق سامانه پیامکی <a href='https://kavenegar.com' target='_blank'>کاوه نگار</a> - طراحی و توسطعه داده شده توسط <a href='https://miladworkshop.ir' target='_blank'>میلاد مالدار</a></p><hr class='hr-10'>",
            'options' => [
                [
                    'name'  => 'from',
                    'label' => 'شماره فرستنده',
                ],
				[
                    'name'  => 'api_key',
                    'label' => 'کلید دسترسی ( API Key )',
                ],
            ],
        ]);
    }

    public function send($number, $message)
    {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "https://api.kavenegar.com/v1/{$this->api_key}/sms/send.json");
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type' => 'application/json'));
		curl_setopt($curl, CURLOPT_POSTFIELDS, "receptor={$number}&sender={$this->from}&message={$message}");
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_exec = curl_exec($curl);
		curl_close($curl);

		$result = json_decode($curl_exec, true);

		if (isset($result['return']['status']) && $result['return']['status'] == 200)
		{
			return true;
		} else {
			return false;
		}
    }
}
