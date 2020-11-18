<?php
class MenuShell extends AppShell {
   var $tasks = array('OwCore.Carregar');

   function main() {
      $this->print_instructions();
   }

   function print_instructions() {
      $this->out("\nCommandos");
      $this->hr();
      foreach($this->tasks as $t) {
          list(,$nome) = explode('.', $t);
         $description = isset($this->{$nome}->description) ? $this->{$nome}->description : '';
         $this->out(Inflector::underscore($nome) . "\t$description\n");
      }
   }
}
?>