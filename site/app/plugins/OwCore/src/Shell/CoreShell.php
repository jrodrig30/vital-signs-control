<?php
namespace OwCore\Shell;
use Cake\Console\Shell;
use Cake\Utility\Inflector;

class CoreShell extends Shell {
    public $tasks = ['OwCore.CarregaActions','OwCore.PopularTabelas'];

   function main() {
      $this->print_instructions();
      $this->CarregaActions->main();
   }

   function print_instructions() {
      $this->out("\nCommandos");

      foreach($this->tasks as $key => $value) {
         list(,$nome) = explode('.', $key);
         $description = isset($this->{$nome}->description) ? $this->{$nome}->description : '';
         $this->out(Inflector::underscore($nome) . "\t$description\n");
      }
   }
}
