<?php

declare(strict_types=1);

namespace JoinUI;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;

class Main extends PluginBase implements Listener
{
    public function onEnable()
    {
        $this->getLogger()->info("by misael38 Enabled!");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveResource("config.yml");
        
        $this->FormAPI = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        if (!$this->FormAPI or $this->FormAPI->isDisabled()) {
            $this->getLogger()->warning("Plugin FormAPI not found, disabling JoinUI...");
            $this->getLogger()->warning("Please install FormAPI in : poggit.pmmp.io/p/FormAPI");
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }
    }
    
    public function onDisable()
    {
        $this->getLogger()->info("by misael38 disabled!");
    }
    
    public function onJoin(PlayerJoinEvent $event)
    {
            $player = $event->getPlayer();
            $player->sendMessage(str_replace(["{name}"], [$player->getName()], $this->getConfig()->get("welcome-message")));
            if ($player instanceof Player) {
                $this->openUI($player);
        }
    }
    
    public function openUI($player)
    {
        $form = new SimpleForm(function (Player $player, $data) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    break;
            }
        });
        
        $form->setTitle($this->getConfig()->get("Title"));
        $form->setContent(str_replace(["{name}"], [$player->getName()], $this->getConfig()->get("Content")));
        $form->addButton($this->getConfig()->get("Button"));
        $form->sendToPlayer($player);
        return true;
    }
}

