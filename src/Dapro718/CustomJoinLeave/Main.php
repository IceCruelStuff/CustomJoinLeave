<?php

declare(strict_types=1);

namespace Dapro718\CustomJoinLeave;
  
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\Config;
use pocketmine\Player;
use jojoe77777\FormAPI\SimpleForm;
class Main extends PluginBase implements Listener{
  
  public $config;
  public $plugin;
    

  
    public function onLoad(): void{
        $this->getLogger()->info("ImperialPE-CustomJoinLeave Loaded");
    }

  
    public function onEnable(): void{
        $this->getLogger()->info("ImperialPE-CustomJoinLeave Enabled");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->config = $this->getConfig();
    }

    public function onDisable(): void{
        $this->getLogger()->info("ImperialPE-CustomJoinLeave Disabled");
    }
    
    public function sendJoinForm($player) {
      $form = new SimpleForm(function(Player $player, ?string $data): void{
        switch($data){
          case "playButton":
            break;
        }
      });
      $form->setTitle($this->config->get("ui-title"));            
      $form->setContent($this->config->get("ui-description"));
      $form->addButton($this->config->get("ui-button-text"), -1, " ", "playButton");
      $form->sendToPlayer($player);
      return $form;
    }
  
    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $name = $player->getName();
        if(!$player->hasPermission("message.disable")) {
            $message = $this->config->get("Join");
            $msg = str_replace("{player}", $name, $message);
            $event->setJoinMessage($msg);
        }

        if($this->config->get("show-join-ui")) {
            $this->sendJoinForm($player);
        }
    }
  
    public function onQuit (PlayerQuitEvent $event) {
        $player = $event->getPlayer();
        $name = $player->getName();
        if(!$player->hasPermission("message.disable")) {
            $message = $this->config->get("Leave");
            $msg = str_replace("{player}", $name, $message);
            $event->setQuitMessage($msg);
        }
    }

}
