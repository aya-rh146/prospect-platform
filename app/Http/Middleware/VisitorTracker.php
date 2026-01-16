<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorTracker
{
    public function handle(Request $request, Closure $next)
    {
        // Track visitor for dashboard pages only
        if ($request->is('admin/*') || $request->is('dashboard')) {
            $this->trackVisitor($request);
        }

        return $next($request);
    }

    private function trackVisitor(Request $request)
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        // Avoid tracking bots and repeated visits
        if ($this->isBot($userAgent) || $this->isRecentVisit($ip)) {
            return;
        }

        Visitor::create([
            'ip' => $ip,
            'user_agent' => $userAgent,
            'visited_at' => now()
        ]);
    }

    private function isBot($userAgent)
    {
        $bots = ['googlebot', 'bingbot', 'slurp', 'yahoo', 'duckduckbot', 'baiduspider'];
        foreach ($bots as $bot) {
            if (stripos($userAgent, $bot) !== false) {
                return true;
            }
        }
        return false;
    }

    private function isRecentVisit($ip)
    {
        $recentVisit = Visitor::where('ip', $ip)
            ->where('visited_at', '>', now()->subMinutes(30))
            ->first();

        return $recentVisit !== null;
    }
}
