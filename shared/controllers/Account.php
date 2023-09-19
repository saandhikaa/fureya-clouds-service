<?php
    class Account extends Controller {
        private $app, $class;
        private $data = [];
        
        public function __construct() {
            $this->class = strtolower(__CLASS__);
            $this->app = basename(dirname(__DIR__));
            
            $this->data["mainApp"] = $this->app;
            $this->data["app"] = $this->class;
            $this->data["image-path"] = '<p class="image-path">' . BASEURL . '/' . $this->app . '/assets/images/</p>' . PHP_EOL;
        }
        
        public function index() {
            if (!$this->model($this->app, "AccountControl")->checkSignInInfo()) {
                header("Location: " . BASEURL . "/$this->class/signin");
                exit;
            }
            
            $this->data["title"] = "Fureya: Account";
            
            $this->view($this->app, "templates/header", $this->data);
            $this->view($this->app, "$this->class/index", $this->data);
            $this->view($this->app, "templates/footer", $this->data);
        }
        
        public function signup ($parameter = null) {
            if ($parameter === "checkusernameavailability") {
                // Handle the AJAX request
                if (isset($_POST["username"])) {
                    echo ($this->model($this->app, "AccountControl")->checkUsername($_POST["username"])) ? "available" : "taken";
                    exit;
                }
            } elseif (!is_null($parameter)) {
                header("Location: " . BASEURL . "/$this->class/signup");
                exit;
            }
            
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0 && isset($_POST["submit"])) {
                if ($_POST["submit"] === "Sign Up") {
                    if ($this->model($this->app, "AccountControl")->signUp($_POST["username"], $_POST["password"])) {
                        if ($this->model($this->app, "AccountControl")->signIn($_POST["username"], $_POST["password"])) {
                            header("Location: " . BASEURL . "/$this->class");
                            exit;
                        }
                    } else {
                        echo "failed create account";
                    }
                }
            }
            
            $this->data["title"] = "Fureya: Sign Up";
            $this->data["appScript"] = '<script type="text/javascript">thicknessSVG(' . "'.passwordVisibility path', '15');</script>" . PHP_EOL;
            $this->data["appScript"] .= '<script type="text/javascript">validationSVG();</script>' . PHP_EOL;
            
            $this->view($this->app, "templates/header", $this->data);
            $this->view($this->app, "$this->class/signup", $this->data);
            $this->view($this->app, "templates/footer", $this->data);
        }
        
        public function signin() {
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0 && isset($_POST["submit"])) {
                if ($_POST["submit"] === "Sign In") {
                    if ($this->model($this->app, "AccountControl")->signIn($_POST["username"], $_POST["password"])) {
                        header("Location: " . BASEURL . "/$this->class");
                        exit;
                    } else {
                        $this->data["sign-in-failed"] = "Username/password incorrect";
                    }
                }
            }
            
            $this->data["title"] = "Fureya: Sign In";
            $this->data["appScript"] = '<script type="text/javascript">thicknessSVG(' . "'.passwordVisibility path', '15');</script>" . PHP_EOL;
            
            $this->view($this->app, "templates/header", $this->data);
            $this->view($this->app, "$this->class/signin", $this->data);
            $this->view($this->app, "templates/footer", $this->data);
        }
        
        public function signout() {
            session_destroy();
            unset($_SESSION["sign-in"]);
            header("Location: " . BASEURL . "/$this->class/signin");
            exit;
        }
        
        public function setup() {
            $tableName = "users";
            
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                if (isset($_POST["submit"]) && isset($_POST["table"])) {
                    $this->data["status"] = $this->model($this->app, "TableMaster")->createTable($tableName, $_POST["table"]);
                    $this->model($this->app, "AccountControl")->signup(ADMIN_USERNAME, ADMIN_PASSWORD, 1);
                    
                    $this->data["admin"] = "<p>Default username: <strong>" . ADMIN_USERNAME . "</strong></p>" . PHP_EOL . "<p>Default password: <strong>" . ADMIN_PASSWORD . "</strong></p>" . PHP_EOL;
                }
            }
            
            $this->data["title"] = "Fureya: Setup";
            $this->data["table"] = $this->model($this->app, "TableMaster")->getTableStructure($tableName);
            
            $this->view($this->app, "templates/header", $this->data);
            $this->view($this->app, "$this->class/setup", $this->data);
            $this->view($this->app, "templates/footer");
        }
    }
?>