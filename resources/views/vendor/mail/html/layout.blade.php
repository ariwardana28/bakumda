<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<title>{{ config('app.name') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

/* Base Reset */
* { box-sizing: border-box; }

body {
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    background-color: #ffffff;
    color: #1e293b;
    margin: 0;
    padding: 0;
    width: 100% !important;
    -webkit-text-size-adjust: 100%;
}

/* Wrapper */
.wrapper {
    background-color: #ffffff;
    width: 100%;
    margin: 0;
    padding: 40px 0;
}

.content {
    width: 100%;
    max-width: 540px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Header */
.header {
    padding: 0 0 32px 0;
    text-align: left;
}

.header a {
    text-decoration: none;
    display: inline-block;
}

.logo {
    height: 48px;
    width: auto;
    max-width: 200px;
    object-fit: contain;
    display: block;
}

/* Body */
.inner-body {
    background-color: #ffffff;
    width: 100%;
    margin: 0 auto;
    padding: 0;
}

.content-cell {
    padding: 0;
    color: #475569;
    font-size: 16px;
    line-height: 1.6;
}

/* Typography */
h1 {
    color: #0f172a !important;
    font-size: 28px;
    font-weight: 800;
    line-height: 1.25;
    margin: 0 0 16px 0;
    letter-spacing: -0.5px;
}

p {
    color: #64748b;
    font-size: 16px;
    line-height: 1.6;
    margin: 0 0 28px 0;
}

/* Action Button (Blue Rounded Modern Accent) */
.action {
    margin: 32px 0;
    width: 100%;
    text-align: left;
}

.button {
    display: block;
    width: 100%;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    padding: 16px 24px;
    text-decoration: none;
    text-align: center;
    box-sizing: border-box;
}

.button-primary {
    background-color: #0066ff;
    color: #ffffff !important;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 102, 255, 0.25);
}

.button-primary:hover {
    background-color: #0052cc;
}

/* Subcopy & Questions Footer */
.subcopy {
    margin-top: 32px;
    padding-top: 24px;
    font-size: 13px;
    color: #94a3b8;
    line-height: 1.6;
}

.subcopy a {
    color: #0066ff;
    text-decoration: none;
    font-weight: 500;
    word-break: break-all;
}

/* Footer */
.footer {
    margin: 40px auto 0;
    text-align: left;
    width: 100%;
}

.footer td {
    color: #94a3b8;
    font-size: 13px;
    line-height: 1.6;
}

.footer a {
    color: #0066ff;
    text-decoration: none;
    font-weight: 600;
}

/* Responsive */
@media only screen and (max-width: 600px) {
    .wrapper {
        padding: 24px 0 !important;
    }
    .content {
        padding: 0 16px !important;
    }
    h1 {
        font-size: 24px !important;
    }
    p {
        font-size: 15px !important;
    }
    .button {
        padding: 14px 20px !important;
        font-size: 15px !important;
    }
}
</style>
{!! $head ?? '' !!}
</head>
<body>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
<table class="content" cellpadding="0" cellspacing="0" role="presentation">

{!! $header ?? '' !!}

<!-- Email Body -->
<tr>
<td class="body" width="100%" cellpadding="0" cellspacing="0">
<table class="inner-body" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="content-cell">
{!! Illuminate\Mail\Markdown::parse($slot) !!}

{!! $subcopy ?? '' !!}
</td>
</tr>
</table>
</td>
</tr>

{{-- {!! $footer ?? '' !!} --}}

</table>
</td>
</tr>
</table>
</body>
</html>