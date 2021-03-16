<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        if (count($reordered) == 1) {  
            $orders_3[] = $reordered[0];
        }   elseif (count($reordered) == 2) {
                $orders_3[] = $reordered[0];
                $orders_3[] = $reordered[1];
        }   elseif (count($reordered) >= 3) {
            for ($j=0; $j < 3; $j++) { 
                $orders_3[] = $reordered[$j];
            }
        }

        $current = Carbon::now();
        $counterPerMonth = array (0,0,0);

        foreach ($userOrders as $order_x) {
            if($current -> diffInDays($order_x -> updated_at) < 30) {
                $counterPerMonth[0] += 1;
            } else if ($current -> diffInDays($order_x -> updated_at) < 60) {
                $counterPerMonth[1] += 1;
            } else if ($current -> diffInDays($order_x -> updated_at) < 90) {
                $counterPerMonth[2] += 1;
            }
        }

        $total_1month = [];
        foreach ($userOrders as $order_last) {
            if ($current -> diffInDays($order_last -> created_at) < 30) {
                $total_1month[] = $order_last;
            }
        }

        $total_24h = [];
        foreach ($userOrders as $order_24) {
            if ($current -> diffInHours($order_24 -> created_at) < 24) {
                $total_24h[] = $order_24;
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
        ->size(['width' => 300, 'height' => 300])
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
                            'display' => false,
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
            'responsive' => true,
            'legend' => [
                'display' => true,
                'labels' => [
                    'fontColor' => '#000'
                ]
            ],
        ]);

        return view('dashboard.dashboard-index', compact('mail_cut', 'chartjsDashboard','chartjsFeedbacks', 'orders_3', 'total_1month', 'total_24h'));
    }

    public function feedbackPage() {

        $feedbacks = Auth::user() ->  feedback;
        $email_user = Auth::user() -> email;
        $word = '@';
        $mail_cut = substr($email_user, 0, strpos($email_user, $word));

        $feedbacksOrder = $feedbacks -> sortByDesc('created_at');

        return view('dashboard.feedbacks', compact('feedbacksOrder', 'mail_cut'));
    }

    public function stats() {

        $user = Auth::user();
        $email_user = Auth::user() -> email;
        $word = '@';
        $mail_cut = substr($email_user, 0, strpos($email_user, $word));
        $plates = [];

        foreach ($user -> plates as $plate) {
            $plates[] = $plate -> plate_name;
        }

        $plateOrdersId = [];
        $userOrdersId = [];
        foreach ($user -> plates as $plate) {
            $orders = [];
            foreach ($plate -> orders as $order) {
                $orders[] = $order;
                $userOrdersId[] = $order -> id;
            }
        $plateOrdersId[] = count($orders);
        $ordersIds[] = $orders;
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

        $userOrdersId = array_unique($userOrdersId);
        $userOrders = Order::findOrFail($userOrdersId);

        $reordered = [];
        foreach ($userOrders as $order_item) {
            $reordered[] = $order_item;
        }

        $monthsDatas = array (0,0,0,0,0,0,0,0,0,0,0,0);
        $incassi = array (0,0,0,0,0,0,0,0,0,0,0,0);


        foreach ($reordered as $orderToCount) {
            if($orderToCount -> updated_at -> format('M') == 'Jan') {
                $monthsDatas[0] = $monthsDatas[0] + 1;
                $incassi[0] = $incassi[0] + ($orderToCount -> total_price / 100);
            } else if ($orderToCount -> updated_at -> format('M') == 'Feb') {
                $monthsDatas[1] = $monthsDatas[1] + 1;
                $incassi[1] = $incassi[1] + ($orderToCount -> total_price / 100);
            } else if ($orderToCount -> updated_at -> format('M') == 'Mar') {
                $monthsDatas[2] = $monthsDatas[2] + 1;
                $incassi[2] = $incassi[2] + ($orderToCount -> total_price / 100);
            } else if ($orderToCount -> updated_at -> format('M') == 'Apr') {
                $monthsDatas[3] = $monthsDatas[3] + 1;
                $incassi[3] = $incassi[3] + ($orderToCount -> total_price / 100);
            } else if ($orderToCount -> updated_at -> format('M') == 'May') {
                $monthsDatas[4] = $monthsDatas[4] + 1;
                $incassi[4] = $incassi[4] + ($orderToCount -> total_price / 100);
            } else if ($orderToCount -> updated_at -> format('M') == 'Jun') {
                $monthsDatas[5] = $monthsDatas[5] + 1;
                $incassi[5] = $incassi[5] + ($orderToCount -> total_price / 100);
            } else if ($orderToCount -> updated_at -> format('M') == 'Jul') {
                $monthsDatas[6] = $monthsDatas[6] + 1;
                $incassi[6] = $incassi[6] + ($orderToCount -> total_price / 100);
            } else if ($orderToCount -> updated_at -> format('M') == 'Aug') {
                $monthsDatas[7] = $monthsDatas[7] + 1;
                $incassi[7] = $incassi[7] + ($orderToCount -> total_price / 100);
            } else if ($orderToCount -> updated_at -> format('M') == 'Sep') {
                $monthsDatas[8] = $monthsDatas[8] + 1;
                $incassi[8] = $incassi[8] + ($orderToCount -> total_price / 100);
            } else if ($orderToCount -> updated_at -> format('M') == 'Oct') {
                $monthsDatas[9] = $monthsDatas[9] + 1;
                $incassi[9] = $incassi[9] + ($orderToCount -> total_price / 100);
            } else if ($orderToCount -> updated_at -> format('M') == 'Nov') {
                $monthsDatas[10] = $monthsDatas[10] + 1;
                $incassi[10] = $incassi[10] + ($orderToCount -> total_price / 100);
            } else {
                $monthsDatas[11] = $monthsDatas[11] + 1;
                $incassi[11] = $incassi[11] + ($orderToCount -> total_price / 100);
            }
        }

        $chartjs1 = app()->chartjs
        ->name('platesOrdered')
        ->type('bar')
        ->size(['width' => 500, 'height' => 300])
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
        ->size(['width' => 500, 'height' => 300])
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
                    'stepSize' => 1,
                    // 'min' => 0,
                ],
            ],
            'responsive' => true,
            'legend' => [
                'display' => true,
            ],
        ]);

        $chartjs3 = app()->chartjs
        ->name('last12Months')
        ->type('line')
        ->size(['width' => 600, 'height' => 600])
        ->labels(['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'])
        ->datasets([
            [
                "label" => "Incassi per mese",
                'backgroundColor' => [
                    "rgba(233, 79, 55 ,0.55)"
                ],
                'hoverBackgroundColor' => 'rgba(0, 204, 188, 0.51)',
                'data' => $incassi,
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
                            'stepSize' => 100,
                        ],
                        'stacked' => true,
                        'gridLines' => [
                            'display' => true,
                        ],
                    ]
                ]
            ]
        ]);

        return view('dashboard.stats', compact('chartjs1', 'chartjs2', 'chartjs3', 'mail_cut'));
    }
}
