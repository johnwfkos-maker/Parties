<?php

namespace PartySystem;

class PartyManager {

    private array $parties = [];
    private array $invites = [];

    public function createParty(string $player): void {
        $this->parties[$player] = [$player];
    }

    public function invitePlayer(string $leader, string $target): void {
        if(!isset($this->parties[$leader])) return;
        $this->invites[$target] = $leader;
    }

    public function acceptInvite(string $player): void {
        if(!isset($this->invites[$player])) return;

        $leader = $this->invites[$player];
        unset($this->invites[$player]);

        $this->parties[$leader][] = $player;
    }

    public function leaveParty(string $player): void {
        foreach($this->parties as $leader => &$members){
            if(in_array($player, $members)){
                $members = array_values(array_diff($members, [$player]));
                if($player === $leader){
                    unset($this->parties[$leader]);
                }
                break;
            }
        }
    }

    public function getPartyList(string $player): array {
        foreach($this->parties as $leader => $members){
            if(in_array($player, $members)){
                return $members;
            }
        }
        return [$player];
    }
}
