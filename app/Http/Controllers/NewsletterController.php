<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    //

    /**
     * Subscribe a user to the newsletter.
     */
    public function subscribe(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('newsletter_error', 'Please enter a valid email address.');
        }

        try{
            $subscriber = NewsletterSubscriber::where('email', $request->email)->first();

            if ($subscriber){
                if ($subscriber->is_subscribed){
                    return back()->with('newsletter_info', 'you are already subscribed to the newsletter.');

                } else {
                    //Re-subscribe  
                    $subscriber->update([
                        'is_subscribed' => true,
                        'subscribed_at' => now(),
                        'unsubscribed_at' => null,
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'name' => $request->name ?? $subscriber->name,
                    ]);
                    return back()->with('newsletter_success', 'You have been re-subscribed to the newsletter.');
                }
            }

            //New subscription
            NewsletterSubscriber::create([
                'email' => $request->email,
                'name' => $request->name,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'is_subscribed' => true,
                'subscribed_at' => now(),
            ]);

            return back()->with('newsletter_success', 'Thank you for subscribing to our newsletter!');
        } catch (\Exception $e){
            return back()->with('newsletter_error', 'An error occurred while processing your subscription. Please try again later.');
        }
    }

    /**
     * Unsubscribe a user from the newsletter.
     */
    public function unsubscribe($token){
        $subscriber = NewsletterSubscriber::where('token', $token)->firstOrFail();

        if (!$subscriber->is_subscribed){
            return view('newsletter.already-unsubscribed', compact('subscriber'));
        }

        $subscriber->unsubscribe();
        return view('newsletter.unsubscribed', compact('subscriber'));
    }

    /**
     * Admin: View all subscribers.
     */
    public function index(){
        $subscribers = NewsletterSubscriber::latest()->paginate(20);
        $stats = [
            'total' => NewsletterSubscriber::count(),
            'active' => NewsletterSubscriber::active()->count(),
            'unsubscribed' => NewsletterSubscriber::where('is_subscribed', false)->count(),
            'today' => NewsletterSubscriber::whereDate('created_at', today())->count(),
            
        ];

        return view('newsletter.index', compact('subscribers', 'stats'));
    }

    /**
     * Admin: Export subscribers
     */

    public function export(){
        $subscribers = NewsletterSubscriber::active()->get([
            'email', 
            'name', 
            'ip_address', 
            'user_agent', 
            'subscribed_at'
        ]);
        $filename = 'newsletter-subscribers-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($subscribers){
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Email', 'Name', 'IP Address', 'User Agent', 'Subscribed At']);

            foreach ($subscribers as $subscriber){
                fputcsv($file, [
                    $subscriber->email,
                    $subscriber->name ?? 'N/A',
                    $subscriber->ip_address ?? 'N/A',
                    $subscriber->user_agent ?? 'N/A',
                    $subscriber->subscribed_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
