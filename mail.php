<?php
header('Content-Type: application/json; charset=UTF-8');

// 送信先
$to = 'kakido@strut-ink.com';

// POST以外は拒否
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
    exit;
}

// 入力取得・サニタイズ
$name    = trim($_POST['name'] ?? '');
$company = trim($_POST['company'] ?? '');
$email   = trim($_POST['email'] ?? '');
$tel     = trim($_POST['tel'] ?? '');
$type    = trim($_POST['type'] ?? '');
$body    = trim($_POST['body'] ?? '');

// バリデーション
if ($name === '' || $email === '' || $type === '' || $body === '') {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => '必須項目を入力してください。']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'メールアドレスが正しくありません。']);
    exit;
}

// --- 管理者宛メール ---
$subject = "【お問い合わせ】{$type} - {$name}様";
$message = <<<EOT
お問い合わせを受信しました。

━━━━━━━━━━━━━━━━━━━━━━━━
■ 氏名: {$name}
■ 会社名: {$company}
■ メールアドレス: {$email}
■ 電話番号: {$tel}
■ お問い合わせ種別: {$type}
━━━━━━━━━━━━━━━━━━━━━━━━

【お問い合わせ内容】
{$body}

━━━━━━━━━━━━━━━━━━━━━━━━
EOT;

$headers  = "From: {$email}\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$admin_sent = mb_send_mail($to, $subject, $message, $headers);

// --- 自動返信メール ---
$reply_subject = "【プレジールライフ】お問い合わせありがとうございます";
$reply_message = <<<EOT
{$name} 様

この度はお問い合わせいただき、誠にありがとうございます。
以下の内容で承りました。

━━━━━━━━━━━━━━━━━━━━━━━━
■ 氏名: {$name}
■ 会社名: {$company}
■ メールアドレス: {$email}
■ 電話番号: {$tel}
■ お問い合わせ種別: {$type}

【お問い合わせ内容】
{$body}
━━━━━━━━━━━━━━━━━━━━━━━━

内容を確認のうえ、2営業日以内にご返信いたします。
今しばらくお待ちくださいませ。

──────────────────────────
株式会社プレジールライフ
TEL. 011-206-1273 / FAX. 011-206-1368
mail@plaisir-life.info
──────────────────────────
EOT;

$reply_headers  = "From: {$to}\r\n";
$reply_headers .= "Reply-To: {$to}\r\n";
$reply_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$reply_sent = mb_send_mail($email, $reply_subject, $reply_message, $reply_headers);

if ($admin_sent) {
    echo json_encode(['status' => 'ok']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => '送信に失敗しました。時間をおいて再度お試しください。']);
}
