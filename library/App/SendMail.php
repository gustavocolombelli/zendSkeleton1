<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SendMail
 *
 * @author paulocesargarcia
 */
class App_SendMail {
    
    public function __construct() {
        
    }

    public function send($toEmail, $toName, $subject, $msg, $html=1, $replyEmail=null, $replyName=null, $fromEmail=null, $fromName=null) {
        

        $config = Zend_Registry::get('config');
        
        #$fromEmail  = !empty($fromEmail)? $fromEmail : $config->resources->mail->defaultFrom->email;
        $fromEmail = 'no-reply@uniamerica.br';
	$fromName   = !empty($fromName)? $fromEmail : $config->resources->mail->defaultFrom->name;
        
        $replyEmail  = !empty($replyEmail)? $replyEmail : $config->resources->mail->defaultReplyTo->email;
        $replyName   = !empty($replyName)? $replyName : $config->resources->mail->defaultReplyTo->name;        
        
        $smtpHost = $config->resources->mail->transport->host;
        $smtpConf = array(
            'auth' => $config->resources->mail->transport->auth,
            'ssl' => $config->resources->mail->transport->ssl,
            'port' => $config->resources->mail->transport->port,
            'username' => $config->resources->mail->transport->username,
            'password' => $config->resources->mail->transport->password
        );

#$smtpConf['ssl'] = 587;
#$smtpConf['port'] = 587;
       
#echo '<pre>'; print_r($smtpConf); die;

 
        $transport = new Zend_Mail_Transport_Smtp($smtpHost, $smtpConf);
        
        $mail = new Zend_Mail('UTF-8');
        $mail->setFrom($fromEmail, $fromName);
        $mail->setReplyTo($replyEmail, $replyName);
        $mail->addTo($toEmail, $toName);
        $mail->setSubject($subject);
        if($html) {
            $mail->setBodyHtml($msg);
        } else {
            $mail->setBodyText($msg);
        }

        //Send
        $sent = true;
        try {
            $mail->send($transport);
        }
        catch (Exception $e) {
            echo "Exceção pega: ",  $e->getMessage(), "\n";
            die('oi1');
            $sent = false;
        }    
        
        return $sent;
        
    }
}

?>
