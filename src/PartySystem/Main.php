<?php

namespace PartySystem;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class Main extends PluginBase {

    private PartyManager $partyManager;

    public function onEnable(): void {
        $this->partyManager = new PartyManager();
        $this->getLogger()->info("PartySystem enabled!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {

        if(!$sender instanceof Player){
            return true;
        }

        $name = $sender->getName();

        if(!isset($args[0])){
            $sender->sendMessage("§e/party create|invite|accept|leave|list");
            return true;
        }

        switch(strtolower($args[0])){

            case "create":
                $this->partyManager->createParty($name);
                $sender->sendMessage("§aParty created!");
                break;

            case "invite":
                if(!isset($args[1])) return true;
                $this->partyManager->invitePlayer($name, $args[1]);
                $sender->sendMessage("§eInvited {$args[1]}");
                break;

            case "accept":
                $this->partyManager->acceptInvite($name);
                $sender->sendMessage("§aJoined party!");
                break;

            case "leave":
                $this->partyManager->leaveParty($name);
                $sender->sendMessage("§cLeft party.");
                break;

            case "list":
                $list = $this->partyManager->getPartyList($name);
                $sender->sendMessage("§bParty: " . implode(", ", $list));
                break;
        }

        return true;
    }
}
