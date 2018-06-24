<?

  class error {
      
      var $error, $message, $cart;
      
      function addError($str){
      
          $this->error[] = $str;
          
      }
      
      function addMessage($str){
      
          $this->message[] = $str;
          
      }
      
      function addCart($str){
      
          $this->cart[] = $str;
          
      }
      
  }

?>