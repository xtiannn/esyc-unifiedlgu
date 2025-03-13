<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

// class CheckPhpAppLogin
// {
//     public function handle($request, Closure $next)
//     {
//         // Allow access to login/register routes without checking PHP app
//         if ($request->is('login') || $request->is('register')) {
//             return $next($request);
//         }

//         // Get PHP session ID (from cookie, header, or query param)
//         $phpSessionId = $request->cookie('PHPSESSID') ?? $request->query('session_id');

//         // Check if user is logged in to PHP app
//         $phpUser = $this->fetchUserBySessionId($phpSessionId);

//         if (!$phpUser || !$phpSessionId || $phpUser['last_activity'] < now()->subMinutes(30)->toDateTimeString()) {
//             // User is not logged in to PHP app or session expired
//             return redirect('https://smartbarangayconnect.com');
//         }

//         // User is logged in to PHP app, check Laravel login status
//         if (!Auth::check()) {
//             // Not logged in to Laravel, redirect to Laravel login
//             return redirect()->route('login')->with('message', 'Please log in or register to access the system.');
//         }

//         // User is logged in to both systems, proceed
//         return $next($request);
//     }

//     private function fetchUserBySessionId($sessionId)
//     {
//         try {
//             $client = new Client();
//             $response = $client->get('https://smartbarangayconnect.com/api_get_registerlanding.php');
//             $users = json_decode($response->getBody(), true);

//             return collect($users)->firstWhere('session_id', $sessionId);
//         } catch (\Exception $e) {
//             return null; // Handle API errors gracefully
//         }
//     }
// }
