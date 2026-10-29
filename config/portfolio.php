<?php

return [

    'name' => env('PORTFOLIO_NAME', 'John Bryan'),
    'full_name' => env('PORTFOLIO_FULL_NAME', 'John Bryan Bolarde'),
    'title' => env('PORTFOLIO_TITLE', 'Full Stack / Laravel Developer'),
    'email' => env('PORTFOLIO_EMAIL', 'bolardejohnbryan24@gmail.com'),
    'location' => env('PORTFOLIO_LOCATION', 'Philippines'),

    'github' => env('PORTFOLIO_GITHUB', ''),
    'linkedin' => env('PORTFOLIO_LINKEDIN', 'https://www.linkedin.com/in/john-bryan-bolarde-bb87891b9'),

    /*
    |--------------------------------------------------------------------------
    | Contact delivery
    |--------------------------------------------------------------------------
    |
    | Preferred: Formspree endpoint (https://formspree.io/f/xxxxx)
    | Fallback: FormSubmit AJAX to PORTFOLIO_EMAIL (confirm once via inbox)
    | Last resort: Laravel Mail (configure MAIL_* in .env)
    |
    */
    'formspree_endpoint' => env('PORTFOLIO_FORMSPREE_ENDPOINT', ''),
    'formsubmit_ajax' => env('PORTFOLIO_FORMSUBMIT_AJAX', true),

    'resume_path' => 'files/John-Bryan-Resume.pdf',
    'og_image' => env('PORTFOLIO_OG_IMAGE', 'images/bryan.jpg'),

    'site_url' => env('APP_URL', 'http://localhost'),
    'description' => env(
        'PORTFOLIO_DESCRIPTION',
        'John Bryan Bolarde — Full Stack / Laravel Developer building scalable web apps, REST APIs, and MySQL-backed systems.'
    ),
];
