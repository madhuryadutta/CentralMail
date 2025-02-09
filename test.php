<?php

$url = 'http://127.0.0.1:8000/api/send-email';
$data = [
    'email' => 'recipient@example.com',
    'subject' => 'Test Email with URL Attachments',
    'content' => 'This is a test email with attachments from URLs.',
    'content_type' => 'text',
    'attachment_urls' => [
        'https://en.wikipedia.org/wiki/File:Facebook_f_logo_%282021%29.svg',
    ],
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

echo $response;
