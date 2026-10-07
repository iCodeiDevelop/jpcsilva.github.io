<!DOCTYPE html>
<html>
<body style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;padding:24px;background:#ffffff;">
  <div style="border-bottom:3px solid #2563eb;padding-bottom:16px;margin-bottom:24px;">
    <h2 style="color:#2563eb;margin:0;font-size:20px;">📬 New Contact Message</h2>
    <p style="color:#6b7280;font-size:13px;margin:4px 0 0;">Received via jpcsilva.com</p>
  </div>
  <table style="width:100%;border-collapse:collapse;">
    <tr>
      <td style="padding:10px 8px;font-weight:600;color:#374151;width:130px;vertical-align:top;">From</td>
      <td style="padding:10px 8px;color:#1f2937;">{{ $name }}<br/><a href="mailto:{{ $email }}" style="color:#2563eb;font-size:13px;">{{ $email }}</a></td>
    </tr>
    <tr style="background:#f9fafb;">
      <td style="padding:10px 8px;font-weight:600;color:#374151;vertical-align:top;">Subject</td>
      <td style="padding:10px 8px;color:#1f2937;">{{ $subject }}</td>
    </tr>
    @if(isset($project_type) && $project_type)
    <tr>
      <td style="padding:10px 8px;font-weight:600;color:#374151;vertical-align:top;">Service Needed</td>
      <td style="padding:10px 8px;"><span style="background:#dbeafe;color:#1e40af;padding:3px 10px;border-radius:20px;font-size:13px;font-weight:600;">{{ $project_type }}</span></td>
    </tr>
    @endif
    @if(isset($budget_range) && $budget_range)
    <tr style="background:#f9fafb;">
      <td style="padding:10px 8px;font-weight:600;color:#374151;vertical-align:top;">Budget</td>
      <td style="padding:10px 8px;"><span style="background:#dcfce7;color:#166534;padding:3px 10px;border-radius:20px;font-size:13px;font-weight:600;">{{ $budget_range }}</span></td>
    </tr>
    @endif
    <tr>
      <td style="padding:10px 8px;font-weight:600;color:#374151;vertical-align:top;">Message</td>
      <td style="padding:10px 8px;color:#374151;line-height:1.7;white-space:pre-wrap;">{{ $message }}</td>
    </tr>
  </table>
  <div style="margin-top:24px;padding-top:16px;border-top:1px solid #e5e7eb;">
    <a href="mailto:{{ $email }}?subject=Re: {{ $subject }}"
       style="display:inline-block;background:#2563eb;color:#fff;padding:10px 20px;border-radius:8px;text-decoration:none;font-weight:600;font-size:14px;">
      Reply to {{ $name }}
    </a>
  </div>
  <p style="margin-top:20px;font-size:12px;color:#9ca3af;">
    {{ now()->format('D, M d Y H:i A T') }} · jpcsilva.com contact form
  </p>
</body>
</html>
