<?php
namespace Cms\Controllers;

class Login {
    private $authentication;

    public function __construct(\Ninja\Authentication $authentication) {
        $this->authentication = $authentication;
    }

    public function loginForm() {
        $supabaseAuthUrl = 'https://your-supabase-url.supabase.co/auth/v1/authorize?provider=email';
        header('Location: ' . $supabaseAuthUrl);
        exit();
    }

    public function processLogin() {
        if ($this->authentication->login($_POST['email'], $_POST['password'])) {
            header('Location: index.php?login/success'); 
        }
        else {
            return ['template' => 'login.html.php',
                    'title' => 'Log In',
                    'variables' => [
                        'error' => 'Invalid username/password.'
                        ]
                    ];
        }
    }

    public function success() {
        $title = 'Course Timetabling';
        $user = $this->authentication->getUser();
        return ['template' => 'home.html.php',
                'title' => $title, 
                'variables' => [
                    'user' => $user
                    ]
                ];
    }

    public function error() {
        return ['template' => 'loginerror.html.php', 'title' => 'You are not logged in'];
    }

    public function permissionsError() {
        return ['template' => 'permissionserror.html.php', 'title' => 'Access Denied'];
    }

    public function logout() {
        unset($_SESSION);
        session_destroy();
        return ['template' => 'logout.html.php', 'title' => 'You have been logged out'];
    }
}