<?php
    function pr($input){
        echo "<pre>";
        print_r($input);
        echo "</pre>";
    }
    function prx($input){
        echo "<pre>";
        print_r($input);
        echo "</pre>";
        die();
    }
    function redirect($url) {
        header('Location: '.$url);
        die();
    }
    function sanitizeInput($input) {
        // Example of basic integer sanitization
        return intval($input); // Convert to integer
    }
?>
    