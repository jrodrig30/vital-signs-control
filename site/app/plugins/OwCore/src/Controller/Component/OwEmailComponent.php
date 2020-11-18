<?php
namespace OwCore\Controller\Component;

use Cake\Controller\Component;

class OwEmailComponent extends Component {

    public $Username = '';
    public $Password = '';
    public $SMTPAuth = true;
    private $setouFrom = false;
    public $Host = '';
    public $email;

    function __construct(ComponentCollection $collection, $settings = array()) {
        App::import('Vendor', 'PHPMailer', array('file' => 'phpmailer' . DS . 'class.phpmailer.php'));
        $this->email = new PHPMailer();
        return parent::__construct($collection, $settings);
    }
    
    public function reset() {
        $this->setouFrom = false;
        $this->email->ClearAllRecipients();
        $this->email->ClearAddresses();
        $this->email->ClearAttachments();
        $this->email->ClearCustomHeaders();
        return true;
    }
    
    public function AddAddress($address, $name = '') {
        $this->email->AddAddress($address, $name);
    }

    public function AddReplyTo($address, $name = '') {
        $this->email->AddReplyTo($address, $name);
    }

    public function SetSubject($subject) {
        $this->email->Subject = $subject;
    }

    public function SetBody($body) {
        $this->email->Body = $body;
    }
    
    public function SetFrom($address, $name = '', $auto = 1) {
        $this->setouFrom = true;
        return $this->email->SetFrom($address, $name, $auto);
    }
    
    public function SetHost($host){
        $this->Host = $host;
    }

    public function SetSmtpUserName($smtp_user_name){
        $this->Username = $smtp_user_name;
    }

    public function SetSmtpPassword($smtp_password){
        $this->Password = $smtp_password;
    }

    public function Send() {

        $this->email->IsSMTP();
        $this->email->SMTPAuth = true;
        
        if(!strlen( $this->Host )){
            $this->email->Host = Parametro::v('SMTP_HOST');
            $this->email->Username = Parametro::v('SMTP_USER');
            $this->email->Password = Parametro::v('SMTP_PASSWORD');
        }
        
        $this->email->Mailer = 'smtp';
        $this->email->CharSet = 'UTF-8';
        $this->email->Port = 587;
        $this->email->IsHTML(true);

        if (!$this->setouFrom) {
            $this->email->SetFrom(Parametro::v('EMAIL_DEFAULT_FROM'));
        }

        return $this->email->Send();
    }

}