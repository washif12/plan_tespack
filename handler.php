<?php

//require_once __DIR__ . '/vendor/autoload.php';
ini_set('allow_url_fopen',1);
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
        require 'stats.php';
        break;
    case '/index':
        require 'stats.php';
        break;
    case '/index.php':
        require 'stats.php';
        break;
    case '/stats.php':
        require 'stats.php';
        break;
    case '/stats':
        require 'stats.php';
        break;
    case '/login':
        require 'login.php';
        break;
    case '/login.php':
        require 'login.php';
        break;
    case '/user':
        require 'user.php';
        break;
    case '/user.php':
        require 'user.php';
        break;
    case '/countries':
        require 'countries.php';
        break;
    case '/countries.php':
        require 'countries.php';
        break;
    case '/geoFencing':
        require 'geoFencing.php';
        break;
    case '/geoFencing.php':
        require 'geoFencing.php';
        break;
    case '/report':
        require 'report.php';
        break;
    case '/report.php':
        require 'report.php';
        break;
    case '/logs':
        require 'logs.php';
        break;
    case '/logs.php':
        require 'logs.php';
        break;
    case '/map':
        require 'map.php';
        break;
    case '/map.php':
        require 'map.php';
        break;
    case '/projects':
        require 'projects.php';
        break;
    case '/projects.php':
        require 'projects.php';
        break;
    case '/smb':
        require 'smb.php';
        break;
    case '/smb.php':
        require 'smb.php';
        break;
    case '/smbDetails':
        require 'smbDetails.php';
        break;
    case '/smbDetails.php':
        require 'smbDetails.php';
        break;
    case '/teams':
        require 'teams.php';
        break;
    case '/teams.php':
        require 'teams.php';
        break;
    case '/tickets':
        require 'tickets.php';
        break;
    case '/tickets.php':
        require 'tickets.php';
        break;
    case '/trainings':
        require 'trainings.php';
        break;
    case '/trainings.php':
        require 'trainings.php';
        break;
    case '/register':
        require 'register.php';
        break;
    case '/register.php':
        require 'register.php';
        break;
    case '/message.php':
        require 'message.php';
        break;
    case '/message':
        require 'message.php';
        break;
    case '/forgot-pass.php':
        require 'forgot-pass.php';
        break;
    case '/forgot-pass':
        require 'forgot-pass.php';
        break;
    case '/setPassword.php':
        require 'setPassword.php';
        break;
    case '/setPassword':
        require 'setPassword.php';
        break;
        
    case '/api/smbData':
        require __DIR__.'/assets/api/smbData.php';
        break;
    case '/api/emailInvite.php':
        require __DIR__.'/assets/api/emailInvite.php';
        break;
    case '/sendEmailInvite.php':
        require __DIR__.'/assets/api/sendEmailInvite.php';
        break;

    case '/email/callback.php':
        require __DIR__.'/assets/api/emailInvite/callback.php';
        break;
    case '/email/emailInvite.php':
        require __DIR__.'/assets/api/emailInvite/emailInvite.php';
        break;

    case '/api/signup.php':
        require __DIR__.'/assets/api/signup.php';
        break;
    case '/api/logout.php':
        require __DIR__.'/assets/api/logout.php';
        break;
    case '/api/signin.php':
        require __DIR__.'/assets/api/signin.php';
        break;
    case '/verify_email.php':
        require __DIR__.'/backend/verify_email.php';
        break;
    case '/backend/signin.php':
        require __DIR__.'/backend/signin.php';
        break;
    case '/backend/logout.php':
        require __DIR__.'/backend/logout.php';
        break;

    case '/api/pass_reset.php':
        require __DIR__.'/assets/api/pass_reset.php';
        break;
    case '/backend/pass_reset.php':
        require __DIR__.'/backend/pass_reset.php';
        break;
    case '/api/setPassword.php':
        require __DIR__.'/assets/api/setPassword.php';
        break;
    case '/backend/setPassword.php':
        require __DIR__.'/backend/setPassword.php';
        break;
    /* Page APIs */
    case '/backend/teams/modal.php':
        require __DIR__.'/backend/teams/modal.php';
        break;
    case '/backend/teams/read.php':
        require __DIR__.'/backend/teams/read.php';
        break;
    case '/backend/teams/create.php':
        require __DIR__.'/backend/teams/create.php';
        break;
    case '/backend/teams/delete.php':
        require __DIR__.'/backend/teams/delete.php';
        break;
    case '/backend/teams/update.php':
        require __DIR__.'/backend/teams/update.php';
        break;
    case '/backend/teams/selectData.php':
        require __DIR__.'/backend/teams/selectData.php';
        break;

    case '/backend/smb/modal.php':
        require __DIR__.'/backend/smb/modal.php';
        break;
    case '/backend/smb/read.php':
        require __DIR__.'/backend/smb/read.php';
        break;
    case '/backend/smb/insert.php':
        require __DIR__.'/backend/smb/insert.php';
        break;
    case '/backend/smb/delete.php':
        require __DIR__.'/backend/smb/delete.php';
        break;
    case '/backend/smb/update.php':
        require __DIR__.'/backend/smb/update.php';
        break;

    case '/backend/country/modal.php':
        require __DIR__.'/backend/country/modal.php';
        break;
    case '/backend/country/read.php':
        require __DIR__.'/backend/country/read.php';
        break;
    case '/backend/country/insert.php':
        require __DIR__.'/backend/country/insert.php';
        break;
    case '/backend/country/delete.php':
        require __DIR__.'/backend/country/delete.php';
        break;
    case '/backend/country/update.php':
        require __DIR__.'/backend/country/update.php';
        break;
    
    case '/backend/users/modal.php':
        require __DIR__.'/backend/users/modal.php';
        break;
    case '/backend/users/read.php':
        require __DIR__.'/backend/users/read.php';
        break;
    case '/backend/users/insert.php':
        require __DIR__.'/backend/users/insert.php';
        break;
    case '/backend/users/delete.php':
        require __DIR__.'/backend/users/delete.php';
        break;
    case '/backend/users/update.php':
        require __DIR__.'/backend/users/update.php';
        break;

    case '/backend/projects/modal.php':
        require __DIR__.'/backend/projects/modal.php';
        break;
    case '/backend/projects/read.php':
        require __DIR__.'/backend/projects/read.php';
        break;
    case '/backend/projects/create.php':
        require __DIR__.'/backend/projects/create.php';
        break;
    case '/backend/projects/delete.php':
        require __DIR__.'/backend/projects/delete.php';
        break;
    case '/backend/projects/update.php':
        require __DIR__.'/backend/projects/update.php';
        break;
    case '/backend/projects/selectData.php':
        require __DIR__.'/backend/projects/selectData.php';
        break;
    case '/backend/emailInvite.php':
        require __DIR__.'/backend/emailInvite.php';
        break;

    case '/backend/map/selectData.php':
        require __DIR__.'/backend/map/selectData.php';
        break;

    case '/backend/geofencing/selectData.php':
        require __DIR__.'/backend/map/selectData.php';
        break;
    case '/backend/others/smbCount.php':
        require __DIR__.'/backend/others/smbCount.php';
        break;
    case '/api/ssm':
        require __DIR__.'/assets/api/ssmData.php';
        break;
    /*case '/clasesDAO/ClientesDAO.php':
        require __DIR__.'/clasesDAO/ClientesDAO.php';
        break;
    case '/clases/Usuario.php':
        require __DIR__.'/clases/Usuario.php';
        break;
    case '/clasesDAO/UsuarioDAO.php':
        require __DIR__.'/clasesDAO/UsuarioDAO.php';
        break;*/
    default:
        http_response_code(404);
        echo @parse_url($_SERVER['REQUEST_URI'])['path'];
        exit('Not Found');
}


?>