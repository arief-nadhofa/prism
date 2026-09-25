<?php

namespace App\Http\Controllers;

use App\Models\LogProblem;
use Illuminate\Http\Request;

class LayoutController extends Controller
{
    function index()
    {
        return view('pages.login');
    }

    function dashboard()
    {
        $totalProblem = LogProblem::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalDuration = LogProblem::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereNotNull('finish_problem')
            ->selectRaw('
            SUM(
                TIMESTAMPDIFF(
                    MINUTE,
                    start_problem,
                    finish_problem
                )
            ) as total_minutes
        ')
            ->value('total_minutes') ?? 0;

        $hours = intdiv((int) $totalDuration, 60);
        $minutes = (int) $totalDuration % 60;

        $formattedDuration = "{$hours} Jam {$minutes} Menit";



        $year = request()->integer('year', now()->year);

        // Query total problem dan durasi per bulan
        $problemData = LogProblem::selectRaw('
        MONTH(created_at) as month,
        COUNT(*) as total_problem,

        COALESCE(
            SUM(
                CASE
                    WHEN start_problem IS NOT NULL
                    AND finish_problem IS NOT NULL
                    THEN GREATEST(
                        TIMESTAMPDIFF(
                            MINUTE,
                            start_problem,
                            finish_problem
                        ), 0
                    )
                    ELSE 0
                END
            ), 0
        ) as total_duration
    ')
            ->whereYear('created_at', $year)
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get()
            ->keyBy('month');

        // Label bulan
        $months = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        ];

        $monthlyProblems = [];
        $monthlyDurations = [];

        for ($month = 1; $month <= 12; $month++) {

            $monthlyProblems[] = (int) (
                $problemData[$month]->total_problem ?? 0
            );

            $monthlyDurations[] = (int) (
                $problemData[$month]->total_duration ?? 0
            );
        }



        return view('pages.dashboard.dashboard', compact('totalProblem', 'formattedDuration', 'year', 'months', 'monthlyProblems', 'monthlyDurations'));
    }
}
