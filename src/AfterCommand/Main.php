<?php

  namespace AfterCommand;
  
  use pocketmine\plugin\PluginBase;
  use pocketmine\event\Listener;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\command\Command;
  use pocketmine\command\CommandSender;
  use pocketmine\command\ConsoleCommandSender;
  
  class Main extends PluginBase implements Listener {
  
    public function onEnable() {
    
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
      
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
    
      if(strtolower($cmd->getName()) === "after") {
      
        if(!(isset($args[0]) and isset($args[1]))) {
        
          $sender->sendMessage(TF::RED . "Error: not enough args. Usage: /after <seconds> <command>");
          
          return true;
          
        } else {
          
          $timeout = $args[0];
          
          unset($args[0]);
          
          $command = implode(" ", $args);
          
          function run() {
          
            static $count = 0;
            
            $count++;
            
            if($count < $timeout) {
            
              sleep(1);
              
              run();
              
            } else {
            
              $this->getServer()->dispatchCommand(new ConsoleCommandSender, $command);
              
            }
            
          }
          
          $sender->sendMessage(TF::GREEN . "Command will run in " . $timeout . " second(s)!");
          
          run();
          
          return true;
          
        }
        
      }
      
    }
    
  }
  
?>
