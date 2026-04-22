<?php

namespace App\Services\Mail;

use App\Services\CustomService;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
class MailService extends CustomService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function sendMailWithHttps($view, $dataView = [], $dataMail = [])
    {
        $url = getConfig('mail.api_url');
        $token = getConfig('mail.api_token');
        $mailBcc = data_get($dataMail, 'bcc');
        $mailFrom = getConfig('mail.mail_from');
        $data = [
            "from" => [
                "email" => $mailFrom,
                "name" => data_get($dataMail, 'from_name', getConfigMail('from.name'))
            ],
            "to" => data_get($dataMail, 'to'),
            "subject" => data_get($dataMail, 'subject'),
            "text_part" => "これはテストメールです。破棄してください。",
            "html_part" => view($view, $dataView)->render(),
        ];
        if (!empty($mailBcc)) {
            $data['bcc'] = is_array($mailBcc) ? $mailBcc : [$mailBcc];
        }
        $data = json_encode($data);

        $header = [
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        ];

        $context = [
            "http" => [
                "method"  => "POST",
                "header"  => implode("\r\n", $header),
                "content" => $data
            ]
        ];

        file_get_contents($url, false, stream_context_create($context));
    }

    public function sendMailWithSmtp($view, $dataView = [], $dataMail = []): void
    {
        $mailFrom = config('mail.from.address');
        $fromName = data_get($dataMail, 'from_name', config('mail.from.name'));
        $mailTo = data_get($dataMail, 'to');
        $subject = data_get($dataMail, 'subject', 'No Subject');
        $bcc = data_get($dataMail, 'bcc');

        try {
            Mail::send($view, $dataView, function ($message) use ($mailTo, $subject, $mailFrom, $fromName, $bcc) {
                $message->from($mailFrom, $fromName);
                $message->to($mailTo);
                $message->subject($subject);

                if (!empty($bcc)) {
                    $message->bcc(is_array($bcc) ? $bcc : [$bcc]);
                }
            });
        } catch (Exception $e) {
            Log::error('Blastengine SMTP mail send failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * @throws Exception
     */
    public function sendContactMail(array $formData, array $settings, string $adminEmail): void
    {
        try {
            $hasMessage = array_key_exists('message', $formData) && array_key_exists('dates', $formData) && !empty($formData['dates']);
            if ($hasMessage) {
                $this->sendMailWithSmtp(
                    'web.emails.request_tour_user',
                    [
                        'formData' => $formData,
                        'settings' => $settings
                    ],
                    [
                        'to' => $formData['email'],
                        'from_name' => 'UNITED HOUSING',
                        'subject' => '【UNITED HOUSING】Thank you for reaching out!'
                    ]
                );

                $this->sendMailWithSmtp(
                    'web.emails.request_tour_admin',
                    [
                        'formData' => $formData,
                        'settings' => $settings
                    ],
                    [
                        'to' => $adminEmail,
                        'from_name' => 'UNITED HOUSING',
                        'subject' => '【UNITED HOUSING】お問合せがありました。'.$formData['view_id']
                    ]
                );
            } else {
                $this->sendMailWithSmtp(
                    'web.emails.contact_user',
                    [
                        'formData' => $formData,
                        'settings' => $settings
                    ],
                    [
                        'to' => $formData['email'],
                        'from_name' => 'UNITED HOUSING',
                        'subject' => '【UNITED HOUSING】Thank you for reaching out!'
                    ]
                );

                $this->sendMailWithSmtp(
                    'web.emails.contact_admin',
                    [
                        'formData' => $formData,
                        'settings' => $settings
                    ],
                    [
                        'to' => $adminEmail,
                        'from_name' => 'UNITED HOUSING',
                        'subject' => '【UNITED HOUSING】お問合せがありました。'
                    ]
                );
            }
        } catch (Exception $e) {
            Log::error('Contact form mail send failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'formData' => $formData
            ]);
            throw $e;
        }
    }

}
