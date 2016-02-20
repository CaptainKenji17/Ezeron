<?php
namespace Ezero;


use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\level\sound\AnvilFallSound;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\utils\TextFormat;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\entity\Effect;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\item\Item;
use pocketmine\level\particle\DustParticle;
use pocketmine\math\Vector3;

class Main extends PluginBase implements Listener {
    
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->getLogger()->info(TextFormat::GREEN.'Ezero Activated!');
    }
    
    public function onHurt(EntityDamageEvent $ev){
        $p = $ev->getEntity();
        if($ev instanceof EntityDamageByEntityEvent){
            $damager = $ev->getDamager();
            if($damager instanceof Player){
                if($damager->getInventory()->getItemInHand()->getId() === 369){
                    $ev->setKnockBack(0.5);
                    $ev->setDamage($ev->getDamage()+3);
      $x = $p->getX();
      $y = $p->getY();
      $z = $p->getZ();
        $r = mt_rand(0, 255);
        $g = mt_rand(0, 255);
        $b = mt_rand(0, 255);
        $cen =  new Vector3($x, $y, $z);    
        $particle = new DustParticle($cen, $r, $g, $b);
      $p->getLevel()addParticle($particle);
 $p->addEffect(Effect::getEffect(9)->setAmplifier(1)->setDuration(20)->setVisible(true));
                    $level = $damager->getLevel();
                    $level->addSound(new AnvilFallSound($damager->getLocation()),[$level]);
                }
            }
        }
    }
    public function onItemHeld(PlayerItemHeldEvent $ev){
        $player = $ev->getPlayer();
        if($ev->getPlayer()->getInventory()->getItemInHand()->getId() === 369){
            $ev->getPlayer()->sendTip(TextFormat::RED."Ezero Enabled!");
            $player->addEffect(Effect::getEffect(11)->setAmplifier(0)->setDuration(999999)->setVisible(false));
        }else{
            $player->removeEffect(11);
        }
    }
}
