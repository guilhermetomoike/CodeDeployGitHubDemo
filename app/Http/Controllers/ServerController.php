<?php

namespace App\Http\Controllers;

use Aws\Ec2\Ec2Client;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    /**
     * @var Ec2Client
     */
    private $ec2Client;

    /**
     * ServerController constructor.
     */
    public function __construct()
    {
        $this->ec2Client = new Ec2Client([
            'region' => 'us-east-1',
            'version' => '2016-11-15',
        ]);
    }

    public function instanceStatus()
    {
        $instances = $this->ec2Client->describeInstances()->toArray();

        $data = [];
        foreach ($instances['Reservations'] as $reservation) {
            foreach ($reservation['Instances'] as $instance) {
                $data[] = [
                    'InstanceId' => $instance['InstanceId'],
                    'status' => $instance['State']['Name'],
                    'PublicIpAddress' => $instance['PublicIpAddress'] ?? null,
                ];
            }
        }
        return response($data);
    }

    public function httpCheck()
    {
        return response('http server ok', 200);
    }
}
