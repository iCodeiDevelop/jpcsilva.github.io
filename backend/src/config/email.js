const nodemailer = require('nodemailer');
const logger     = require('./logger');

let transporter = null;

const getTransporter = () => {
  if (!transporter) {
    transporter = nodemailer.createTransport({
      host: process.env.SMTP_HOST,
      port: parseInt(process.env.SMTP_PORT, 10) || 587,
      secure: process.env.SMTP_SECURE === 'true',
      auth: { user: process.env.SMTP_USER, pass: process.env.SMTP_PASS },
      tls: { rejectUnauthorized: false },
    });
  }
  return transporter;
};

const sendEmail = async ({ to, subject, html, text }) => {
  try {
    const info = await getTransporter().sendMail({
      from: process.env.EMAIL_FROM || 'Portfolio <noreply@portfolio.dev>',
      to, subject, html, text,
    });
    logger.info(`Email sent: ${info.messageId} → ${to}`);
    return { success: true, messageId: info.messageId };
  } catch (error) {
    logger.error(`Email failed: ${error.message}`);
    throw error;
  }
};

const sendContactEmail = async ({ name, email, subject, message }) => {
  const html = `
    <div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;padding:24px;border:1px solid #e5e7eb;border-radius:8px;">
      <h2 style="color:#2563eb;margin-bottom:20px;">📬 New Portfolio Message</h2>
      <table style="width:100%;border-collapse:collapse;">
        <tr><td style="padding:8px 4px;font-weight:600;color:#374151;width:80px;">From:</td>
            <td style="padding:8px 4px;">${name} &lt;${email}&gt;</td></tr>
        <tr style="background:#f9fafb;"><td style="padding:8px 4px;font-weight:600;color:#374151;">Subject:</td>
            <td style="padding:8px 4px;">${subject}</td></tr>
        <tr><td style="padding:8px 4px;font-weight:600;color:#374151;vertical-align:top;">Message:</td>
            <td style="padding:8px 4px;white-space:pre-wrap;color:#4b5563;">${message}</td></tr>
      </table>
      <p style="margin-top:20px;font-size:12px;color:#9ca3af;">
        Received: ${new Date().toUTCString()} | Source: Portfolio Contact Form
      </p>
    </div>`;

  return sendEmail({
    to: process.env.CONTACT_RECIPIENT,
    subject: `[Portfolio Contact] ${subject}`,
    html,
    text: `From: ${name} <${email}>\nSubject: ${subject}\n\n${message}`,
  });
};

module.exports = { sendEmail, sendContactEmail };
