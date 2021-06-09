<?php 
namespace App\Controllers;


class Logout extends \IonAuth\Controllers\Auth
{
    /**
     * If you want to customize the views,
     *  - copy the ion-auth/Views/auth folder to your Views folder,
     *  - remove comment
     */
    protected $viewsFolder = 'auth_mahasiswa';



    public function index()
    {
        $this->data['title'] = 'Logout';

        // log the user out
        $this->ionAuth->logout();

        // redirect them to the login page
        return redirect()->to('/')->withCookies();
    }


}