<?php

namespace app\controllers;

use app\core\Controller;
use app\models\User;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        if (isset($_SESSION['user_id'])) {
            $user = new User();
            $user->id = $_SESSION['user_id'];
            $user->getUserById(); // تأكد من وجود هذه الطريقة لجلب بيانات المستخدم من قاعدة البيانات باستخدام ID

            // استرداد بيانات جميع المستخدمين
            $allUsers = $user->readAll();

            $this->render('dashboard', ['user' => $user, 'users' => $allUsers]);
        } else {
            header("Location: /login");
            exit();
        }
    }
}
