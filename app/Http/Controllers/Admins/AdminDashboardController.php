<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use app\Models\User;
use App\Models\Ticket;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\Auth;



class EmployeeTicketCreator
{
    protected $chart3;

    public function __construct(LarapexChart $chart3)
    {
        $this->chart3 = $chart3;
    }


    public function build(): array
    {
        return $this->chart3->donutChart()
            ->setTitle('Top Ticket Creator')
            ->setToolbar('true')
            ->setHeight('399')
            ->setColors(['#ffc63b', '#ff6384', '#3339FF','#008FFB', '#00E396', '#feb019', '#ff455f', '#775dd0', '#80effe',])
            ->setFontColor('#ffffff')
            ->addData([

                \App\Models\Ticket::where('name', '=', 'admin')->count(),
                \App\Models\Ticket::where('name', '=', 'Hakim')->count(),


                ])
            ->setLabels(['Admin', 'Hakim'])
            ->toVue();
    }
}


class DonutChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): array
    {
        return $this->chart->donutChart()
            ->setTitle('Top incident reported by category')
            ->setHeight('399')
            ->setToolbar('true')
            ->addData([

                \App\Models\Ticket::where('category', '=', 'security')->count(),
                \App\Models\Ticket::where('category', '=', 'Network')->count(),
                \App\Models\Ticket::where('category', '=', 'Hardware')->count(),
                \App\Models\Ticket::where('category', '=', 'Software')->count(),
                \App\Models\Ticket::where('category', '=', 'Maintainance')->count(),
                \App\Models\Ticket::where('category', '=', 'Email')->count(),
                \App\Models\Ticket::where('category', '=', 'Other')->count(),

                ])
            ->setLabels(['Security', 'Network', 'Hardware', 'Software', 'Maintainance', 'Email', 'Other'])
            ->setColors(['#ffc63b', '#ff6384', '#3339FF','#008FFB', '#00E396', '#feb019', '#ff455f', '#775dd0', '#80effe',])
            ->setFontColor('#ffffff')
            ->toVue();
    }
}

class BarChart
{
    protected $chart2;

    public function __construct(LarapexChart $chart2)
    {
        $this->chart2 = $chart2;
    }

    public function build(): array
    {


        $results = Ticket::whereMonth('created_at','=', '06')->count();
        $results2 = Ticket::whereMonth('created_at','=', '05' )->count();
        $results3 = Ticket::whereMonth('created_at', '=', '04')->count();
        $results4 = Ticket::whereMonth('created_at','=', '03' )->count();
        $results5 = Ticket::whereMonth('created_at','=', '02' )->count();
        $results6 = Ticket::whereMonth('created_at', '=','01' )->count();

        $Closedresults = Ticket::where('status', '=', 'Closed')->whereMonth('created_at','=', '06')->count();
        $Closedresults2 = Ticket::where('status', '=', 'Closed')->whereMonth('created_at','=', '05' )->count();
        $Closedresults3 = Ticket::where('status', '=', 'Closed')->whereMonth('created_at', '=', '04')->count();
        $Closedresults4 = Ticket::where('status', '=', 'Closed')->whereMonth('created_at','=', '03' )->count();
        $Closedresults5 = Ticket::where('status', '=', 'Closed')->whereMonth('created_at','=', '02' )->count();
        $Closedresults6 = Ticket::where('status', '=', 'Closed')->whereMonth('created_at', '=','01' )->count();



        return $this->chart2->areaChart()
            ->setTitle('Ticket Churns')
            ->addData(
                'TIcket Opened',
                [$results6,$results5,$results4, $results3, $results2, $results]
                )
            ->addData('Ticket Closed', [$Closedresults6,$Closedresults5, $Closedresults4, $Closedresults3, $Closedresults2, $Closedresults])
            ->setHeight('399')
            ->setColors(['#ffc63b', '#ff6384', '#3339FF'])
            ->setFontColor('#ffffff')
            ->setMarkers(['#FF5722', '#E040FB'], 7, 10)
            ->setXAxis(['January 2022', 'February 2022', 'March 2022','April 2022','May 2022','June 2022'])
            ->setToolbar('true')
            ->toVue();
    }
}

class AdminDashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DonutChart $chart,Barchart $chart2,EmployeeTicketCreator $chart3)
    {

        $now = Carbon::now();
        $ago = $now->subDays(3);
        $Notifications = auth()->user()->unreadNotifications;
        return Inertia::render('Admins/Dashboard',[
            'users' => User::where('is_admin',0)->whereDate('created_at', '>' , $ago) ->count(),
            'ticket' =>Ticket::where('status', '=', 'In Progress')->count(),
            'chart' => $chart->build(),
            'chart2' => $chart2->build(),
            'chart3' => $chart3->build()
            ]);
    }

    public function unreadNotifications()
    {
        $unreadNotifications = Auth::user()->unreadNotifications;
        return response()->json($unreadNotifications);
    }

    public function markAsRead()
    {
        Auth::user()->notifications->markAsRead();
        return response()->json('success');
    }

    public function MaR()
    {
        $id = auth()->user()->unreadNotifications[0]->id;
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
    }

    public function updateNotification()
    {
        $user = App\Models\User::find(1);
        $unreadNotifications = $user->unreadNotifications;
        return response()->json($unreadNotifications);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
