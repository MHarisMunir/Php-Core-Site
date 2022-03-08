<?php

class Post {
    
    private $db;
    public function __construct() {
        $this->db = new Database;
    }

    public function findAllPosts(){
        //Prepared statement
        $this->db->query('SELECT * FROM posts');
        $posts = $this->db->resultSet();

        //Check if email is already registered
        // if($this->db->rowCount() > 0) {
            return $posts;
            // echo gettype($users);
        // } else {
        //     return 'No User Found!';
        // }
    }
}
?>