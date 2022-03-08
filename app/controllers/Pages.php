<?php
class Pages extends Controller {
    public function __construct() {
        $this->userModel = $this->model('User');
        $this->postModel = $this->model('Post');
    }

    public function index() {
        $data = [
            'title' => 'Home page',
        ];

        $this->view('index', $data);
    }

    public function about() {
        
        $this->view('about');
    }

    public function allUsers(){
        if(isset($_COOKIE['jwt'])){
        if($this->userModel->is_jwt_valid()){  

            $users = [];
            $data = [];
            $users = $this->userModel->findAllUsers();
            $i = 0;
            foreach($users as $user){

                // $user = (array)$user;
                $data[$i] = $user;
                // $data = $user;
                $i ++;
                
            }

            $this->view('users/AllUsers', $data);
        }else{

            $this->view('users/login');
        }
    }
    }

    public function allPosts(){
        if(isset($_COOKIE['jwt'])){
        if($this->userModel->is_jwt_valid()){ 
            $posts = [];
            $data = [];
            $posts = $this->postModel->findAllPosts();
            $i = 0;
            foreach($posts as $post){

                // $post = (array)$post;
                $data[$i] = $post;
                $i ++;
                
            }
            $this->view('users/AllPosts', $data);
            }else{

                $this->view('users/login');
            }
        }

    }

    public function contact(){
        if($this->userModel->is_jwt_valid()){ 

            $this->view('users/contact');
        }else{

            $this->view('index');
        }
    }
}
