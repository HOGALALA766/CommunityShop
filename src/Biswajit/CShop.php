<?php

namespace Biswajit;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\item\ItemIds;
use pocketmine\item\Item;
use pocketmine\block\Block;
use pocketmine\item\ItemBlock;
use pocketmine\plugin\PluginBase;
use pocketmine\item\ItemFactory;
use pocketmine\world\World;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\tile\Chest;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\utils\Config;
use onebone\economyapi\EconomyAPI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\enchantment\ItemFlags;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\data\bedrock\EnchantmentIdMap;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;

class CShop extends PluginBase implements Listener {
	
	public function onEnable() : void {
      $this->getLogger()->info("Enabled ✅️");
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
      $this->saveResource("config.yml");
      $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array());
    }
    
  public function onDisable() : void {
      $this->getLogger()->info("Disabled ✅️");
    }
    
  public function onCommand(CommandSender $gamer, Command $cmd, string $label,array $args): bool{
		switch($cmd->getName()){
			case "cshop":
				  if(!$gamer->hasPermission("cshop.cmd.use")) {
				    $gamer->sendMessage("You Don't Have Permission To Use This Command");
				  } else {
				    $this->form($gamer);
				  }
				}
				return true;
		}
		
	public function form(Player $player) {
					$form = new SimpleForm(function (Player $player, $data){
						$result = $data;
						if($result === null){
							return true;
						}
						switch($result){
						  case 0:
						  $this->potions($player);
						  break;
						  
						  case 1:
						  $this->cookies($player);
						  break;
						  
						  case 2:
						  $this->others($player);
						  break;
			   		}
					});					
					$form->setTitle("§l§bCOMMUNITY SHOP");
          $form->setContent("§dSelect The Which Item You Want To Purchase:", 0, );
          $form->addButton("§r§l§ePOTIONS\n§r§l§c»» §r§6Tap To Open", 1, "https://cdn-icons-png.flaticon.com/512/867/867927.png");
          $form->addButton("§r§l§eCOOKIES\n§r§l§c»» §r§6Tap To Open", 1, "https://cdn-icons-png.flaticon.com/512/541/541803.png");
          $form->addButton("§r§l§eOTHERS\n§r§l§c»» §r§6Tap To Open", 1, "https://cdn-icons-png.flaticon.com/512/8323/8323931.png");
          $form->sendToPlayer($player);
            return $form;
		}
		
	public function potions(Player $player) {
					$form = new SimpleForm(function (Player $player, $data){
						$result = $data;
						if($result === null){
							return true;
						}
						switch($result){
						  case 0:
						  $this->godpotion($player);
						  break;
						  
						  case 1:
						  $this->bloodpotion($player);
						  break;
					
			   		}
					});					
					$form->setTitle("§l§bPOTIONS - PURCHASE");
          $form->setContent("§dSelect The Which Potion You Want To Purchase:", 0, );
          $form->addButton("§r§l§eGOD POTION\n§r§l§c»» §r§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/867/867927.png");
          $form->addButton("§r§l§eBLOOD POTION\n§r§l§c»» §r§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/867/867927.png");
          $form->sendToPlayer($player);
            return $form;
		}
		
	public function cookies(Player $player) {
					$form = new SimpleForm(function (Player $player, $data){
						$result = $data;
						if($result === null){
							return true;
						}
						switch($result){
						  case 0:
						  $this->boostercookie($player);
						  break;
						  
						  case 1:
						  $this->gbcookie($player);
						  break;
						  
			   		}
					});					
					$form->setTitle("§l§bCOOKIES - PURCHASE");
          $form->setContent("§dSelect The Which Cookie You Want To Purchase:", 0, );
          $form->addButton("§r§l§eBOOSTER COOKIE\n§r§l§c»» §r§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/541/541803.png");
          $form->addButton("§r§l§eGB COOKIE\n§r§l§c»» §r§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/541/541803.png");
          $form->sendToPlayer($player);
            return $form;
		}
		
	public function others(Player $player) {
					$form = new SimpleForm(function (Player $player, $data){
						$result = $data;
						if($result === null){
							return true;
						}
						switch($result){
						  case 0:
						  $this->darkcarrot($player);
						  break;
						  
						  case 1:
						  $this->legendsapple($player);
						  break;
						
			   		}
					});					
					$form->setTitle("§l§bOTHERS - PURCHASE");
          $form->setContent("§dSelect The Which Item You Want To Purchase:", 0, );
          $form->addButton("§r§l§eDARK CARROT\n§r§l§c»» §r§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/8323/8323931.png");
          $form->addButton("§r§l§eLEGENDS APPLE\n§r§l§c»» §r§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/8323/8323931.png");
          $form->sendToPlayer($player);
            return $form;
		}
		
	public function godpotion(Player $player) {
					$form = new SimpleForm(function (Player $player, $data){
						$result = $data;
						if($result === null){
							return true;
						}
						$money = EconomyAPI::getInstance()->myMoney($player);
						switch($result){
						  case 0:
						  if($money >= $this->config->get("God_Potion_Price")) {
				      EconomyAPI::getInstance()->reduceMoney($player, $this->config->get("God_Potion_Price"));
						  $item1 = ItemFactory::getInstance()->get(ItemIds::POTION);
						  $glow = VanillaEnchantments::UNBREAKING();
              $item1->addEnchantment(new EnchantmentInstance($glow, 1));
              $item1->getNamedTag()->setString("god_potion", "gems");
              $item1->setCustomName("§r§l§6GOD POTION\n§r§7Consume This Potion To Receive\n§r§7All Effects For 3 Days.\n\n§r§aDuration§8: §r§c3 Days\n\n§r§eRight-Click To Consume");
              $item1->setLore(["§r§l§eLEGENDARY"]);
              $player->getInventory()->addItem($item1);
              $player->sendMessage("§l§aSuccess! §r§eYou Purchased §bGod Potion");
						  } else {
						    $player->sendMessage("§l§cError! §r§cYou Don't Have Enough Money :<");
						  }
						  break;
			   		}
					});					
					$form->setTitle("§l§bPURCHASE GOD POTION?");
          $form->setContent("§dName: §fGod Potion\n\n§dDescription: §fConsume This Potion To Receive All Effects For 3 Days.\n\n§dDuration: §f3 Days\n\n§dPrice §f" . $this->config->get("God_Potion_Price"), 0, );
          $form->addButton("§r§l§aPURCHASE\n§r§l§c»» §r§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/1168/1168610.png");
          $form->sendToPlayer($player);
            return $form;
		}
		
		public function bloodpotion(Player $player) {
					$form = new SimpleForm(function (Player $player, $data){
						$result = $data;
						if($result === null){
							return true;
						}
						$money = EconomyAPI::getInstance()->myMoney($player);
						switch($result){
						  case 0:
						  if($money >= $this->config->get("Blood_Potion_Price")) {
				      EconomyAPI::getInstance()->reduceMoney($player, $this->config->get("Blood_Potion_Price"));
						  $item1 = ItemFactory::getInstance()->get(ItemIds::POTION);
						  $glow = VanillaEnchantments::UNBREAKING();
              $item1->addEnchantment(new EnchantmentInstance($glow, 1));
              $item1->getNamedTag()->setString("blood_potion", "gems");
              $item1->setCustomName("§r§l§6BLOOD POTION\n§r§7Consume This Potion To Receive\n§r§7All Effects For 2 Days.\n\n§r§aDuration§8: §r§c3 Days\n\n§r§eRight-Click To Consume");
              $item1->setLore(["§r§l§eLEGENDARY"]);
              $player->getInventory()->addItem($item1);
              $player->sendMessage("§l§aSuccess! §r§eYou Purchased §bBlood Potion");
						  } else {
						    $player->sendMessage("§l§cError! §r§cYou Don't Have Enough Money :<");
						  }
						  break;
			   		}
					});					
					$form->setTitle("§l§bPURCHASE BLOOD POTION?");
          $form->setContent("§dName: §fBlood Potion\n\n§dDescription: §fConsume This Potion To Receive All Effects For 2 Days.\n\n§dDuration: §f2 Days\n\n§dPrice §f" . $this->config->get("Blood_Potion_Price"), 0, );
          $form->addButton("§r§l§aPURCHASE\n§r§l§c»» §r§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/1168/1168610.png");
          $form->sendToPlayer($player);
            return $form;
		}

         public function boostercookie(Player $player) {
					$form = new SimpleForm(function (Player $player, $data){
						$result = $data;
						if($result === null){
							return true;
						}
						$money = EconomyAPI::getInstance()->myMoney($player);
						switch($result){
						  case 0:
						  if($money >= $this->config->get("Booster_Cookie_Price")) {
				      EconomyAPI::getInstance()->reduceMoney($player, $this->config->get("Booster_Cookie_Price"));
						  $item1 = ItemFactory::getInstance()->get(ItemIds::COOKIE);
						  $glow = VanillaEnchantments::UNBREAKING();
              $item1->addEnchantment(new EnchantmentInstance($glow, 1));
              $item1->getNamedTag()->setString("booster_cookie", "gems");
              $item1->setCustomName("§r§l§6BOOSTER COOKIE\n§r§7Consume This Cookie To Receive\n§r§7Some Effects For 3 Days.\n\n§r§aDuration§8: §r§c3 Days\n\n§r§eRight-Click To Consume");
              $item1->setLore(["§r§l§eLEGENDARY"]);
              $player->getInventory()->addItem($item1);
              $player->sendMessage("§l§aSuccess! §r§eYou Purchased §bBooster Cookie");
						  } else {
						    $player->sendMessage("§l§cError! §r§cYou Don't Have Enough Money :<");
						  }
						  break;
			   		}
					});					
					$form->setTitle("§l§bPURCHASE BOOSTER COOKIE?");
          $form->setContent("§dName: §fBooster Cookie\n\n§dDescription: §fConsume This Cookie To Receive Some Effects For 3 Days.\n\n§dDuration: §f3 Days\n\n§dPrice §f" . $this->config->get("Booster_Cookie_Price"), 0, );
          $form->addButton("§r§l§aPURCHASE\n§r§l§c»» §r§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/1168/1168610.png");
          $form->sendToPlayer($player);
            return $form;
		}

         public function gbcookie(Player $player) {
					$form = new SimpleForm(function (Player $player, $data){
						$result = $data;
						if($result === null){
							return true;
						}
						$money = EconomyAPI::getInstance()->myMoney($player);
						switch($result){
						  case 0:
						  if($money >= $this->config->get("GB_Cookie_Price")) {
				      EconomyAPI::getInstance()->reduceMoney($player, $this->config->get("GB_Cookie_Price"));
						  $item1 = ItemFactory::getInstance()->get(ItemIds::COOKIE);
						  $glow = VanillaEnchantments::UNBREAKING();
              $item1->addEnchantment(new EnchantmentInstance($glow, 1));
              $item1->getNamedTag()->setString("gb_cookie", "gems");
              $item1->setCustomName("§r§l§6GB COOKIE\n§r§7Consume This Cookie To Receive\n§r§7Some Effects For 1 Day.\n\n§r§aDuration§8: §r§c1 Day\n\n§r§eRight-Click To Consume");
              $item1->setLore(["§r§l§eLEGENDARY"]);
              $player->getInventory()->addItem($item1);
              $player->sendMessage("§l§aSuccess! §r§eYou Purchased §bGB Cookie");
						  } else {
						    $player->sendMessage("§l§cError! §r§cYou Don't Have Enough Money :<");
						  }
						  break;
			   		}
					});					
					$form->setTitle("§l§bPURCHASE GB COOKIE?");
          $form->setContent("§dName: §fGB Cookie\n\n§dDescription: §fConsume This Cookie To Receive Some Effects For 1 Day.\n\n§dDuration: §f1 Day\n\n§dPrice §f" . $this->config->get("GB_Cookie_Price"), 0, );
          $form->addButton("§r§l§aPURCHASE\n§r§l§c»» §r§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/1168/1168610.png");
          $form->sendToPlayer($player);
            return $form;
		}
		
		public function darkcarrot(Player $player) {
					$form = new SimpleForm(function (Player $player, $data){
						$result = $data;
						if($result === null){
							return true;
						}
						$money = EconomyAPI::getInstance()->myMoney($player);
						switch($result){
						  case 0:
						  if($money >= $this->config->get("Dark_Carrot_Price")) {
				      EconomyAPI::getInstance()->reduceMoney($player, $this->config->get("Dark_Carrot_Price"));
						  $item1 = ItemFactory::getInstance()->get(ItemIds::GOLDEN_CARROT);
						  $glow = VanillaEnchantments::UNBREAKING();
              $item1->addEnchantment(new EnchantmentInstance($glow, 1));
              $item1->getNamedTag()->setString("dark_carrot", "gems");
              $item1->setCustomName("§r§l§6DARK CARROT\n§r§7Consume This Carrot To Receive\n§r§7Health Boost Or Night Vision\n§r§7For 2 Days.\n\n§r§aDuration§8: §r§c2 Days\n\n§r§eRight-Click To Consume");
              $item1->setLore(["§r§l§eLEGENDARY"]);
              $player->getInventory()->addItem($item1);
              $player->sendMessage("§l§aSuccess! §r§eYou Purchased §bDark Carrot");
						  } else {
						    $player->sendMessage("§l§cError! §r§cYou Don't Have Enough Money :<");
						  }
						  break;
			   		}
					});					
					$form->setTitle("§l§bPURCHASE DARK CARROT?");
          $form->setContent("§dName: §fDark Carrot\n\n§dDescription: §fConsume This Carrot To Receive Health Boost And Night Vision Effect For 2 Days.\n\n§dDuration: §f2 Days\n\n§dPrice §f" . $this->config->get("Dark_Carrot_Price"), 0, );
          $form->addButton("§r§l§aPURCHASE\n§r§l§c»» §r§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/1168/1168610.png");
          $form->sendToPlayer($player);
            return $form;
		}
		
		public function legendsapple(Player $player) {
					$form = new SimpleForm(function (Player $player, $data){
						$result = $data;
						if($result === null){
							return true;
						}
						$money = EconomyAPI::getInstance()->myMoney($player);
						switch($result){
						  case 0:
						  if($money >= $this->config->get("Legends_Apple_Price")) {
				      EconomyAPI::getInstance()->reduceMoney($player, $this->config->get("Legends_Apple_Price"));
						  $item1 = ItemFactory::getInstance()->get(ItemIds::GOLDEN_APPLE);
						  $glow = VanillaEnchantments::UNBREAKING();
              $item1->addEnchantment(new EnchantmentInstance($glow, 1));
              $item1->getNamedTag()->setString("legends_apple", "gems");
              $item1->setCustomName("§r§l§6LEGENDS APPLE\n§r§7Consume This Apple To Receive\n§r§7Health Boost Or Night Vision\n§r§7For 1 Day.\n\n§r§aDuration§8: §r§c1 Day\n\n§r§eRight-Click To Consume");
              $item1->setLore(["§r§l§eLEGENDARY"]);
              $player->getInventory()->addItem($item1);
              $player->sendMessage("§l§aSuccess! §r§eYou Purchased §bLegends Apple");
						  } else {
						    $player->sendMessage("§l§cError! §r§cYou Don't Have Enough Money :<");
						  }
						  break;
			   		}
					});					
					$form->setTitle("§l§bPURCHASE LEGENDS APPLE?");
          $form->setContent("§dName: §fLegends Apple\n\n§dDescription: §fConsume This Apple To Receive Health Boost And Night Vision Effect For 1 Day.\n\n§dDuration: §f1 Day\n\n§dPrice §f" . $this->config->get("Legends_Apple_Price"), 0, );
          $form->addButton("§r§l§aPURCHASE\n§r§l§c»» §r§6Tap To Purchase", 1, "https://cdn-icons-png.flaticon.com/512/1168/1168610.png");
          $form->sendToPlayer($player);
            return $form;
		}
		
		public function onItemUse(PlayerItemUseEvent $event){
        $player = $event->getPlayer();
        $item = $event->getItem();
        
        if($item->getNamedTag()->getTag("god_potion")) {
          $speed = VanillaEffects::SPEED();
          $haste = VanillaEffects::HASTE();
          $strength = VanillaEffects::STRENGTH();
          $jump = VanillaEffects::JUMP_BOOST();
          $regen = VanillaEffects::REGENERATION();
          $firesafe = VanillaEffects::FIRE_RESISTANCE();
          $light = VanillaEffects::NIGHT_VISION();
          $health = VanillaEffects::HEALTH_BOOST();
          $player->getEffects()->add(new EffectInstance($speed, 259200*20, 1, true));
          $player->getEffects()->add(new EffectInstance($haste, 259200*20, 1, true));
          $player->getEffects()->add(new EffectInstance($strength, 259200*20, 1, true));
          $player->getEffects()->add(new EffectInstance($jump, 259200*20, 1, true));
          $player->getEffects()->add(new EffectInstance($regen, 259200*20, 1, true));
          $player->getEffects()->add(new EffectInstance($firesafe, 259200*20, 1, true));
          $player->getEffects()->add(new EffectInstance($light, 259200*20, 1, true));
          $player->getEffects()->add(new EffectInstance($health, 259200*20, 1, true));
          $player->getInventory()->remove($item);
        }
        
        if($item->getNamedTag()->getTag("blood_potion")) {
          $speed = VanillaEffects::SPEED();
          $haste = VanillaEffects::HASTE();
          $strength = VanillaEffects::STRENGTH();
          $jump = VanillaEffects::JUMP_BOOST();
          $regen = VanillaEffects::REGENERATION();
          $firesafe = VanillaEffects::FIRE_RESISTANCE();
          $light = VanillaEffects::NIGHT_VISION();
          $health = VanillaEffects::HEALTH_BOOST();
          $player->getEffects()->add(new EffectInstance($speed, 172800*20, 1, true));
          $player->getEffects()->add(new EffectInstance($haste, 172800*20, 1, true));
          $player->getEffects()->add(new EffectInstance($strength, 172800*20, 1, true));
          $player->getEffects()->add(new EffectInstance($jump, 172800*20, 1, true));
          $player->getEffects()->add(new EffectInstance($regen, 172800*20, 1, true));
          $player->getEffects()->add(new EffectInstance($firesafe, 172800*20, 1, true));
          $player->getEffects()->add(new EffectInstance($light, 172800*20, 1, true));
          $player->getEffects()->add(new EffectInstance($health, 172800*20, 1, true));
          $player->getInventory()->remove($item);
        }
        
        if($item->getNamedTag()->getTag("booster_cookie")) {
          $speed = VanillaEffects::SPEED();
          $haste = VanillaEffects::HASTE();
          $jump = VanillaEffects::JUMP_BOOST();
          $light = VanillaEffects::NIGHT_VISION();
          $health = VanillaEffects::HEALTH_BOOST();
          $player->getEffects()->add(new EffectInstance($speed, 172800*20, 1, true));
          $player->getEffects()->add(new EffectInstance($haste, 172800*20, 1, true));
          $player->getEffects()->add(new EffectInstance($jump, 172800*20, 1, true));
          $player->getEffects()->add(new EffectInstance($light, 172800*20, 1, true));
          $player->getEffects()->add(new EffectInstance($health, 172800*20, 1, true));
          $player->getInventory()->remove($item);
        }
        
        if($item->getNamedTag()->getTag("gb_cookie")) {
          $speed = VanillaEffects::SPEED();
          $haste = VanillaEffects::HASTE();
          $jump = VanillaEffects::JUMP_BOOST();
          $light = VanillaEffects::NIGHT_VISION();
          $health = VanillaEffects::HEALTH_BOOST();
          $player->getEffects()->add(new EffectInstance($speed, 86400*20, 1, true));
          $player->getEffects()->add(new EffectInstance($haste, 86400*20, 1, true));
          $player->getEffects()->add(new EffectInstance($jump, 86400*20, 1, true));
          $player->getEffects()->add(new EffectInstance($light, 86400*20, 1, true));
          $player->getEffects()->add(new EffectInstance($health, 86400*20, 1, true));
          $player->getInventory()->remove($item);
        }
        
        if($item->getNamedTag()->getTag("dark_carrot")) {
          $light = VanillaEffects::NIGHT_VISION();
          $health = VanillaEffects::HEALTH_BOOST();
          $player->getEffects()->add(new EffectInstance($light, 172800*20, 1, true));
          $player->getEffects()->add(new EffectInstance($health, 172800*20, 1, true));
          $player->getInventory()->remove($item);
        }
        
        if($item->getNamedTag()->getTag("legends_apple")) {
          $light = VanillaEffects::NIGHT_VISION();
          $health = VanillaEffects::HEALTH_BOOST();
          $player->getEffects()->add(new EffectInstance($light, 86400*20, 1, true));
          $player->getEffects()->add(new EffectInstance($health, 86400*20, 1, true));
          $player->getInventory()->remove($item);
        }
	}
}
