<?php

  enum SignatureColor: string {
      case Red = 'red';
      case Green = 'green';
  }

  class SignatureData {
      public string $name;
      public string $phone;
      public string $email;

      public function __construct(string $name, string $phone, string $email) {
          $this->name = $name;
          $this->phone = $phone;
          $this->email = $email;
      }

      public function getFormattedPhone(): string {
          $phone = preg_replace('/[^0-9]/', '', $this->phone); // remove non-numeric characters
          $formatted = '';
          $formatted = preg_replace("/(\\d{1})(\\d{3}|\\d{4})(\\d{3}|\\d{4})(\\d{2})(\\d{2})$/i", "+ $1 ($2) $3 $4 $5 $6", $this->phone);


          return $formatted;
      }
  }

  class SignatureGenerator {
      private SignatureData $data;
      private SignatureColor $color;

      public function __construct(SignatureData $data, SignatureColor $color) {
          $this->data = $data;
          $this->color = $color;
      }

      public function generate(): string {
          $name = $this->data->name;
          $phone = $this->data->getFormattedPhone();
          $email = $this->data->email;
          $color = $this->color->value;

          $phone_link = 'tel:+' . preg_replace('/[^0-9]/', '', $this->data->phone);
          $email_link = 'mailto:' . $this->data->email;


          return <<<HTML
          <div style="font-family: Arial; font-size: 14px; color: $color; display: grid; margin: 0 5%;">
              <p style="margin-bottom: 5px;">С уважением,</p>
              <p style="margin-bottom: 15px;">$name</p>
              <p style="margin-bottom: 5px;">Тел:</p>
              <p style="margin-bottom: 15px;"><a href="$phone_link">$phone</a></p>
              <p style="margin-bottom: 5px;">E-mail:</p>
              <p style="margin-bottom: 15px;"><a href="$email_link">$email</a></p>
          </div>
          HTML;
      }
  }

  // Example usage
  $signature_data1 = new SignatureData('Фамилия И.О.', '+375 (29) 503-81-83', 'demo@bx-shef.by');
  $signature_generator1 = new SignatureGenerator($signature_data1, SignatureColor::Red);
  $signature1 = $signature_generator1->generate();

  $signature_data2 = new SignatureData('Фамилия И.О.', '+375 (29) 503-81-84', 'demo2@bx-shef.by');
  $signature_generator2 = new SignatureGenerator($signature_data2, SignatureColor::Green);
  $signature2 = $signature_generator2->generate();

  // Example message
  $message = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Laoreet sit amet cursus sit amet dictum. Aliquam etiam erat velit scelerisque in dictum. Ut enim blandit volutpat maecenas. Scelerisque felis imperdiet proin fermentum leo vel.</p>';

  echo $message;
  echo($signature1);

  echo $message;
  echo($signature2);