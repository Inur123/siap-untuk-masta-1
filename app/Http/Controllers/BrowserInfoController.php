<?php
namespace App\Http\Controllers;

use Jenssegers\Agent\Agent;

class BrowserInfoController extends Controller
{
    public function showBrowserInfo()
    {
        $agent = new Agent();
        $browser = $agent->browser();
        $device = $agent->device();
        $os = $agent->platform();

        return view('browser-info', compact('browser', 'device', 'os'));
    }
}
