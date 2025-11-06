<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px 20px;
        }
        .field {
            margin-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 15px;
        }
        .field:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: 600;
            color: #374151;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            display: block;
        }
        .value {
            color: #1f2937;
            font-size: 16px;
            word-wrap: break-word;
        }
        .message-content {
            background: #f9fafb;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #3b82f6;
            margin-top: 10px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .footer {
            background: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 5px 0;
        }
        .badge {
            display: inline-block;
            background: #dbeafe;
            color: #1e40af;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 New Contact Form Submission</h1>
            <p style="margin: 10px 0 0; opacity: 0.9;">You've received a new message from {{ config('app.name') }}</p>
        </div>
        
        <div class="content">
            <div class="field">
                <span class="label">From</span>
                <div class="value">
                    <strong>{{ $data['name'] }}</strong>
                    <br>
                    <a href="mailto:{{ $data['email'] }}" style="color: #3b82f6; text-decoration: none;">
                        {{ $data['email'] }}
                    </a>
                </div>
            </div>

            <div class="field">
                <span class="label">Subject</span>
                <div class="value">{{ $data['subject'] }}</div>
            </div>

            <div class="field">
                <span class="label">Message</span>
                <div class="message-content">{{ $data['message'] }}</div>
            </div>

            <div class="field" style="border: none; padding-top: 10px;">
                <span class="label">Received</span>
                <div class="value">
                    <span class="badge">{{ now()->format('F j, Y \a\t g:i A') }}</span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p><strong>{{ config('app.name') }}</strong></p>
            <p>This email was sent from your contact form</p>
            <p>To reply, click the sender's email address above</p>
        </div>
    </div>
</body>
</html>