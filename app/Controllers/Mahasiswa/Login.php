<?php 
namespace App\Controllers\Mahasiswa;

class Login extends \IonAuth\Controllers\Auth
{
    /**
     * If you want to customize the views,
     *  - copy the ion-auth/Views/auth folder to your Views folder,
     *  - remove comment
     */
    protected $viewsFolder = 'auth_mahasiswa';


    public function index()
    {
        $this->data['title'] = lang('Auth.login_heading');

        // validate form input
        $this->validation->setRule('identity', str_replace(':', '', lang('Auth.login_identity_label')), 'required');
        $this->validation->setRule('password', str_replace(':', '', lang('Auth.login_password_label')), 'required');

        if ($this->request->getPost() && $this->validation->withRequest($this->request)->run())
        {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool)$this->request->getVar('remember');
            
            if(!$this->ionAuth->IsMahasiswa($this->request->getVar('identity'))){
                // use redirects instead of loading views for compatibility with MY_Controller libraries
                // // log the user out
                $this->session->setFlashdata('message', '<div class="errors alert alert-danger small pb-0" role="alert"><ul class="mb-2 pl-0"><li><i class="fas fa-info-circle mr-2"></i>Login gagal! Periksa kembali username dan password anda</li></ul></div>');
                return redirect()->to('login')->withInput();
            } else {
                if ($this->ionAuth->login($this->request->getVar('identity'), $this->request->getVar('password'), $remember))
                {
                    //if the login is successful
                    //redirect them back to the home page
                    $this->session->setFlashdata('message', $this->ionAuth->messages());
                    return redirect()->to('/')->withCookies();
                }
                else
                {
                    // if the login was un-successful
                    // redirect them back to the login page
                    $this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
                    // use redirects instead of loading views for compatibility with MY_Controller libraries
                    return redirect()->to('login')->withInput();
                }
            }  
        }
        else
        {
            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->data['message'] = $this->session->getFlashdata('message');
            $this->data['validation'] = $this->validation;

            $this->data['identity'] = [
                'name'  => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'value' => set_value('identity'),
                'class'	=> 'form-control form-control-user',
                'placeholder' => 'Username',
                'autocomplete' => 'off',
            ];

            $this->data['password'] = [
                'name' => 'password',
                'id'   => 'password',
                'type' => 'password',
                'class'	=> 'form-control form-control-user',
                'placeholder' => 'Password',
                'autocomplete' => 'off',
            ];

            return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'login', $this->data);
        }
    }

}