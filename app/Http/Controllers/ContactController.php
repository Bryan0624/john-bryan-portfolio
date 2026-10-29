<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'subject' => ['required', 'string', 'max:190'],
            'message' => ['required', 'string', 'max:5000'],
            'website' => ['nullable', 'max:0'], // honeypot
        ]);

        if ($validator->fails()) {
            return response()->json([
                'ok' => false,
                'message' => 'Please check the form fields and try again.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Bot honeypot filled
        if (filled($request->input('website'))) {
            return response()->json([
                'ok' => true,
                'message' => 'Thanks! Your message has been sent.',
            ]);
        }

        $data = $validator->validated();
        $to = config('portfolio.email');

        try {
            if ($endpoint = config('portfolio.formspree_endpoint')) {
                $response = Http::asJson()
                    ->acceptJson()
                    ->timeout(15)
                    ->post($endpoint, [
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'subject' => $data['subject'],
                        'message' => $data['message'],
                        '_replyto' => $data['email'],
                    ]);

                if ($response->successful()) {
                    return response()->json([
                        'ok' => true,
                        'message' => 'Thanks! Your message has been sent.',
                    ]);
                }

                Log::warning('Formspree contact failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }

            if (config('portfolio.formsubmit_ajax', true)) {
                $response = Http::asJson()
                    ->acceptJson()
                    ->withHeaders([
                        'Accept' => 'application/json',
                    ])
                    ->timeout(15)
                    ->post('https://formsubmit.co/ajax/'.$to, [
                        'name' => $data['name'],
                        'email' => $data['email'],
                        '_subject' => '[Portfolio] '.$data['subject'],
                        'message' => $data['message'],
                        '_template' => 'table',
                        '_captcha' => 'false',
                    ]);

                if ($response->successful()) {
                    return response()->json([
                        'ok' => true,
                        'message' => 'Thanks! Your message has been sent.',
                    ]);
                }

                Log::warning('FormSubmit contact failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }

            Mail::raw(
                "Portfolio contact form\n\n".
                "Name: {$data['name']}\n".
                "Email: {$data['email']}\n".
                "Subject: {$data['subject']}\n\n".
                $data['message'],
                function ($message) use ($to, $data) {
                    $message->to($to)
                        ->subject('[Portfolio] '.$data['subject'])
                        ->replyTo($data['email'], $data['name']);
                }
            );

            return response()->json([
                'ok' => true,
                'message' => 'Thanks! Your message has been sent.',
            ]);
        } catch (\Throwable $e) {
            Log::error('Contact form error', ['exception' => $e->getMessage()]);

            return response()->json([
                'ok' => false,
                'message' => 'Could not send right now. Please email '.$to.' directly.',
            ], 500);
        }
    }
}
