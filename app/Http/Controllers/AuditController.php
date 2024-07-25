<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function dashboard(Request $request)
    {
        $selectedDate = $request->input('date');

        // Obtener auditorías por fecha
        $auditsQuery = Audit::query();
        if ($selectedDate) {
            $auditsQuery->whereDate('created_at', $selectedDate);
        }

        $audits = $auditsQuery->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $audits->pluck('date');
        $data = $audits->pluck('count');

        // Datos para la gráfica de estadísticas de usuarios basada en la escala Likert
        $eventPoints = [
            'created' => 5,
            'updated' => 3,
            'deleted' => 1,
        ];

        $userStatisticsQuery = Audit::query();
        if ($selectedDate) {
            $userStatisticsQuery->whereDate('created_at', $selectedDate);
        }

        $userStatistics = $userStatisticsQuery->with('user', 'auditable')
            ->get()
            ->groupBy(function ($audit) {
                return $audit->user ? $audit->user->firstname : 'No Identificado';
            })
            ->map(function ($group) use ($eventPoints) {
                $totalPoints = $group->reduce(function ($carry, $item) use ($eventPoints) {
                    return $carry + ($eventPoints[$item->event] ?? 0);
                }, 0);

                $actions = $group->groupBy('event')->mapWithKeys(function ($events, $event) {
                    return [$event => $events->count()];
                });

                return [
                    'total_points' => $totalPoints,
                    'actions' => $actions,
                    'count' => $group->count()
                ];
            });

        $userNames = $userStatistics->keys();
        $points = $userStatistics->pluck('total_points');
        $actions = $userStatistics->map(function ($stats) {
            return $stats['actions'];
        });
        $counts = $userStatistics->pluck('count');

        return view('audits.dashboard', compact('labels', 'data', 'userNames', 'points', 'actions', 'counts', 'selectedDate'));
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $audits = Audit::with('user')
                ->where('id', 'like', "%{$search}%")
                ->paginate(10);
        } else {
            $audits = Audit::with('user')->paginate(10);
        }

        $userEvents = Audit::with('user')
            ->get()
            ->groupBy('user.firstname')
            ->map(function ($audits) {
                return [
                    'created' => $audits->where('event', 'created')->count(),
                    'updated' => $audits->where('event', 'updated')->count(),
                    'deleted' => $audits->where('event', 'deleted')->count(),
                ];
            });

        return view('audits.index', compact('audits', 'userEvents'));
    }
}
