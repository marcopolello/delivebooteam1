<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use App\Order;
use App\Plate;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard() {

        $user = Auth::user();
        $feedbacks = $user -> feedback;
        $email_user = $user -> email;
        $word = '@';
        $mail_cut = substr($email_user, 0, strpos($email_user, $word));

        $months_label = [];

        for ($i=0; $i > -3; $i--) {
            $months_label[] = date('M', strtotime($i . ' month'));
        }

        $userOrdersId = [];
        foreach ($user -> plates as $plate) {
          $orders = [];
          foreach ($plate -> orders as $order) {
            $orders[] = $order;
            $userOrdersId[] = $order -> id;
          }
          $plateOrdersId[] = $orders;
        }
        $userOrdersId = array_unique($userOrdersId);
        $userOrders = Order::findOrFail($userOrdersId);
        $userOrders = $userOrders -> sortByDesc('updated_at');

        $reordered = [];
        foreach ($userOrders as $order_item) {
            $reordered[] = $order_item;
        }

        $orders_3 = [];
        if (count($reordered) > 0) {
            for ($j=0; $j < 3; $j++) {
                $orders_3[] = $reordered[$j];
            }
        }

        $current = Carbon::now();
        $monthsAgo = $current -> subMonths(3);
        $counterPerMonth = array (0,0,0);

        foreach ($userOrders as $order_x) {
            if($current -> diffInDays($order_x -> updated_at) < 90) {
                $counterPerMonth[0] += 1;
            }
        }

        $counterFeedbacks = array (0,0,0,0,0);

        foreach ($user -> feedback as $fdb) {
            if ($fdb -> rate == 1) {
                $counterFeedbacks[0] += 1;
            } else if ($fdb -> rate == 2) {
                $counterFeedbacks[1] += 1;
            } else if ($fdb -> rate == 3) {
                $counterFeedbacks[2] += 1;
            } else if ($fdb -> rate == 4) {
                $counterFeedbacks[3] += 1;
            } else {
                $counterFeedbacks[4] += 1;
            }
        }

        $chartjsDashboard = app()->chartjs
        ->name('lastMonths')
        ->type('bar')
        ->size(['width' => 300, 'height' => 295])
        ->labels($months_label)
        ->datasets([
            [
                "label" => "Orders",
                'backgroundColor' => [
                    "rgba(0, 204, 188, 0.71)",
                    "rgba(31, 255, 236, 0.41)",
                    "rgba(250, 125, 15, 0.41)",
                    "rgba(255, 252, 49, 0.41)",
            ],
                'data' => $counterPerMonth,
            ],
        ])
        ->optionsRaw([
            'responsive' => true,
            'legend' => [
                'display' => true,
                'labels' => [
                    'fontColor' => '#000'
                ]
            ],
            'scales' => [
                'xAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                            // 'max' => 100,
                            // 'min' => 0,
                            // 'stepSize' => 10,
                        ],
                        'stacked' => true,
                        'gridLines' => [
                            'display' => true,
                        ],
                    ]
                ],
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                            // 'max' => 100,
                            // 'min' => 20,
                            // 'stepSize' => 10,
                        ],
                        'stacked' => true,
                        'gridLines' => [
                            'display' => true,
                        ],
                    ]
                ]
            ]
        ]);

        $chartjsFeedbacks = app()->chartjs
        ->name('feedb')
        ->type('doughnut')
        ->size(['width' => 300, 'height' => 295])
        ->labels(['1 Stella', '2 Stelle', '3 Stelle', '4 Stelle', '5 Stelle'])
        ->datasets([
            [
                "label" => "Feedbacks",
                'backgroundColor' => [
                    "rgba(31, 255, 236, 0.41)",
                    "rgba(250, 125, 15, 0.41)",
                    "rgba(255, 252, 49, 0.41)",
                    "rgba(222, 60, 75, 0.41)",
                    "rgba(153, 247, 171, 0.41)",
                ],
                'data' => $counterFeedbacks,
            ],
        ])
        ->optionsRaw([
            'animation' => [
                'rotate' => '-0.5 * Math.PI',
                'animateRotate' => true,
            ],
            'responsive' => true,
            'legend' => [
                'display' => true,
                'labels' => [
                    'fontColor' => '#000'
                ]
            ],
        ]);

        $smallFeedbacks = [];
        $feedMax = 0;
        if (count($feedbacks) > 0) {
            while ($feedMax <= 12) {
                $smallFeedbacks[] = $feedbacks[$feedMax];
                $feedMax++;
            }
        }

        return view('dashboard.dashboard-index', compact('mail_cut', 'smallFeedbacks', 'chartjsDashboard','chartjsFeedbacks', 'orders_3'));
    }

    public function stats() {

        $user = Auth::user();
        $plates = [];

        foreach ($user -> plates as $plate) {
            $plates[] = $plate -> plate_name;
        }

        $userOrdersId = [];
        foreach ($user -> plates as $plate) {

        $orders = [];
        foreach ($plate -> orders as $order) {
            $orders[] = $order;
            $userOrdersId[] = $order -> id;
        }
        $plateOrdersId[] = count($orders);
        }

        $counterFeedbacks = array (0,0,0,0,0);

        foreach ($user -> feedback as $fdb) {
            if ($fdb -> rate == 1) {
                $counterFeedbacks[0] += 1;
            } else if ($fdb -> rate == 2) {
                $counterFeedbacks[1] += 1;
            } else if ($fdb -> rate == 3) {
                $counterFeedbacks[2] += 1;
            } else if ($fdb -> rate == 4) {
                $counterFeedbacks[3] += 1;
            } else {
                $counterFeedbacks[4] += 1;
            }
        }

        // dd($counterFeedbacks, $plateOrdersId);

        $chartjs1 = app()->chartjs
        ->name('platesOrdered')
        ->type('bar')
        ->size(['width' => 500, 'height' => 200])
        ->labels($plates)
        ->datasets([
            [
                "label" => "Ordinazioni per piatto",
                'backgroundColor' => [
                    "rgba(31, 255, 236, 0.41)",
                    "rgba(250, 125, 15, 0.41)",
                    "rgba(231, 13, 75, 0.41)",
                    "rgba(0, 224, 206, 0.41)",
                    "rgba(255, 252, 49, 0.41)",
                    "rgba(112, 215, 208, 0.41)",
                    "rgba(224, 221, 0, 0.41)",
                    "rgba(120, 215, 247, 0.41)",
                    "rgba(221, 28, 26, 0.41)",
                    "rgba(6, 174, 213, 0.41)",
                    "rgba(6, 186, 99, 0.41)",
                    "rgba(139, 148, 163, 0.41)",
                    "rgba(203, 255, 77, 0.41)",
                    "rgba(84, 84, 84, 0.41)",
                    "rgba(107, 170, 117, 0.41)",
                    "rgba(59, 65, 60, 0.41)",
                    "rgba(222, 60, 75, 0.41)",
                    "rgba(92, 255, 241, 0.41)",
                    "rgba(252, 168, 95, 0.41)",
                    "rgba(244, 65, 116, 0.41)",
                    "rgba(31, 255, 236, 0.41)",
                    "rgba(250, 125, 15, 0.41)",
                    "rgba(231, 13, 75, 0.41)",
                    "rgba(0, 224, 206, 0.41)",
                    "rgba(180, 86, 4, 0.41)",
                    "rgba(154, 9, 50, 0.41)",
                    "rgba(255, 252, 49, 0.41)",
                    "rgba(112, 215, 208, 0.41)",
                    "rgba(224, 221, 0, 0.41)",
                    "rgba(120, 215, 247, 0.41)",
                    "rgba(221, 28, 26, 0.41)",
                    "rgba(6, 174, 213, 0.41)",
                    "rgba(6, 186, 99, 0.41)",
                    "rgba(139, 148, 163, 0.41)",
                    "rgba(203, 255, 77, 0.41)",
                    "rgba(84, 84, 84, 0.41)",
                    "rgba(107, 170, 117, 0.41)",
                    "rgba(59, 65, 60, 0.41)",
                    "rgba(222, 60, 75, 0.41)",
                    "rgba(92, 255, 241, 0.41)",
                    "rgba(252, 168, 95, 0.41)",
                    "rgba(244, 65, 116, 0.41)",
                    "rgba(31, 255, 236, 0.41)",
                    "rgba(250, 125, 15, 0.41)",
                    "rgba(231, 13, 75, 0.41)",
                    "rgba(0, 224, 206, 0.41)",
                    "rgba(180, 86, 4, 0.41)",
                    "rgba(154, 9, 50, 0.41)",
                    "rgba(255, 252, 49, 0.41)",
                    "rgba(112, 215, 208, 0.41)",
                    "rgba(224, 221, 0, 0.41)",
                    "rgba(120, 215, 247, 0.41)",
                    "rgba(221, 28, 26, 0.41)",
                    "rgba(6, 174, 213, 0.41)",
                    "rgba(6, 186, 99, 0.41)",
                    "rgba(139, 148, 163, 0.41)",
                    "rgba(203, 255, 77, 0.41)",
                    "rgba(84, 84, 84, 0.41)",
                    "rgba(107, 170, 117, 0.41)",
                    "rgba(59, 65, 60, 0.41)",
                    "rgba(222, 60, 75, 0.41)",
                ],
                'hoverBackgroundColor' => 'rgba(0, 204, 188, 0.51)',
                'data' => $plateOrdersId,
            ],
        ])
        ->optionsRaw([
            'responsive' => true,
            'legend' => [
                'display' => true,
                'labels' => [
                    'fontColor' => '#000'
                ]
            ],
            'scales' => [
                'xAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                        'stacked' => true,
                        'gridLines' => [
                            'display' => true,
                        ],
                    ]
                ],
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                            'stepSize' => 1,
                        ],
                        'stacked' => true,
                        'gridLines' => [
                            'display' => true,
                        ],
                    ]
                ]
            ]
        ]);

        $chartjs2 = app()->chartjs
        ->name('feedbacks')
        ->type('radar')
        ->size(['width' => 500, 'height' => 200])
        ->labels(['1 Stella', '2 Stelle', '3 Stelle', '4 Stelle', '5 Stelle'])
        ->datasets([
            [
                "label" => "Feedbacks",
                'backgroundColor' => "rgba(0, 204, 188, 0.31)",
                'borderColor' => "rgba(0, 204, 188, 1)",
                'pointRadius' => 6,
                'pointHoverRadius' => 8,
                "pointBorderColor" => "rgba(0, 204, 188, 0.7)",
                "pointBackgroundColor" => "rgba(0, 204, 188, 1)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $counterFeedbacks,
            ],
        ])
        ->optionsRaw([
            'scale' => [
                'ticks' => [
                    'beginAtZero' => true,
                    'stepSize' => 15,
                    // 'min' => 0,
                ],
            ],
            'responsive' => true,
            'legend' => [
                'display' => true,
                'labels' => [
                    'fontColor' => '#000'
                ]
            ],
        ]);

        return view('dashboard.stats', compact('chartjs1', 'chartjs2'));
    }

    // public function dashProvvisoria(){
    //   $user = Auth::user();
    //   return view('dashboard.dashboard-index', compact('user'));
    // }
}
