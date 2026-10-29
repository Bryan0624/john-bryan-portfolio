<?php

$out = __DIR__.'/public/files/John-Bryan-Resume.pdf';

$lines = [
    'JOHN BRYAN BOLARDE',
    'Full Stack / Laravel Developer',
    'Philippines | bolardejohnbryan24@gmail.com',
    'LinkedIn: linkedin.com/in/john-bryan-bolarde-bb87891b9',
    '',
    'SUMMARY',
    'Full Stack Developer specializing in Laravel, PHP, MySQL, and Tailwind CSS.',
    'Builds scalable web apps, REST APIs, and clean relational MySQL schemas',
    'with maintainable MVC architecture.',
    '',
    'EXPERIENCE',
    'Full-stack Developer — Outposter (Mar 2024 – Present)',
    '- Full-stack delivery for offshore engineering teams',
    '- Laravel-oriented web features, APIs, and data flows',
    '- Responsive UI collaboration and maintainable backend code',
    '',
    'CORE SKILLS',
    'Backend: PHP, Laravel, Node.js, RESTful APIs',
    'Frontend: HTML5, CSS3, JavaScript, Blade, Tailwind CSS',
    'Data: MySQL schema design, indexing, Eloquent',
    'Tools: Git, GitHub, Postman, XAMPP',
    '',
    'EDUCATION',
    'BSIT — Gordon College, Olongapo City (2019 – 2024)',
    '',
    'TECHNICAL FOCUS',
    '- Laravel MVC apps with Blade + Tailwind',
    '- REST API contracts and JSON response design',
    '- MySQL migrations, foreign keys, and indexes',
];

$ops = "BT\n/F1 18 Tf\n50 760 Td\n(JOHN BRYAN BOLARDE) Tj\n0 -22 Td\n/F1 12 Tf\n(Full Stack / Laravel Developer) Tj\n0 -26 Td\n/F1 10 Tf\n";

foreach (array_slice($lines, 2) as $line) {
    $safe = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $line);
    $ops .= "({$safe}) Tj\n0 -14 Td\n";
}
$ops .= 'ET';
$len = strlen($ops);

$objects = [];
$objects[] = "1 0 obj<< /Type /Catalog /Pages 2 0 R >>endobj\n";
$objects[] = "2 0 obj<< /Type /Pages /Kids [3 0 R] /Count 1 >>endobj\n";
$objects[] = "3 0 obj<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>endobj\n";
$objects[] = "4 0 obj<< /Length {$len} >>stream\n{$ops}\nendstream\nendobj\n";
$objects[] = "5 0 obj<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>endobj\n";

$pdf = "%PDF-1.4\n";
$offsets = [0];
foreach ($objects as $obj) {
    $offsets[] = strlen($pdf);
    $pdf .= $obj;
}
$xrefPos = strlen($pdf);
$pdf .= 'xref'."\n0 ".(count($objects) + 1)."\n";
$pdf .= "0000000000 65535 f \n";
for ($i = 1; $i <= count($objects); $i++) {
    $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
}
$pdf .= 'trailer<< /Size '.(count($objects) + 1)." /Root 1 0 R >>\n";
$pdf .= "startxref\n{$xrefPos}\n%%EOF";

if (! is_dir(dirname($out))) {
    mkdir(dirname($out), 0777, true);
}

file_put_contents($out, $pdf);
echo 'Wrote '.strlen($pdf).' bytes to '.$out.PHP_EOL;
