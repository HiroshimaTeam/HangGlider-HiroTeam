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
 * GitHub: https://github.com/HiroshimaTeam/HangGlider-HiroTeam
 */

namespace HiroTeam\HangGlider;


use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;

class EventListener implements Listener
{
    private HangGliderMain $main;


    public function __construct(HangGliderMain $main)
    {
        $this->main = $main;
    }

    public function itemHeld(PlayerItemHeldEvent $event)
    {
        $this->main->checkItemHeld($event->getPlayer(), $event->getItem());
    }

    public function playerJoinEvent(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        $this->main->checkItemHeld($player, $player->getInventory()->getItemInHand());
    }

    public function playerQuitEvent(PlayerQuitEvent $event)
    {
        $player = $event->getPlayer();
        $this->main->checkItemHeld($player, ItemFactory::air());
    }

    public function onDamage(EntityDamageEvent $event)
    {
        $player = $event->getEntity();
        if (!($player instanceof Player)) return;
        if ($event->getCause() === EntityDamageEvent::CAUSE_FALL and $this->main->isOnHangGlider($player)) {
            $event->cancel();
        }
    }
}
