<?php
    require "vendor/autoload.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class ContactModel {
        private $name;
        private $email;
        private $age;
        private $message;

        public function setData($name, $email, $age, $message) {
            $this->name = $name;
            $this->email = $email;
            $this->age = $age;
            $this->message = $message;
        }
        public function validForm() {
            if(strlen($this->name) < 3)
                return "Ім'я надто коротке";
            elseif (strlen($this->email) < 3)
                return "Email надто короткий";
            else if(!is_numeric($this->age) || $this->age <= 0 || $this->age > 90)
                return "Ви ввели не вік";
            else if(strlen($this->message) < 5)
                return "Повідомлення надто коротке";
            else
                return "Вірно";
        }
        public function mail(){
            $mail = new PHPMailer(true);
            try {
              // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->SMTPDebug = 0;                     
                $mail->isSMTP();           
                $mail->Host       = 'smtp.sendgrid.net';       
                $mail->SMTPAuth   = true;                       
                $mail->Username   = 'apikey';                    
                //$mail->Password   = 'password should be here';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
                $mail->Port       = 587;                               
            
                
                $mail->setFrom('beefeater83@gmail.com', 'Sergey');
                $mail->addAddress($this->email, $this->name);             
                             
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';
                $mail->Subject = 'Повідомлення з сайту short-links.diakonov-it.com.ua';          
                                                
                $mail->Body = $this->message;
             
                if($mail->send()){
                    $_POST['name'] = $_POST['email'] = $_POST['age'] = $_POST['message'] = '';
                    $_SESSION['mail'] = "Повідомлення було надіслано!";  
                    header('Location: ' . $_SERVER['REQUEST_URI']);
                    exit();                  
                }                
               
            } catch (Exception $e) {
                $_SESSION['mail'] = "Не вдалося надіслати лист. Помилка: {$mail->ErrorInfo}";
            }
        }        

    }