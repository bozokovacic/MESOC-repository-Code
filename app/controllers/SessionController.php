<?php

/**
 * SessionController
 *
 * Allows to authenticate users
 */
class SessionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Signin');
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->request->isPost()) {
            $this->tag->setDefault('email', 'gost');
            $this->tag->setDefault('password', '1234');
        }
    }

    /**
     * Register an authenticated user into session data
     *
     * @param Users $user
     */
    private function _registerSession(Users $user)
    {
        $this->session->set('auth', [
            'id' => $user->id,
            'name' => $user->name,
            'ID_Role' => $user->ID_Role,
            'ID_Partner' => $user->ID_Partner,
            'ID_Organisation' => $user->ID_Organisation    
        ]);
    }

    /**
     * This action authenticate and logs an user into the application
     *
     */
    public function startAction()
    {
        if ($this->request->isPost()) {

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = Users::findFirst([
                "(email = :email: OR username = :email:) AND password = :password: AND active = 'Y'",
                'bind' => ['email' => $email, 'password' => sha1($password)]
            ]);
            if ($user != false) {
                $this->_registerSession($user);
                $this->flash->success('Welcome ' . $user->name);

                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "view",
                    ]
                );
            }

            $this->flash->error('Email/password is incorrect');
        }

        return $this->dispatcher->forward(
            [
                "controller" => "session",
                "action"     => "index",
            ]
        );
    }

     public function accessAction()
    {
        
        $user = new Users();
        $user->id = 4;
        $user->name = "Guest";
        $user->ID_Role = 2;
        $user->ID_Partner = 21;
        $user->ID_Organisation = 1;   
         
        $this->_registerSession($user);
        $this->flash->success('Welcome ' . $user->name);

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "view",
                ]
            );

    }
    
    /**
     * Finishes the active session redirecting to the index
     *
     * @return unknown
     */
    public function endAction()
    {
        $this->session->remove('auth');
        $this->flash->success('Good bye!');

        return $this->dispatcher->forward(
            [
                "controller" => "index",
                "action"     => "index",
            ]
        );
    }
}
