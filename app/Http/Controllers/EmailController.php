<?php

namespace App\Http\Controllers;

use App\Mail\YourMailable;
use App\Services\SmtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EmailController extends Controller
{
    protected $smtpService;

    public function __construct(SmtpService $smtpService)
    {
        $this->smtpService = $smtpService;
    }

    public function send(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|email',
        //     'subject' => 'required|string',
        //     'body' => 'required|string',
        //     // 'smtp' => 'required|string|in:smtp1,smtp2', // Ensure smtp value matches your mailers
        // ]);
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string',
            'content' => 'required|string',
            'content_type' => 'required|string|in:text,html',
            // 'attachments.*' => 'file|max:10240', // Allow multiple file uploads, max size 10MB per file
        ]);

        try {
            $smtp = $this->smtpService->getAvailableSmtpServer();

            config(['mail.mailers.dynamic' => [
                'transport' => 'smtp',
                'host' => $smtp->host,
                'port' => $smtp->port,
                'encryption' => $smtp->encryption,
                'username' => $smtp->username,
                'password' => $smtp->password,
            ]]);
            var_dump($request->all());
            // Mail::mailer('dynamic')
            //     ->to($request->email)
            //     ->send(new YourMailable($request->subject, $request->content, $request->content_type));

            $attachmentPaths = [];

            // // Download files from URLs
            if ($request->has('attachment_urls')) {
                $urls = is_array($request->attachment_urls) ? $request->attachment_urls : [];

                foreach ($urls as $url) {
                    $fileContents = Http::get($url)->body();

                    if ($fileContents) {
                        $fileName = basename(parse_url($url, PHP_URL_PATH)); // Get filename from URL
                        $path = "attachments/$fileName";

                        Storage::put($path, $fileContents); // Store file temporarily
                        $attachmentPaths[] = storage_path("app/{$path}"); // Get full path
                    }
                }
            }
            var_dump($attachmentPaths);

            // Mail::mailer('dynamic')
            //     // ->to($request->email)
            //     ->send(new YourMailable(
            //         toEmail: $request->email,
            //         subject: $request->subject,
            //         body: $request->content,
            //         fromEmail: $fromEmail ?? config('mail.from.address'),
            //         fromName: config('mail.from.name'),
            //         contentType: $request->content_type,
            //         attachments: $attachmentPaths // Pass attachments
            //     ));
            $attachmentPaths = [];

            Mail::mailer('dynamic')->send(new YourMailable(
                toEmail: $request->email,
                subject: $request->subject,
                body: $request->content,
                contentType: $request->content_type,
                fromEmail: config('mail.from.address'),
                fromName: config('mail.from.name'),
                attachments: $attachmentPaths, // Pass attachments correctly
            ));

            // Log and update SMTP usage
            $this->smtpService->incrementUsage($smtp);
            Log::channel('emails')->info('Email sent', ['email' => $request->email]);

            return response()->json(['message' => 'Email sent successfully'], 200);
        }
        //
        // catch (\Exception $e) {
        //     return response()->json(['error' => 'Failed to send email: ' . $e->getMessage()], 500);
        // }
        catch (\Exception $e) {
            Log::error('Email sending failed', [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'Failed to send email: '.$e->getMessage()], 500);
        }
    }

    private function _onesignal($fromName, $subject, $body, $to, $appId, $apiKey)
    {

        try {
            $response = Http::withHeaders([
                'Authorization' => "Key $apiKey",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('https://api.onesignal.com/notifications?c=email', [
                'app_id' => $appId,
                'include_email_tokens' => [$to],
                'email_subject' => $subject,
                'email_body' => $body,
                'email_from_name' => $fromName,
            ]);

            return $response->successful() ? $response->json() : $response->body();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email: '.$e->getMessage()], 500);
        }
    }
}
