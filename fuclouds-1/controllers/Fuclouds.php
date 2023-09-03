<?php
    class Fuclouds extends Controller {
        private $app, $class;
        private $data = [];
        
        public function __construct() {
            $this->class = strtolower(__CLASS__);
            $this->app = basename(dirname(__DIR__));
            
            $this->model($this->app, "FileHandler")->autoRemove();
            
            $this->data["mainApp"] = "shared";
            $this->data["app"] = $this->class;
            $this->data["styles"] = '<link rel="stylesheet" href="' . BASEURL . '/' . $this->app . '/assets/css/app.css">' . PHP_EOL;
            $this->data["appScript"] = '<script src="' . BASEURL . '/' . $this->app . '/assets/js/app.js"></script>' . PHP_EOL;
        }
        
        public function index() {
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                $url = BASEURL . "/$this->class/result/" . $_POST["keyword"];
                header("Location: $url");
                exit;
            }
            
            $this->data["title"] = ucfirst($this->class) . ": Search";
            
            $this->view($this->data["mainApp"], "templates/header", $this->data);
            $this->view($this->app, "$this->class/index", $this->data);
            $this->view($this->data["mainApp"], "templates/footer", $this->data);
        }
        
        public function upload() {
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                $url = BASEURL . "/$this->class/result/" . $this->model($this->app, "FileHandler")->upload() . "/uploaded";
                header("Location: $url");
                exit;
            }
            
            $this->data["title"] = ucfirst($this->class) . ": Upload";
            $this->data["appScript"] .= '<script type="text/javascript">createInput();</script>' . PHP_EOL;
            
            $this->view($this->data["mainApp"], "templates/header", $this->data);
            $this->view($this->app, "$this->class/upload", $this->data);
            $this->view($this->data["mainApp"], "templates/footer", $this->data);
        }
        
        public function result ($codename = null, $key = null, $status = "") {
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                if ($_POST["submit"] === "Download" || $_POST["submit"] === "Download All as Zip") {
                    $this->model($this->app, "FileHandler")->download($_POST["filename"], $_POST["filepath"]);
                }
            } elseif (is_null($codename) || is_null($key)) {
                header("Location: " . BASEURL . "/$this->class");
                exit;
            }
            
            $this->data["title"] = ucfirst($this->class) . ": Result";
            $this->data["result"] = $this->model($this->app, "FileHandler")->loadFiles($codename, $key);
            $this->data["status"] = $status;
            $this->data["keyword"] = "$codename/$key";
            
            $this->view($this->data["mainApp"], "templates/header", $this->data);
            $this->view($this->app, "$this->class/result", $this->data);
            $this->view($this->data["mainApp"], "templates/footer", $this->data);
        }
        
        public function setup() {
            $tableName = "uploads";
            
            $this->model($this->data["mainApp"], "TableMaster")->createTable($tableName);
            $this->model($this->app, "FileHandler")->createUploadsDir();
            
            $this->data["title"] = ucfirst($this->class) . ": Setup";
            $this->data["table"] = $this->model($this->data["mainApp"], "TableMaster")->getTableStructure($tableName);
            
            $this->view($this->data["mainApp"], "templates/header", $this->data);
            $this->view($this->app, "$this->class/setup", $this->data);
            $this->view($this->data["mainApp"], "templates/footer", $this->data);
        }
    }
?>