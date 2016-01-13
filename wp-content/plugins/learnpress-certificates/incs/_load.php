<?php

// Admin
new LPR_Certificate();

// Frontend
require_once( LPR_CERTIFICATE_PATH . '/incs/class-lpr-certificate-frontend.php' );
new LPR_Certificate_Frontend();
