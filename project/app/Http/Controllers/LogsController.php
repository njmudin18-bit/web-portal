<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Jenssegers\Agent\Facades\Agent;
use App\Models\Logs;

class LogsController extends Controller
{
  public function save(Request $request)
  {
    $ip         = file_get_contents('https://api.ipify.org');
    $browser    = Agent::browser();
    $version    = Agent::version($browser);
    $device     = Agent::device();
    $platform   = Agent::platform();
    $versionOS  = Agent::version($platform);
    $result     = "";
    $robot      = "";
    $route_name = url()->previous();

    if (Agent::isMobile()) {
      $result = 'Mobile';
    } else if (Agent::isDesktop()) {
      $result = 'Desktop';
    } else if (Agent::isTablet()) {
      $result = 'Desktop';
    } else if (Agent::isPhone()) {
      $result = 'Phone';
    }

    if (Agent::isRobot()) {
      $robot  = "Robot";
    } else {
      $robot  = "not Robot";
    }

    $hasil = array(
      "IP"              => $ip,
      "Browser"         => $browser,
      "Browser version" => $version,
      "Device"          => $device,
      "Platform OS"     => $platform,
      "Version OS"      => $versionOS,
      "Device"          => $result,
      "Robot?"          => $robot,
      "link"            => $request->input('link')
    );

    $insert = Logs::create([
      'log_user_id'   => $request->input('nama_apps'),
      'log_url'       => $route_name,
      'log_type'      => "PORTAL",
      'log_time'      => date('Y-m-d H:i:s'),
      'log_data'      => json_encode($hasil)
    ]);

    if ($insert) {
      return response()->json([
        'code'        => 200,
        'status'      => "success",
        'message'     => "Data berhasil disimpan",
        'data'        => $insert
      ], 200);
    } else {
      return response()->json([
        'code'        => 500,
        'status'      => "error",
        'message'     => "Data gagal disimpan",
        'data'        => $insert
      ], 500);
    }
  }

  function get_ip()
  {
    $keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');

    foreach ($keys as $key) {
      if (array_key_exists($key, $_SERVER) === true) {
        foreach (explode(',', $_SERVER[$key]) as $ip) {
          if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
            return $ip;
          }
        }
      }
    }
  }

  function get_operating_system()
  {
    $u_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $operating_system = 'Unknown Operating System';

    //Get the operating_system name
    if ($u_agent) {
      if (preg_match('/linux/i', $u_agent)) {
        $operating_system = 'Linux';
      } elseif (preg_match('/macintosh|mac os x|mac_powerpc/i', $u_agent)) {
        $operating_system = 'Mac';
      } elseif (preg_match('/windows|win32|win98|win95|win16/i', $u_agent)) {
        $operating_system = 'Windows';
      } elseif (preg_match('/ubuntu/i', $u_agent)) {
        $operating_system = 'Ubuntu';
      } elseif (preg_match('/iphone/i', $u_agent)) {
        $operating_system = 'IPhone';
      } elseif (preg_match('/ipod/i', $u_agent)) {
        $operating_system = 'IPod';
      } elseif (preg_match('/ipad/i', $u_agent)) {
        $operating_system = 'IPad';
      } elseif (preg_match('/android/i', $u_agent)) {
        $operating_system = 'Android';
      } elseif (preg_match('/blackberry/i', $u_agent)) {
        $operating_system = 'Blackberry';
      } elseif (preg_match('/webos/i', $u_agent)) {
        $operating_system = 'Mobile';
      }
    } else {
      $operating_system = php_uname('s');
    }

    return $operating_system;
  }
}
