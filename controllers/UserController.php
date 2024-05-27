<?php

namespace app\controllers;

use app\core\Controller;
use app\models\User;

class UserController extends Controller
{
    public function login()
    {
        $errors = [];
        $user = new User();
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];

        if ($user->authenticate()) {
            session_start();
            $_SESSION['user_id'] = $user->id;
            $_SESSION['powers'] = $user->powers;
            header("Location: /dashboard");
            exit();
        } else {
            $errors[] = $user->emailErr;
            $errors[] = $user->passwordErr;
            return $this->render("login", ['errors' => $errors, 'email' => $_POST['email']]);
        }
    }

    public function register()
    {
        $errors = [];
        $user = new User();
        $user->username = $_POST['username'];
        $user->email = $_POST['email'];
        $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        // $user->powers = $_POST['powers']; // تأكد من تعيين القيمة الصحيحة

        if ($user->isRegistered()) {
            $errors[] = "User is already registered.";
            return $this->render("register", ["errors" => $errors, "email" => $_POST["email"]]);
        } else {
            if ($user->create()) {
                $this->render("login", []);
                exit();
            } else {
                $errors[''] = "Registration failed.";
                return $this->render("register", ["errors" => $errors, "email" => $_POST["email"]]);
            }
        }
    }

    public function dashboard()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['powers'] !== 'admin') {
            echo "Access denied.";
            exit();
        }

        $user = new User();
        $users = $user->readAll();

        return $this->render('dashboard', ['users' => $users]);
    }

    public function showRegister()
    {
        $errors = [];
        return $this->render("register", ['errors' => $errors]);
    }

    public function showLogin()
    {
        $errors = [];
        return $this->render("login", ['errors' => $errors]);
    }

    public function logout()
    {
        session_start();
        // إزالة البيانات من الجلسة
        session_unset();
        // إنهاء الجلسة
        session_destroy();
        // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول بعد تسجيل الخروج
        header("Location: /login");
        exit();
    }
}
