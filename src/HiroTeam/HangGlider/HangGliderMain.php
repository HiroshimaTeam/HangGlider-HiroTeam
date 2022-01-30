<?php
/**
 * ██╗░░██╗██╗██████╗░░█████╗░████████╗███████╗░█████╗░███╗░░░███╗
 * ██║░░██║██║██╔══██╗██╔══██╗╚══██╔══╝██╔════╝██╔══██╗████╗░████║
 * ███████║██║██████╔╝██║░░██║░░░██║░░░█████╗░░███████║██╔████╔██║
 * ██╔══██║██║██╔══██╗██║░░██║░░░██║░░░██╔══╝░░██╔══██║██║╚██╔╝██║
 * ██║░░██║██║██║░░██║╚█████╔╝░░░██║░░░███████╗██║░░██║██║░╚═╝░██║
 * ╚═╝░░╚═╝╚═╝╚═╝░░╚═╝░╚════╝░░░░╚═╝░░░╚══════╝╚═╝░░╚═╝╚═╝░░░░░╚═╝
 * HangGlider_PM4-HiroTeam By WillyDuGang
 *
 * GitHub: https://github.com/HiroshimaTeam/AreaGuard
 */

namespace HiroTeam\HangGlider;

use HiroTeam\HangGlider\effect\MyEffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class HangGliderMain extends PluginBase
{

    private array $onHangGliderPlayer = [];

    public function checkItemHeld(Player $player, Item $item)
    {
        $hangGlider = $this->getConfig()->get('hangGlider');
        $playerName = $player->getName();
        $playerEffect = $player->getEffects();
        if ($item->getId() . ':' . $item->getMeta() === $hangGlider) {
            $effect = new MyEffectInstance(VanillaEffects::LEVITATION(), 100 * 99999, -4, false);
            $playerEffect->add($effect);
            $this->onHangGliderPlayer[$playerName] = true;
        } elseif ($this->isOnHangGlider($player)) {
            $playerEffect->remove(VanillaEffects::LEVITATION());
            unset($this->onHangGliderPlayer[$playerName]);
        }
    }

    public function isOnHangGlider(Player $player): bool
    {
        return isset($this->onHangGliderPlayer[$player->getName()]);
    }

    protected function onEnable(): void
    {
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }
}