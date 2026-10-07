<?php
namespace App\Http\Controllers\Public;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|max:150',
            'subject'      => 'required|string|max:200',
            'message'      => 'required|string|min:20|max:3000',
            'project_type' => 'nullable|string|max:80',
            'budget_range' => 'nullable|string|max:50',
        ]);

        $message = Message::create([
            ...$validated,
            'ip_address' => $request->ip(),
        ]);

        // Send email notification
        try {
            $to = env('PORTFOLIO_CONTACT_EMAIL', config('mail.from.address'));
            Mail::send([], [], function ($mail) use ($to, $validated) {
                $mail->to($to)
                     ->subject("[Portfolio] {$validated['subject']} — {$validated['name']}")
                     ->html(view('emails.contact', $validated)->render());
            });
        } catch (\Exception $e) {
            // Log but don't fail — message is saved in DB
            \Log::warning('Contact email failed: ' . $e->getMessage());
        }

        return back()->with('success', "Thanks {$validated['name']}! Your message has been sent. I'll get back to you within 24 hours.");
    }
}
